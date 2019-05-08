<?php

namespace application\core;

use application\lib\Db;


abstract class Model
{
    public $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function isPostExist($id)
    {
        $params = [
            'id' => $id,
        ];

        return $this->db->col('SELECT id FROM posts WHERE id = :id', $params);
    }

    public function postCount()
    {
        return $this->db->col('SELECT COUNT(id) FROM posts');
    }

    public function postsList($route)
    {
        // the same value as in  Pagination limit from Controller
        $max = 5;

        $params = [
            'max' => $max,
            'start' => (($route['page'] ?? 1) - 1) * $max,
        ];
        return $this->db->all('SELECT * FROM posts ORDER BY id DESC LIMIT :start, :max', $params);
    }

    public function postData($id)
    {
        $params = [
            'id' => $id,
        ];
        return $this->db->all('SELECT * FROM posts WHERE id = :id', $params);
    }

}
