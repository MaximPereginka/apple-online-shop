<?php
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 28/03/2016
 * Time: 07:22
 */

//Отвечает за авторизацию пользователей админки и управление пользователями
class UsersController extends Controller
{
    //Конструктор
    public function __construct(){
        parent::__construct($data = array());
        //Соединяемся с моделью User
        $this->model = new Users();
    }

    //Метод вызывает форму авторизации и обрабатывает её
    public function administrator_login(){
        //Проверка на полноту введённых данных
        if($_POST && isset($_POST['login']) && isset($_POST['password'])){
            //Получаем данные о пользователе по его логину
            $user = $this->model->getByLogin($_POST['login']);
            //Хешируем введённый пароль для дальнейшего сравнения
            $hash = md5(Config::get('salt').$_POST['password']);

            //Проверяем правильность логина и пароля
            if($user && $hash == $user['password']) {
                //Запоминаем данные о пользователи в переменной $_SESSION
                //Авторизация прошла успешно
                //Логин
                Session::set('login', $user['login']);
                //Тип пользователя
                Session::set('user_type', $user['user_type']);
                Router::redirect('/administrator');
            }
            else{
                Session::setMessage('Пользователя с таким логином не существует или неверный пароль');
            }
        }
    }

    //Метод позволяет выйти из системы
    public function administrator_logout(){
        //Уничтожаем сессию
        Session::destroy();
        //Редирект
        Router::redirect('/administrator/users/login');
    }

    //Выводит всех пользователей админки
    public function administrator_index(){
        $this->data['users'] = $this->model->get_all_users();
    }

    //Открывает страницу редактирования информации о пользователе по его id
    public function administrator_edit(){
        //Проверяем, задан ли ID в параметрах запроса
        if(isset($this->params[0])) {
            $this->data['user'] = $this->model->get_by_id($this->params[0]);
            $this->data['user_types'] = $this->model->get_user_types();

            //Принимаем данные в случаи отправки форм на странице
            if(isset($_POST)){
                //В случаи обновления информации о пользователе
                if(isset($_POST['user_id']) && isset($_POST['save_main_information'])) {
                    $id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
                    $result = $this->model->save($_POST, $id);

                    if($result) {
                        Session::setMessage('Пользователь успешно отредактирован');
                    }
                    else {
                        Session::setMessage('Ошибка редактирования пользователя');
                    }
                }
                //В случаи изменения пароля
                if(isset($_POST['change_password'])) {
                    $id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
                    
                    //Проверяем, совпадают ли новый пароль и его повторный ввод
                    if($_POST['new_password'] != $_POST['new_password_repeated']) {
                        Session::setMessage('Неверный повторный ввод нового пароля'); //Стоит перефразировать
                    }
                    else {
                        //Сохраняем данные из формы в переменные
                        $new = $_POST['new_password'];

                        //Шифруем новый пароль
                        $new = md5(Config::get('salt').$new);
                        //Изменяем пароль
                        $result = $this->model->change_password($id, $new);

                        if($result) {
                            Session::setMessage('Пароль успешно изменён');
                        }
                        else {
                            Session::setMessage('Ошибка изменения пароля');
                        }
                    }
                }
            }
        }
        else {
                Session::setMessage('Неверный ID пользователя');
                Router::redirect('/administrator/users');
        }
    }

    //Создаёт нового пользователя и открывает страницу редактирования
    public function administrator_add(){
        $password = 0;
        //Генерируем случайное 4-х значное число
        for($i = 0; $i < 4; $i++) {
            $password *= 10;
            $password += rand() % 10;
        }
        
        $result = $this->model->add($password);
        if($result) {
            //Получаем id нового пользователя
            $user_id = $this->model->get_last();
            $user_id = $user_id[0]['user_id'];
            if($user_id) {
                Session::setMessage('Новый пользователь успешно создан. Временный пароль: ' . $password);
                Router::redirect('/administrator/users/edit/'. $user_id);
            }
            else {
                Session::setMessage('Новый пользователь успешно создан. Ошибка редактирования.');
                Router::redirect('/administrator/users');
            }
        }
        else {
            Session::setMessage('Ошибка создания пользователя');
            Router::redirect('/administrator/users');
        }
    }
    
    //Метод удаляет товар по его ID
    //Методу не нужно представление
    public function administrator_delete(){
        if(isset($this->params[0])) {
            $result = $this->model->delete($this->params[0]);
            if($result) {
                Session::setMessage('Пользователь успешно удалён');
                Router::redirect('/administrator/users');
            }
            else {
                Session::setMessage('Ошибка удаления пользователя');
            }
        }
    }
}