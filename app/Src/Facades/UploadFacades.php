<?php
namespace App\Src\Facades;

use Illuminate\Support\Facades\Facade;

class UploadFacades extends Facade {

    protected static function getFacadeAccessor() {
        return 'UploadImage';
    }

}