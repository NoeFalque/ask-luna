<?php
namespace App\System;

use \App\Models\CategoriesModel;
use \App\Models\UsersModel;

class FormValidator {

    private $errors = [];

    public function notEmpty($element, $value, $message) {
        if(empty($value)) {
            $this->errors[$element] = $message;
        }
    }

    public function validEmail($element, $value, $message) {
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$element] = $message;
        }
    }

    public function validPassword($element, $value, $value_verification, $message) {
        if(empty($value) || ($value != $value_verification)) {
            $this->errors[$element] = $message;
        }
    }

    public function rightPassword($element, $id, $value, $message) {
        $model    = new UsersModel();
        $user     = $model->find($id);

        if($user->password != $value) {
            $this->errors[$element] = $message;
        }
    }

    public function validUsername($element, $value, $message) {
        if(!preg_match('/[a-z0-9]+/', $value)) {
            $this->errors[$element] = $message;
        }
    }

    public function validDescription($element, $value, $message) {
        if(strlen($value) > 160) {
            $this->errors[$element] = $message;
        }
    }

    public function availableUsername($element, $value, $message) {
        if($_SESSION['auth'] != $value) {
            $model  = new UsersModel();
            $result = $model->query("SELECT * FROM users WHERE username = ?", [
                $value
            ], true);

            if($result) {
                $this->errors[$element] = $message;
            }
        }
    }

    public function isNumeric($element, $value, $message) {
        if(!is_numeric($value)) {
            $this->errors[$element] = $message;
        }
    }

    public function isInteger($element, $value, $message) {
        if(!is_int(intval($value))) {
            $this->errors[$element] = $message;
        }
    }

    public function validImage($element, $value, $message) {
        if(empty($value)) {
            $this->errors[$element] = $message;
        }

        else {
            if(empty($value['type'])) {
                $this->errors[$element] = $message;
                return;
            }

            if(!exif_imagetype($value['tmp_name'])) {
                $this->errors[$element] = $message;
                return;
            }

            if($value['size'] > 1000000) {
                $this->errors[$element] = "Your media is too big (> 1Mo)";
                return;
            }
        }
    }

    public function squareImage($element, $value, $message) {
        if(getimagesize($value['tmp_name'])[0] != getimagesize($value['tmp_name'])[1]) {
            $this->errors[$element] = $message;
        }
    }

    public function isValid() {
        if(empty($this->errors)) return true;
        else return false;
    }

    public function getErrors() {
        return $this->errors;
    }

}
