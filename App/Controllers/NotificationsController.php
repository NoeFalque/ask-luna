<?php
namespace App\Controllers;

use \App\System\App;
use \App\Models\NotificationsModel;

class NotificationsController extends Controller {

    public function mark() {
        if(isset($_SESSION['id'])) {
            $id = $_SESSION['id'];

            $model = new NotificationsModel();
            $model->mark($id);

            echo 'ok';
        }

        else {
            echo '';
        }
    }

}
