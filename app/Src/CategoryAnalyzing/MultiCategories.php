<?php

namespace App\Src\CategoryAnalyzing;

use App\Src\CategoryAnalyzing\CategoryList;

class MultiCategories extends AbstractCategory implements CategoryList {

    use CategoryFunctions;

    private $_class;
    public $request;

    public function __construct(CategoryList $catgoryList) {
        $this->_class = $catgoryList;
        $this->request=$catgoryList->request;
        $this->setCategories_id()
                ->setItems()
                ->setChilds()
                ->setBrands()
                ->setFilters();
    }

    protected function setCategories_id() {
        foreach ($this->_class->getCategories_id() as $catgory_id) {
            if (in_array($catgory_id, $this->_class->request->categories)) {
                $this->categories_id[] = $catgory_id;
            }
        }
        return $this;
    }

    protected function setItems() {
        foreach ($this->_class->getItems() as $id => $item) {
            if (in_array($item['category_id'], $this->categories_id)) {
                $this->items_id[] = $id;
                $this->items[$id] = $item;
            }
        }
        return $this;
    }

    protected function setChilds() {
        foreach ($this->_class->getChilds() as $id => $child) {
            if (in_array($id, $this->_class->request->categories)) {
                $this->childs[$id] = $child;
                $this->allCategories[$id] = $this->_class->allCategories[$id];
            }
        }
        return $this;
    }



}
