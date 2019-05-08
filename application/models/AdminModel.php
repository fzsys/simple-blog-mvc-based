<?php

namespace application\models;

use application\core\Model;
//use Imagick;

class AdminModel extends Model
{

    public $error;

    public function loginValidate($post)
    {
        $config = require 'application/config/admin.php';
        if($config['login'] != $_POST['login'] or $config['password'] != $_POST['password']) {
            $this->error = 'login or pass is incorrect';
            return false;
        }
        return true;
    }

    public function postValidate($post, $type)
    {
        $nameLen = iconv_strlen($post['name']);
        $descriptionLen = iconv_strlen($post['description']);
        $textLen = iconv_strlen($post['text']);
        if($nameLen < 10 or $nameLen > 100) {
            $this->error = 'name should be from 10 to 100 char';
            return false;
        } else if($descriptionLen < 10 or $descriptionLen > 100) {
            $this->error = 'description should be from 10 to 100 char';
            return false;
        } else if($textLen < 10 or $textLen > 5000) {
            $this->error = 'text should be from 10 to 5000 char';
            return false;
        }
        /*
         * check loading of image (temporary off)
        if($type = 'add' and !$_FILES['img']['tmp_name']) {
            $this->error = 'choose img for post';
            return false;
        }
        */
        return true;
    }

    public function postAdd($post)
    {
        $params = [
            'id' => null,
            'name' => $post['name'],
            'description' => $post['description'],
            'text' => $post['text'],
        ];
        $this->db->query('INSERT INTO posts VALUES (:id, :name, :description, :text)', $params);
        return $this->db->getLastInsertId();
    }

    public function postEdit($post, $id)
    {

        $params = [
            'id' => $id,
            'name' => $post['name'],
            'description' => $post['description'],
            'text' => $post['text'],
        ];
        $this->db->query('UPDATE posts SET name = :name, description = :description, text = :text WHERE id = :id', $params);

    }

    public function postUploadImg($path, $id)
    {
        // to include imageMagick library at first its need to confi it on web server
        /*
        $img = new Imagick($path);
        $img->cropThumbnailImage(1024, 1024);
        $img->setCompressionQuality(80);
        $img->writeImage('public/images/posts/' . $id . '.jpg');
        */
        move_uploaded_file($path, 'public/images/posts/' . $id . '.jpg');
    }



    public function postDelete($id)
    {
        $params = [
            'id' => $id,
        ];

        $this->db->query('DELETE FROM posts WHERE id = :id', $params);
        unlink('public/images/posts/' . $id . '.jpg');
    }





}