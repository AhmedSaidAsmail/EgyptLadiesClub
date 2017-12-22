<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Categorie;

class HomeController extends Controller {

    public function home() {
        $sections = Section::all();
        return view('Public.home', ['sections' => $sections]);
    }

    public function categoryShow(Request $request, $categoryName, $id, $barnd = null) {
        $category = Categorie::find($id);
        $allCategories = categoryChilds($category);
        $items = $allCategories->getItems();
        return view('Public.category', ['category_name' => $categoryName,
            'category' => $category,
            'allCategories' => $allCategories,
            'items'=>$items]);
    }

    public function sectionShow($section, $id) {
        
    }

}
