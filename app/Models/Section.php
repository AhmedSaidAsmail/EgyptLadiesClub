<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model {

    protected $fillable = [
        'en_name',
        'ar_name',
        'title',
        'status',
        'top_list',
        'arrangement',
        'img',
        'symbol',
        'keywords',
        'description'];

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function brands() {
        return $this->belongsToMany(Brand::class, 'section_brands');
    }

    public function checkBrand($brand_id) {
        $brand = $this->belongsToMany(Brand::class, 'section_brands')->where('brand_id', '=', $brand_id)->first();
        return (isset($brand)) ? true : false;
    }
 
}
