<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Exception;
use App\Src\Facades\UploadFacades;
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
        $this->itValidate($request);
        $data = $request->all();
        $this->createImage($request, $data);
        try {
            Brand::create($data);
        } catch (Exception $ex) {
            UploadFacades::removeImg();
            return redirect()->back()->with('errorMsg', $ex->getMessage());
        }
        return redirect()->route('brands.index')->with('success', ' Brand has been inserted');
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        $brand = Brand::find($id);
        try {
            $brand->delete();
        } catch (Exception $ex) {
            return redirect()->back()->with('errorMsg', $ex->getMessage());
        }
    }

    public function destroySelected(Request $request) {
        $rows = $request->brand_id;
        if (count($rows) <= 0) {
            return redirect()->back()->with('errorMsg', 'No Brands selected');
        }
        foreach ($rows as $row) {
            $this->destroy($row);
        }
        return redirect()->route('brands.index')->with('success', ' Brands has been deleted');
    }

    private function itValidate(Request $request) {
        return $this->validate($request, [
                    'sort_order' => 'required|integer',
                    'ar_name' => 'required',
                    'en_name' => 'required',
        ]);
    }

    private function createImage(Request $request, array &$items) {
        if ($request->hasFile('img')) {
            $file = Input::file('img');
            $items['img'] = UploadFacades::Upload($file, $this->_path, 250);
        }
    }

}
