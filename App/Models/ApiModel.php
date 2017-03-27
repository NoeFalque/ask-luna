<?php
namespace App\Models;

use \App\System\App;
use \App\System\Settings;
use \App\System\ImageUpload;

class ApiModel extends Model {

    protected $table = "posts";

    public function get($date) {
        $key     = Settings::getConfig()['api_key'];
        $picture = json_decode(file_get_contents("https://api.nasa.gov/planetary/apod?api_key=$key&date=$date"));

        $title       = $picture->title;
        $description = $picture->explanation;
        $date        = $picture->date;
        $media       = $picture->url;
        $media_hd    = $picture->hdurl;

        $uploader = new ImageUpload();
        $file     = $uploader->add($media);
        $file_hd  = $uploader->add($media_hd);

        $this->create([
            'title'       => $title,
            'description' => $description,
            'date'        => $date,
            'media'       => $file,
            'media_hd'    => $file_hd
        ]);
    }

}
