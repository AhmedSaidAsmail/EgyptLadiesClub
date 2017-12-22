<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filters_item extends Model
{
     protected $fillable=['filter_id','filter_ar_name','filter_en_name','filter_sort_order','has_image'];
     public function filters(){
         return $this->belongsTo(\App\Models\Filter::class);
     }
     public function categoryItems(array $catgegories){
         return $this->belongsToMany(Item::class,'items_filters')->whereIn('categorie_id',$catgegories)->get();
     }
}
