<?php

namespace App\Src\CategoryAnalyzing;

trait CategoryFunctions {

    protected function setBrands() {
        foreach ($this->allCategories as $category) {
            if (!empty($category->brands)) {
                $brands = $category->brands;
                $this->setCategoryBrands($brands);
            }
        }

        return $this;
    }

    private function setCategoryBrands($brands) {
        foreach ($brands as $brand) {
            $this->brands[$brand->id]['sort_order'] = $brand->sort_order;
            $this->brands[$brand->id]['items'] = count($brand->categoryItems($this->categories_id));
            $this->brands[$brand->id]['brand'] = $brand;
        }
    }
    protected function setFilters() {
        foreach ($this->allCategories as $category) {
            if (!empty($category->filters)) {
                $filters = $category->filters;
                $this->setCategoryFilters($filters);
            }
        }
        return $this;
    }

    private function setCategoryFilters($filters) {
        foreach ($filters as $filter) {
            $this->filters[$filter->id] = $filter;
        }
    }

}
