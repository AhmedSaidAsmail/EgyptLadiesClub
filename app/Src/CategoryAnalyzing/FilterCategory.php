<?php

namespace App\Src\CategoryAnalyzing;

class FilterCategory extends AbstractCategory implements CategoryList {

    private $_class;
    public $request;
    private $filter_items = [];

    public function __construct(CategoryList $catgoryList) {
        $this->_class = $catgoryList;
        $this->request = $catgoryList->request;
        $this->setFilters()->setItems()->setChilds()->setBrands();
    }

    protected function setFilters() {
        foreach ($this->_class->getFilters() as $filter) {
            if ($filter->checkFilterItems($this->_class->request->filters)) {
                $this->filters[$filter->id] = $filter;
            }
        }
        return $this;
    }

    protected function setItems() {
        foreach ($this->_class->getItems() as $id => $item) {
            if ($item['item']->checkFiltersExists($this->_class->request->filters)) {
                $this->items_id[] = $id;
                $this->items[$id] = $item;
            }
        }
        return $this;
    }

    protected function setChilds() {
        foreach ($this->_class->getChilds() as $id => $child) {
            if ($child['category']->countItems($this->items_id) > 0) {
                $this->childs[$id]['category'] = $child['category'];
                $this->childs[$id]['items'] = $child['category']->countItems($this->items_id);
            }
        }
        return $this;
    }

    protected function setBrands() {
        foreach ($this->_class->getBrands() as $id => $brand) {
            if (count(collect($this->items)->where('brand_id', $id)) > 0) {
                $this->brands[$id] = $brand;
                $this->brands[$id]['items'] = count(collect($this->items)->where('brand_id', $id));
            }
        }
    }

}
