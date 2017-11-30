<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable=['item_id','dis_quantity','dis_price','date_start','date_end'];
    public function item(){
        return $this->belongsTo(\App\Models\Item::class);
    }
}
