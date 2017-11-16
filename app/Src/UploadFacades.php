<?php
namespace App\Src;

use Intervention\Image\Facades\Image;

class UploadFacades {

    protected static $_img = [];
    public function Upload($image, $path, $width) {
        $newPath = public_path() . $path;
        if (!is_dir($newPath)) {
            mkdir($newPath, 0777);
            mkdir($newPath . "thumb/", 0777);
        }
        $filename = md5(uniqid(mt_rand())) . "." . $image->getClientOriginalExtension();
        $thumb    = Image::make($image->getRealPath())->resize($width, null, function ($ratio) {
            $ratio->aspectRatio();
        });
        $thumb->save($newPath . "thumb/" . $filename);
        $image->move($newPath, $filename);
        self::$_img['image'] = $newPath . $filename;
        self::$_img['thumb'] = $newPath . 'thumb/' . $filename;
        return $filename;
    }
    public function removeImg() {
        (isset(self::$_img['image']) && file_exists(self::$_img['image'])) ? unlink(self::$_img['image']) : '';
        (isset(self::$_img['thumb']) && file_exists(self::$_img['thumb'])) ? unlink(self::$_img['thumb']) : '';
    }
    // to avoid if not created new entry  to don't delete the old image
    public function removeExImg($img, $path) {
        $newPath = public_path() . $path;
        $exImg   = $newPath . $img;
        $exThmub = $newPath . 'thumb/' . $img;
        (file_exists($exImg)) ? unlink($exImg) : '';
        (file_exists($exThmub)) ? unlink($exThmub) : '';
    }

}