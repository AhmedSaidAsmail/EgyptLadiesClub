<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories_filter extends Model
{
    protected $fillable=['category_id','filter_id'];
    public function filter(){
        return $this->belongsTo(\App\Models\Filter::class);
    }
}
