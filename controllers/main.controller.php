<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 26/03/2016
 * Time: 07:15
 */

//Контроллер для отображения главной страницы
class MainController extends Controller
{
    //Конструктор
    //Связывает контроллер и модель
    public function __construct($data = array()){
        parent::__construct($data);
    }

    //Метод выводит главную страницу (страница по-умолчанию)
    public function index() {
        //Формируем данные для представления
        $this->data['h1'] = 'Главная страница';
    }

    //Метод выводит панель управления (админку)
    public function administrator_index(){
       
    }
}