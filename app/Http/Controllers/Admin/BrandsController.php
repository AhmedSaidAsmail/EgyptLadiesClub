<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use App\Models\Brand;

class BrandsController extends Controller {

    protected $_path = '/images/brands/';

    public function index() {
        $brands = Brand::all();
        return view('Admin.Brands_all', ['brands' => $brands, 'activeBrands' => true]);
    }

    public function create() {
        return view('Admin.Brands_create', ['activeBrands' => true]);
    }

    public function store(Request $request) {
        $this->ValidateData($request);
        $data = $request->all();
        $data['img'] = uploadImage(['image' => $data['img'], 'path' => $this->_path]);
        try {
            Brand::create($data);
        } catch (Exception $ex) {
            return redirect()->back()->with('errorMsg', $ex->getMessage());
        }
        return redirect()->route('brands.index')->with('success', ' Brand has been inserted');
    }

    public function edit($id) {
        $brand = Brand::find($id);
        return view('Admin.Brands_edit', ['brand' => $brand, 'activeBrands' => true]);
    }

    public function update(Request $request, $id) {
        $brand = Brand::find($id);
        $this->ValidateData($request);
        $data = $request->all();
        if ($request->hasFile('img')) {
            $data['img'] = uploadImage(['image' => $data['img'], 'path' => $this->_path]);
        }

        try {
            $brand->update($data);
        } catch (Exception $ex) {
            return redirect()->back()->with('errorMsg', $ex->getMessage());
        }
        return redirect()->route('brands.index')->with('success', ' Brand has been updated');
    }

    private function ValidateData(Request $request) {
        return $this->validate($request, [
                    'sort_order' => 'required|integer',
                    'ar_name' => 'required',
                    'en_name' => 'required',
        ]);
    }

}
