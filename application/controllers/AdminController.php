<?php

namespace application\controllers;

use application\core\Controller;

class AdminController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'admin';
    }

    public function loginAction()
    {
        if(!empty($_POST)) {
            if(!$this->model->loginValidate($_POST)) {
                $this->view->message('error', $this->model->error);
            }

            $this->view->message('success', 'OK');

        }

        $this->view->render('Login page');
    }

    public function editAction()
    {
        $this->view->render('Edit page');
    }

    public function addAction()
    {
        $this->view->render('Add page');
    }

    public function deleteAction()
    {
        exit('delete');
    }

    public function logoutAction()
    {
        exit('logout');
    }


}