<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\UploadedFile;
use UploadImage;
use App\Models\Categorie;
use App\Models\Filter;
use App\Models\Categories_filter;
use App\Src\ArrayMethods;

class CategoriesController extends Controller {

    protected $_path = '/images/categories/';

    public function index() {
        $categories = Categorie::all();
        return view('Admin.Categories_all', ['activeCategory' => true, 'categories' => $categories]);
    }

    public function create() {
        $categories = Categorie::all();
        $filters = Filter::all();
        return view('Admin.Categories_create', ['categories' => $categories, 'filters' => $filters, 'activeCategory' => true]);
    }

    public function store(Request $request) {
        $this->itValidate($request);
        $item = $request->all();
        (!is_null($request->parent_id)) ? $this->changeSctionParent($item, $request->parent_id) : "";
        $links = ArrayMethods::colleactRecursiveArray($request, 'category_links', $this->_path);
        try {
            $item['img'] = $this->uploadImage($item['img']);
            $category = Categorie::create($item);
            $category->filters()->sync($item['filters']);
            $category->category_links()->createMany($links);
        } catch (Exception $e) {
            return redirect()->back()->with('failure', $e->getMessage());
        }
        return redirect()->route('categories.index')->with('success', $request->en_name . ' has been inserted');
    }

    public function edit($id) {
        $category = Categorie::findOrFail($id);
        return view('Admin.Categories_edit', ['category' => $category, 'activeCategory' => 1]);
    }

    public function update(Request $request, $id) {
        $this->itValidate($request);
        $data = $request->all();
        $category = Categorie::findOrFail($id);
        $exImg = $category->img;
        $data['parent_id'] = isset($data['parent_id']) ? $data['parent_id'] : 0;
        if ($request->hasFile('img')) {
            $file = Input::file('img');
            $data['img'] = UploadFacades::Upload($file, $this->_path, 250);
        }
        try {
            $this->updateSection($request->section_id, $category->section_id, $id);
            $category->update($data);
            $category->filters()->sync($data['filters']);
            (isset($exImg) && $request->hasFile('img')) ? UploadFacades::removeExImg($exImg, $this->_path) : '';
        } catch (Exception $e) {
            return redirect()->back()->with('errorMsg', $e->getMessage());
        }
        return redirect()->route('categories.index')->with('success', $request->en_name . ' has been modified');
    }

    public function destroy($id) {
        $category = Categorie::findOrFail($id);
        $exImg = $category->img;
        try {
            $category->delete();
            (isset($exImg)) ? UploadFacades::removeExImg($exImg, $this->_path) : '';
            return redirect()->route('categories.index')->with('success', 'Category No:' . $id . ' has been deleted');
        } catch (Exception $e) {
            return redirect()->back()->with('errorMsg', $e->getMessage());
        }
    }

    private function itValidate(Request $request) {
        return $this->validate($request, [
                    'section_id' => 'required_without_all:parent_id|integer',
                    'parent_id' => 'required_without_all:section_id|integer',
                    'en_name' => 'required',
                    'ar_name' => 'required',
                    'title' => 'required',
                    'arrangement' => 'required|integer',
                    'img' => 'image',
//                    'link_img' => 'image',
                    'filters' => 'required'
        ]);
    }

    private function uploadImage($value) {
        if ($value instanceof UploadedFile) {
            return UploadImage::Upload($value, $this->_path, 250);
        }
        throw new Exception('The intro image must not be null');
    }

//    private function createFilters($category_id, array $filters) {
//        foreach ($filters as $filter) {
//            Categories_filter::create(['categorie_id' => $category_id, 'filter_id' => $filter]);
//        }
//    }

    public static function analyzeCatgoryName($id, array $name = null) {
        $category = Categorie::find($id);
        $return = [];
        $return[] = $category->en_name;
        if ($category->parent_id != 0) {
            $return[] = self::analyzeCatgoryName($category->parent_id, $return);
        }
        return self::getName($return);
    }

    private static function getName(array $name) {
        return implode(' > ', array_reverse($name));
    }

    public static function checkFilterExists($category, $filter_id) {
        $filters = $category->filters;
        foreach ($filters as $filter) {
            if ($filter->id == $filter_id) {
                return true;
            }
        }
        return FALSE;
    }

    private function changeSctionParent(&$data, $parent_id) {
        $parent_category = Categorie::find($parent_id);
        $section = $parent_category->section_id;
        $data["section_id"] = $section;
    }

    private function updateSection($requestSection, $currentSection, $id) {
        if ($this->checkSection($requestSection, $currentSection, $id)) {
            $this->updateChilds($requestSection, $id);
        }
    }

    private function hasChilds($id) {
        $childs = Categorie::where('parent_id', $id)->count();
        if ($childs > 0) {
            return true;
        }
        return false;
    }

    private function checkSection($requestSection, $currentSection, $id) {
        if ($requestSection !== $currentSection && $this->hasChilds($id)) {
            return true;
        }
        return FALSE;
    }

    private function updateChilds($requestSection, $id) {
        $childs = Categorie::where('parent_id', $id)->get();
        foreach ($childs as $child) {
            $child->update(['section_id' => $requestSection]);
            if ($this->hasChilds($child->id)) {
                $this->updateChilds($requestSection, $child->id);
            }
        }
    }

}
