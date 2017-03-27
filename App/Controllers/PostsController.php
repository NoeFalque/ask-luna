<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\ImageUpload;
use \App\Models\PostsModel;
use \App\Models\ApiModel;
use \App\System\FormValidator;

class PostsController extends Controller {

    public function __construct() {
        $date = date('Y-m-d');

        $model = new PostsModel();
        $current = $model->findByDate($date);

        if(!$current) {
            $api = new ApiModel();
            $api->get($date);
        }
    }

    public function all() {
        $model = new PostsModel();
        $posts  = $model->all();
        $last   = $model->last();

        $this->render('pages/index.twig', [
            'title'       => 'Welcome!',
            'description' => '',
            'page'        => 'posts',
            'posts'       => $posts,
            'last_post'   => $last
        ]);
    }

}
