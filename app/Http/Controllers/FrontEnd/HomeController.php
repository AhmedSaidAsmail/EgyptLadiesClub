<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Category;

class HomeController extends Controller {

    public function home() {
        $sections = Section::all();
        $topCategories= Category::where('status',1)->where('recommended',1)->orderBy('arrangement')->get();
        return view('Public.home', ['sections' => $sections,'topCategories'=>$topCategories]);
    }

    public function categoryShow(Request $request, $categoryName, $id) {
        $targetCategory = Category::find($id);
        $catgoryClass = analyzeCategory($targetCategory, $request);
        $data = ['category_name' => $categoryName,
            'category' => $targetCategory,
            'childs' => $catgoryClass->getChilds(),
            'items' => $catgoryClass->getItems(),
            'items_id' => $catgoryClass->getItemsId(),
            'brands' => $catgoryClass->getBrands(),
            'filters' => $catgoryClass->getFilters(),
            'request' => $request->all()];
        if ($request->ajax()) {
            return $this->returnAjaxResult($data);
        }
        return view('Public.category', $data);
    }
    private function returnAjaxResult($data){
        $data['ajax']=true;
        return view('Public.Layouts.categoryList', $data);
    }

    public function sectionShow($section, $id) {
        
    }

}
