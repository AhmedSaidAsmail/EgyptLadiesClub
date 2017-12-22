<?php

namespace App;

class Supplier extends User {

    protected $fillable = [
        'email',
        'password',
        'confirm',
        'f_name',
        'l_name',
        'mobile',
        'company',
        'store_name',
        'address',
        'city',
        'postal_code',
        'rand_code',
    ];

    public function items() {
        return $this->hasMany(\App\Models\Item::class);
    }

    public function reviews() {
        return $this->hasManyThrough(\App\Models\Review::class, \App\Models\Item::class);
    }

}
