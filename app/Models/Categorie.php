<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model {

    protected $fillable = [
        'section_id',
        'has_parent',
        'parent_id',
        'en_name',
        'ar_name',
        'arrangement',
        'title',
        'txt',
        'status',
        'recommended',
        'keywords',
        'description',
        'img'];

    public function childs() {
        return $this->hasMany(\App\Models\Categorie::class, 'parent_id', 'id');
    }

    public function section() {
        return $this->belongsTo(\App\Models\Section::class);
    }

    public function filters() {
        return $this->belongsToMany(\App\Models\Filter::class, 'categories_filters');
    }

    public function brands() {
        return $this->belongsToMany(Brand::class, 'category_brands');
    }
    public function brandsExists(array $brands){
        return $this->hasMany(Category_brand::class)->whereIn('brand_id',$brands)->count();
    }

    public function category_Brands(array $brands) {
        return $this->hasMany(Category_brand::class)->WhereIn('brand_id', $brands)->get();
    }

    public function categories_filters() {
        return $this->hasMany(\App\Models\Categories_filter::class);
    }

    public function category_links() {
        return $this->hasMany(Category_link::class);
    }

    public function items() {
        return $this->hasMany(\App\Models\Item::class);
    }

    public function countItems(array $items) {
        return $this->hasMany(Item::class)->whereIn('id', $items)->count();
    }

    public function delete() {
        $this->categories_filters()->delete();
        return parent::delete();
    }

}
