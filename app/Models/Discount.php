<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fiilable=['item_id','quantity','price','date_start','date_end'];
}
