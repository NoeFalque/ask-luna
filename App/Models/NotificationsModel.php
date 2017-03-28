<?php
namespace App\Models;

use \App\System\App;

class NotificationsModel extends Model {

    protected $table = "notifications";

    public function related($id) {
        return $this->query("SELECT * FROM {$this->table}
                             WHERE user_id = ?
                             AND is_seen = 0
                             ORDER BY date DESC", [$id]);
    }

    public function mark($id) {
        App::getDb()->execute("UPDATE {$this->table} SET is_seen = 1 WHERE user_id = ?", [$id]);
    }

}
