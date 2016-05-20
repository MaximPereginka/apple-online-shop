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

        //Создаём объект модели
        $this->model = new Main();
    }

    //Метод выводит главную страницу (страница по-умолчанию)
    public function index() {
        //Формируем данные для представления
        $this->data['popular'] = $this->model->get_popular_products();
        
    }

    //Метод выводит панель управления (админку)
    public function administrator_index(){
           
    }
}