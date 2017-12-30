<?php

namespace App\Src\CategoryAnalyzing;

use App\Models\Categorie;
use Illuminate\Http\Request;

class Category implements CategoryFactory {

    private $class;

    public function __construct(Categorie $category, Request $request) {
        $this->buildCategory($category, $request);
    }

    public function buildCategory(Categorie $category, Request $request) {
        $data = $request->all();
        $this->setClass(new ParentCategory($category,$request));
        if (isset($data['categories'])) {
            $this->setClass(new MultiCategories($this->class));
        }
        if (isset($data['brands'])) {
            $this->setClass(new BrandsCategory($this->class));
        }
        if (isset($data['filters']) && !is_null($data['filters'])) {
            $this->setClass(new FilterCategory($this->class));
        }
    }

    private function setClass(CategoryList $list) {
        $this->class = $list;
    }

    public function getClass() {
        return $this->class;
    }

}
