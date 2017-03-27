<?php
namespace App\System;

class ImageUpload {

    public function add($media) {
        $target_dir    = __DIR__ . '/../../public/uploads/';
        $temp          = explode('.', $media);
        $name          = round(microtime(true)) . '.' . end($temp);
        $file          = $target_dir . $name;

        if(file_put_contents($file, file_get_contents($media))) {
            return $name;
        }

        else {
            throw new \Error("File couldn't be uploaded.");
        }
    }

}
