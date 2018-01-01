<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model {

    protected $fillable = ['en_name', 'ar_name', 'sort_order', 'img'];
    public function items(){
        return $this->hasMany(Item::class);
    }
    public function categoryItems(array $catgegories){
        return $this->hasMany(Item::class)->whereIn('category_id',$catgegories)->get();
    }

}
