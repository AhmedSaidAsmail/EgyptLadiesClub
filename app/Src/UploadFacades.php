<?php

namespace App\Src;

use Intervention\Image\Facades\Image;
use Illuminate\Http\UploadedFile;

class UploadFacades {

    protected static $_img = [];
    protected static $_instance;
    protected $_uploadFile;
    protected $_path;
    protected $_imageName;
    protected $_thumb;

    public static function getInstance(UploadedFile $file) {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($file);
        }
        return self::$_instance;
    }

    protected function setFile(UploadedFile $file) {
        $this->_uploadFile = $file;
        return $this;
    }

    protected function setPath($path) {
        $this->_path = public_path() . $path;
        return $this;
    }

    protected function makeDir() {
        if (!is_dir($this->_path)) {
            mkdir($this->_path, 0777);
            mkdir($this->_path . "thumb/", 0777);
        }
        return $this;
    }

    protected function setImageName($image) {
        $this->_imageName = md5(uniqid(mt_rand())) . "." . $image->getClientOriginalExtension();
        return $this;
    }

    protected function setThumb($width) {
        $this->_thumb = Image::make($this->_uploadFile->getRealPath())->resize($width, null, function ($ratio) {
            $ratio->aspectRatio();
        });
        return $this;
    }

    protected function saveThumb() {
        $this->_thumb->save($this->_path . "thumb/" . $this->_imageName);
        return $this;
    }

    protected function moveImage() {
        $this->_uploadFile->move($this->_path, $this->_imageName);
        return $this;
    }

    public function Upload(UploadedFile $file, $path, $width,$exImage=null) {
        $instance = self::getInstance($file);
        return $instance->setFile($file)
                        ->setPath($path)
                        ->makeDir()
                        ->setImageName($file)
                        ->setThumb($width)
                        ->saveThumb()
                        ->moveImage()
                ->_imageName;
    }

}
