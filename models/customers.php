<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 09.05.2016
 * Time: 20:40
 */

Class Customers extends Model
{
    //Принимает массив с id товаров
    //Возвращает информацию об этих товарах
    public function get_products_list_by_ids($ids = array()){
        if(empty($ids)) {
            return false;
        }
        else {
            //Готовим список id нужных товаров
            $id_list = array_shift($ids);

            foreach($ids as $id) {
                $id = (int)$id;
                $id_list .= ", " . $id;
            }
            
        $sql = "
            SELECT `caption`, `price`, `product_id` 
            FROM `products`
            WHERE `product_id` IN (".$id_list.")
        ";

            return $this->db->query($sql);
        }
    }

    //Проверяет, есть ли email пользователя в базе
    public function check_customer_email($email) {
        $email = $this->db->escape($email);

        $sql = "
            SELECT `client_id`, `email`
            FROM `clients`
            WHERE `email` = '".$email."'
            LIMIT 1
            ";

        return $this->db->query($sql);
    }

    //Принимает данные о пользователе и корзину с количеством каждой позиции
    //Создаёт нового пользователя и новый заказ
    public function new_order_new_client($data, $cart){
        if(!isset($data['name'])
            || !isset($data['surname'])
                || !isset($data['email'])
                || !isset($data['phone'])
                || !isset($data['address'])
                || !isset($data['delivery_type'])) {
            return false;
        }
        else if(empty($cart)) return false;
        else {
            $name = $this->db->escape($data['name']);
            $surname = $this->db->escape($data['surname']);
            $email = $this->db->escape($data['email']);
            $phone = $this->db->escape($data['phone']);
            $address = $this->db->escape($data['address']);
            $delivery_type = $this->db->escape($data['delivery_type']);

            //Получаем идентификатор подключения к БД
            $connection = $this->db->get_connection();

            //Начало транзакции
            mysqli_autocommit($connection, false);

            //Создаём пользователя
            $sql = "
                INSERT INTO `clients`
                  (`name`, `surname`, `email`, `phone`)
                  VALUES ('".$name."','".$surname."','".$email."','".$phone."')
            ";

            $this->db->query($sql);

            //Получаем id последнего созданного пользователя
            $sql = "
                SELECT MAX(`client_id`) FROM `clients` LIMIT 1 
            ";

            $client_id = $this->db->query($sql);
            $client_id = $client_id[0]['MAX(`client_id`)'];

            //Создаём заказ
            $sql = "
              INSERT INTO `orders`
              (`client_id`, `user_id`, `status_id`, `delivery_type`, `delivery_adress`)
              VALUES ('".$client_id."', '0', '1', '".$delivery_type."', '".$address."');
            ";

            $this->db->query($sql);

            //Получаем id созданного заказа
            $sql = "
                SELECT MAX(`order_id`)
                FROM `orders`
                LIMIT 1
            ";

            $order_id = $this->db->query($sql);
            $order_id = $order_id[0]['MAX(`order_id`)'];

            //Добавляем содержимое корзины
            foreach ($cart as $item) {

                $product_id = (int)$item['product_id'];
                $quantity = (int)$item['quantity'];

                $sql = "
                    INSERT INTO `order_content`
                    (`order_id`, `product_id`, `quantity`)
                    VALUES('".$order_id."', '".$product_id."', '".$quantity."')
                ";

                $this->db->query($sql);
            }

            //Конец транзакции
            mysqli_commit($connection);
            mysqli_autocommit($connection, true);

            return true;
        }
    }

    //Принимает данные о пользователе, корзину с количеством каждой позиции и id пользователя
    //Создаёт новый заказ, обновляет информацию о пользователе
    public function new_order_old_client($data, $cart, $client_id){
        if(!isset($data['name'])
            || !isset($data['surname'])
            || !isset($data['email'])
            || !isset($data['phone'])
            || !isset($data['address'])
            || !isset($data['delivery_type'])) {
            return false;
        }
        else if(empty($cart)) return false;
        else if(is_null($client_id)) return false;
        else {
            $name = $this->db->escape($data['name']);
            $surname = $this->db->escape($data['surname']);
            $phone = $this->db->escape($data['phone']);
            $address = $this->db->escape($data['address']);
            $delivery_type = $this->db->escape($data['delivery_type']);

            //Получаем идентификатор подключения к БД
            $connection = $this->db->get_connection();

            //Начало транзакции
            mysqli_autocommit($connection, false);

            //Обновляем данные пользователя
            $sql = "
                UPDATE `clients`
                SET `name` = '".$name."',
                    `surname` = '".$surname."',
                    `phone` = '".$phone."'
                WHERE `client_id` = '".$client_id."'
            ";

            $this->db->query($sql);

            //Создаём заказ
            $sql = "
              INSERT INTO `orders`
              (`client_id`, `user_id`, `status_id`, `delivery_type`, `delivery_adress`)
              VALUES ('".$client_id."', '0', '1', '".$delivery_type."', '".$address."');
            ";

            $this->db->query($sql);

            //Получаем id созданного заказа
            $sql = "
                SELECT MAX(`order_id`)
                FROM `orders`
                LIMIT 1
            ";

            $order_id = $this->db->query($sql);
            $order_id = $order_id[0]['MAX(`order_id`)'];

            //Добавляем содержимое корзины
            foreach ($cart as $item) {

                $product_id = (int)$item['product_id'];
                $quantity = (int)$item['quantity'];

                $sql = "
                    INSERT INTO `order_content`
                    (`order_id`, `product_id`, `quantity`)
                    VALUES('".$order_id."', '".$product_id."', '".$quantity."')
                ";

                $this->db->query($sql);
            }

            //Конец транзакции
            mysqli_commit($connection);
            mysqli_autocommit($connection, true);

            return true;
        }
    }

    //Возвращает 20 клиентов для страницы n
    public function get_clients_page($page){
        $page = (int)$page;
        $offset = 20 * ($page - 1);

        $sql = "
            SELECT *
            FROM clients
            LIMIT ".$offset.",20
        ";

        return $this->db->query($sql);
    }

    //Возвращает все заказы клиента по id клиента
    public function get_client_orders($id){
        $id = (int)$id;

        $sql = "
            SELECT orders.order_id, users.login, 
                order_status.name, SUM(products.price * order_content.quantity) as order_price
            FROM orders, order_status, users, clients, products, order_content
            WHERE (orders.status_id = order_status.status_id) 
                AND (users.user_id = orders.user_id)
                    AND (clients.client_id = orders.client_id)
                        AND (orders.order_id = order_content.order_id)
                            AND (order_content.product_id = products.product_id)
                              AND (clients.client_id = ".$id.")
            GROUP BY(orders.order_id)  
        ";

        return $this->db->query($sql);
    }

    //Возвращает информацию о клиенте по его id
    public function get_client($id){
        $id = (int)$id;

        $sql = "
            SELECT *
            FROM clients
            WHERE clients.client_id = ".$id."
        ";

        return $this->db->query($sql);
    }

    //Удаляет клиента по его id
    public function delete_client($id){
        $id = (int)$id;

        $sql = "
            DELETE
            FROM clients
            WHERE client_id = ".$id."
        ";

        return $this->db->query($sql);
    }

    //Возвращает количество клиентов
    public function count_clients(){
        $sql = "SELECT COUNT(client_id) AS clients_count FROM clients";
        
        return $this->db->query($sql);
    }

    //Принимает номер страницы
    //Возвращает 20 заказов для этой страницы
    public function get_orders_page($page){
        $page = (int)$page;
        $offset = 20 * ($page - 1);

        $sql = "
            SELECT orders.order_id, clients.name AS client_name, clients.phone, users.login, 
                order_status.name, SUM(products.price * order_content.quantity) as order_price
            FROM orders, order_status, users, clients, products, order_content
            WHERE (orders.status_id = order_status.status_id) 
                AND (users.user_id = orders.user_id)
                    AND (clients.client_id = orders.client_id)
                        AND (orders.order_id = order_content.order_id)
                            AND (order_content.product_id = products.product_id)
            GROUP BY(orders.order_id)  
            LIMIT ".$offset.",20
        ";

        return $this->db->query($sql);
    }

    //Возвращает количество заказов
    public function count_orders(){
        $sql = "
            SELECT COUNT(orders.order_id) as order_count
            FROM orders, order_status, users, clients, products, order_content
            WHERE (orders.status_id = order_status.status_id) 
                AND (users.user_id = orders.user_id)
                    AND (clients.client_id = orders.client_id)
                        AND (orders.order_id = order_content.order_id)
                            AND (order_content.product_id = products.product_id)
        ";

        return $this->db->query($sql);
    }

    //Полностью удаляет заказ по его id
    public function delete_order($id){
        $id = (int)$id;

        //Получаем идентификатор подключения к БД
        $connection = $this->db->get_connection();

        //Начало транзакции
        mysqli_autocommit($connection, false);

        $sql = "
            DELETE
            FROM `order_content`
            WHERE `order_id` = '".$id."'
        ";

        $this->db->query($sql);

        $sql = "
            DELETE
            FROM `orders`
            WHERE `order_id` = '".$id."'
        ";

        $this->db->query($sql);

        //Конец транзакции
        mysqli_commit($connection);
        mysqli_autocommit($connection, true);
    }

    //Принимает id заказа
    //Возвращает содержание заказа
    public function get_order_content($id){
        $id = (int)$id;

        $sql = "
            SELECT products.product_id, products.caption, products.price, order_content.quantity
            FROM order_content, products
            WHERE (order_content.order_id = '".$id."') AND (order_content.product_id = products.product_id)
        ";

        return $this->db->query($sql);
    }

    //Принимает id заказа
    //Возвращает главную информацию о заказе
    public function get_order_main($id){
        $id = (int)$id;

        $sql = "
            SELECT orders.order_id, clients.client_id, clients.name as client_name,
              clients.surname, users.login as user_name, users.user_id, order_status.status_id, order_status.name as status_name,
                orders.date_created, orders.delivery_type, orders.delivery_adress
            FROM orders, clients, users, order_status
            WHERE (orders.order_id = '".$id."') AND (orders.client_id = clients.client_id)
                AND (users.user_id = orders.user_id) AND (order_status.status_id = orders.status_id)
        ";

        return $this->db->query($sql);
    }

    //Возвращает все возможные статусы заказов
    public function get_statuses(){
        $sql = "
            SELECT *
            FROM order_status
        ";

        return $this->db->query($sql);
    }

    //Возвращает всех возможных менеджеров и старших менеджеров
    public function get_managers(){
        $sql = "
            SELECT users.user_id, users.login
            FROM users, user_type
            WHERE (user_type <> '1') AND (user_type.type_id = users.user_type)
        ";

        return $this->db->query($sql);
    }

    //Сохраняет главную информацию о заказе
    public function save_order($data){
        if(!isset($data['order_id'])
            || !isset($data['user_id'])
            || !isset($data['status_id'])
        ) {
            return false;
        }
        else {
            $order_id = (int)$this->db->escape($data['order_id']);
            $user_id = (int)$this->db->escape($data['user_id']);
            $status_id = (int)$this->db->escape($data['status_id']);

            $sql = "
                UPDATE orders
                SET `user_id` = '".$user_id."',
                    `status_id` = '".$status_id."'
                WHERE `order_id` = '".$order_id."'
            ";

            return $this->db->query($sql);
        }
    }
}