<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 26/03/2016
 * Time: 13:38
 */

//Класс, отвечающий за управление языковыми настройками
class Lang
{
    //Хранит языковые настройки
    protected static $data;

    //Загружает данные из языковых файлов и записывает языковые настройки
    public static function load($lang_code) {
        //Путь к файлу локализации
        $lang_file_path = ROOT.DS.'lang'.DS.strtolower($lang_code).'.php';
        if(file_exists($lang_file_path)) {
            self::$data = include($lang_file_path);
        } else {
            throw new Exception('Lang file not found: '.$lang_file_path);
        }
    }

    //Принимает ключ слова в качестве аргумента
    //Возвращает перевод для загруженного языка или значение по-умолчанию, если ключ не найден
    public static function get($key, $default_value = '') {
        return isset(self::$data[strtolower($key)]) ?  self::$data[strtolower($key)] : $default_value;
    }
}