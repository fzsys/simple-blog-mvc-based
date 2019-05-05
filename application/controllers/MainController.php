<?php

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $this->view->render('Main page');

    }

    public function contactAction()
    {
        if(!empty($_POST)) {
            if(!$this->model->formValidate($_POST)) {
                $this->view->message('error', $this->model->error);
            }
            mail('example@gmail.com', 'Message from blog', $_POST['text']);
            $this->view->message('success', 'message send');

        }

        $this->view->render('Contacts page');
    }

    public function aboutAction()
    {
        $this->view->render('About page');
    }

    public function postAction()
    {
        $this->view->render('Contacts page');
    }

}