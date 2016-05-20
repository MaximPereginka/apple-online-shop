<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 27/03/2016
 * Time: 22:42
 */

//Контроллер отвечает за отображение товаров на сайте

class ProductsController extends Controller
{
    //Конструктор
    //Связывает контроллер и модель
    public function __construct($data = array()){
        parent::__construct($data);

        $this->model = new Products();
    }

    //Базовый метод (по-умолчанию)
    //Выводит список базовых категорий товаров
    public function index() {
        //Получаем данные с модели
        $this->data['categories'] = $this->model->getRootCategoriesList();
        $this->data['popular'] = $this->model->get_popular_products();
    }

    //Метод отвечает за просмотр отдельных товаров
    public function view() {
        //Получаем параметры с роутера
        $params = App::getRouter()->getParams();

        //Проверяем, переданы ли параметры через URL
        if( isset($params[0]) ) {
            $product_id = strtolower($params[0]);
            $this->data['product'] = $this->model->getProductByID($product_id);
            $this->data['product_features'] = $this->model->getProductFeatures($product_id);
            $this->data['product_categories'] = $this->model->getProductCategories($product_id);
            $this->data['popular'] = $this->model->get_popular_products();
        }
        else throw new Exception('Такой страницы не существует');
    }

    //Метод выводит подкатегории даной категории а так же товары этой категории
    public function category(){
        if(isset($this->params[0])) {
            $this->data['current_category'] = $this->model->get_category_name($this->params[0]);
            $this->data['categories'] = $this->model->get_child_categories($this->params[0]);
            $this->data['products'] = $this->model->getProductsByCategory($this->params[0]);

            if(isset($this->params[1])){
                $this->data['products'] = $this->model->getProductsByCategory($this->params[0], $this->params[1]);
            }
        }
        else Session::setMessage("Такой страницы не существует");
    }
    
    //Добавляет товар в корзину по его id
    public function add_to_cart(){
        //Получаем параметры с роутера
        $params = App::getRouter()->getParams();

        //Проверяем, переданы ли параметры через URL
        if( isset($params[0]) ) {
            $product_id = strtolower($params[0]);
            App::$cart->addProduct($product_id);
            Router::redirect('/customers/cart');
        }
        else throw new Exception('Товара с таким id не существует');
    }

    //---------------------- Методы админки -----------------------------
    //Метод отображает список товаров
    public function administrator_view(){
        $this->data['products-list'] = $this->model->getProductsList();
    }


    //Метод отображает страницу добавления нового товара
    public function administrator_add(){
        //Создаём новую запись в БД
        $result = $this->model->create_product();
        if($result) {
            //Находим максимальный ID
            $id = $this->model->get_max_id();
            if($id) {
                $id = $id[0]['product_id'];

                //Переходим к редактированию товара
                Router::redirect('/administrator/products/edit/'.$id);
            }

        }
        else {
            Session::setMessage('Ошибка создания товара');
        }
    }

    //Метод отображает страницу редактирования отдельного товара
    public function administrator_edit(){
        //Проверяем, задан ли ID в параметрах запроса
        if(isset($this->params[0])) {
            $this->data['product'] = $this->model->getProductByID($this->params[0] );
            $this->data['product_features'] = $this->model->getProductFeatures($this->params[0] );
            $this->data['product_categories'] = $this->model->getProductCategories($this->params[0] );
            $this->data['providers'] = $this->model->getProviders();
            $this->data['categories'] = $this->model->getCategoriesList();
            $this->data['features'] = $this->model->getFeaturesList();

            //Удаляет товар из категории
            if((isset($this->params[1])) and ($this->params[1] == "deleteCategory")) {
                if(isset($this->params[2])) {
                    $result = $this->model->remove_product_from_category($this->params[0], $this->params[2]);
                    if($result) {
                        Session::setMessage('Товар удалён из категории');
                        Router::redirect('/administrator/products/edit/'.$this->params[0]);
                    }
                    else {
                        Session::setMessage('Ошибка удаления товара из категории');
                        Router::redirect('/administrator/products/edit/'.$this->params[0]);
                    }
                }
                else {
                    Router::redirect('/administrator/products/edit/'.$this->params[0]);
                }
            }
            //Удаляет характеристику из товара
            if((isset($this->params[1])) and ($this->params[1] == "deleteFeature")) {
                if(isset($this->params[2])) {
                    $result = $this->model->remove_product_feature($this->params[0], $this->params[2]);
                    if($result) {
                        Session::setMessage('Характеристика успешно добавлена');
                        Router::redirect('/administrator/products/edit/'.$this->params[0]);
                    }
                    else {
                        Session::setMessage('Ошибка удаления характеристики');
                        Router::redirect('/administrator/products/edit/'.$this->params[0]);
                    }
                }
                else {
                    Router::redirect('/administrator/products/edit/'.$this->params[0]);
                }
            }
        }
        else {
            Session::setMessage('Неверный ID товара');
            Router::redirect('/administrator');
        }

        if($_POST) {
            //Добавление товара в категорию по ID категории
            if(isset($_POST['add_to_category'])) {
                $result = $this->model->add_product_to_category($this->params[0], $_POST['add_to_category']);
                if($result) {
                    Session::setMessage('Товар добавлен в категорию');
                    Router::redirect('/administrator/products/edit/'.$this->params[0]);
                }
                else {
                    Session::setMessage('Ошибка добавления товара в категорию');
                    Router::redirect('/administrator/products/edit/'.$this->params[0]);
                }
            }
            if(isset($_POST['add_product_feature'])) {
                $result = $this->model->add_product_feature($this->params[0], $_POST['add_product_feature'], $_POST['new_feature_value']);
                if($result) {
                    Session::setMessage('Характеристика успешно добавлена');
                    Router::redirect('/administrator/products/edit/'.$this->params[0]);
                }
                else {
                    Session::setMessage('Ошибка добавления характеристики');
                    Router::redirect('/administrator/products/edit/'.$this->params[0]);
                }
            }
            else {
                $id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
                $result = $this->model->save($_POST, $id);
                if($result) {
                    header('location:'.$_SERVER['HTTP_REFERER']); //Костыль

                    Session::setMessage('Товар успешно отредактирован');
                }
                else {
                    Session::setMessage('Ошибка редактирования товара');
                }
            }
        }
    }

    //Метод удаляет товар по его ID
    //Методу не нужно представление
    public function administrator_delete(){
        if(isset($this->params[0])) {
            $result = $this->model->delete($this->params[0]);
            if($result) {
                Router::redirect('/administrator/products/view');
            }
            else {
                Session::setMessage('Ошибка удаления товара');
            }
        }
    }

    //Страница с поставщиками
    public function administrator_providers(){
        $this->data['providers'] = $this->model->getProviders();

        //Добавление нового поставщика
        if($_POST) {
            $result = $this->model->add_provider($_POST);
            
            if($result) {
                Session::setMessage("Поставщик успешно добавлен");
                Router::redirect("/administrator/products/providers");
            }
            else {
                Session::setMessage("Ошибка создания поставщика");
            }
        }
        
        //Удаление поставщика
        if(isset($this->params[0]) && ($this->params[0] == 'delete')) {
            if(isset($this->params[1]) && ($this->params[1] != '1')) {

                //Подготовка базы - если поставщик назначен на товар, товару присваивается поставщик "не определен"
                $result = $this->model->reset_providers($this->params[1]);

                if($result) {
                    //Удаления поставщика из базы
                    $result = $this->model->delete_provider($this->params[1]);

                    if($result) {
                        Session::setMessage('Поставщик успешно удалён');
                        Router::redirect('/administrator/products/providers');
                    }
                    else {
                        Session::setMessage('Ошибка удаления поставщика');
                    }
                }
                else {
                    Session::setMessage("Не удалось удалить поставщика");
                }
            }
        }
    }
    
    //Страница с категориями
    public function administrator_categories(){
        $this->data['categories'] = $this->model->getCategoriesList();

        //Добавление новой категории
        if($_POST){
            $result = $this->model->add_category($_POST);
            if($result){
                Session::setMessage("Категория успешно добавлена");
                Router::redirect("/administrator/products/categories");
            }
            else {
                Session::setMessage("Ошибка создания категории");
            }
        }

        //Удаление категории
        if(isset($this->params[0]) && ($this->params[0] == 'delete')) {
            if(isset($this->params[1])) {

                //Подготовка базы - если категория назначена на товар, удаляем привязки
                $result = $this->model->reset_category($this->params[1]);

                if($result) {
                    //Удаления категории из базы
                    $result = $this->model->delete_category($this->params[1]);

                    if($result) {
                        Session::setMessage('Категория успешно удалена');
                        Router::redirect('/administrator/products/categories');
                    }
                    else {
                        Session::setMessage('Ошибка удаления категории');
                    }
                }
                else {
                    Session::setMessage("Не удалось удалить категорию");
                }
            }
        }
    }
    
    //Страница с х-ками товаров
    public function administrator_features(){
        $this->data['features'] = $this->model->getFeaturesList();
        
        //Добавляем новую характеристику
        if($_POST) {
            $result = $this->model->add_feature($_POST);
            if($result){
                Session::setMessage("Характеристика успешно добавлена");
                Router::redirect("/administrator/products/features");
            }
            else {
                Session::setMessage("Ошибка добавления характеристики");
            }
        }
        
        //Удаляем характеристику по ID
        if(isset($this->params[0]) && ($this->params[0] == 'delete')) {
            if(isset($this->params[1])) {

                //Подготовка базы - если арактеристика назначена на товар, удаляем привязки
                $result = $this->model->reset_feature($this->params[1]);

                if($result) {
                    //Удаления характеристики из базы
                    $result = $this->model->delete_feature($this->params[1]);

                    if($result) {
                        Session::setMessage('Характеристика успешно удалена');
                        Router::redirect('/administrator/products/features');
                    }
                    else {
                        Session::setMessage('Ошибка удаления характеристики');
                    }
                }
                else {
                    Session::setMessage("Не удалось удалить характеристику");
                }
            }
        }
    }
}