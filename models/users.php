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

     //Возвращает ID последнего зарегистрированного пользователя
     public function get_last(){
         $sql = "
            SELECT user_id
            FROM users
            ORDER BY user_id DESC
            LIMIT 1
        ";

         return $this->db->query($sql);
     }

     //Создаёт нового пользователя
     //Принимает сгенерированный пароль из 4-х цифр
     public function add($password) {
         //Кодируем пароль
         $password = md5(Config::get('salt').(int)$password);

         $sql = "
            SELECT user_id
            FROM users
            ORDER BY user_id DESC 
            LIMIT 1
         ";

         //Генерируем login
         $result = $this->db->query($sql);
         $result = $result[0]['user_id'] + 1;

         $sql = "
            INSERT INTO users
            (login, password, user_type) VALUES ('user".$result."', '".$password."', '3')
         ";

         return $this->db->query($sql);
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

     //Получает зашифрованный пароль пользователя
     public function get_user_password($id) {
         $id = (int)$id;

         $sql = "
             SELECT password
             FROM users
             WHERE user_id = '".$id."'
             LIMIT 1
         ";
         
         return $this->db->query($sql);
     }

     //Изменяет пароль пользователя
     public function change_password($id, $new) {
         $id = (int)$id;
         $new = $this->db->escape($new);
         
         $sql = "
            UPDATE users
            SET password = '".$new."'
            WHERE user_id = '".$id."'
         ";
         
         return $this->db->query($sql);
     }
     
     //Личный кабинет
     //Сохраняет информацию в личном кабинете. Принимает данные, отправленные с формы
     public function private_office_save($data){
         //Проверяем, все ли данные получены с формы
         if(
            !isset($data['user_id'])
            || !isset($data['login'])
            || !isset($data['email'])
            || !isset($data['phone'])
         ) return false;
         else {

             //Подготовка для записи в базу данных
             //Защита от SQL инъекций
             $id = $this->db->escape($data['user_id']);
             $login = $this->db->escape($data['login']);
             $email = $this->db->escape($data['email']);
             $phone = $this->db->escape($data['phone']);

             $sql = "
                UPDATE users
                SET login = '".$login."',
                    email = '".$email."',
                    phone = '".$phone."'
                WHERE user_id = '".$id."'
             ";

             return $this->db->query($sql);
         }
     }

    public function private_office_change_password($user_id, $new_password){
        $user_id = (int)$user_id;
        $new_password = $this->db->escape($new_password);

        $sql = "
            UPDATE users
            SET password = '".$new_password."'
            WHERE user_id = '".$user_id."'
        ";

        return $this->db->query($sql);
    }
 }