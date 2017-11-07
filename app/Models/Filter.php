<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model {

    protected $fillable = ['en_name', 'ar_name', 'sort_order'];

    public function filter_items() {
        return $this->hasMany(\App\Models\Filters_item::class);
    }

    public function delete() {
        $this->filter_items()->delete();
        return parent::delete();
    }

}
