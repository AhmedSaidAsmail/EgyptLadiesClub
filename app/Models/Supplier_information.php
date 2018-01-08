<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier_information extends Model {

    protected $fillable = [
        'f_name',
        'l_name',
        'mobile',
        'company',
        'store_name',
        'address',
        'city',
        'postal_code',
    ];

}
