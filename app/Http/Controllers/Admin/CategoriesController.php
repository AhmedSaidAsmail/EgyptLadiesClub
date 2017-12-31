<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use App\Models\Filter;
use Exception;

class CategoriesController extends Controller {

    protected $_path = '/images/categories/';

    public function index() {
        $categories = Category::all();
        return view('Admin.Categories_all', ['activeCategory' => true, 'categories' => $categories]);
    }

    public function create() {
        $categories = Category::all();
        $filters = Filter::all();
        return view('Admin.Categories_create', ['categories' => $categories, 'filters' => $filters, 'activeCategory' => true]);
    }

    public function store(Request $request) {
        $this->validatedData($request);
        $item = $request->all();
        (!is_null($request->parent_id)) ? $this->changeSctionParent($item, $request->parent_id) : "";
        $links = colleactRecursiveArray($request, 'category_links', $this->_path);
        $item['img'] = uploadImage(['image' => $item['img'], 'path' => $this->_path]);
        try {
            $category = Category::create($item);
            $category->filters()->sync($item['filters']);
            $category->brands()->sync($item['brnads']);
            $category->category_links()->createMany($links);
        } catch (Exception $e) {
            return redirect()->back()->with('failure', $e->getMessage());
        }
        return redirect()->route('categories.index')->with('success', $request->en_name . ' has been inserted');
    }

    public function edit($id) {
        $category = Category::findOrFail($id);
        return view('Admin.Categories_edit', ['category' => $category, 'activeCategory' => true]);
    }

    public function update(Request $request, $id) {
        $this->validatedData($request);
        $data = $request->all();
        $category = Category::findOrFail($id);
        $data['parent_id'] = isset($data['parent_id']) ? $data['parent_id'] : 0;
        if ($request->hasFile('img')) {
            $data['img'] = uploadImage(['image' => $data['img'], 'path' => $this->_path, 'exImage' => $category->img]);
        }
        $links = colleactRecursiveArray($request, 'category_links', $this->_path, 'link_id');
        try {
            $this->updateSection($request->section_id, $category);
            $category->update($data);
            $category->filters()->sync($data['filters']);
            $category->brands()->sync($data['brnads']);
            sync($category, 'category_links', $links);
        } catch (Exception $e) {
            return redirect()->back()->with('errorMsg', $e->getMessage());
        }
        return redirect()->route('categories.index')->with('success', $request->en_name . ' has been modified');
    }

    private function validatedData(Request $request) {
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

    private function changeSctionParent(&$data, $parent_id) {
        $parent_category = Category::find($parent_id);
        $section = $parent_category->section_id;
        $data["section_id"] = $section;
    }

    private function updateSection($requestSection, Category $category) {
        if ($this->checkSection($requestSection, $category)) {
            $this->updateChilds($requestSection, $category);
        }
    }

    private function checkSection($requestSection, Category $category) {
        if ($requestSection !== $category->section_id && !is_null($category->childs)) {
            return true;
        }
        return false;
    }

    private function updateChilds($requestSection, Category $category) {
        foreach ($category->childs as $child) {
            $child->update(['section_id' => $requestSection]);
            if (!is_null($child->childs)) {
                $this->updateChilds($requestSection, $child);
            }
        }
    }

    public function getSectionBrands(Request $request) {
        $id = $request->id;
        $brands = Section::find($id)->brands;
        return view('Admin.Layouts.getBrands', ['brands' => $brands]);
    }

    public function getCategoryBrands(Request $request) {
        $id = $request->id;
        $brands = Category::find($id)->section->brands;
        return view('Admin.Layouts.getBrands', ['brands' => $brands]);
    }

}
