<?php

namespace App\Src\CategoryAnalyzing;

use App\Models\Category as CategoryModel;
use Illuminate\Http\Request;



interface CategoryFactory {

    public function buildCategory(CategoryModel $category, Request $request);
}
