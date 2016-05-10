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

//Предупреждает об удалении поставщиков
function confirmDeleteProvider() {
    if(confirm("Вы действительно хотите удалить этого поставщика?")) {
        return true;
    }
    else {
        return false;
    }
}

//Предупреждает об удалении категорий
function confirmDeleteCategory() {
    if(confirm("Вы действительно хотите удалить эту категорию?")) {
        return true;
    }
    else {
        return false;
    }
}

//Предупреждает об удалении категорий
function confirmDeleteFeature() {
    if(confirm("Вы действительно хотите удалить эту характеристику?")) {
        return true;
    }
    else {
        return false;
    }
}

//Предупреждает об удалении категорий
function confirmDeleteOrder() {
    if(confirm("Вы действительно хотите удалить этот заказ?")) {
        return true;
    }
    else {
        return false;
    }
}

//Предупреждает об удалении клиента
function confirmDeleteCustomer() {
    if(confirm("Вы действительно хотите удалить этого клиента?")) {
        return true;
    }
    else {
        return false;
    }
}