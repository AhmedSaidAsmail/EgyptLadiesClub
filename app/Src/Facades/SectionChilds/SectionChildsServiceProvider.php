<?php

namespace App\Src\Facades\SectionChilds;

use Illuminate\Support\ServiceProvider;
use App;

class SectionChildsServiceProvider extends ServiceProvider {

    public function boot() {
        
    }

    public function register() {
        App::bind('sectionChild', function() {
            return new \App\Src\SectionChilds();
        });
    }

}
