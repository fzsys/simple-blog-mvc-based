<?php

namespace application\core;


class Router
{
    protected $routes = [];
    protected $params = [];

    //подключаем пути из массива config/routes.php и наполняем массив $this->routes с помошью ф-ции add с превращением ключа в регулярку для дальнейшего сравнения с урлом
    function __construct()
    {
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $value) {
            $this->add($key, $value);
        }
    }

    public function add($route, $params)
    {
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    //сравниваем урл запроса с ключем массива $this->routes, возвращаем тру если совпадение есть
    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $match)) {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    //ф-ция запуска обьекта роутера (если путь контроллер/екшн найден в массиве конфига и существуют соответствующие урлу Контроллер и Екшн, то запускаем их, если нет -
    // выбрасываем ошибку из статического метода errorCode класса View)
    public function run()
    {
        //проверяем существование указанного в запросе урла через вышеописанный метод match, если да - присваиваем путь к классу указанного в урле контроллера в переменную path
        if ($this->match()) {
            $path = 'application\controllers\\' . ucfirst($this->params['controller']) . 'Controller';

            //если по указанному пути существует класс контроллера, присваиваем переменной $action название метода Екшн, указанного в запросе
            if (class_exists($path)) {
                $action = $this->params['action'] . 'Action';

                //есдли екшн существует запускаем екшн с указанного контроллера
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }

            } else {
                View::errorCode(404);
            }

        } else {
            View::errorCode(404);
        }
    }

}