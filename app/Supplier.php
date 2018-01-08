<?php

namespace App;

class Supplier extends User {

    protected $fillable = [
        'email',
        'password',
        'confirm',
        'rand_code',
        'items'
    ];

    public function items() {
        return $this->hasMany(\App\Models\Item::class);
    }

    public function reviews() {
        return $this->hasManyThrough(\App\Models\Review::class, \App\Models\Item::class);
    }
    public function informations(){
        return $this->hasOne(Models\Supplier_information::class);
    }

    public function categories(){
        return $this->belongsToMany(\App\Models\Category::class,'supplier_categories');
    }

}
