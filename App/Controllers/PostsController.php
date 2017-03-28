<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\ImageUpload;
use \App\Models\PostsModel;
use \App\Models\CommentsModel;
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
        $posts  = $model->latest(10);
        $last   = $model->last();

        $this->render('pages/index.twig', [
            'title'       => 'Welcome!',
            'description' => '',
            'page'        => 'posts',
            'posts'       => $posts,
            'last_post'   => $last
        ]);
    }

    public function single($id) {
        $model = new PostsModel();
        $post  = $model->find($id);

        if(!$post) {
            App::error();
            exit;
        }

        if(!empty($_POST)) {
            if(!empty($_POST['question']) && isset($_SESSION['id'])) {
                $model2 = new CommentsModel();
                $model2->create([
                    'post_id' => $id,
                    'content' => $_POST['question'],
                    'date'    => date('Y-m-d H:i:s'),
                    'user_id' => $_SESSION['id']
                ]);
            }
        }

        $model2   = new CommentsModel();
        $comments = $model2->related($id);

        $comments_by_id = [];

        foreach ($comments as $comment) {
            $comments_by_id[$comment->id] = $comment;
        }

        foreach ($comments as $key => $comment) {
            if($comment->parent_id != 0) {
                $comments_by_id[$comment->parent_id]->children[] = $comment;
                unset($comments[$key]);
            }
        }

        if($post->media_type == 'image') {
            $this->render('pages/single_image.twig', [
                'title'       => 'Picture of the day',
                'description' => '',
                'page'        => 'post',
                'post'        => $post,
                'comments'    => $comments
            ]);
        }

        else {
            $this->render('pages/single_video.twig', [
                'title'       => 'Picture of the day',
                'description' => '',
                'page'        => 'post',
                'post'        => $post,
                'comments'    => $comments
            ]);
        }
    }

}
