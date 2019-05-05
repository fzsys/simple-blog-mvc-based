<?php

namespace application\models;

use application\core\Model;

class MainModel extends Model
{
    public $error;
    public function formValidate($post)
    {
        $nameLen = iconv_strlen($post['name']);
        $textLen = iconv_strlen($post['text']);
        if($nameLen < 3 or $nameLen > 20) {
            $this->error = 'name should be from 3 to 20 char';
            return false;
        } else if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $this->error = 'email isn\'t valid';
            return false;
        } else if($textLen < 10 or $textLen > 500) {
            $this->error = 'text should be from 10 to 500 char';
            return false;
        }
        return true;
    }
}