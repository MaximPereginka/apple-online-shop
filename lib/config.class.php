<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 26/03/2016
 * Time: 05:09
 */

//Отвечает за хранение настроек приложения
class Config
{
    //Хранит в себе настройки приложение
    protected static $settings = array();

    //Принимает название настройки
    //Возвращает значение настройки, если она установлена
    //В противном случаи возвразает NULL
    public static function get($key){
        return isset(self::$settings[$key]) ? self::$settings[$key] : null;
    }

    //Устанавливает настройки приложения
    //Принимает пару "ключ настройки" - "значение"
    public static function set($key, $value) {
         self::$settings[$key] = $value;
    }
}
