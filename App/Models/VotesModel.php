<?php
namespace App\Models;

use \App\System\App;

class VotesModel extends Model {

    protected $table = "votes";

    public function already($type, $id, $user_id) {
        return $this->query("SELECT * FROM {$this->table} WHERE type = ? AND type_id = ? AND user_id = ?", [
            $type,
            $id,
            $user_id
        ], true);
    }

    public function downvote($type, $id, $user_id) {
        App::getDb()->execute("DELETE FROM {$this->table} WHERE type = ? AND type_id = ? AND user_id = ?", [
            $type,
            $id,
            $user_id
        ]);
    }

    public function upvote($type, $id, $user_id) {
        $this->create([
            'type'    => $type,
            'user_id' => $user_id,
            'type_id' => $id
        ]);
    }

}
