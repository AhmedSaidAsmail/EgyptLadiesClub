<?php

use App\Src\SectionChilds;
use App\Src\CategoryChilds;
use App\Src\CategoryAnalyzing\Category;
use Illuminate\Http\UploadedFile;
use App\Src\Facades\UploadFacades;
use App\Src\ArrayMethods;
//use App\Src\CollectData;
use Illuminate\Http\Request;
use App\Src\SyncData;
use Illuminate\Database\Eloquent\Model;
use App\Src\HierarchicalData\HierarchicalDataFactory;
use App\Src\CollectData\CollectFactory;

if (!function_exists('sectionChilds')) {

    function sectionChilds($section) {
        return SectionChilds::Childs($section);
    }

}
if (!function_exists('checkChilds')) {

    function checkChilds($category) {
        return CategoryChilds::checkChilds($category);
    }

}
if (!function_exists('categoryChilds')) {

    function categoryChilds($category) {
        return CategoryChilds::childs($category);
    }

}
if (!function_exists('analyzeCategory')) {

    function analyzeCategory($category, $request) {
        $analyze = new Category($category, $request);
        return $analyze->getClass();
    }

}
if (!function_exists('uploadImage')) {

    function uploadImage(array $imgDetails) {
        if (isset($imgDetails['image']) && $imgDetails['image'] instanceof UploadedFile) {
            $width = isset($imgDetails['width']) ? $imgDetails['width'] : 250;
            $exImage = isset($imgDetails['exImage']) ? $imgDetails['exImage'] : null;
            return UploadFacades::Upload($imgDetails['image'], $imgDetails['path'], $width, $exImage);
        }
        return $imgDetails['image'];
    }

}
if (!function_exists('colleactRecursiveArray')) {

    function colleactRecursiveArray(Request $request, $tableName, $path, $primaryKey = null) {
        return ArrayMethods::colleactRecursiveArray($request, $tableName, $path, $primaryKey);
    }

}
if(!function_exists('collectData')){
    function collectData(array $details,$type = 'multiple'){
        $factory= new CollectFactory($details, $type);
        return $factory->build()->collect();
//        $collection=new CollectData($details);
//        return $collection->build();
    }
}
if(!function_exists('hierarchicalData')){
    function hierarchicalData($collection,$type){
        $dataFactory= new HierarchicalDataFactory($collection);
        return $dataFactory->returned($type)->returnData();
    }
    
    
}
if (!function_exists('sync')) {

    function sync(Model $model, $related, array $data) {
        SyncData::sync($model, $related, $data);
    }

}