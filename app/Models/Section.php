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
        'symbol',
        'keywords',
        'description'];

    public function categories() {
        return $this->hasMany(Categorie::class);
    }

    public function brands() {
        return $this->belongsToMany(Brand::class, 'section_brands');
    }

    public function delete() {
        $this->categories()->delete();
        return parent::delete();
    }

}
