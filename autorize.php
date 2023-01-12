<?php

include_once "action.php";


$str_form = "<div class='container-fluid d-flex justify-content-center mt-4'>
<form name='autoForm' action='autorize.php' method='post' onSubmit='return overify_login(this);'>
    Логин: <input id='login' type='text' class='form-control' name='login'>
    Пароль: <input type='password' class='form-control' name='pas'><br>
    <input type='submit' class='btn btn-success' style='width:100%;' name='go' value='Войти'>
</form>
</div>";
if (!isset($_POST['go'])) {
    include "header.php";
    backToMainPage();
    echo $str_form;
} else {
    if (check_autorize($_POST['login'], $_POST['pas'])) {
            header("Location: index.php");
    } else {
        include "header.php";
        backToMainPage();
        echo $str_form; // распечатываем форму
        echo "<h3 style='color:red;text-align:center;'>Нет такого пользователя</h3>";
    }
}
include "footer.php";
