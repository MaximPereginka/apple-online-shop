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
                if(isset($_POST['user_id'])) {
                    $id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
                    $result = $this->model->save($_POST, $id);

                    if($result) {
                        Router::redirect('/administrator');
                        Session::setMessage('Пользователь успешно отредактирован');
                    }
                    else {
                        Session::setMessage('Ошибка редактирования пользователя');
                    }
                }
            }
        }
        else {
                Session::setMessage('Неверный ID пользователя');
                Router::redirect('/administrator/users');
        }
    }

    //Метод удаляет товар по его ID
    //Методу не нужно представление
    public function administrator_delete(){
        if(isset($this->params[0])) {
            $result = $this->model->delete($this->params[0]);
            if($result) {
                Router::redirect('/administrator/users');
            }
            else {
                Session::setMessage('Ошибка удаления пользователя');
            }
        }
    }
}