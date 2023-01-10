<?php
include_once "action.php";

$str_form = "<div class='container-fluid d-flex justify-content-center mt-3'>
<form  name='autoForm' action='registration.php' method='post' onSubmit='return overify_login(this);' >
 			 Логін: <input type='text' class='form-control' name='login'>
 			 Пароль: <input type='password' class='form-control' name='pas'><br>
 			 <input type='submit' class='btn btn-success' style='width:100%' name='go' value='Підтвердити'>
 		     </form>
			 </div>";
if (!isset($_POST['go'])) {
	include "header.php";
	echo "<div class='container-fluid d-flex justify-content-center mt-3'>
<a class='btn btn-info' href='index.php'>Вернуться на главную страницу</a>
</div>";
	echo $str_form;
} else {
	if (!check_log($_POST['login'])) {
		if (registration($_POST['login'], $_POST['pas'])) {
			include "header.php";
			echo "Ви успішно зареєстровані!<br/>";
			echo "<a href='index.php'>Перегляд сайту</a><br/>";
			echo "<a href='admin_panel.php'>Увійти до адміністративної панелі</a><br/>";
		}
	} else {
		include "header.php";
		echo $str_form;
		echo "Користувач із таким ім'ям вже існує!";
	}
}
include "footer.php";
