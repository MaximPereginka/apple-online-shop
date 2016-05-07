<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 01/04/2016
 * Time: 23:41
 */

//Класс отвечает за работу с куками
//Куки нужны для покупательской тележки
abstract class Cookies
{
    //Устанавливает куку
    //Принимает название куки, значение, время хранения в секундах
    //По-умолчанию кука хранится год
    public static function set($key, $value, $time = 31536000){
        setcookie($key, $value, time() + $time, '/');
    }

    //Возвращает куку по названию, если существует
    //Если такой куки нет, возвращает NULL
    public static function get($key)
    {
        if ( isset($_COOKIE[$key]) ){
            return $_COOKIE[$key];
        }
        return null;
    }

    //Удаляет куку по названию
    public static function delete($key)
    {
        if ( isset($_COOKIE[$key]) ){
            self::set($key, '', -3600);
            unset($_COOKIE[$key]);
        }
    }
}