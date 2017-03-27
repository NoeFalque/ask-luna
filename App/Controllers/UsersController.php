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

                App::redirect();
            }

            else {
                $errors = [
                    "Your username and your password don't match."
                ];
            }
        }

        $this->render('pages/login.twig', [
            'title'       => 'Sign in',
            'description' => 'Sign in to the dashboard',
            'errors'      => isset($errors) ? $errors : ''
        ]);
    }

    public function signup() {
        if(!empty($_POST)) {
            $username         = isset($_POST['username']) ? $_POST['username'] : '';
            $email            = isset($_POST['email']) ? $_POST['email'] : '';
            $password         = isset($_POST['password']) ? $_POST['password'] : '';
            $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

            $validator = new FormValidator();
            $validator->validUsername('username', $username, "Your username is not valid (no spaces, uppercase, special character)");
            $validator->availableUsername('username', $username, "Your username is not available");
            $validator->validEmail('email', $email, "Your email is not valid");
            $validator->validPassword('password', $password, $password_confirm, "You didn't write the same password twice");

            if($validator->isValid()) {
                $model = new UsersModel();
                $model->create([
                    'username'   => $username,
                    'email'      => $email,
                    'password'   => hash('sha256', Settings::getConfig()['salt'] . $password),
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                // $content = App::getTwig()->render('mail_new.twig', [
                //     'username'    => $username,
                //     'password'    => $password,
                //     'title'       => Settings::getConfig()['name'],
                //     'description' => Settings::getConfig()['description'],
                //     'link'        => Settings::getConfig()['url'] . 'signin'
                // ]);
                //
                // $mailer = new Mailer();
                // $mailer->setFrom(Settings::getConfig()['mail']['from'], 'Mailer');
                // $mailer->addAddress($email);
                // $mailer->Subject = 'Hello ' . $username . ', welcome on board!';
                // $mailer->msgHTML($content);
                // $mailer->send();

                App::redirect('login');
            }

            else {
                $this->render('pages/signup.twig', [
                    'title'       => 'Sign up',
                    'description' => '',
                    'errors'      => $validator->getErrors(),
                    'data'        => [
                        'username' => $username,
                        'email'    => $email
                    ]
                ]);
            }
        }

        else {
            $this->render('pages/signup.twig', [
                'title'       => 'Sign up',
                'description' => ''
            ]);
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        App::redirect();
    }

    public function settingsAccount() {
        if(!empty($_POST)) {
            $username         = isset($_POST['username']) ? $_POST['username'] : '';
            $email            = isset($_POST['email']) ? $_POST['email'] : '';

            $validator = new FormValidator();
            $validator->validUsername('username', $username, "Your username is not valid (no spaces, uppercase, special character)");
            $validator->availableUsername('username', $username, "Your username is not available");
            $validator->validEmail('email', $email, "Your email is not valid");

            if($validator->isValid()) {
                $model = new UsersModel();
                $model->update($_SESSION['id'], [
                    'username'   => $username,
                    'email'      => $email
                ]);

                $_SESSION['auth']  = $username;
                $_SESSION['email'] = $email;

                $user  = $model->find($_SESSION['id']);

                $this->render('pages/settings/account.twig', [
                    'title'       => 'Settings - Account',
                    'description' => '',
                    'success'     => 'Your information have been updated.',
                    'page'        => 'account',
                    'user'        => $user
                ]);
            }

            else {
                $model = new UsersModel();
                $user  = $model->find($_SESSION['id']);

                $this->render('pages/settings/account.twig', [
                    'title'       => 'Settings - Account',
                    'description' => '',
                    'errors'      => $validator->getErrors(),
                    'page'        => 'account',
                    'user'        => $user
                ]);
            }
        }

        else {
            $model = new UsersModel();
            $user  = $model->find($_SESSION['id']);

            $this->render('pages/settings/account.twig', [
                'title'       => 'Settings - Account',
                'description' => '',
                'page'        => 'account',
                'user'        => $user
            ]);
        }
    }

}
