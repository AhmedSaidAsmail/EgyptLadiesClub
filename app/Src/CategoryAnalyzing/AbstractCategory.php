<?php

namespace App\Src\CategoryAnalyzing;

abstract class AbstractCategory {
    public $allCategories = [];
    public $categories_id = [];
    public $childs = [];
    public $items = [];
    public $items_id = [];
    public $brands = [];
    public $filters = [];
    public $filteredItemsArguments = [];

    abstract protected function setChilds();

    abstract protected function setBrands();

    abstract protected function setFilters();

    abstract protected function setItems();

    private function sortChilds() {
        $childs = collect($this->childs);
        $items = $childs->all();
        ksort($items);
        return collect($items);
    }

    public function getChilds() {
        return $this->sortChilds();
    }

    public function getItems() {
        return collect($this->items)->sortBy('sort_order');
    }

    public function getItemsId() {
        return $this->items_id;
    }

    public function getBrands() {
        return collect($this->brands)->sortBy('sort_order');
    }

    public function getCategories_id() {
        return $this->categories_id;
    }

    public function getFilters() {
        return $this->filters;
    }

    public function getFilteredItemsArguments() {
        return $this->filteredItemsArguments;
    }

}
