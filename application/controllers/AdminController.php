<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;

class AdminController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'admin';
    }

    //============================== login Action
    public function loginAction()
    {

        if (!empty($_SESSION) and $_SESSION['admin'] == 1) {
            $this->view->redirect('admin/add');
        }
        if (!empty($_POST)) {
            if (!$this->model->loginValidate($_POST)) {
                $this->view->message('error', $this->model->error);
            }
            $_SESSION['admin'] = 1;

            $this->view->location('admin/add');

        }

        $this->view->render('Login page');
    }

    //============================== logout Action
    public function logoutAction()
    {
        $_SESSION['admin'] = 0;
        $this->view->redirect('admin/login');
    }

    //============================== add Post Action
    public function addAction()
    {
        if (!empty($_POST)) {

            if (!$this->model->postValidate($_POST, 'add')) {
                $this->view->message('error', $this->model->error);
            }

            $id = $this->model->postAdd($_POST);

            if (!$id) {
                $this->view->message('error', 'request error');
            }

            $this->model->postUploadImg($_FILES['img']['tmp_name'], $id);

            $this->view->message('success', "post added successfully");

        }

        $this->view->render('Add new post');
    }

    //============================== edit Post Action
    public function editAction()
    {

        if (!$this->model->isPostExist($this->route['id'])) {
            $this->view->errorCode(404);
        }

        if (!empty($_POST)) {

            if (!$this->model->postValidate($_POST, 'edit')) {
                $this->view->message('error', $this->model->error);
            }

            $this->model->postEdit($_POST, $this->route['id']);
            if ($_FILES['img']['tmp_name']) {
                $this->model->postUploadImg($_FILES['img']['tmp_name'], $this->route['id']);
            }
            $this->view->message('success', 'Edited');

        }

        $vars = [
            'data' => $this->model->postData($this->route['id'])[0],
        ];

        $this->view->render('Edit post', $vars);

    }

    //============================== delete Post Action
    public function deleteAction()
    {
        if (!$this->model->isPostExist($this->route['id'])) {
            $this->view->errorCode(404);
        }
        $this->model->postDelete($this->route['id']);
        $this->view->redirect('admin/posts');
    }

    //============================== posts Page Action
    public function postsAction()
    {
        //$mainModel = new MainModel();
        $pagination = new Pagination($this->route, $this->model->postCount(), 5);
        $vars = [
            'pagination' => $pagination->get(),
            'list' => $this->model->postsList($this->route),
        ];
        $this->view->render('All posts', $vars);
    }

}