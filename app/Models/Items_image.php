<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items_image extends Model {

    protected $fillable = ['item_id', 'item_image', 'image_sort_order'];
    protected $_path = 'images/items/';

    public function item() {
        return $this->belongsTo(\App\Models\Item::class);
    }

    public function delete() {
        $this->removeImg($this->item_image, $this->_path);
        return parent::delete();
    }

    private function removeImg($image, $path) {
        $dir=dirname(dirname(__DIR__)).'/public/'.$path;
        (file_exists($dir . $image)) ? unlink($dir . $image) : '';
        (file_exists($dir . 'thumb/' . $image)) ? unlink($dir . 'thumb/' . $image) : '';
    }

}
