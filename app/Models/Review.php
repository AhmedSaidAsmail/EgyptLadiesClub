<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {

    protected $fillable = [
        'item_id',
        'customer_id',
        'overall_rating',
        'good',
        'bad',
        'review',
        'date',
        'confirm'];

    public function item() {
        return $this->belongsTo(Item::class);
    }

    public function customer() {
        return $this->belongsTo(\App\Customer::class);
    }

}
