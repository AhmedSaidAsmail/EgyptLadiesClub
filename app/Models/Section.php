<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model {

    protected $fillable = [
        'en_name',
        'ar_name',
        'title',
        'status',
        'top_list',
        'arrangement',
        'img',
        'keywords',
        'description'];
    public function categories(){
        return $this->hasMany(\App\Models\Categorie::class);
    }
    public function delete() {
        $this->categories()->delete();
        return parent::delete();
    }

}
