<?php

use \App\System\App;
use \App\System\Settings;
use \App\Models\UsersModel;
use \App\Models\CommentsModel;
use \App\Models\NotificationsModel;

App::getEmitter()->addListener('Comments.upvote', function() {
    $model        = new CommentsModel();
    $url          = explode('/', $_GET['url']);

    $comment_id   = end($url);
    $user_id_to   = $model->find($comment_id)->user_id;
    $post_id      = $model->find($comment_id)->post_id;
    $user_id_from = $_SESSION['id'];

    $model3       = new UsersModel();
    $user_from    = $model3->find($user_id_from)->username;

    if($model->find($comment_id)->parent_id == 0) {
        $message = "$user_from has upvoted your question.";
    }

    else {
        $message = "$user_from has upvoted your answer.";
    }

    $model2 = new NotificationsModel();
    $model2->create([
        'user_id' => $user_id_to,
        'message' => $message,
        'date'    => date('Y-m-d H:i:s'),
        'url'     => Settings::getConfig()['url'] . "picture-of-the-day/$post_id#$comment_id"
    ]);


    $user = $model3->find($_SESSION['id']);

    if($user->has_five == 0) {
        $count = $model->likesCount($_SESSION['id']);

        if($count >= 10) {
            $model3->update($_SESSION['id'], [
                'has_five' => 1
            ]);

            $model2->create([
                'user_id' => $_SESSION['id'],
                'message' => "You received a new badge!",
                'date'    => date('Y-m-d H:i:s'),
                'url'     => Settings::getConfig()['url'] . $user->username
            ]);
        }
    }

    if($user->has_six == 0) {
        $count = $model->likesCount($_SESSION['id']);

        if($count >= 20) {
            $model3->update($_SESSION['id'], [
                'has_six' => 1
            ]);

            $model2->create([
                'user_id' => $_SESSION['id'],
                'message' => "You received a new badge!",
                'date'    => date('Y-m-d H:i:s'),
                'url'     => Settings::getConfig()['url'] . $user->username
            ]);
        }
    }
});

App::getEmitter()->addListener('Comments.add', function() {
    $model            = new CommentsModel();
    $model3           = new UsersModel();

    $url              = explode('/', $_GET['url']);

    $post_id          = end($url);
    $user_id_from     = $_SESSION['id'];
    $comment_id_reply = $_POST['parent_id'];

    $user_id_to       = $model->find($comment_id_reply)->user_id;
    $user_from        = $model3->find($user_id_from)->username;

    $model2 = new NotificationsModel();
    $model2->create([
        'user_id' => $user_id_to,
        'message' => "$user_from replied to your message.",
        'date'    => date('Y-m-d H:i:s'),
        'url'     => Settings::getConfig()['url'] . "picture-of-the-day/$post_id#$comment_id_reply"
    ]);


    $user = $model3->find($_SESSION['id']);

    if($user->has_one == 0) {
        $count = $model->questionsCount($_SESSION['id']);

        if($count >= 10) {
            $model3->update($_SESSION['id'], [
                'has_one' => 1
            ]);

            $model2->create([
                'user_id' => $_SESSION['id'],
                'message' => "You received a new badge!",
                'date'    => date('Y-m-d H:i:s'),
                'url'     => Settings::getConfig()['url'] . $user->username
            ]);
        }
    }

    if($user->has_two == 0) {
        $count = $model->questionsCount($_SESSION['id']);

        if($count >= 20) {
            $model3->update($_SESSION['id'], [
                'has_two' => 1
            ]);

            $model2->create([
                'user_id' => $_SESSION['id'],
                'message' => "You received a new badge!",
                'date'    => date('Y-m-d H:i:s'),
                'url'     => Settings::getConfig()['url'] . $user->username
            ]);
        }
    }

    if($user->has_three == 0) {
        $count = $model->answersCount($_SESSION['id']);

        if($count >= 10) {
            $model3->update($_SESSION['id'], [
                'has_three' => 1
            ]);

            $model2->create([
                'user_id' => $_SESSION['id'],
                'message' => "You received a new badge!",
                'date'    => date('Y-m-d H:i:s'),
                'url'     => Settings::getConfig()['url'] . $user->username
            ]);
        }
    }

    if($user->has_four == 0) {
        $count = $model->answersCount($_SESSION['id']);

        if($count >= 20) {
            $model3->update($_SESSION['id'], [
                'has_four' => 1
            ]);

            $model2->create([
                'user_id' => $_SESSION['id'],
                'message' => "You received a new badge!",
                'date'    => date('Y-m-d H:i:s'),
                'url'     => Settings::getConfig()['url'] . $user->username
            ]);
        }
    }
});

App::getEmitter()->addListener('Comments.misunderstand', function() {
    $model        = new CommentsModel();
    $url          = explode('/', $_GET['url']);

    $comment_id   = end($url);

    $user_id_to   = $model->find($comment_id)->user_id;
    $post_id      = $model->find($comment_id)->post_id;
    $user_id_from = $_SESSION['id'];

    $model3       = new UsersModel();
    $user_from    = $model3->find($user_id_from)->username;

    $message = "$user_from didn't understand your answer.";

    $model2 = new NotificationsModel();
    $model2->create([
        'user_id' => $user_id_to,
        'message' => $message,
        'date'    => date('Y-m-d H:i:s'),
        'url'     => Settings::getConfig()['url'] . "picture-of-the-day/$post_id#$comment_id"
    ]);
});
