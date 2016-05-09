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

    //Получает настройки с БД
    public static function get_options_from_database(){
        $connection = new mysqli(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.name'));

        //Устанавливаем кодировку
        $connection->set_charset("utf8");

        $sql = "SELECT * FROM options";

        $result = $connection->query($sql);

        if(is_bool($result)) {
            return $result;
        }

        //Записываем полученные данные запроса в массив
        $data = array();
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        //Возвращаем результаты запроса
        return $data;
    }
}
