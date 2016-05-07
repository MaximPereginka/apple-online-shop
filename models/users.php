 <?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 28/03/2016
 * Time: 07:25
 */

 //Модель обеспечивает авторизацию пользователей и доступ к информации о пользователях
 class Users extends Model
 {
     //Получаем данные о пользователе по его логину
     public function getByLogin($login){
         //Защита от SQL инъекций
         $login = $this->db->escape($login);

         //SQL запрос
         $sql = "
            SELECT *
            FROM users
            WHERE login = '".$login."'
            LIMIT 1
         ";


         //Выполняем запрос
         $result = $this->db->query($sql);

         if(isset($result[0])) {
             return $result[0];
         }
         return false;
     }

     //Получаем данные о пользователе по его логину
     public function get_by_id($id){
         //Защита от SQL инъекций
         $id = (int)$id;

         //SQL запрос
         $sql = "
            SELECT users.user_id, users.login, user_type.name, users.email, users.user_type, users.phone
            FROM users, user_type
            WHERE user_id = '".$id."'
            LIMIT 1
         ";


         //Выполняем запрос
         $result = $this->db->query($sql);

         if(isset($result[0])) {
             return $result[0];
         }
         return false;
     }
     
     //Получает информацию о всех пользователях
     public function get_all_users(){
         //SQL запрос
         $sql = "
            SELECT users.user_id, users.login, user_type.name, users.email, users.phone
            FROM users, user_type
            WHERE users.user_type = user_type.type_id
         ";


         //Выполняем запрос
         $result = $this->db->query($sql);

         if($result) {
             return $result;
         }
         return false;
     }
     
     //Сохраняет информацию после редактирования
     public function save($data, $id = null) {
         if (!isset($data['login']) ||
             !isset($data['user_type']) ||
             !isset($data['email']) ||
             !isset($data['phone'])
         ) {
             return false;
         }

         //Подготовка для записи в базу данных
         //Защита от SQL инъекций
         $id = (int)$id;
         $login = $this->db->escape($data['login']);
         $user_type = $this->db->escape($data['user_type']);
         $email = $this->db->escape($data['email']);
         $phone = $this->db->escape($data['phone']);

         //Проверяем наличие id
         if (!$id) {
             //Добавление нового пользователя
             $sql = "INSERT INTO users (login, user_type, email, phone)
                    VALUES(
                    '" . $login . "',
                    '" . $user_type . "',
                    '" . $email . "',
                    '" . $phone . "'
                    )
            ";
         } else {
             //Обновление информации о существующем пользователе
             $sql = "UPDATE users
                    SET login = '" . $login . "', 
                        user_type = '" . $user_type . "',
                        email = '" . $email . "',
                        phone = '" . $phone . "'
                    WHERE user_id = '" . $id . "'
            ";
         }

         //Выполняем запрос
         return $this->db->query($sql);
     }

     //Изменяет пароль
     public function change_password($data, $id = null) {
         
     }

     //Удаляет пользователя
     public function delete($id) {
         $id = (int)$id;
         $sql = "DELETE FROM users
                WHERE user_id = ".$id."
               ";
         return $this->db->query($sql);
     }
     
     //Возвращает все типы пользователей
     public function get_user_types(){
         $sql = "
            SELECT *
            FROM user_type
         ";
         
         return $this->db->query($sql);
     }
 }