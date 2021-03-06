<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\Settings;
use \App\System\ImageUpload;
use \App\Models\PostsModel;
use \App\Models\CommentsModel;
use \App\Models\VotesModel;
use \App\Models\MediasModel;
use \App\Models\ApiModel;
use \App\System\FormValidator;

class PostsController extends Controller {

    /*
     * Constuctor used to get last APOD if
     * not in Databse
     */
    public function __construct() {
        $date = date('Y-m-d');

        $model = new PostsModel();
        $current = $model->findByDate($date);

        if(!$current) {
            $api = new ApiModel();
            $api->get($date);
        }
    }

    /*
     * Index page with Pictures
     * and questions
     */
    public function index() {
        $model         = new PostsModel();
        $latest_posts  = $model->latest(6);
        $last          = $model->last();

        $model2        = new CommentsModel();
        $questions     = $model2->popularQuestions();

        $popular_posts = $model->popular();

        $this->render('pages/index.twig', [
            'title'         => 'Welcome!',
            'description'   => '',
            'page'          => 'index',
            'last_post'     => $last,
            'questions'     => $questions,
            'popular_posts' => $popular_posts,
            'latest_posts'  => $latest_posts
        ]);
    }

    /*
     * APOD history
     */
    public function all() {
        $model = new PostsModel();
        $posts = $model->latest();

        $this->render('pages/all.twig', [
            'title'         => 'Pictures of the day',
            'description'   => '',
            'page'          => 'index',
            'posts'         => $posts
        ]);
    }

    /*
     * Search API
     */
    public function search($query) {
        $model   = new PostsModel();
        $results = $model->search($query);

        $response = [
            'message' => 'ok',
            'url'     => Settings::getConfig()['url'],
            'results' => $results
        ];

        echo json_encode($response);
    }

    /*
     * Single APOD with infos,
     * questions & answers
     */
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


                $comment_id = $model2->last($_SESSION['id'])[0]->id;

                App::redirect("picture-of-the-day/$id#$comment_id");
                exit;
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

                $comment_id = $model2->last($_SESSION['id'])[0]->id;

                App::redirect("picture-of-the-day/$id#$comment_id");
                exit;
            }
        }

        $model2   = new CommentsModel();
        $comments = $model2->related($id);

        /*
         * Know if current user already
         * reacted to a comment
         */
        if(isset($_SESSION['id'])) {
            foreach ($comments as $comment) {
                $model = new VotesModel();

                if($model->alreadyUpvote('comments', $comment->id, $_SESSION['id']) != false) {
                    $comment->upvote = 'true';
                } else {
                    $comment->upvote = 'false';
                }

                if($model->alreadyDownvote('comments', $comment->id, $_SESSION['id']) != false) {
                    $comment->downvote = 'true';
                } else {
                    $comment->downvote = 'false';
                }
            }
        }

        else {
            foreach ($comments as $comment) {
                $comment->upvote   = 'false';
                $comment->downvote = 'false';
            }
        }

        /*
         * Create comments tree with questions
         * and answers using children property
         */
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
