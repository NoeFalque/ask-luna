<?php
namespace App\Models;

class PostsModel extends Model {

    protected $table = "posts";

    public function findByDate($date) {
        return $this->query("SELECT * FROM {$this->table} WHERE date = ?", [$date], true);
    }

    public function last() {
        return $this->query("SELECT * FROM {$this->table} LIMIT 1", [], true);
    }

}
