<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SyncData {

    private static $instance;
    protected $hasMany;
    protected $collection;
    protected $table;
    protected $data;
    protected $columnListing;
    protected $current = [];
    protected $updated = [];
    protected $created = [];
    protected $deleted = [];

    public function __construct(Collection $collection, HasMany $hasMany, $table, $data) {
        $this->collection = $collection;
        $this->hasMany = $hasMany;
        $this->table = $table;
        $this->data = $data;
    }

    public static function getInstance(Collection $collection, HasMany $hasMany, $table, $data) {
        self::$instance = new self($collection, $hasMany, $table, $data);
        return self::$instance;
    }

    public static function sync(Collection $collection, HasMany $hasMany, $table, $data) {
        $instance = self::getInstance($collection, $hasMany, $table, $data);
        return $instance->getColumnListing()
                        ->setCurrent()
                        ->setArrays()
                        ->syncUpdated()
                        ->syncCreated()
                        ->syncDeleted();
    }

    public function getColumnListing() {
        $this->columnListing = DB::getSchemaBuilder()->getColumnListing($this->table);
        return $this;
    }

    public function setCurrent() {
        foreach ($this->collection as $currentRow) {
            $this->current[] = $currentRow->id;
        }
        return $this;
    }

    public function setArrays() {
        foreach ($this->data as $row) {
            if (isset($row['id']) && in_array($row['id'], $this->current)) {
                $this->updated[] = $row;
                unset($this->current[array_search($row['id'], $this->current)]);
            }
            else {
                $this->created[] = $row;
            }
        }
        $this->deleted = $this->current;
        return $this;
    }

    public function syncUpdated() {
        foreach ($this->updated as $update) {
            $currentRow = $this->collection->find($update['id']);
            $currentRow->update($update);
        }
        return $this;
    }

    public function syncCreated() {
        if (!is_null($this->created)) {
            $this->hasMany->createMany($this->created);
        }
        return $this;
    }

    public function syncDeleted() {
        foreach ($this->deleted as $deleted) {
            $currentRow = $this->collection->find($deleted);
            $currentRow->delete();
        }
    }

}
