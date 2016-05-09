<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 09.05.2016
 * Time: 14:06
 */

//Класс отвечает за страницы с настройками сайта
Class OptionsController extends Controller
{
    //Конструктор
    public function __construct($data = array()) {
        parent::__construct($data);

        //Создаём объект модели
        $this->model = new Options();
    }

    //Методы админки
    //Выводит настройки сайта
    public function administrator_index(){

    }
}