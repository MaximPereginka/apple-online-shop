<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 27/03/2016
 * Time: 23:43
 */

//Базовый класс для всех моделей приложения
class Model
{
    protected $db;

    //Конструктор
    public function __construct(){
        $this->db = App::$db;
    }
}