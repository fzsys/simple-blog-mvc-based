<?php

namespace application\models;

use application\core\Model;

class AdminModel extends Model
{
    public $error;
    public function loginValidate($post)
    {
        $this->error = 'error';
        return true;
    }
}