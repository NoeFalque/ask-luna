<?php
namespace App\Models;

class MediasModel extends Model {

    protected $table = "medias";

    public function related($id) {
        return $this->query("SELECT medias.id, medias.post_id, medias.media, medias.user_id, medias.date, users.id AS user__id, users.username FROM {$this->table}
                             LEFT JOIN users
                             ON medias.user_id = users.id
                             WHERE medias.post_id = ?
                             ORDER BY medias.date DESC", [$id]);
    }

}
