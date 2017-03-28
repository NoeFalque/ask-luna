<?php
namespace App\Controllers;

use \App\System\App;
use \App\Models\PostsModel;
use \App\Models\CommentsModel;
use \App\Models\VotesModel;

class CommentsController extends Controller {

    public function upvote($id) {
        $model  = new VotesModel();
        $model2 = new CommentsModel();

        if($model2->find($id)) {
            if($model->already('comments', $id, $_SESSION['id'])) {
                $model->downvote('comments', $id, $_SESSION['id']);
                echo $model2->downvote($id);
            }

            else {
                $model->upvote('comments', $id, $_SESSION['id']);
                echo $model2->upvote($id);
            }
        }

        else {
            echo '';
        }
    }

}
