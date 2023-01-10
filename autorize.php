<?php

include_once "action.php";

$str_form = "<div class='container-fluid d-flex justify-content-center mt-3'>
<form name='autoForm' action='autorize.php' method='post' onSubmit='return overify_login(this);'>
    Логин: <input type='text' class='form-control' name='login'>
    Пароль: <input type='password' class='form-control' name='pas'><br>
    <input type='submit' class='btn btn-success' style='width:100%;' name='go' value='Войти'>
</form>
</div>";
if (!isset($_POST['go'])) {
    include "header.php";
    echo "<div class='container-fluid d-flex justify-content-center mt-3'>
<a class='btn btn-info' href='index.php'>Вернуться на главную страницу</a>
</div>";
    echo $str_form;
} else {
    if (check_autorize($_POST['login'], $_POST['pas'])) {
        if ($_POST['login'] == "admin") {
            header("Location: admin_panel.php");
        } else {
            header("Location: index.php");
        }
    } else {
        include "header.php";
        echo $str_form; // распечатываем форму
        echo "Нет такого пользователя. Попробуйте снова <br>";
    }
}
include "footer.php";
