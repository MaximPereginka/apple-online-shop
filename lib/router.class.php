<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 26/03/2016
 * Time: 05:15
 */

//Диспечер запросов к веб-сайту
class Router
{
    //Данные по запросу к сайту
    //URL запроса
    protected $uri;
    //Вызываемый контроллер
    protected $controller;
    //Вызываемы экшн
    protected $action;
    //Вызываемый метод
    protected $method;
    //Массив параметров запроса
    protected $params;
    //Запрос
    protected $route;
    //Префик метода
    protected $method_prefix;
    //Язык
    protected $language;

    //Get-еры и Set-еры для переменных класса
    public function getUri() {
        return $this->uri;
    }
    public function getAction() {
        return $this->action;
    }
    public function getController() {
        return $this->controller;
    }
    public function getMethod() {
        return $this->method;
    }
    public function getParams() {
        return $this->params;
    }
    public function getRoute() {
        return $this->route;
    }
    public function getMethodPrefix() {
        return $this->method_prefix;
    }
    public function getLanguage() {
        return $this->language;
    }

    //Конструктор класса
    //Принимает URL запроса
    //Парсит запрос
    public function __construct($uri){
        //Убираем слеши в URL запроса
        $this->uri = urldecode(htmlspecialchars(trim($uri, '/')));

        //Получаем настройки по-умолчанию
        $routes = Config::get('routes');
        $this->route = Config::get('default_route');
        //Получаем префикс метода по-умолчанию
        $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
        //Устанавливаем язык
        $this->language = Config::get('default_language');
        //Устанавливаем контроллер
        $this->controller = Config::get('default_controller');
        //Устанавливаем метод
        $this->action = Config::get('default_action');

        //Разбиваем URI на части
        $uri_parts = explode('?', $this->uri);

        //В uri_parts[0] хранится строка вида /язык/контроллер/метод/параметр1/параметр2/.../...
        //Сохраняем в отдельную переменнуую
        $path = $uri_parts[0];

        //Разбиваем запрос на отдельные части
        $path_parts = explode('/', $path);

        //Магия
        if (count($path_parts)) {

            //Проверяем, записан ли указанный в URL запрос в конфигурационном файле.
            if(in_array(strtolower(current($path_parts)), array_keys($routes))) {
                //Если запрос валидный - записываем его
                $this->route = strtolower(current($path_parts));
                //Перезаписываем префикс метода (?)
                $this->method_prefix = $routes[$this->route];
                //Убираем с массива текущий элемент(уже отпарсеный)
                array_shift($path_parts);
            }
            //Проверяем, является ли первый элемент массива языком
            elseif (in_array(strtolower(current($path_parts)), Config::get('languages'))) {
                //Перезаписываем текущий язык
                $this->language = strtolower(current($path_parts));
                //Удаляем пропарсенный элемент массива
                array_shift($path_parts);
            }

            //Получаем название контроллера (если указан)
            if(current($path_parts)) {
                $this->controller = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            //Получаем название метода (если указан)
            if(current($path_parts))  {
                $this->action = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            //Получаем параметры (если указаны)
            $this->params = $path_parts;
        }
    }

    //Функция перенаправления страницы
    //Перенаправляет страницу на указанную в переданныую в функцию локацию
    public static function redirect($location) {
        header("Location: $location");
    }
}