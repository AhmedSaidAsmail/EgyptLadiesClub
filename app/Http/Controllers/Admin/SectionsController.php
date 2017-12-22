<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use UploadImage;
use Exception;
use App\Models\Section;

class SectionsController extends Controller {

    protected $_instance;
    protected $_path = "/images/sections/";

    public function __construct() {
        if (is_null($this->_instance)) {
            $this->_instance = \App\Http\Controllers\Admin\CategoriesController::class;
        }
    }

    public function index() {
        $sections = Section::all();
        return view('Admin.Sections_all', ['sections' => $sections, 'activeSections' => 1]);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $this->itValidate($request);
        $item = $request->all();
        $item['img'] = $this->uploadImage($item['img']);
        try {
            $section = Section::create($item);
            $section->brands()->sync($item['brands']);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('sections.index')->with('success', $request->en_name . ' has been inserted');
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        $section = Section::find($id);
        return view('Admin.1_MainCategory_update', ['basicSort' => $basicSort, 'activeMaincategory' => true]);
    }

    public function update(Request $request, $id) {
        $this->itValidate($request);
        $item = $request->all();
        $Maincategory = Countries::find($id);
        $exImg = $Maincategory->img;
        $item['img'] = $this->uploadImage($item['img']);
        try {
            $Maincategory->update($item);
            (isset($exImg) && $request->hasfile('img')) ? UploadImage::removeExImg($exImg, $this->_path) : '';
        } catch (\Exception $e) {
            UploadImage::removeImg();
            $request->session()->flash('errorDetails', $e->getMessage());
            $request->session()->flash('errorMsg', "Oops something went wrong !!");
        }

        return redirect()->route('MainCategory.index')->with('success', $request->name . ' has been updated');
    }

    public function destroy($id) {
        $MainCategory = Basicsort::find($id);
        $exImg = $MainCategory->img;
        $_instance = new $this->_instance;
        // to dlete all sub Categories and it's Items
        foreach ($MainCategory->sorts as $category) {
            $_instance->destroy($category->id);
        }
        $MainCategory->delete();
        (isset($exImg)) ? UploadImage::removeExImg($exImg, $this->_path) : '';
        Session::flash('deleteStatus', "Main Category No: {$id} is Deleted !!");
        return redirect(route('MainCategory.index'));
    }

    private function itValidate(Request $request) {
        return $this->validate($request, [
                    'en_name' => 'required',
                    'ar_name' => 'required',
                    'title' => 'required',
                    'arrangement' => 'required|integer',
                    'img' => 'image'
        ]);
    }

    private function uploadImage($value) {
        if ($value instanceof UploadedFile) {
            return UploadImage::Upload($value, $this->_path, 250);
        }
        return $value;
    }

}
