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

    public function latest($count) {
        return $this->query("SELECT * FROM {$this->table} ORDER BY date DESC LIMIT $count", []);
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

}
