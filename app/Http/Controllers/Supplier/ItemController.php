<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use App\Models\Brand;
use Auth;
use Exception;

class ItemController extends Controller {

    protected $_path = '/images/items/';

    public function index() {
        $items = Auth::guard('supplier')->user()->items()->get();

        return view('Supplier.Items', [
            'items' => $items,
            'activeItems' => true]);
    }

    public function create() {
        $categories = Category::all();
        $categories = hierarchicalData($categories, 'flatten');
        $brands = Brand::all();
        $items = Item::all();
        return view('Supplier.Items_create', ['categories' => $categories,
            'brands' => $brands,
            'items' => $items,
            'activeItems' => true]);
    }

    public function store(Request $request) {
        $this->validateData($request);
        $data = $request->all();
        $data['img'] = uploadImage(['image' => $data['img'], 'path' => $this->_path]);
        $discountData = collectData(['request' => $request, 'table' => 'discounts', 'path' => $this->_path]);
        $imagesData = collectData(['request' => $request, 'table' => 'items_images', 'path' => $this->_path]);
        try {
            $item = Item::create($data);
            $item->details()->create($data);
            $item->filters()->sync($data['filters_item_id']);
            $item->discounts()->createMany($discountData);
            $item->images()->createMany($imagesData);
        } catch (Exception $ex) {
            return redirect()->back()->with('failure', $ex->getMessage());
        }
        return redirect()->route('suItems.index')->with('success', 'The product has been inserted');
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        try {
            $item = $this->getItem($id);
            $categories = Category::all();
            $categories = hierarchicalData($categories, 'flatten');
            $brands = Brand::all();
            $items = Item::all();
            return view('Supplier.Items_edit', [
                'item' => $item,
                'categories' => $categories,
                'brands' => $brands,
                'items' => $items,
                'activeItems' => true]);
        } catch (Exception $ex) {
            return redirect()->route('suItems.index')->with('failure', $ex->getMessage());
        }
    }

    public function update(Request $request, $id) {
        $this->validateData($request);
        $data = $request->all();
        $item = Item::find($id);
        $discountData = collectData(['request' => $request, 'table' => 'discounts', 'primaryKey' => 'discount_id']);
        $imagesData = collectData(['request' => $request, 'table' => 'items_images', 'path' => $this->_path, 'primaryKey' => 'image_id']);
        $detailsData= collectData(['request' => $request,'table' => 'items_details'],'flatten');
        $item->update($data);
        $item->details()->update($detailsData);
        $item->filters()->sync($data['filters_item_id']);
        sync($item, 'discounts', $discountData);
        sync($item, 'images', $imagesData);
        return redirect()->route('suItems.index')->with('success', 'The product has been updated');
    }

    protected function getItem($id) {
        $item = Auth::guard('supplier')->user()->items()->find($id);
        if (is_null($item)) {
            throw new Exception('!! Oops something went wrong ');
        }
        return $item;
    }

    public function getFilters(Request $request) {
        $id = $request->id;
        $category = Category::find($id);
        $filters = $category->filters;
        $item_id = isset($request->item_id) ? isset($request->item_id) : null;
        return view('Supplier.Layouts.filters_get', ['filters' => $filters, 'item_id' => $item_id]);
    }

    public function getBrands(Request $request) {
        $id = $request->id;
        $category = Category::find($id);
        $brands = $category->brands;
        $item_id = isset($request->item_id) ? isset($request->item_id) : null;
        return view('Supplier.Layouts.brands_get', ['brands' => $brands, 'item_id' => $item_id]);
    }

    private function validateData(Request $request) {
        return $this->validate($request, [
                    'category_id' => 'required|integer',
                    'brand_id' => 'required|integer',
                    'model' => 'required',
                    'img' => 'image',
                    'quantity' => 'required|integer',
                    'min_quantity' => 'required|integer',
                    'price' => 'required',
                    'shipping' => 'required',
                    'date_available' => 'required|date',
                    'ar_name' => 'required',
                    'ar_text' => 'required',
                    'ar_title' => 'required',
                    'ar_keywords' => 'required',
                    'ar_description' => 'required',
                    'en_name' => 'required',
                    'en_text' => 'required',
                    'en_title' => 'required',
                    'en_keywords' => 'required',
                    'en_description' => 'required',
                    'dis_quantity.*' => 'nullable|integer',
                    'date_start.*' => 'nullable|date',
                    'date_end.*' => 'nullable|date',
        ]);
    }

}
