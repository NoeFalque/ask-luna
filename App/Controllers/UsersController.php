<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\Settings;
use \App\System\FormValidator;
use \App\Models\UsersModel;
use \App\System\Mailer;

class UsersController extends Controller {

    public function login() {
        if(!empty($_POST)) {
            $model = new UsersModel();

            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? hash('sha256', Settings::getConfig()['salt'] . $_POST['password']) : '';

            if($model->login($username, $password)) {
                $user = $model->query("SELECT * FROM users WHERE username = ?", [
                    $username
                ], true);

                $_SESSION['auth']  = $username;
                $_SESSION['id']    = $user->id;
                $_SESSION['email'] = $user->email;

                App::redirect('admin/');
            }

            else {
                $errors = [
                    "Your username and your password don't match."
                ];
            }
        }

        $this->render('pages/signin.twig', [
            'title'       => 'Sign in',
            'description' => 'Sign in to the dashboard',
            'errors'      => isset($errors) ? $errors : ''
        ]);
    }

    public function logout() {
        session_unset();
        session_destroy();
        App::redirect();
    }

}
