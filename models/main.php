<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 20.05.2016
 * Time: 4:34
 */

Class Main Extends Model
{
    //Метод возвращает не более 6 самых популярных товаров
    public function get_popular_products(){
        $sql = "
            SELECT SUM(`order_content`.`quantity`) as `popularity`, `products`.`image`,
             `products`.`caption`,`products`.`product_id`,  `products`.`price`
            FROM `order_content`, `products`
            WHERE `order_content`.`product_id` = `products`.`product_id`
            GROUP BY `order_content`.`product_id`
            ORDER BY `popularity` DESC
            LIMIT 6
            ";

        //Выполняем запрос
        $result = $this->db->query($sql);
        //Возвращаем результат запроса или null
        return isset($result[0]) ? $result : null;
    }
}