<?php
namespace App\Models;

use \App\System\App;

class UsersModel extends Model {

    protected $table = "users";

    public function login($username, $password) {
        $user = App::getDb()->prepare('SELECT * FROM users WHERE username = ?', [$username], true);

        if($user) {
            if($user->password === $password) {
                return true;
            }
        }

        return false;
    }

    public static function logged() {
        if(!isset($_SESSION['auth'])) {
            App::redirect('signin');
            exit;
        }
    }

    public function single($username) {
        return $this->query("SELECT * FROM {$this->table} WHERE username = ?", [$username], true);
    }

}
