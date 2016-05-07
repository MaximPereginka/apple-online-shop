<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 26/03/2016
 * Time: 08:47
 */

//Отвечает за работу с представлениями
class View
{
    //Данные, которые передаются с контроллеров
    protected $data;
    //Путь к текущему файлу представлению
    protected $path;

    //Определяет путь к стандартному шаблону (представлению) без создания объекта
    protected static function getDefaultViewPath() {
        $router = App::getRouter();
        //Если запрос не получен - возвращает false
        if(!$router){
            return false;
        }
        //Получаем название контроллера
        $controller_dir = $router->getController();
        //Получаем название шаблона
        $template_name = $router->getMethodPrefix().$router->getAction().'.html';
        //Возвращаем путь к шаблону
        return VIEWS_PATH.DS.$controller_dir.DS.$template_name;
    }

    //Конструктор
    //Принимает данные с контроллера и путь к файлу представления
    public function __construct($data = array(), $path = null)
    {
        if(!$path) {
            $path = self::getDefaultViewPath();
        }
        //Проверка на существование файла
        if(!file_exists($path)) {
            throw new Exception('Template file is not found in path '.$path);
        }
        //Записываем путь к шаблону
        $this->path = $path;
        //Записываем данные с контроллера
        $this->data = $data;
    }

    //Возвращает готовый HTML-код
    public function render(){
        //Записываем данные с контроллера
        $data = $this->data;

        //Буферизация вывода
        ob_start();
        //Подключаем шаблон
        include($this->path);
        $content = ob_get_clean();
        //Возвразаем готовый html-код
        return $content;
    }

}