<?php

namespace App\Src;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use UploadImage;

class ArrayMethods {

    public static function collectArray(Request $request, $table) {
        $collection = [];
        $fields = DB::getSchemaBuilder()->getColumnListing($table);
        foreach ($fields as $field) {
            if (isset($request->$field) && !is_null($request->$field)) {
                $collection[$field] = $request->$field;
            }
        }
        return $collection;
    }

    private static function getColumnListing($table) {
        $columnListing = DB::getSchemaBuilder()->getColumnListing($table);
        return $columnListing;
    }

    private static function setPrimrayKey(array &$fields, $primaryKey = null) {
        if (!is_null($primaryKey)) {
            $fields[] = $primaryKey;
        }
    }

    public static function colleactRecursiveArray(Request $request, $table, $path, $primaryKey = null) {
        $collection = [];
        $fields = static::getColumnListing($table);
        self::setPrimrayKey($fields, $primaryKey);
        foreach ($fields as $field) {
            if (isset($request->$field) && !is_null($request->$field)) {
                self::perpareCollectionData($collection, $field, $request, $path, $primaryKey);
            }
        }
        return $collection;
    }

    private static function perpareCollectionData(array &$collection, $field, Request $request, $path, $primaryKey = null) {
        foreach ($request->$field as $key => $fieldData) {
            $fixField = (!is_null($primaryKey) && $primaryKey == $field) ? "id" : $field;
            $data = self::uploadImage($fieldData, $path);
            $collection[$key][$fixField] = $data;
        }
    }

    protected static function uploadImage($value, $path) {
        if ($value instanceof UploadedFile) {
            return UploadImage::Upload($value, $path, 250);
        }
        return $value;
    }

}
