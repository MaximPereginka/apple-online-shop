<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 27/03/2016
 * Time: 22:34
 */

//Отвечает за отображение страницы "Контакты"
Class CallbackController extends Controller
{
    //Конструктор
    public function __construct($data = array()) {
        parent::__construct($data);

        //Создаём объект модели
        $this->model = new Callback();
    }

    //Метод по-умолчанию
    public function index() {
        //Если страница принимает POST-запрос, вызываем метод для его обработки
        if($_POST) {
            //Если функция возвращает True, то сообщение с формы сохранено в БД
            if($this->model->save($_POST)) {
                Session::setMessage('Ваше сообщение успешно отправлено');
            }
        }
    }

    //-------------------------- Методы админки ----------------------------
    //Выводит все сообщения
    public function administrator_index(){
        $this->data['callback'] = $this->model->getMessages();
    }

    //Удаляет все сообщения
    public function administrator_delete(){
        if(isset($this->params[0])) {
            $result = $this->model->delete($this->params[0]);
            if($result) {
                Router::redirect('/administrator/callback');
            }
            else {
                Session::setMessage('Ошибка удаления сообщения');
            }
        }
    }
}