<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 09.05.2016
 * Time: 20:40
 */

Class Customers extends Model
{
    //Возвращает список клиентов и информацию о них

    //Возвращает все заказы клиента по id клиента

    //Возвращает информацию о клиенте по его id

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

    //Создаёт новый заказ

    //Создаёт нового клиента

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
                orders.date_created
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