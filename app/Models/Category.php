<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

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
    protected $table = 'categories';

    public function childs() {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parents() {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function section() {
        return $this->belongsTo(Section::class);
    }

    public function filters() {
        return $this->belongsToMany(Filter::class, 'categories_filters');
    }
    public function checkFilter($filterId){
        $filter_exists= $this->filters()->where('filter_id','=',$filterId)->first();
        return isset($filter_exists)?true:false;
    }

    public function brands() {
        return $this->belongsToMany(Brand::class, 'category_brands');
    }
        public function checkBrand($brandId){
        $brand_exists= $this->brands()->where('brand_id','=',$brandId)->first();
        return isset($brand_exists)?true:false;
    }

    public function brandsExists(array $brands) {
        return $this->hasMany(Category_brand::class)->whereIn('brand_id', $brands)->count();
    }

    public function category_Brands(array $brands) {
        return $this->hasMany(Category_brand::class)->WhereIn('brand_id', $brands)->get();
    }

    public function categories_filters() {
        return $this->hasMany(Categories_filter::class);
    }

    public function category_links() {
        return $this->hasMany(Category_link::class);
    }

    public function items() {
        return $this->hasMany(Item::class);
    }

    public function countItems(array $items) {
        return $this->hasMany(Item::class)->whereIn('id', $items)->count();
    }

    public function analyzeName() {
        $return = [];
        $return[] = $this->en_name;
        if (!is_null($this->parents)) {
            $return[] = $this->parents->analyzeName();
        }
        return self::getName($return);
    }

    private static function getName(array $name) {
        return implode(' > ', array_reverse($name));
    }

    public function delete() {
        $this->categories_filters()->delete();
        return parent::delete();
    }

}
