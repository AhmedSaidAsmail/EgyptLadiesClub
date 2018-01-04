<?php


namespace App\Src\HierarchicalData;


abstract class AbstractDataReturned {
    protected $data;

    public function __construct(array $data) {
        $this->data=$data;
    }

    abstract public function returnData();
}
