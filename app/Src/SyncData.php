<?php

namespace App\Src;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Exception;

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

    public function __construct(Model $model, $related, array $data) {
        $this->setData($data)
                ->setCollection($model, $related)
                ->setHasMany($model, $related)
                ->setColumnListing();
    }
    private function setData(array $data) {
        $this->data = $data;
        return $this;
    }

    private function setCollection(Model $model, $related) {
        if ($model->$related instanceof Collection) {
            $this->collection = $model->$related;
        }
        else {
            throw new Exception('this is not a valid collection');
        }
        return $this;
    }

    private function setHasMany(Model $model, $related) {
        if ($model->$related() instanceof HasMany) {
            $this->hasMany = $model->$related();
        }
        else {
            throw new Exception('this is not a valid HasMany Relation');
        }
        return $this;
    }

    private function setColumnListing() {
        $this->columnListing = $this->hasMany->getRElated()->getFillable();
    }

    public static function getInstance(Model $model, $related, array $data) {
        self::$instance = new self($model, $related, $data);
        return self::$instance;
    }

    public static function sync(Model $model, $related, array $data) {
        $instance = self::getInstance($model, $related, $data);
        $instance->setCurrent()
                ->setArrays()
                ->syncUpdated()
                ->syncCreated()
                ->syncDeleted();
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
