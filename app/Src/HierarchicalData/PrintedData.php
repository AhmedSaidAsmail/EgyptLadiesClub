<?php

namespace App\Src\HierarchicalData;

class PrintedData extends AbstractDataReturned implements ReturnedData {

    public function returnData() {
        $this->printArray($this->data);
    }

    public function printArray($tree) {
        if (!is_null($tree) && count($tree) > 0) {
            echo '<ul>';
            foreach ($tree as $node) {
                echo '<li><a href="'.route('category.show',['category'=>$node['category']->en_name,'id'=>$node['category']->id]).'">' . $node['name'] . "</a>";
                $this->printArray($node['children']);
                echo '</li>';
            }
            echo '</ul>';
        }
    }

}
