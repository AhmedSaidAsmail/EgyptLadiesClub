<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Src\Facades\UploadFacades;
use Illuminate\Http\UploadedFile;
use App\SyncData;
use App\Models\Item;
use App\Models\Categorie;
use App\Models\Brand;
use App\Http\HierarchicalData;
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
        $categories = Categorie::all();
        $categoriesArray = ( HierarchicalData::flatten(HierarchicalData::makeTree($categories)));
        $brands = Brand::all();
        $items = Item::all();
        return view('Supplier.Items_create', ['categories' => $categoriesArray,
            'brands' => $brands,
            'items' => $items,
            'activeItems' => true]);
    }

    public function store(Request $request) {
        $this->itsValidate($request);
        $data = $request->all();
        $data['img'] = $this->uploadImage($data['img']);
        $discountsArray = $this->colleactRecursiveArray($request, ['dis_price', 'dis_quantity', 'date_start', 'date_end']);
        $imgArray = $this->colleactRecursiveArray($request, ['item_image', 'image_sort_order']);
        try {
            $item = Item::create($data);
            $item->details()->create($data);
            $item->filters()->sync($data['filters_item_id']);
            $item->discounts()->createMany($discountsArray);
            $item->images()->createMany($imgArray);
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
            $categories = Categorie::all();
            $categoriesArray = ( HierarchicalData::flatten(HierarchicalData::makeTree($categories)));
            $brands = Brand::all();
            $items = Item::all();
            return view('Supplier.Items_edit', [
                'item' => $item,
                'categories' => $categoriesArray,
                'brands' => $brands,
                'items' => $items,
                'activeItems' => true]);
        } catch (Exception $ex) {
            return redirect()->route('suItems.index')->with('failure', $ex->getMessage());
        }
    }

    public function update(Request $request, $id) {
        $this->itsValidate($request);
        $data = $request->all();
        $item = Item::find($id);
        $item->update($data);
        $item->details()->update($this->collectArray($request, 'items_details'));
        $item->filters()->sync($data['filters_item_id']);
        $discountsArray = $this->colleactRecursiveArray($request, ['discount_id', 'dis_price', 'dis_quantity', 'date_start', 'date_end'], 'discount_id');
        $imgArray = $this->colleactRecursiveArray($request, ['image_id', 'item_image', 'image_sort_order'], 'image_id');
        SyncData::sync($item->discounts, $item->discounts(), 'discounts', $discountsArray);
        SyncData::sync($item->images, $item->images(), 'items_images', $imgArray);
//        dd($imgArray);
    }

    public function destroy($id) {
        //
    }

    protected function collectArray(Request $request, $table) {
        $collection = [];
        $fields = DB::getSchemaBuilder()->getColumnListing($table);
        foreach ($fields as $field) {
            if (isset($request->$field) && !is_null($request->$field)) {
                $collection[$field] = $request->$field;
            }
        }
        return $collection;
    }

    protected function colleactRecursiveArray(Request $request, array $fields, $primaryKey = null) {
        $collection = [];
        foreach ($fields as $field) {
            if (isset($request->$field) && !is_null($request->$field)) {
                $this->perpareCollectionData($collection, $field, $request, $primaryKey);
            }
        }
        return $collection;
    }

    protected function perpareCollectionData(array &$collection, $field, Request $request, $primaryKey = null) {
        foreach ($request->$field as $key => $fieldData) {
            $fixField = (!is_null($primaryKey) && $primaryKey == $field) ? "id" : $field;
            $data = $this->uploadImage($fieldData);
            $collection[$key][$fixField] = $data;
        }
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
        $category = Categorie::find($id);
        $filters = $category->filters;
        $item_filters = null;
        if (isset($request->item_id)) {
            $item = Item::find($request->item_id);
            $item_filters = $item->item_filters;
        }
        return view('Supplier.Layouts.filters_get', ['filters' => $filters, 'item_filters' => $item_filters]);
    }

    public static function checkFilter(Collection $item_filters, $filter_id) {
        foreach ($item_filters as $item_filter) {
            if ($item_filter->filters_item_id == $filter_id) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function itsValidate(Request $request) {
        return $this->validate($request, [
                    'categorie_id' => 'required|integer',
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

    private function uploadImage($value) {
        if ($value instanceof UploadedFile) {
            return UploadFacades::Upload($value, $this->_path, 250);
        }
        return $value;
    }

}
