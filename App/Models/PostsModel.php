<?php
namespace App\Models;

class PostsModel extends Model {

    protected $table = "posts";

    public function findByDate($date) {
        return $this->query("SELECT * FROM {$this->table} WHERE date = ?", [$date], true);
    }

    public function last() {
        return $this->query("SELECT * FROM {$this->table} ORDER BY date DESC LIMIT 1", [], true);
    }

    public function search($query) {
        $q = "%$query%";
        return $this->query("SELECT * FROM {$this->table} WHERE title LIKE ?", [$q]);
    }

    public function previous($date) {
        $day      = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
        $response = $this->query("SELECT id FROM {$this->table} WHERE date = ?", [$day], true);

        if($response) {
            return $response;
        }

        else {
            return false;
        }
    }

    public function next($date) {
        $day      = date( 'Y-m-d', strtotime( $date . ' +1 day' ) );
        $response = $this->query("SELECT id FROM {$this->table} WHERE date = ?", [$day], true);

        if($response) {
            return $response;
        }

        else {
            return false;
        }
    }

    public function popular() {
        $popular = $this->query("SELECT COUNT(id), post_id FROM comments GROUP BY post_id ORDER BY COUNT(id) DESC LIMIT 3", []);

        $results = [];
        foreach ($popular as $element) {
            $post = $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$element->post_id], true);
            $post->questions = count($this->query("SELECT * FROM comments WHERE post_id = ? AND parent_id = 0", [$element->post_id]));
            $post->answers   = count($this->query("SELECT * FROM comments WHERE post_id = ? AND parent_id != 0", [$element->post_id]));

            $results[] = $post;
        }

        return $results;
    }

    public function latest() {
        $latest = $this->query("SELECT * FROM {$this->table} ORDER BY date DESC LIMIT 6", []);

        $results = [];
        foreach ($latest as $element) {
            $post = $element;
            $post->questions = count($this->query("SELECT * FROM comments WHERE post_id = ? AND parent_id = 0", [$element->id]));
            $post->answers   = count($this->query("SELECT * FROM comments WHERE post_id = ? AND parent_id != 0", [$element->id]));

            $results[] = $post;
        }

        return $results;
    }

}
