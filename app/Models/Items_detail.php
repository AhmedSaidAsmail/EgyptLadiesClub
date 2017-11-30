<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items_detail extends Model
{
    protected $fillable=['item_id','en_name','ar_name','en_title','ar_title','en_description','ar_description','en_keywords','ar_keywords','en_text','ar_text'];
    public function item(){
        return $this->belongsTo(Item::class);
    }
    
}
