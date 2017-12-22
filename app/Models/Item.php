<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    protected $fillable = ['supplier_id', 'categorie_id', 'brand_id', 'model', 'img', 'price', 'quantity', 'min_quantity', 'shipping', 'date_available','status','enable'];

    public function supplier() {
        return $this->belongsTo(\App\Supplier::class);
    }

    public function categorie() {
        return $this->belongsTo(\App\Models\Categorie::class);
    }

    public function brands() {
        return $this->belongsTo(Brand::class);
    }

    public function details() {
        return $this->hasOne(Items_detail::class);
    }
    public function filters(){
        return $this->belongsToMany(Filters_item::class,'items_filters');
    }

    public function item_filters() {
        return $this->hasMany(Items_filter::class);
    }

    public function images() {
        return $this->hasMany(Items_image::class);
    }
    public function discounts(){
        return $this->hasMany(Discount::class);
    }

    public function related() {
        return $this->hasMany(Related_product::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function delete() {
        $this->details()->delete();
        $this->item_filters()->delete();
        $this->discounts()->delete();
        $this->images()->delete();
        $this->related()->delete();
        return parent::delete();
    }

}
