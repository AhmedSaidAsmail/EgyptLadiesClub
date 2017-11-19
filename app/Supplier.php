<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
        protected $fillable = [
        'email',
        'password',
        'confirm',
        'title',
        'f_name',
        'l_name',
        'company',
        'address',
        'city',
        'state',
        'country',
        'phone',
        'fax',
        'website',
        'company_type',
        'service_offer'
    ];
}
