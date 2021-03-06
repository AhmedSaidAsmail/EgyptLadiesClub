<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category_link extends Model {

    protected $fillable = ['category_id', 'link', 'link_img', 'link_sort_order','header1','header2'];
    public function category(){
        return $this->belongsTo(Category::class);
    }

}
