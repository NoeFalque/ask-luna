<?php
namespace App\Models;

class CommentsModel extends Model {

    protected $table = "comments";

    public function related($id) {
        return $this->query("SELECT comments.id, comments.post_id, comments.content, comments.parent_id, comments.score, comments.date, comments.user_id, users.id AS user__id, users.username FROM {$this->table}
                             LEFT JOIN users
                             ON comments.user_id = users.id
                             WHERE comments.post_id = ?
                             ORDER BY comments.parent_id ASC, comments.score DESC", [$id]);
    }

    public function upvote($id) {
        $score = $this->find($id)->score;
        $score++;
        $this->update($id, [
            'score' => $score
        ]);

        return $score;
    }

    public function downvote($id) {
        $score = $this->find($id)->score;
        $score--;
        $this->update($id, [
            'score' => $score
        ]);

        return $score;
    }

}
