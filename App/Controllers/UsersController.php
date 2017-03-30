<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\Settings;
use \App\System\FormValidator;
use \App\Models\UsersModel;
use \App\Models\CommentsModel;
use \App\System\Mailer;
use \App\System\ImageUpload;
use \Google_Client;
use \Google_Service_Oauth2;

class UsersController extends Controller {

    public function login() {
        $client = new Google_Client();
        $client->setClientId(Settings::getConfig()['google_client']['id']);
        $client->setClientSecret(Settings::getConfig()['google_client']['secret']);
        $client->setRedirectUri(Settings::getConfig()['google_client']['redirect_uri']);
        $client->addScope('email');
        $client->addScope('profile');

        $auth_url = $client->createAuthUrl();
        $service  = new Google_Service_Oauth2($client);

        if(!empty($_POST)) {
            $model = new UsersModel();

            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? hash('sha256', Settings::getConfig()['salt'] . $_POST['password']) : '';

            if($model->login($username, $password)) {
                $user = $model->query("SELECT * FROM users WHERE username = ?", [
                    $username
                ], true);

                $_SESSION['auth']    = $username;
                $_SESSION['id']      = $user->id;
                $_SESSION['email']   = $user->email;
                $_SESSION['picture'] = $user->picture;

                App::redirect();
            }

            else {
                $errors = [
                    "Your username and your password don't match."
                ];
            }
        }

        $this->render('pages/login.twig', [
            'title'         => 'Sign in',
            'description'   => 'Sign in to the dashboard',
            'googleconnect' => $auth_url,
            'errors'        => isset($errors) ? $errors : ''
        ]);
    }

    public function single($username) {
        $model = new UsersModel();
        $user  = $model->single($username);

        if(!$user) {
            App::error();
            exit;
        }

        $stats = new \stdClass;
        $model2 = new CommentsModel();
        $stats->questions = $model2->questionsCount($user->id);
        $stats->answers   = $model2->answersCount($user->id);
        $stats->likes     = $model2->likesCount($user->id);
        $questions        = $model2->userQuestions($user->id);
        $answers          = $model2->userAnswers($user->id);

        $this->render('pages/profile.twig', [
            'title'       => 'Profile',
            'description' => '',
            'user'        => $user,
            'stats'       => $stats,
            'questions'   => $questions,
            'answers'     => $answers
        ]);
    }

    public function signup() {
        $client = new Google_Client();
        $client->setClientId(Settings::getConfig()['google_client']['id']);
        $client->setClientSecret(Settings::getConfig()['google_client']['secret']);
        $client->setRedirectUri(Settings::getConfig()['google_client']['redirect_uri']);
        $client->addScope('email');
        $client->addScope('profile');

        $auth_url = $client->createAuthUrl();
        $service  = new Google_Service_Oauth2($client);

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

                App::redirect('login');
            }

            else {
                $this->render('pages/signup.twig', [
                    'title'         => 'Sign up',
                    'description'   => '',
                    'errors'        => $validator->getErrors(),
                    'googleconnect' => $auth_url,
                    'data'        => [
                        'username' => $username,
                        'email'    => $email
                    ]
                ]);
            }
        }

        else {
            $this->render('pages/signup.twig', [
                'title'         => 'Sign up',
                'description'   => '',
                'googleconnect' => $auth_url
            ]);
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        App::redirect();
    }

    public function googleConnect() {
        $client = new Google_Client();
        $client->setClientId(Settings::getConfig()['google_client']['id']);
        $client->setClientSecret(Settings::getConfig()['google_client']['secret']);
        $client->setRedirectUri(Settings::getConfig()['google_client']['redirect_uri']);
        $client->addScope('email');
        $client->addScope('profile');

        $auth_url = $client->createAuthUrl();
        $service  = new Google_Service_Oauth2($client);

        if(isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $client->setAccessToken($client->getAccessToken());
            $user = $service->userinfo->get();

            $model  = new UsersModel();
            $result = $model->googleConnect($user->id);

            if($result == false) {
                $model2  = new ImageUpload();
                $picture = $model2->add($user->picture);

                $model->create([
                    'username'         => round(microtime(true)),
                    'email'            => $user->email,
                    'picture'          => $picture,
                    'google_connected' => $user->id,
                    'created_at'       => date('Y-m-d H:i:s')
                ]);

                $new_user = $model->query("SELECT * FROM users WHERE google_connected = ?", [
                    $user->id
                ], true);

                $_SESSION['auth']    = $new_user->username;
                $_SESSION['id']      = $new_user->id;
                $_SESSION['email']   = $new_user->email;
                $_SESSION['picture'] = $new_user->picture;

                App::redirect();
            }

            else {
                $new_user = $model->query("SELECT * FROM users WHERE google_connected = ?", [
                    $user->id
                ], true);

                $_SESSION['auth']    = $new_user->username;
                $_SESSION['id']      = $new_user->id;
                $_SESSION['email']   = $new_user->email;
                $_SESSION['picture'] = $new_user->picture;

                App::redirect();
            }
        }

        else {
            App::redirect('login');
        }
    }

    public function settingsAccount() {
        if(!empty($_POST)) {
            $username         = isset($_POST['username']) ? $_POST['username'] : '';
            $email            = isset($_POST['email']) ? $_POST['email'] : '';
            $description      = isset($_POST['description']) ? $_POST['description'] : '';

            $validator = new FormValidator();
            $validator->validUsername('username', $username, "Your username is not valid (no spaces, uppercase, special character)");
            $validator->availableUsername('username', $username, "Your username is not available");
            $validator->validEmail('email', $email, "Your email is not valid");
            $validator->validDescription('description', $description, "Your description must be under 160 characters");

            if($validator->isValid()) {
                $model = new UsersModel();
                $model->update($_SESSION['id'], [
                    'username'    => $username,
                    'email'       => $email,
                    'description' => $description
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

    public function settingsSecurity() {
        if(!empty($_POST)) {
            $old         = isset($_POST['old_password']) ? hash('sha256', Settings::getConfig()['salt'] . $_POST['old_password']) : '';
            $new         = isset($_POST['new_password']) ? $_POST['new_password'] : '';
            $new_confirm = isset($_POST['new_password_confirm']) ? $_POST['new_password_confirm'] : '';

            $validator = new FormValidator();
            $validator->rightPassword('old_password', $_SESSION['id'], $old, "Your old password is not correct");
            $validator->validPassword('password', $new, $new_confirm, "You didn't write the same password twice");

            if($validator->isValid()) {
                $model = new UsersModel();
                $model->update($_SESSION['id'], [
                    'password' => hash('sha256', Settings::getConfig()['salt'] . $new)
                ]);

                $this->render('pages/settings/security.twig', [
                    'title'       => 'Settings - Security',
                    'description' => '',
                    'success'     => 'Your information have been updated.',
                    'page'        => 'security',
                ]);
            }

            else {
                $this->render('pages/settings/security.twig', [
                    'title'       => 'Settings - Security',
                    'description' => '',
                    'errors'      => $validator->getErrors(),
                    'page'        => 'security'
                ]);
            }
        }

        else {
            $this->render('pages/settings/security.twig', [
                'title'       => 'Settings - Security',
                'description' => '',
                'page'        => 'security'
            ]);
        }
    }

    public function settingsPicture() {
        if(!empty($_FILES)) {
            $media = isset($_FILES['media']) ? $_FILES['media'] : '';

            $validator = new FormValidator();
            $validator->validImage('media', $media, "You didn't provided a media or it is invalid");
            $validator->squareImage('media', $media, "Your media must have the same width and height");

            if($validator->isValid()) {
                $upload = new ImageUpload();
                $model  = new UsersModel();

                $old_picture = $model->find($_SESSION['id'])->picture;

                if(!empty($old_picture)) {
                    if($upload->delete(__DIR__ . '/../../public/uploads/' . $old_picture)) {
                        $media_url = $upload->upload($media);

                        $model->update($_SESSION['id'], [
                            'picture' => $media_url
                        ]);

                        $_SESSION['picture'] = $media_url;

                        $this->render('pages/settings/picture.twig', [
                            'title'       => 'Settings - Picture',
                            'description' => '',
                            'success'     => 'Your information have been updated.',
                            'page'        => 'picture'
                        ]);
                    }
                }

                else {
                    $media_url = $upload->upload($media);

                    $model->update($_SESSION['id'], [
                        'picture' => $media_url
                    ]);

                    $_SESSION['picture'] = $media_url;

                    $this->render('pages/settings/picture.twig', [
                        'title'       => 'Settings - Picture',
                        'description' => '',
                        'success'     => 'Your information have been updated.',
                        'page'        => 'picture'
                    ]);
                }
            }

            else {
                $this->render('pages/settings/picture.twig', [
                    'title'       => 'Settings - Picture',
                    'description' => '',
                    'errors'      => $validator->getErrors(),
                    'page'        => 'picture'
                ]);
            }
        }

        else {
            $this->render('pages/settings/picture.twig', [
                'title'       => 'Settings - Picture',
                'description' => '',
                'page'        => 'picture'
            ]);
        }
    }

}
