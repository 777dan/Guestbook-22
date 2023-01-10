<?php
include_once "action.php";
include "header.php";

$c = 0;
echo '<div class="container d-flex justify-content-center mt-3">';
echo '<div class="btn-group">';
if (isset($_SESSION['user_login'])) {
    echo "<a class='btn btn-info' href='admin_panel.php'>Войти в административную панель</a><br/>";
    echo "<a class='btn btn-info' href='action.php?action=logout'>Выйти из учётной записи</a><br/>";
} else {
    echo "<a class='btn btn-info' href='autorize.php'>Войти</a>";
    echo "<a class='btn btn-info' href='registration.php'>Зарегистрироваться</a>";
}
echo "</div>";
echo "</div>";

output();

if (isset($_GET['next'])) {
    $page_num = $_GET['page'] + 1;
}

include "footer.php";
