<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items_image extends Model {

    protected $fillable = ['item_id', 'item_image', 'image_sort_order'];

    public function item() {
        return $this->belongsTo(\App\Models\Item::class);
    }

}
