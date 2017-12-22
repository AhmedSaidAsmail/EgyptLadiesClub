<?php

namespace App\Src;

use App\Models\Categorie;

class CategoryChilds {

    private static $_instance = null;
    private $categories_id = [];
    private $childs = [];
    private $items = [];
    private $brands = [];
    private $filters=[];

    private function __construct() {
        
    }

    private static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public static function checkChilds(Categorie $category) {
        if (count($category->childs) > 0) {
            return true;
        }
        return false;
    }

    public static function childs(Categorie $category) {
        $instance = static::getInstance();
        $instance->setChilds($category);
        return $instance;
    }

    private function setChilds(Categorie $category) {
        $this->setelEments($category);
        foreach ($category->childs as $child) {
            if (count($child->childs) > 0) {
                $this->setChilds($child);
            }
            else {
                $this->setelEments($child);
            }
            $this->childs[$child->id]['category'] = $child;
            $this->childs[$child->id]['items'] = count($child->items);
        }
    }

    private function setelEments(Categorie $category) {
        $this->setBrands($category)
                ->setCategories_id($category)
                ->setItems($category)
                ->setFilters($category);
    }

    private function setBrands(Categorie $category) {
        if (!empty($category->brands())) {
            $brands = $category->brands;
            $this->brands = array_merge($this->brands, $brands->all());
        }
        return $this;
    }

    private function setItems(Categorie $category) {
        $items = $category->items()->where('status', '=', 1)
                ->where('enable', '=', 1)
                ->get();
        $this->items = array_merge($this->items, $items->all());
        return $this;
    }

    private function setCategories_id(Categorie $category) {
        $this->categories_id[] = $category->id;
        return $this;
    }
    private function setFilters(Categorie $category){
        foreach ($category->filters as $filter){
            $this->filters[$filter->id]=$filter;
        } 
    }

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
        return collect($this->items);
    }

    public function getBrands() {
        return collect($this->brands);
    }

    public function getCategories_id() {
        return $this->categories_id;
    }
    public function getFilters(){
        return $this->filters;
    }

}
