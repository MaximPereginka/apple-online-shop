<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 09.05.2016
 * Time: 20:39
 */

Class CustomersController extends Controller
{
    //Конструктор
    public function __construct($data = array()) {
        parent::__construct($data);

        //Создаём объект модели
        $this->model = new Customers();
    }
    //Методы админки
    //Выводит многостраничный список заказов
    public function administrator_orders(){
        //Удаление заказа
        if(isset($this->params[0]) && ($this->params[0] == 'delete')){
            if(isset($this->params[1])) {
                $result = $this->model->delete_order($this->params[1]);

                if($result) {
                    Session::setMessage("Щаказ успешно удалён");
                    Router::redirect("/administrator/customers/orders");
                }
                else {
                    Session::setMessage("Ошибка удаления заказа");
                }
            }
        }

        $orders_count = $this->model->count_orders();
        if($orders_count) {
            //Получаем количество заказов
            $orders_count = $orders_count[0]['order_count'];
            //Рассчитываем количество страниц, необходимых для отображения заказов
            $this->data['pages_required'] = ceil($orders_count / 20);

            //Текущая страница по-умолчанию
            $current_page = 1;

            //Получаем номер текущей страницы
            if(isset($this->params[0]) && ($this->params[0] == 'page')){
                if(isset($this->params[1]) && ($this->params[1] <= $this->data['pages_required'] )) {
                    $current_page = $this->params[1];
                }
                else {
                    Session::setMessage("Такой страницы не существует");
                    Router::redirect("/administrator/customers/orders");
                }
            }

            //Получаем заказы для данной страницы
            $this->data['orders'] = $this->model->get_orders_page($current_page);

        }
        else {
            Session::setMessage("Не удалось получить количество заказов");
        }

    }
    
    //Выводит полную информацию о заказе
    public function administrator_edit_order(){
        
        if(isset($this->params[0])) {
            //Получаем всю необходимую информацию их базы данных
            $this->data['order'] = $this->model->get_order_main($this->params[0]);
            $this->data['statuses'] = $this->model->get_statuses();
            $this->data['managers'] = $this->model->get_managers();
            $this->data['order_content'] = $this->model->get_order_content($this->params[0]);

            //Сохраняем информацию, если нужно
            if($_POST) {
                //Краткая информация о товаре
                if($_POST['action'] = 'change-main-info') {
                    $result = $this->model->save_order($_POST);

                    if($result) {
                        Session::setMessage("Заказ успешно изменён");
                        Router::redirect("/administrator/customers/edit_order/".$this->params[0]);
                    }
                }
            }
        }
        else {
            Session::setMessage("Такой страницы не существует");
            Router::redirect("/administrator/customers/orders");
        }
        
    }
    
    //Выводит многостраничный список клиентов
    public function administrator_index(){
        
    }
    
    //Выводит подробную информацию о клиенте и список его заказов
    public function edit(){

    }
}