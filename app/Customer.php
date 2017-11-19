<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

    protected $fillable = [
        'email',
        'password',
        'confirm',
        'name',
        'address',
        'city',
        'state',
        'country',
        'phone',
        'newsletter'
    ];

}
