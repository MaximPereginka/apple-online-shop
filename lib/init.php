<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 26/03/2016
 * Time: 05:23
 */

//Подключает все необходимые скрипты приложения
//Поключение главного конфигурационного файла
require_once(ROOT.DS.'config'.DS.'config.php');

//Выполняется, если в коде вызывается неопределённый ранее класс
//Принимает название класса
//Автоматически подгружает недостающие классы
//Обеспечивает доступ файлов приложения к конфигам
function __autoload($class_name)
{
    //Формируем путь к необходимым классам

    //Путь к главной библиотеке классов
    $lib_path = ROOT.DS.'lib' . DS . strtolower($class_name) . '.class.php';
    //Путь к библиотеке классов контроллеров
    $controllers_path = ROOT . DS . 'controllers' . DS . str_replace('controller', '', strtolower($class_name)) . '.controller.php';
    //Путь к библиотеке классов моделей
    $models_path = ROOT . DS . 'models' . DS . strtolower($class_name) . '.php';

    //Непосредственно подключение скриптов и библиотек классов
    if (file_exists($lib_path)) {
        require_once($lib_path);
    } elseif (file_exists($models_path)) {
        require_once($models_path);
    } elseif (file_exists($controllers_path)) {
        require_once($controllers_path);
    }

    //Если нужный класс не найден ни в одной из директорий, возбуждаем исключение
    else {
        throw new Exception('Failed to include class: '.$class_name);
    }
}

//Функция для быстрого доступа к переводам разных слов по их ключу
function __($key, $default_value = '') {
    return Lang::get($key, $default_value = '');
}