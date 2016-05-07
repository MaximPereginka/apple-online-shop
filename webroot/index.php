<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 26/03/2016
 * Time: 05:03
 */

//Точка входа в приложение

//Базовые константы
//Символ разделения директорий
define('DS', DIRECTORY_SEPARATOR);
//Указывает на корневую директорию сайта
define('ROOT', dirname(dirname(__FILE__)));
//Путь к представлениям
define('VIEWS_PATH', ROOT.DS.'views');

//Инициализируем новую сессию или возобновляем старую
session_start();

//Подключаем файл, подтягивающий библиотеки классов и скрипты
try {
    require_once(ROOT.DS.'lib'.DS.'init.php');
    //Перехватываем исключение
} catch (Exception $e) {
    echo 'Something is wrong: ', $e->getMessage();
}

//Запускаем отображение страницы
try {
    App::run($_SERVER['REQUEST_URI']);
    //Перехватываем исключение
} catch (Exception $e) {
    echo 'Something is wrong: ', $e->getMessage();
}

