<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filters_item extends Model
{
     protected $fillable=['filter_id','en_name','ar_name','sort_order','has_image'];
     public function filters(){
         return $this->belongsTo(\App\Models\Filter::class);
     }
}
