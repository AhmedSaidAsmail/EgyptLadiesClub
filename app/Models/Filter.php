<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model {

    protected $fillable = ['en_name', 'ar_name', 'sort_order'];

    public function filter_items() {
        return $this->hasMany(Filters_item::class);
    }

    public function checkFilterItems(array $filters) {
        return $this->hasMany(Filters_item::class)->whereIn('id', $filters)->count() > 0 ? TRUE : FALSE;
    }

    public function delete() {
        $this->filter_items()->delete();
        return parent::delete();
    }

}
