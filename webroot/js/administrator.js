/**
 * Created by Maxim on 28/03/2016.
 */

//Предупреждает об удалении страницы
function confirmDeleteProduct() {
    if(confirm("Вы действительно хотите удалить этот товар?")) {
        return true;
    }
    else {
        return false;
    }
}

//Предупреждает об удалении сообщений
function confirmDeleteMessage() {
    if(confirm("Вы действительно хотите удалить это сообщение?")) {
        return true;
    }
    else {
        return false;
    }
}

//Предупреждает об удалении пользователей
function confirmDeleteUsers() {
    if(confirm("Вы действительно хотите удалить этого пользователя?")) {
        return true;
    }
    else {
        return false;
    }
}