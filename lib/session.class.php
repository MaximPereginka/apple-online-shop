<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 28/03/2016
 * Time: 03:04
 */

//Класс предназначен для реализации сессий на сайте
class Session
{
    //Текст сообщений для пользователя
    protected static $flash_message;

    //Устанавливает текст сообщения *
    public static function setMessage($message){
        self::$flash_message = $message;
    }

    //Проверяет наличие сообщения для пользователя
    public static function hasMessage() {
        return !is_null(self::$flash_message);
    }

    //Выводит текущее сообщение
    //После вывода удаляет сообщение из памяти
    public static function message(){
        echo self::$flash_message;
    }

    //Метод записывает данные в массив $_SESSION по ключу
    //Принимает ключ и значения
    public static function set($key,$value){
        $_SESSION[$key] = $value;
    }

    //Метод получает даннные сессии по ключу
    //Принимает ключ
    public static function get($key) {
        if(isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    //Метод удаляет пару ключ-значения сессии
    //Принимает ключ
    public static function delete($key){
        if(isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
        return null;
    }

    //Метод заканчивает сессию при выходе пользователя из системы
    public static function destroy(){
        session_destroy();
    }
}