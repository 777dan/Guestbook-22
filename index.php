<?php
if ($_SERVER['REQUEST_URI'] == "/guestBook-22/" || $_SERVER['REQUEST_URI'] == "/guestBook-22/index.php") {
    header("Location: index.php?page=0");
}

include_once "action.php";
include "header.php";

echo '<div class="container d-flex justify-content-center mt-3">';
echo '<div class="btn-group">';
if (isset($_SESSION['user_login'])) {
    if ($_SESSION['user_login'] == "admin") echo "<a class='btn btn-info' href='admin_panel.php'>Войти в административную панель</a><br/>";
    echo "<a class='btn btn-info' href='action.php?action=logout'>Выйти из учётной записи</a><br/>";
} else {
    echo "<a class='btn btn-info' href='autorize.php'>Войти</a>";
    echo "<a class='btn btn-info' href='registration.php'>Зарегистрироваться</a>";
}
echo "</div>";
echo "</div>";


$page = $_GET['page'];
$fragmentLen = 5;
$pagination = pagination($posts = []);
$numPages = ceil(count($pagination) / $fragmentLen);
output($pagination, $page, $fragmentLen);
echo '<div class="container d-flex justify-content-center mt-3">';
echo "<ul class='pagination'>";
($page - 1) < 0
    ?
    $strElements = [$page, "Prev"]
    :
    $strElements = [$page - 1, "Prev"];
echo "<li class='page-item'><a class='page-link' href='?page=" . $strElements[0] . "'>" . $strElements[1] . "</a></li>";

for ($i = 0; $i < $numPages; $i++) {
    echo "<li class='page-item'><a class='page-link' href='?page=" . $i . "'>" . $i + 1 . "</a></li>";
}

($page + 1) > ($numPages - 1)
    ?
    $strElements = [$page, "Next"]
    :
    $strElements = [$page + 1, "Next"];

echo "<li class='page-item'><a class='page-link' href='?page=" . $strElements[0] . "'>" . $strElements[1] . "</a></li>";
echo "</ul>";
echo "</div>";

$categoriesList = getCategories();

include "footer.php";
