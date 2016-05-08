<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 26/03/2016
 * Time: 07:01
 */

//Самый главный класс приложения
//Соединяем все куски мозаики воедино
//Обрабатывает запросы
//Вызывает методы контроллеров

class App
{
    //Запрос
    protected static $router;

    //Подключение к базе данных
    public static $db;

    //Get-еры
    //Получаем запрос
    public static function getRouter() {
        return self::$router;
    }

    //Метод непосредственно обрабатывает запросы к приложению
    //Получает URL запроса
    public static function run($uri){
        self::$router = new Router($uri);
        //Подключаемся к базе данных
        self::$db = new DB(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.name'));

        //Загрузка локализации
        Lang::load(self::$router->getLanguage()); 

        //Получаем название класса контроллера и название вызвваемого метода
        $controller_class = ucfirst(self::$router->getController().'Controller');
        $controller_method = strtolower(self::$router->getMethodPrefix().self::$router->getAction());

        //Проверяем, может ли пользователь просматривать запрашиваемую страницу
        $layout = self::$router->getRoute();
        if($layout == 'administrator'
            && Session::get('user_type') != '1'
            && Session::get('user_type') != '2'
            && Session::get('user_type') != '3') {
            if($controller_method != 'administrator_login') {
                Session::setMessage('Для просмотра данной страницы авторизируйтесь');
                Router::redirect('/administrator/users/login');
            }
        }

        //Проверяем, может ли пользователь вызывать определённые методы админки
        if(Session::get('user_type') != '1'
            && ($controller_class == 'UsersController')
            && (
                $controller_method == 'administrator_edit' 
                || $controller_method == 'administrator_index'
                || $controller_method == 'administrator_add'
                || $controller_method == 'administrator_delete'
            )
        ) {
            Session::setMessage('У Вас недостаточно полномочий для просмотра данной страницы');
            Router::redirect('/administrator');
        }

        //Создаём объект контроллера и вызываем нужный метод
        $controller_object = new $controller_class();
        //Проверяем, существует ли нужный метод
        if(method_exists($controller_object, $controller_method)) {
            //Записываем путь к шаблону
            $view_path = $controller_object->$controller_method();
            //Создаем объект представления
            $view_object = new View($controller_object->getData(), $view_path);
            //Записываем контент для шаблона
            $content = $view_object->render();
        } else {
            //Если метода не существует - возбуждаем искючегие
            throw new Exception('Method '.$controller_method.' of class '.$controller_class.' does not exist');
        }
        
        //Подключение покупательской тележки
        $cart = new Cart();
        
        //Рендеринг контента
        //Определяем путь к основному шаблону
        $layout_path = VIEWS_PATH.DS.$layout.'.html';

        //Создаём объекь класса представления
        $layout_view_object = new View(compact('content'), $layout_path);
        //Выводим html-код
        echo $layout_view_object->render();
    }
}