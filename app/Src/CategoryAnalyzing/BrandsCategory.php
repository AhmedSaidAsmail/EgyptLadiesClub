<?php

namespace App\Src\CategoryAnalyzing;

class BrandsCategory extends AbstractCategory implements CategoryList {

    use CategoryFunctions;

    private $_class;
    public $request;

    public function __construct(CategoryList $catgoryList) {
        $this->_class = $catgoryList;
        $this->request = $catgoryList->request;
        $this->setBrands()
                ->setItems()
                ->setChilds()
                ->setFilters();
    }

    protected function setBrands() {
        foreach ($this->_class->getBrands() as $id => $brand) {
            if (in_array($id, $this->_class->request->brands)) {
                $this->brands[$id] = $brand;
            }
        }
        return $this;
    }

    protected function setItems() {
        foreach ($this->_class->getItems() as $id => $item) {
            if (in_array($item['brand_id'], $this->_class->request->brands)) {
                $this->items_id[] = $id;
                $this->items[$id] = $item;
                $this->allCategories[$item['category_id']] = $this->_class->allCategories[$item['category_id']];
            }
        }
        return $this;
    }

    protected function setChilds() {
        foreach ($this->_class->getChilds() as $id => $child) {
            if ($child['category']->brandsExists($this->_class->request->brands) > 0) {
                $this->childs[$id]['category'] = $child['category'];
                $this->childs[$id]['items'] = $child['category']->countItems($this->items_id);
            }
        }
        return $this;
    }

}
