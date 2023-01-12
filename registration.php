<?php
include_once "action.php";

$str_form = "<div class='container-fluid d-flex justify-content-center mt-3'>
<form  name='autoForm' action='registration.php' method='post' onSubmit='return overify_login(this);' >
 			 Логин: <input type='text' class='form-control' name='login'>
 			 Пароль: <input type='password' class='form-control' name='pas'><br>
 			 <input type='submit' class='btn btn-success' style='width:100%' name='go' value='Подтвердить'>
 		     </form>
			 </div>";
if (!isset($_POST['go'])) {
	include "header.php";
	backToMainPage();
	echo $str_form;
} else {
	if (!check_log($_POST['login'])) {
		if (registration($_POST['login'], password_hash($_POST['pas'], PASSWORD_DEFAULT))) {
			include "header.php";
			backToMainPage();
			echo "<h1 style='color:#198754;text-align:center;'>Поздравляем! Вы успешно зарегистрировались!</h1><br/>";
		}
	} else {
		include "header.php";
		backToMainPage();
		echo $str_form;
		echo "Такой пользователь уже существует";
	}
}
include "footer.php";
