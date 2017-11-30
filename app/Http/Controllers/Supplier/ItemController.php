<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Src\Facades\UploadFacades;
use App\Models\Item;
use App\Models\Categorie;
use App\Models\Brand;
use App\Models\Discount;
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
        $this->changeImage($request, $data);
        try {
            $item = Item::create($data);
            $item->details()->create($data);
            $item->filters()->sync($data['filters_item_id']);
            $this->attachDiscounts($data, $item->id);
        } catch (Exception $ex) {
            UploadFacades::removeImg();
            return $ex->getMessage();
        }
    }

    protected function attachDiscounts(array $data, $item_id) {
//         for ($i = 0; $i < count($data['dis_price']); $i++)
        foreach (array_keys($data['dis_price']) as $i) {
            Discount::create(['item_id' => $item_id,
                'dis_price' => $data['dis_price'][$i],
                'dis_quantity' => $data['dis_quantity'][$i],
                'date_start' => $data['date_start'][$i],
                'date_end' => $data['date_end'][$i]]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function getFilters(Request $request) {
        $id = $request->id;
        $category = Categorie::find($id);
        $filters = $category->filters;
        return view('Supplier.Layouts.filters_get', ['filters' => $filters]);
    }

    public function itsValidate(Request $request) {
        return $this->validate($request, [
                    'categorie_id' => 'required|integer',
                    'brand_id' => 'required|integer',
                    'model' => 'required',
                    'img' => 'required|image',
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

    private function changeImage(Request $request, array &$items) {
        if ($request->hasFile('img')) {
            $file = Input::file('img');
            $items['img'] = UploadFacades::Upload($file, $this->_path, 250);
        }
    }

}
