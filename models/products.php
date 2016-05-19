<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 28/03/2016
 * Time: 00:07
 */

//Модель отвечает за передачу данных в контроллер Products
//Отображает список категорий товаров, список товаров, информацию о товаре
class Products extends Model
{
    //Метод возвращает массив со всеми товарами
    public function getProductsList(){
        //SQL Запрос
        $sql = "SELECT *
                FROM products
                WHERE 1
        ";

        //Выполняем запрос
        $result = $this->db->query($sql);
        //Возвращаем результат запроса или null
        return isset($result[0]) ? $result : null;
    }

    //Принимает ID товара
    //Возвращает все особенности товара и их значения
    public function getProductFeatures($id){
        $id = (int)$id;

        $sql = "
            SELECT features.feature_id, features.name, product_feature.value
            FROM features, product_feature
            WHERE features.feature_id = product_feature.feature_id and product_feature.product_id = '".$id."'
        ";
        
        //Выполняем запрос
        $result = $this->db->query($sql);
        //Возвращаем результат запроса или null
        return isset($result[0]) ? $result : null;
    }

    //Принимаеь id товара
    //Возвращает категории товара
    public function getProductCategories($id){
        $id = (int)$id;

        $sql = "
            SELECT categories.category_id, categories.name
            FROM categories, product_category
            WHERE categories.category_id = product_category.category_id and product_category.product_id = '".$id."'
        ";

        //Выполняем запрос
        $result = $this->db->query($sql);
        //Возвращаем результат запроса или null
        return isset($result[0]) ? $result : null;
    }

    //Метод возвращает все категории товаров магазина
    public function getCategoriesList(){
        //SQL Запрос
        $sql = "SELECT * FROM apple_store.categories
        ";

        //Выполняем запрос
        $result = $this->db->query($sql);
        //Возвращаем результат запроса или null
        return isset($result[0]) ? $result : null;
    }

    //Метод возвращает все возможные особенности товаров магазина
    public function getFeaturesList(){
        //SQL Запрос
        $sql = "SELECT *
                FROM features
        ";

        //Выполняем запрос
        $result = $this->db->query($sql);
        //Возвращаем результат запроса или null
        return isset($result[0]) ? $result : null;
    }

    //Принимает ID категории товаров
    //Метод возвращает массив со всеми товарами данной категории
    public function getProductsByCategory($category_id = ''){
        //Немного безопасности
        $category_id = (int)$category_id;

        //SQL Запрос
        $sql = "SELECT products.*
                FROM products, product_category, categories
                WHERE categories.category_id = 1 
                    AND categories.category_id = product_category.category_id
                        AND product_category.product_id = products.product_id
        ";

        //Выполняем запрос
        $result = $this->db->   query($sql);
        //Возвращаем результат запроса или null
        return isset($result[0]) ? $result : null;
    }

    //Возвращает список поставщиков
    public function getProviders(){
        $sql = "SELECT *
                FROM provider
                WHERE 1
        ";

        //Выполняем запрос
        $result = $this->db->query($sql);
        //Возвращаем результат запроса или null
        return isset($result[0]) ? $result : null;
    }

    //Принимает ID товара
    //Метод возвращает всю информацию о товаре из БД
    public function getProductByID($product_id = '')
    {
        //Немного безопасности
        $product_id = (int)$product_id;

        //SQL Запрос
        $sql = "SELECT products.*
                FROM products, provider
                WHERE product_id = '" . $product_id . "'
        ";

        //Выполняем запрос
        $result = $this->db->query($sql);
        //Возвращаем результат запроса или null
        return isset($result[0]) ? $result[0] : null;
    }

    //--------------------------------- Методы для админки -------------------------------
    //Добавляет новый товар или обновляет информацию о существующем
    //Принимает данные с контроллера и id записи(при редактировании страницы)
    //Проверяем, все ли поля заполнены
    public function save($data, $id = null)
    {
        if (!isset($data['caption']) ||
            !isset($data['image']) ||
            !isset($data['price']) ||
            !isset($data['provider_id']) ||
            !isset($data['short_description']) ||
            !isset($data['long_description'])
        ) {
            return false;
        }

        //Проверяем, должна ли быть опубликована статья
        $is_published = isset($data['is_published']) ? 1 : 0;

        //Подготовка для записи в базу данных
        //Защита от SQL инъекций
        $id = (int)$id;
        $caption = $this->db->escape($data['caption']);
        $image = $this->db->escape($data['image']);
        $price = $this->db->escape($data['price']);
        $provider_id = $this->db->escape($data['provider_id']);
        $short_description = $this->db->escape($data['short_description']);
        $long_description = $this->db->escape($data['long_description']);

        //Проверяем наличие id
        if (!$id) {
            //Добавление нового товара
            $sql = "INSERT INTO products (caption, image, price, short_description, long_description, is_published, provider_id)
                    VALUES(
                    '" . $caption . "',
                    '" . $image . "',
                    '" . $price . "',
                    '" . $short_description . "', 
                    '" . $long_description . "', 
                    '" . $is_published . "',
                    '" . $provider_id . "'
                    )
            ";
        } else {
            //Обновление информации о старом товаре
            $sql = "UPDATE products
                    SET caption = '" . $caption . "', 
                        image = '" . $image . "',
                        price = '" . $price . "',
                        short_description = '" . $short_description . "', 
                        long_description = '" . $long_description . "', 
                        is_published = '" . $is_published . "',
                        provider_id = '" .$provider_id . "'
                    WHERE product_id = '" . $id . "'
            ";
        }
        
        //Выполняем запрос
        return $this->db->query($sql);
    }

    //Создаёт новый товар
    public function create_product(){

        //Создаём запись в БД
        $sql = "
            INSERT INTO products (provider_id, is_published) 
            VALUES ('1', '0')
        ";
        
        return $this->db->query($sql);
    }

    //Возвращает ID последнего добавленного товара
    public function get_max_id() {
        $sql = "
            SELECT product_id
            FROM products
            ORDER BY product_id DESC
            LIMIT 1
        ";

        return $this->db->query($sql);
    }
    
    //Удаляет особенность товара по его ID и ID особенности
    public function remove_product_feature($id, $featId) {

        $id = (int)$id;
        $featId = (int)$featId;
        $sql = "DELETE FROM product_feature
                WHERE product_id = ".$id." and feature_id = ".$featId."
           ";
        return $this->db->query($sql);
    }

    //Добавляет особенность товару по его ID и ID особенности
    public function add_product_feature($id, $featID, $value) {

        $id = (int)$id;
        $featID = (int)$featID;
        $value = htmlspecialchars(stripslashes(trim($value)));

        $sql = "SELECT product_id,feature_id
                FROM product_feature
                WHERE product_id = ".$id." and feature_id = ".$featID."
           ";

        if(!empty($this->db->query($sql))) {
            $sql = "UPDATE product_feature
                    SET `value` = '".$value."'
                    WHERE `product_id` = ".$id." and `feature_id` = ".$featID."
            ";
        }
        else {
            $sql = "INSERT INTO product_feature (`product_id`,`feature_id`,`value`)
                    VALUES (".$id.",".$featID.",'".$value."')   
            ";
        }

        return $this->db->query($sql);
    }

    //Удаляет товар из категории по его ID и ID категории
    public function remove_product_from_category($id, $catId) {
        
        $id = (int)$id;
        $catId = (int)$catId;
        $sql = "DELETE FROM product_category
                WHERE product_id = ".$id." and category_id = ".$catId."
           ";
        return $this->db->query($sql);
    }

    //Добавляет товар в категорию по его ID и ID категории
    public function add_product_to_category($id, $catId) {

        $id = (int)$id;
        $catId = (int)$catId;

        $sql = "SELECT product_id,category_id
                FROM product_category
                WHERE product_id = ".$id." and category_id = ".$catId."
           ";

        //Проверяем, есть ли подобное значение в базе
        if(!empty($this->db->query($sql))) return 1;

        $sql = "INSERT INTO product_category (product_id,category_id)
                VALUES (".$id.",".$catId.")
           ";
        return $this->db->query($sql);
    }
    
    //Удаляет товар по его ID
    public function delete($id) {
        $id = (int)$id;
        $sql = "
                CALL delete_product(".$id.")   
               ";
        return $this->db->query($sql);
    }

    //Удаляет поставщика по его id
    public function delete_provider($id){
        $id = (int)$id;

        $sql = "
            DELETE FROM provider
            WHERE provider_id = '".$id."'
        ";

        return $this->db->query($sql);
    }

    //Принимает id поставщика
    //Если поставщик назначен на товар, товару назначется поставщик "Не определен"
    public function reset_providers($id) {
        $id = (int)$id;

        $sql = "
            UPDATE products
            SET provider_id = '1'
            WHERE provider_id = '".$id."'
        ";

        return $this->db->query($sql);
    }

    //Создаёт нового поставщика
    public function add_provider($data){
        if(!isset($data['provider_name'])) {
            return false;
        }
        else {
            $name = $this->db->escape($data['provider_name']);
            $email = "undefined";
            $phone = "undefined";
            if(isset($data['email'])) $email = $this->db->escape($data['email']);
            if(isset($data['phone'])) $phone = $this->db->escape($data['phone']);

            $sql = "
                INSERT INTO provider
                (`name`, `email`, `phone`)
                VALUES ('".$name."','".$email."','".$phone."')
            ";

            return $this->db->query($sql);
        }
    }
    
    //Создаёт категорию
    public function add_category($data){
        if(!isset($data['name'])) return false;
        else {
            $name = $this->db->escape($data['name']);
            $parent_id = '0';
            $img = "none";
            if(isset($data['parent_id'])) $parent_id = $this->db->escape($data['parent_id']);
            if(isset($data['img'])) $img = $this->db->escape($data['img']);

            if($data['parent_id'] == 0) {
                $sql = "
                    INSERT INTO categories
                    (`name`, `parent_id`,`has_parent`, `img`)
                    VALUES ('".$name."','".$parent_id."','0', '".$img."')
                ";
            }
            else {
                $sql = "
                    INSERT INTO categories
                    (`name`, `parent_id`, `has_parent`, `img`)
                    VALUES ('".$name."','".$parent_id."','1', '".$img."')
                ";
            }

            
            return $this->db->query($sql);
        }
    }

    //Удаляет пары категория-товар по id категории
    public function reset_category($id){
        $id = (int)$id;

        $sql = "
            DELETE
            FROM `product_category`
            WHERE category_id = '".$id."'
        ";
        
        return $this->db->query($sql);
    }

    //Удаляет категорию
    public function delete_category($id){
        $id = (int)$id;

        $sql = "
            DELETE
            FROM `categories`
            WHERE category_id = '".$id."'
        ";

        return $this->db->query($sql);
    }

    //Добавляет характеристику
    public function add_feature($data){
        if(!isset($data['feature_name'])) return false;
        else {
            $name = $this->db->escape($data['feature_name']);

            $sql = "
                INSERT INTO `features`
                (`name`)
                VALUES ('".$name."')
            ";

            return $this->db->query($sql);
        }
    }

    //Удаляет характеристику
    public function delete_feature($id){
        $id = (int)$id;

        $sql = "
            DELETE
            FROM `features`
            WHERE `feature_id` = '".$id."'
        ";

        return $this->db->query($sql);
    }

    //Удаляет все пары "характеристика-товар" по id х-ки
    public function reset_feature($id){
        $id = (int)$id;

        $sql = "
            DELETE
            FROM `product_feature`
            WHERE `feature_id` = '".$id."'
        ";

        return $this->db->query($sql);
    }
}

