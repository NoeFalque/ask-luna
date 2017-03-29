<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\ImageUpload;
use \App\Models\PostsModel;
use \App\Models\CommentsModel;
use \App\Models\MediasModel;
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
            'page'        => 'index',
            'posts'       => $posts,
            'last_post'   => $last
        ]);
    }

    public function single($id) {
        $model = new PostsModel();
        $post  = $model->find($id);

        $previous = $model->previous($post->date);
        $next     = $model->next($post->date);

        if(!$post) {
            App::error();
            exit;
        }

        if(!empty($_POST) || !empty($_FILES)) {
            if(!isset($_SESSION['id'])) {
                header('Location: /login');
                exit;
            }

            if(!empty($_FILES['media'])) {
                $validator = new FormValidator();
                $media     = $_FILES['media'];

                $validator->validImage('media', $media, "You didn't provided a media or it is invalid");
                if($validator->isValid()) {
                    $upload = new ImageUpload();
                    $media_url = $upload->upload($media);

                    $model = new MediasModel();
                    $model->create([
                        'post_id' => $id,
                        'user_id' => $_SESSION['id'],
                        'media'   => $media_url,
                        'date'    => date('Y-m-d H:i:s')
                    ]);
                }

                else {
                    $errors = $validator->getErrors();
                }
            }

            else if(!empty($_POST['question'])) {
                $model2 = new CommentsModel();
                $model2->create([
                    'post_id' => $id,
                    'content' => strip_tags($_POST['question'], '<a>'),
                    'date'    => date('Y-m-d H:i:s'),
                    'user_id' => $_SESSION['id']
                ]);
            }

            else if(!empty($_POST['answer']) && !empty($_POST['parent_id'])) {
                $model2 = new CommentsModel();
                $model2->create([
                    'post_id'   => $id,
                    'content'   => strip_tags($_POST['answer'], '<a>'),
                    'date'      => date('Y-m-d H:i:s'),
                    'user_id'   => $_SESSION['id'],
                    'parent_id' => $_POST['parent_id']
                ]);

                App::getEmitter()->emit('Comments.add');
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

        $model3 = new MediasModel();
        $medias = $model3->related($id);

        if($post->media_type == 'image') {
            $this->render('pages/single_image.twig', [
                'title'       => 'Picture of the day',
                'description' => '',
                'page'        => 'post',
                'post'        => $post,
                'previous'    => $previous,
                'next'        => $next,
                'comments'    => $comments,
                'medias'      => $medias,
                'errors'      => isset($errors) ? $errors : []
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
