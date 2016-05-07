<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 28/03/2016
 * Time: 03:16
 */

//Класс отвечает за обработку формы обратной связи
class Callback extends Model
{
    //Сохраняет сообщение в базе данных
    //Принимает данные из формы
    //Возвращает False, если не заданы все поля формы
    public function save($data) {
        if(!isset($data['name']) || !isset($data['email']) || !isset($data['message'])) {
            return false;
        }

        //Подготовка для записи в базу данных
        //Защита от SQL инъекций
        $name = $this->db->escape($data['name']);
        $email = $this->db->escape($data['email']);
        $message = $this->db->escape($data['message']);

        //Записываем сообщение
        $sql = "INSERT INTO callback_messages (client_name,email,message)
                VALUES('".$name."','".$email."','".$message."');";

        //Выполняем запрос
        return $this->db->query($sql);
    }

    //Отправляет сообщение на почту для отзывов (Указана в Config.php)
    //Доделать
    public function sendMail() {

    }

    //---------------------- Методы админки ---------------------------
    //Выводит сообщения от пользователей
    public function getMessages(){
        //SQL Запрос
        $sql = "SELECT *
                FROM callback_messages
                WHERE 1
        ";

        //Выполняем запрос
        $result = $this->db->query($sql);
        //Возвращаем результат запроса или null
        return isset($result[0]) ? $result : null;
    }

    //Удаляет сообщение по его ID
    public function delete($id) {
        $id = (int)$id;
        $sql = "DELETE FROM callback_messages
                WHERE message_id = ".$id."
               ";
        return $this->db->query($sql);
    }
}