<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 26/03/2016
 * Time: 05:22
 */
//Главный конфигурационный файл приложения
//Настройки БД
//Хост
Config::set('db.host', 'localhost');
//Имя пользователя
Config::set('db.user', 'root');
//Пароль
Config::set('db.password', '');
//Название БД
Config::set('db.name', 'apple_store');

//Загрузка настроек из админки
$options = Config::get_options_from_database();

//SEO
//Название сайта
Config::set('site_name', $options[0]['value']);
//Описание
Config::set('site_description', $options[1]['value']);
//Ключевые слова
Config::set('site_keywords', $options[2]['value']);

//Список языков сайта
Config::set('languages', array('ru'));

//Возможные запросы к сайту
//Пары "название роута" - "префикс метода"
Config::set('routes', array(
    'default' => '',
    'administrator' => 'administrator_'
));

//Значения по-умолчанию
//Роут по-умолчанию
Config::set('default_route', 'default');
//Язык по-умолчанию
Config::set('default_language', 'ru');
//Контроллер по-умолчанию
Config::set('default_controller', 'main');
//Метод по-умолчанию
Config::set('default_action', 'index');


//Т.н. "соль" - случайный набор символов. Нужен для хеширования данных (защита от взлома)
Config::set('salt', 'ao149u9HAO');
