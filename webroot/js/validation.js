/**
 * Created by Maxim on 20.05.2016.
 */

//Validate drawing up of an order form | /customers/cart page
function validate_customer() {
    document.getElementById('alert').style.display = "none";

    if(document.customer_form.name.value == "") {
        document.getElementById('alert').style.display = "block";
        document.getElementById('alert').innerHTML = "Вы не заполнили поле \"Имя\"";
        return false;
    }
    else if(document.customer_form.surname.value == "") {
        document.getElementById('alert').style.display = "block";
        document.getElementById('alert').innerHTML = "Вы не заполнили поле \"Фамилия\"";
        return false;
    }
    else if(document.customer_form.email.value == "") {
        document.getElementById('alert').style.display = "block";
        document.getElementById('alert').innerHTML = "Вы не заполнили поле \"Email\"";
        return false;
    }
    else if(document.customer_form.phone.value == "") {
        document.getElementById('alert').style.display = "block";
        document.getElementById('alert').innerHTML = "Вы не заполнили поле \"Номер телефона\"";
        return false;
    }
    else if(!/^([0-9_+\x20\-]+)$/.test(document.customer_form.phone.value)) {
        document.getElementById('alert').style.display = "block";
        document.getElementById('alert').innerHTML = "Поле \"Номер телефона\" должно состоять из цифр, пробелов и символов \"+\", \"-\", \"_\"";
        return false;
    }
    else if(document.customer_form.address.value == "") {
        document.getElementById('alert').style.display = "block";
        document.getElementById('alert').innerHTML = "Вы не заполнили поле \"Адрес доставки\"";
        return false;
    }
    else if(document.customer_form.delivery_type.value == "") {
        document.getElementById('alert').style.display = "block";
        document.getElementById('alert').innerHTML = "Вы не заполнили поле \"Тип доставки\"";
        return false;
    }

    return true;
}

//Validate callback form
function validate_callback() {
    document.getElementById('alert').style.display = "none";

    if(document.callback_form.name.value == "") {
        document.getElementById('alert').style.display = "block";
        document.getElementById('alert').innerHTML = "Вы не заполнили поле \"Имя\"";
        return false;
    }
    else if(document.callback_form.email.value == "") {
        document.getElementById('alert').style.display = "block";
        document.getElementById('alert').innerHTML = "Вы не заполнили поле \"Email\"";
        return false;
    }
    else if(document.callback_form.message.value == "") {
        document.getElementById('alert').style.display = "block";
        document.getElementById('alert').innerHTML = "Вы не заполнили поле \"Сообщение\"";
        return false;
    }

    return true;
}