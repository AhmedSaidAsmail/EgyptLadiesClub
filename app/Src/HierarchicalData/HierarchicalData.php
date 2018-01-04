<?php

namespace App\Src\HierarchicalData;

use Illuminate\Database\Eloquent\Collection;

class HierarchicalData {

    private static $instance;
    public $dataArray = [];
    public $parentChildsArray = [];

    public function __construct($categories) {
        $this->dataArray = $categories;
    }

    public static function makeTree(Collection $categories) {
        $instance = self::getInstance($categories);
        return $instance->setArray()->parseTree();
    }

    public static function printTree(Collection $categories) {
        $instance = self::getInstance($categories);
        $tree= $instance->setArray()->parseTree();
        $instance->printArray($tree);
    }

    public static function getInstance($categories) {

        return self::$instance = new self($categories);
    }

    private function setArray() {
        foreach ($this->dataArray as $category) {
            $this->parentChildsArray[$category->id] = $category;
        }
        return $this;
    }

    private function parseTree($root = null) {
        $return = [];
        foreach ($this->parentChildsArray as $child => $category) {
            if ($category->parent_id == $root) {
                unset($this->parentChildsArray[$child]);
                $return[] = array(
                    'id' => $child,
                    'name' => $category->en_name,
                    'category' => $category,
                    'children' => $this->parseTree($child)
                );
            }
        }
        return empty($return) ? null : $return;
    }

    public static function flatten(array $array, &$returnArray = []) {

        foreach ($array as $category) {
            $returnArray[$category['id']] = $category['category'];
            if (count($category['children']) > 0) {
                static::flatten($category['children'], $returnArray);
            }
        }
        return empty($returnArray) ? null : $returnArray;
    }

    public function printArray($tree) {
        if (!is_null($tree) && count($tree) > 0) {
            echo '<ul>';
            foreach ($tree as $node) {
                echo '<li><a href="">' . $node['name']."</a>";
                $this->printArray($node['children']);
                echo '</li>';
            }
            echo '</ul>';
        }
    }

}
