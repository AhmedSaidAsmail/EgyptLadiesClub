<?php
use App\Src\SectionChilds;
use App\Src\CategoryChilds;
if(!function_exists('sectionChilds')){
    function sectionChilds($section){
        return SectionChilds::Childs($section);
    }
}
if(!function_exists('checkChilds')){
    function checkChilds($category){
        return CategoryChilds::checkChilds($category);
    }
}
if(!function_exists('categoryChilds')){
    function categoryChilds($category){
        return CategoryChilds::childs($category);
    }
}