<?php

namespace App\Src\HierarchicalData;

class Flatten extends AbstractDataReturned implements ReturnedData {

    public function returnData() {
        return $this->flatten($this->data);
        
    }

    private function flatten(array $array, &$returnArray = []) {

        foreach ($array as $category) {
            $returnArray[$category['id']] = $category['category'];
            if (count($category['children']) > 0) {
                $this->flatten($category['children'], $returnArray);
            }
        }
        return empty($returnArray) ? null : $returnArray;
    }

}
