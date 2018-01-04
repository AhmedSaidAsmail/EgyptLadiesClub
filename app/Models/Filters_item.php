<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filters_item extends Model {

    protected $fillable = ['filter_id', 'filter_ar_name', 'filter_en_name', 'filter_sort_order', 'has_image'];

    public function filters() {
        return $this->belongsTo(\App\Models\Filter::class);
    }
        public function countItems(array $items){
        return $this->hasMany(Items_filter::class)->whereIn('item_id', $items)->count();
    }
    public function checkItem($item_id){
        $check= $this->hasMany(Items_filter::class)->where('item_id',$item_id)->first();
        return isset($check)?true:false;
    }

//    public function getFilteredItems(array $filters) {
//        if(isset($filters['brands'])){
//            return $this->belongsToMany(Item::class, 'items_filters')
//                    ->whereIn('categorie_id', $filters['categories'])
//                    ->whereIn('brand_id', $filters['brands'])->get();
//        }
//        if (isset($filters['categories'])) {
//            return $this->belongsToMany(Item::class, 'items_filters')->whereIn('categorie_id', $filters['categories'])->get();
//        }
//    }

}
