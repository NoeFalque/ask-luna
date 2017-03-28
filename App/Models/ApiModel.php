<?php
namespace App\Models;

use \App\System\App;
use \App\System\Settings;
use \App\System\ImageUpload;

class ApiModel extends Model {

    protected $table = "posts";

    public function get($date) {
        $key     = Settings::getConfig()['api_key'];
        $media   = json_decode(file_get_contents("https://api.nasa.gov/planetary/apod?api_key=$key&date=$date"));

        if($media->media_type != 'image') {
            $title       = $media->title;
            $description = $media->explanation;
            $date        = $media->date;
            $url         = $media->url;

            $this->create([
                'title'       => $title,
                'description' => $description,
                'date'        => $date,
                'media_type'  => 'video',
                'url'         => $url
            ]);
        }

        else {
            $title       = $media->title;
            $description = $media->explanation;
            $date        = $media->date;
            $url         = $media->url;
            $url_hd      = $media->hdurl;

            $uploader = new ImageUpload();
            $file     = $uploader->add($url);
            $file_hd  = $uploader->add($url_hd);

            $this->create([
                'title'       => $title,
                'description' => $description,
                'date'        => $date,
                'media_type'  => 'image',
                'url'         => $file,
                'url_hd'      => $file_hd
            ]);
        }
    }

}
