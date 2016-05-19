<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 09.05.2016
 * Time: 20:40
 */

Class Customers extends Model
{
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