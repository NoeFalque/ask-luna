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

    public function upload($media) {
        $target_dir    = __DIR__ . '/../../public/uploads/';
        $temp          = explode('.', $media['name']);
        $file          = round(microtime(true)) . '.' . end($temp);
        $target_file   = $target_dir . $file;

        if(move_uploaded_file($media["tmp_name"], $target_file)) {
            return $file;
        }

        else {
            throw new \Error("File couldn't be uploaded.");
        }
    }

    public function delete($media) {
        if(unlink($media)) {
            return true;
        }

        else {
            throw new \Error("Couldn't delete old picture.");
        }
    }

}
