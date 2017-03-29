<?php
namespace App\Controllers;

use \App\System\App;
use \App\Models\PostsModel;
use \App\Models\CommentsModel;
use \App\Models\VotesModel;

class CommentsController extends Controller {

    public function answer() {
        $model     = new CommentsModel();
        $questions = $model->answer();

        $this->render('pages/answer.twig', [
            'title'       => 'Answer questions',
            'description' => '',
            'page'        => 'answer',
            'questions'   => $questions
        ]);
    }

    public function upvote($id) {
        $model  = new VotesModel();
        $model2 = new CommentsModel();

        if(!isset($_SESSION['id'])) {
            echo 'Not connected';
            exit;
        }

        else {
            if($model2->find($id)) {
                if($model->alreadyUpvote('comments', $id, $_SESSION['id'])) {
                    $model->deleteUpvote('comments', $id, $_SESSION['id']);
                    echo $model2->downvote($id);
                }

                else {
                    $model->upvote('comments', $id, $_SESSION['id']);
                    echo $model2->upvote($id);

                    App::getEmitter()->emit('Comments.upvote');
                }
            }

            else {
                echo '';
            }
        }
    }

    public function downvote($id) {
        $model  = new VotesModel();
        $model2 = new CommentsModel();

        if(!isset($_SESSION['id'])) {
            echo 'Not connected';
            exit;
        }

        else {
            if($model2->find($id)) {
                if($model->alreadyDownvote('comments', $id, $_SESSION['id'])) {
                    $model->deleteDownvote('comments', $id, $_SESSION['id']);
                    echo $model2->upvote($id);
                }

                else {
                    $model->downvote('comments', $id, $_SESSION['id']);
                    echo $model2->downvote($id);
                }
            }

            else {
                echo '';
            }
        }
    }

    public function misunderstand($id) {
        $model  = new VotesModel();
        $model2 = new CommentsModel();

        if(!isset($_SESSION['id'])) {
            echo 'Not connected';
            exit;
        }

        else {
            if($model2->find($id)) {
                if($model->alreadyMisunderstand('comments', $id, $_SESSION['id'])) {
                    $model->deleteMisunderstand('comments', $id, $_SESSION['id']);
                    $model2->deleteMisunderstand($id);
                    echo 'ok';
                }

                else {
                    $model->misunderstand('comments', $id, $_SESSION['id']);
                    $model2->misunderstand($id);
                    App::getEmitter()->emit('Comments.misunderstand');
                    echo 'ok';
                }
            }

            else {
                echo '';
            }
        }
    }

}
