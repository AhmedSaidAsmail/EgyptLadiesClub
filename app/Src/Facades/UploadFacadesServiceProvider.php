<?php
namespace App\Src\Facades;

use Illuminate\Support\ServiceProvider;
use App;

class UploadFacadesServiceProvider extends ServiceProvider {

    public function boot() {

    }
    public function register() {
        App::bind('UploadImage', function() {
            return new \App\Src\UploadFacades();
        });
    }

}