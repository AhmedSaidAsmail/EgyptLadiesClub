<?php

namespace App\Src\CategoryAnalyzing;

interface CategoryList {

    public function getCategories_id();

    public function getChilds();

    public function getBrands();

    public function getFilters();

    public function getItems();
}
