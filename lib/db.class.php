<?php

/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 27/03/2016
 * Time: 23:05
 */

//Класс отвечает за соединение с базой данных
class DB
{
    //Хранит в себе объект подключения к базе данных
    protected $connection;

    //Конструктор
    //Принимает настройки для подключения к базе данных
    public function __construct($host, $user, $password, $db_name) {
        $this->connection = new mysqli($host, $user, $password, $db_name);

        //Устанавливаем кодировку
        $this->connection->set_charset("utf8");

        //Возбуждаем исключение в случаи ошибки подключения
        if(mysqli_connect_error()) {
            throw new Exception('Ошибка подключения к базе данных');
        }
    }

    //Функция принимает код запроса и возвращает его результат или False в случаи неудачи
    public function query($sql) {
        //Проверяем, удалось ли подключиться к БД
        if (!$this->connection) {
            return false;
        }

        //Выполняем запрос
        $result = $this->connection->query($sql);

        //Если во время выполнения запроса произошла ошибка - возбуждаем исключение
        if(mysqli_error($this->connection)) {
            throw new Exception('Ошибка выполнения запроса к базе данных');
        }

        //Очередная проверка
        //Если запрос возвращает результат логического типа - возвращаем его
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

    //Защита от SQL иньекций
    //Принимает строку
    //Возвращает безопасную строку
    public function escape($str) {
        return mysqli_escape_string($this->connection, $str);
    }
}