<?php

namespace application\core;

abstract class Controller
{
    public $route;
    public $view;
    public $model;
    public $access;


    public function __construct($route)
    {

        $this->route = $route;

        if (!$this->checkAccess()) {
            View::errorCode(403);
        };
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
    }

    public function loadModel($name)
    {
        $path = 'application\models\\' . ucfirst($name) . 'Model';
        if (class_exists($path)) {
            return new $path();
        }
    }


    public function checkAccess()
    {
        $this->access = require 'application/access/' . $this->route['controller'] . '.php';
        if ($this->isAccess(('all'))) {
            return true;
        } else {
            if (isset($_SESSION['authorized']['id']) and $this->isAccess('authorized')) {
                return true;
            } else {
                if (!isset($_SESSION['authorized']['id']) and $this->isAccess(('guest'))) {
                    return true;
                } else {
                    if (isset($_SESSION['admin']) and $this->isAccess(('admin'))) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    //
    public function isAccess($key)
    {
        return in_array($this->route['action'], $this->access[$key]);
    }

}