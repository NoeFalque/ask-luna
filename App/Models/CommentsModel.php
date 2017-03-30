<?php
namespace App\Models;

class CommentsModel extends Model {

    protected $table = "comments";

    public function related($id) {
        return $this->query("SELECT comments.id, comments.post_id, comments.content, comments.parent_id, comments.score, comments.misunderstand, comments.date, comments.user_id, users.id AS user__id, users.username, users.picture FROM {$this->table}
                             LEFT JOIN users
                             ON comments.user_id = users.id
                             WHERE comments.post_id = ?
                             ORDER BY comments.parent_id ASC, comments.score DESC", [$id]);
    }

    public function answer() {
        return $this->query("SELECT comments.id, comments.post_id, comments.content, comments.parent_id, comments.score, comments.misunderstand, comments.date, comments.user_id, users.id AS user__id, users.username, users.picture, posts.id AS post__id, posts.url FROM {$this->table}
                             LEFT JOIN users
                             ON comments.user_id = users.id
                             LEFT JOIN posts
                             ON comments.post_id = posts.id
                             WHERE comments.parent_id = 0
                             ORDER BY comments.score ASC
                             LIMIT 12", []);
    }

    public function popularQuestions() {
        return $this->query("SELECT comments.id, comments.post_id, comments.content, comments.parent_id, comments.score, comments.misunderstand, comments.date, comments.user_id, users.id AS user__id, users.username, users.picture, posts.id AS post__id, posts.url FROM {$this->table}
                             LEFT JOIN users
                             ON comments.user_id = users.id
                             LEFT JOIN posts
                             ON comments.post_id = posts.id
                             WHERE comments.parent_id = 0
                             ORDER BY comments.score DESC
                             LIMIT 2", []);
    }

    public function userQuestions($id) {
        return $this->query("SELECT comments.id, comments.post_id, comments.content, comments.parent_id, comments.score, comments.misunderstand, comments.date, comments.user_id, users.id AS user__id, users.username, users.picture, posts.id AS post__id, posts.url FROM {$this->table}
                             LEFT JOIN users
                             ON comments.user_id = users.id
                             LEFT JOIN posts
                             ON comments.post_id = posts.id
                             WHERE comments.parent_id = 0
                             AND comments.user_id = ?
                             ORDER BY comments.date DESC
                             LIMIT 3", [$id]);
    }

    public function userAnswers($id) {
        $answers = $this->query("SELECT comments.id, comments.post_id, comments.content, comments.parent_id, comments.score, comments.misunderstand, comments.date, comments.user_id, users.id AS user__id, users.username, users.picture, posts.id AS post__id, posts.url FROM {$this->table}
                             LEFT JOIN users
                             ON comments.user_id = users.id
                             LEFT JOIN posts
                             ON comments.post_id = posts.id
                             WHERE comments.parent_id != 0
                             AND comments.user_id = ?
                             ORDER BY comments.date DESC
                             LIMIT 3", [$id]);

        foreach ($answers as $answer) {
            $question = $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$answer->parent_id], true);

            $answer->question_content  = $question->content;
            $answer->question_date     = $question->date;
            $answer->question_score    = $question->score;
            $answer->question_username = $this->query("SELECT username FROM users WHERE id = ?", [$question->user_id], true)->username;
            $answer->question_picture  = $this->query("SELECT picture FROM users WHERE id = ?", [$question->user_id], true)->picture;
        }

        return $answers;
    }

    public function questionsCount($id) {
        $query = $this->query("SELECT id FROM {$this->table} WHERE user_id = ? AND parent_id = 0", [$id]);

        return count($query);
    }

    public function answersCount($id) {
        $query = $this->query("SELECT id FROM {$this->table} WHERE user_id = ? AND parent_id != 0", [$id]);

        return count($query);
    }

    public function likesCount($id) {
        $query = $this->query("SELECT score FROM {$this->table} WHERE user_id = ?", [$id]);
        $count = 0;

        foreach ($query as $result) {
            $count+= $result->score;
        }

        return $count;
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

    public function misunderstand($id) {
        $misunderstand = $this->find($id)->misunderstand;
        $misunderstand++;
        $this->update($id, [
            'misunderstand' => $misunderstand
        ]);
    }

    public function deleteMisunderstand($id) {
        $misunderstand = $this->find($id)->misunderstand;
        $misunderstand--;
        $this->update($id, [
            'misunderstand' => $misunderstand
        ]);
    }

}
