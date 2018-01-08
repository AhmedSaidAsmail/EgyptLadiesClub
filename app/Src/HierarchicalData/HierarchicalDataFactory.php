<?php

namespace App\Src\HierarchicalData;

use Illuminate\Database\Eloquent\Collection;

class HierarchicalDataFactory {

    protected $collection;
    private $tempCollection;
    private $returnCollection;

    public function __construct(Collection $collection) {
        $this->setCollection($collection)
                ->setTempCollection()
                ->setReturnCollection();
    }

    private function setCollection(Collection $collection) {
        $this->collection = $collection;
        return $this;
    }

    private function setTempCollection() {
        foreach ($this->collection as $collection) {
            $this->tempCollection[$collection->id] = $collection;
        }
        return $this;
    }

    private function setReturnCollection() {
        $this->returnCollection = $this->parseTree();
        $this->elementsWithoutItsParent();
        return $this;
    }

    private function elementsWithoutItsParent() {
        while (!$this->checkTempArray())
        {
            foreach ($this->tempCollection as  $category) {
                
                $this->returnCollection[] = $this->parseTree($category->parent_id)[0];
            }
        }
    }

    private function parseTree($root = null) {
        $return = [];
        foreach ($this->tempCollection as $id => $category) {
            if ($category->parent_id == $root) {
                unset($this->tempCollection[$id]);
                $return[] = array(
                    'id' => $id,
                    'name' => $category->en_name,
                    'category' => $category,
                    'children' => $this->parseTree($id)
                );
            }
        }
        return empty($return) ? null : $return;
    }

    private function checkTempArray() {
        return empty($this->tempCollection) ? true : false;
    }

    private function filterReturnedArray() {
        return array_filter($this->returnCollection, function ($var) {
            return !is_null($var);
        });
    }

    public function returned($type = null) {
        switch ($type)
        {
            case 'flatten':
                return new Flatten($this->filterReturnedArray());
            case 'printed':
                return new PrintedData($this->filterReturnedArray());
        }
    }

}
