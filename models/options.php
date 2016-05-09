<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 09.05.2016
 * Time: 14:08
 */

//Отвечает за передачу и обработку данных на страницах с настройками сайта
Class Options extends Model
{
    public function get_options(){
        $sql = "
            SELECT *
            FROM options
        ";
        
        return $this->db->query($sql);
    }

    //Сохраняет настройку по её названию в базе и значению
    public function save($id, $value){
        $value = $this->db->escape($value);
        $id = (int)$id;

        $sql = "
            UPDATE options
            SET value = '".$value."'
            WHERE option_id = '".$id."'
        ";

        return $this->db->query($sql);
    }
}