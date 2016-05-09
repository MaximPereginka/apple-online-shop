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
        $this->data['options'] = $this->model->get_options();
        
        if($_POST){
            //Сохраняем настройки
            if(!$this->model->save(6, $_POST['site_name'])) {
                Session::setMessage("Не удалось сохранить название сайта");
            }
            else if(!$this->model->save(7, $_POST['site_description'])) {
                Session::setMessage("Не удалось сохранить описание сайта");
            }
            else if(!$this->model->save(8, $_POST['site_keywords'])) {
                Session::setMessage("Не удалось сохранить ключевые слова сайта");
            }
            else {
                Session::setMessage("Настройки успешно сохранены");
                Router::redirect("/administrator/options");
            }
        }
    }
}