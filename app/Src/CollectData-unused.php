<?php

namespace App\Src;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class CollectData {

    private $table;
    private $path;
    private $primaryKey=null;
    private $request;
    private $columnListing;

    public function __construct(array $details) {
        foreach ($details as $key => $value) {
            $key = ucfirst($key);
            $method = "set{$key}";
            $this->$method($value);
        }
    }

    private function setTable($table) {
        $this->table = $table;
    }

    private function setPath($path) {
        $this->path = $path;
    }

    private function setPrimaryKey($primaryKey) {
        $this->primaryKey = $primaryKey;
    }

    private function setRequest(Request $request) {
        $this->request = $request;
    }

    private function setColumnListing() {
        $this->columnListing = DB::getSchemaBuilder()->getColumnListing($this->table);
        return $this;
    }

    private function addPrimaryKey() {
        if (!is_null($this->primaryKey)) {
            $this->columnListing[] = $this->primaryKey;
        }
    }

    private function perpareCollectionData(array &$collection, $field) {
        foreach ($this->request->$field as $key => $fieldData) {
            $collectionKey = (!is_null($this->primaryKey) && $this->primaryKey == $field) ? "id" : $field;
            $collectionValue = $this->CheckImageValue($fieldData);
            $collection[$key][$collectionKey] = $collectionValue;
        }
    }

    private function CheckImageValue($value) {
        if ($value instanceof UploadedFile) {
            return uploadImage(['image' => $value, 'path' => $this->path]);
        }
        return $value;
    }

    public  function build() {
        $collection = [];
        $this->setColumnListing()->addPrimaryKey();
        foreach ($this->columnListing as $field) {
            if (isset($this->request->$field) && !is_null($this->request->$field)) {
                $this->perpareCollectionData($collection, $field);
            }
        }
        return $collection;
//        return $this->primaryKey;
    }

}
