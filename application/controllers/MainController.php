<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;

class MainController extends Controller
{
    public function indexAction()
    {
        $pagination = new Pagination($this->route, $this->model->postCount(), 5);
        $vars = [
            'pagination' => $pagination->get(),
            'list' => $this->model->postsList($this->route),
        ];
        $this->view->render('Main page', $vars);

    }

    public function contactAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->formValidate($_POST)) {
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
        if (!$this->model->isPostExist($this->route['id'])) {
            $this->view->errorCode(404);
        }
        $vars = [
            'data' => $this->model->postData($this->route['id'])[0],
        ];
        $this->view->render($vars['data']['name'], $vars);
    }

}