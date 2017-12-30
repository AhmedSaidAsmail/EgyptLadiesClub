<?php

namespace App\Src\CategoryAnalyzing;

use App\Models\Categorie;
use Illuminate\Http\Request;



interface CategoryFactory {

    public function buildCategory(Categorie $category, Request $request);
}
