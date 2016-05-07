<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 26/03/2016
 * Time: 07:01
 */

//Обрабатывает запросы
//Вызывает методы контроллеров
class Controller
{
    //Данные для представлений
    protected $data;
    //Переменная для связи с моделями
    protected $model;
    //Параметры запроса
    protected $params;

    //Get-еры
    public function getData(){
        return $this->data;
    }
    public function getModel(){
        return $this->model;
    }
    public function getParams(){
        return $this->params;
    }
    public function __construct($data = array()){
        $this->data = $data;
        $this->params = App::getRouter()->getParams();
    }


}