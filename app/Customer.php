<?php

namespace App;

class Customer extends User {

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
