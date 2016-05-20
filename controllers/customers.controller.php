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

    //Выводит покупательскую корзину
    public function cart(){

        $cart = App::$cart->getProducts();
        
        $cart_list = array();

        $length = count($cart);

        //Формируем пары "id товара/количество"
        while(!empty($cart)){
            $id = array_shift($cart);
            $quantity = 1;

            //Ищем товары с таким же id и убираем
            for($i = 0; $i < $length; $i++) {
                if(isset($cart[$i])) {
                    if($id == $cart[$i]) {
                        $quantity++;
                        unset($cart[$i]);

                    }
                }
            }

            $product = array(
                "product_id" => $id,
                "quantity" => $quantity
            );

            array_push($cart_list, $product);
        }

        //Возвращаем информацию о нужных товарах
        $result = $this->model->get_products_list_by_ids(App::$cart->getProducts());

        if($result) {
            $product_info = $result;
            
            $counter = count($product_info);

            //Объединяем информацю в один массив
            for($i = 0; $i < $counter; $i++) {
                foreach($cart_list as $cart) {
                    if($product_info[$i]['product_id'] == $cart['product_id']) {
                        $product_info[$i]['quantity'] = $cart['quantity'];
                    }
                }
            }
            $this->data['product_info'] = $product_info;
        }
        else {
            Session::setMessage("Не удалось получить информацию о товарах");
        }

        //Удаляем товар с корзины
        if((isset($this->params[0])) && ($this->params[0] == "delete")) {
            if(isset($this->params[1])) {
                $id = (int)$this->params[1];
                App::$cart->deleteProduct($id);
                Session::setMessage('Товар успешно удалён с корзины');
                Router::redirect("/customers/cart");
            }
        }
        //Чистим корзину
        else if((isset($this->params[0])) && ($this->params[0] == "clear")) {
            App::$cart->clear();
            Session::setMessage("Корзина очищена");
            Router::redirect("/main");
        }
        else if($_POST) {
            $result = $this->model->check_customer_email($_POST['email']);
            if(!$result) {
                //Добавляем новый заказ и нового пользователя
                $result = $this->model->new_order_new_client($_POST, $cart_list);
                if($result) {
                    Session::setMessage("Заказ успешно оформлен. Наши сотрудники свяжутся с Вами в ближайшее время");
                    //Чистим корзину
                    App::$cart->clear();
                    Router::redirect("/main");
                }
                else {
                    Session::setMessage("Не удалось создать заказ, повторите позже");
                }
            }
            else {
                $client_id = (int)$result[0]['client_id'];
                
                //Добавляем новый заказ к существующему пользователю
                $result = $this->model->new_order_old_client($_POST, $cart_list, $client_id);
                if($result) {
                    Session::setMessage("Заказ успешно оформлен. Наши сотрудники свяжутся с Вами в ближайшее время");
                    //Чистим корзину
                    App::$cart->clear();
                    Router::redirect("/customers/success_page");
                }
                else {
                    Session::setMessage("Не удалось создать заказ, повторите позже");
                }
            }
        }
    }

    //Страница благодарности
    public function success_page(){
        
    }
    
    //Методы админки
    //Выводит многостраничный список заказов
    public function administrator_orders(){
        //Удаление заказа
        if(isset($this->params[0]) && ($this->params[0] == 'delete')){
            if(isset($this->params[1])) {
                $result = $this->model->delete_order($this->params[1]);

                Session::setMessage("Заказ успешно удалён");
                Router::redirect("/administrator/customers/orders");
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
        //Удаление клиента
        if(isset($this->params[0]) && ($this->params[0] == 'delete')){
            if(isset($this->params[1])) {
                $result = $this->model->delete_client($this->params[1]);

                if($result) {
                    Session::setMessage("Клиент успешно удалён");
                    Router::redirect("/administrator/customers");
                }
                else {
                    Session::setMessage("Ошибка удаления клиента");
                }
            }
        }
        
        $customers_count = $this->model->count_clients();
        if($customers_count){
            //Получаем количество клиентов
            $customers_count = $customers_count[0]['clients_count'];

            //Рассчитываем количество страниц, необходимых для отображения заказов
            $this->data['pages_required'] = ceil($customers_count / 20);

            //Текущая страница по-умолчанию
            $current_page = 1;

            //Получаем номер текущей страницы
            if(isset($this->params[0]) && ($this->params[0] == 'page')){
                if(isset($this->params[1]) && ($this->params[1] <= $this->data['pages_required'] )) {
                    $current_page = $this->params[1];
                }
                else {
                    Session::setMessage("Такой страницы не существует");
                    Router::redirect("/administrator/customers/index");
                }
            }

            //Получаем клиентов для данной страницы
            $this->data['customers'] = $this->model->get_clients_page($current_page);
        }
        else {
            Session::setMessage("Не удалось посчитать количество пользователей");
        }
    }
    
    //Выводит подробную информацию о клиенте и список его заказов
    public function administrator_view(){
        if(isset($this->params[0])){
            $this->data['client'] = $this->model->get_client($this->params[0]);
            $this->data['orders'] = $this->model->get_client_orders($this->params[0]);
        } 
        else {
            Router::redirect("/administrator/customers");
        }
    }
}