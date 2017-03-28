<?php
namespace App\Models;

use \App\System\App;

class VotesModel extends Model {

    protected $table = "votes";

    public function alreadyUpvote($type, $id, $user_id) {
        return $this->query("SELECT * FROM {$this->table} WHERE content_type = ? AND content_type_id = ? AND user_id = ? and type = ?", [
            $type,
            $id,
            $user_id,
            'upvote'
        ], true);
    }

    public function alreadyDownvote($type, $id, $user_id) {
        return $this->query("SELECT * FROM {$this->table} WHERE content_type = ? AND content_type_id = ? AND user_id = ? and type = ?", [
            $type,
            $id,
            $user_id,
            'downvote'
        ], true);
    }

    public function upvote($type, $id, $user_id) {
        $this->create([
            'type'            => 'upvote',
            'content_type'    => $type,
            'user_id'         => $user_id,
            'content_type_id' => $id
        ]);
    }

    public function deleteUpvote($type, $id, $user_id) {
        App::getDb()->execute("DELETE FROM {$this->table} WHERE content_type = ? AND content_type_id = ? AND user_id = ? AND type = ?", [
            $type,
            $id,
            $user_id,
            'upvote'
        ]);
    }

    public function downvote($type, $id, $user_id) {
        $this->create([
            'type'            => 'downvote',
            'content_type'    => $type,
            'user_id'         => $user_id,
            'content_type_id' => $id
        ]);
    }

    public function deleteDownvote($type, $id, $user_id) {
        App::getDb()->execute("DELETE FROM {$this->table} WHERE content_type = ? AND content_type_id = ? AND user_id = ? AND type = ?", [
            $type,
            $id,
            $user_id,
            'downvote'
        ]);
    }

    public function alreadyMisunderstand($type, $id, $user_id) {
        return $this->query("SELECT * FROM {$this->table} WHERE content_type = ? AND content_type_id = ? AND user_id = ? and type = ?", [
            $type,
            $id,
            $user_id,
            'misunderstand'
        ], true);
    }

    public function deleteMisunderstand($type, $id, $user_id) {
        App::getDb()->execute("DELETE FROM {$this->table} WHERE content_type = ? AND content_type_id = ? AND user_id = ? AND type = ?", [
            $type,
            $id,
            $user_id,
            'misunderstand'
        ]);
    }

    public function misunderstand($type, $id, $user_id) {
        $this->create([
            'type'            => 'misunderstand',
            'content_type'    => $type,
            'user_id'         => $user_id,
            'content_type_id' => $id
        ]);
    }

}
