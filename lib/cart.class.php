<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 01/04/2016
 * Time: 23:50
 */

//Класс отвечает за работу с покупательской тележкой
class Cart
{
    //Массив идентификаторов продуктов в корзине
    private $products;

    //Конструктор
    //Получает куки и передаёт их в $products
    //Предварительно данные десериализируются (восстановление начального состояния структуры данных из битовой последовательности)
    function __construct()
    {
        $this->products = Cookies::get('products') == null ?
            array()
            :
            unserialize(Cookies::get('products'));
    }

    //Get-ер
    //Возвращает содержимое корзины
    public function getProducts()
    {
        return $this->products;
    }

    //Добавляет товар в корзину по id товара
    public function addProduct($id)
    {
        $id = (int)$id;

        array_push($this->products, $id);

        //Перед записью, кукисы сериализируются (в нашем случаи превращаются из массива в битовую последовательность)
        Cookies::set('products', serialize($this->products));
    }

    //Удаляет товар по id
    public function deleteProduct($id)
    {
        $id = (int)$id;
        
        $key = array_search($id, $this->products);
        if ($key !== false){
            unset($this->products[$key]);
        }

        Cookies::set('products', serialize($this->products));
    }

    //Очищает корзину
    public function clear()
    {
        Cookies::delete('products');
    }

    //Метод проверяет, пуста ли корзина
    public function isEmpty()
    {
        return !$this->products;
    }
}
