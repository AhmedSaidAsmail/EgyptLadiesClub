<?php

namespace App\Src\CategoryAnalyzing;

use App\Models\Categorie as CategoryModel;
use Illuminate\Http\Request;

class ParentCategory extends AbstractCategory implements CategoryList {

    use CategoryFunctions;

    public $category;
    public $request;

    public function __construct(CategoryModel $category, Request $request = null) {
        $this->category = $category;
        $this->request = (!is_null($request)) ? $request : null;
        $this->setCategoriesList();
        $this->run();
    }

    private function setCategoriesList() {

        $this->setParentCategories($this->category)->setCategories_id();
    }

    private function setParentCategories(CategoryModel $category) {
        $this->allCategories[$category->id] = $category;
        if (count($category->childs) > 0) {
            foreach ($category->childs as $child) {
                if (count($child->childs) > 0) {
                    $this->setParentCategories($child);
                }
                else {
                    $this->allCategories[$child->id] = $child;
                }
            }
        }
        return $this;
    }

    protected function run() {
        $this->setChilds()
                ->setBrands()
                ->setFilters()
                ->setItems();
    }

    protected function setChilds() {

        foreach ($this->allCategories as $id => $category) {
            if ($id != $this->category->id) {
                $this->childs[$id]['category'] = $category;
                $this->childs[$id]['items'] = count($category->items);
            }
        }
        return $this;
    }

    protected function setCategories_id() {
        foreach ($this->allCategories as $category) {
            $this->categories_id[] = $category->id;
        }
        return $this;
    }

    protected function setItems() {
        foreach ($this->allCategories as $category) {
            $items = $category->items()->where('status', '=', 1)
                    ->where('enable', '=', 1)
                    ->get();
            $this->setCategoryItems($items);
        }
    }

    private function setCategoryItems($items) {
        foreach ($items as $item) {
            $this->items_id[] = $item->id;
            $this->items[$item->id]['sort_order'] = $item->sort_order;
            $this->items[$item->id]['item'] = $item;
            $this->items[$item->id]['category_id'] = $item->categorie->id;
            $this->items[$item->id]['brand_id'] = $item->brand_id;
            $this->items[$item->id]['price'] = $item->price;
        }
    }

}
