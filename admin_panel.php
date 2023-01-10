<?php
include_once "dbconnect.php";
ob_start();
session_start();
if (!$_SESSION['user_login']) {
    Header("Location: index.php");
    ob_end_flush();
} else {

    include "header.php";
    ob_end_flush();
?>
    <div class="container-fluid d-flex justify-content-center mt-3">
        <a class='btn btn-info' href="index.php">Просмотр сайта</a>
    </div>
    <div class="container-fluid d-flex justify-content-center mt-3">
        <h3>Добавить новость</h3>
    </div>
    <div class="container-fluid d-flex justify-content-center mt-3 input-group mb-3">
        <form name="myForm" action="action.php" method="post" onSubmit="return overify_message(this);">
            <input type=hidden name="action" value="add">
            <div>Имя автора:</div>
            <input name="username" class="form-control" style="width: 300px;">
            <div>Новость:</div>
            <textarea name="message" class="form-control" style="width: 300px;"></textarea><br>
            <div>
                <input type="submit" style="width:100%" class='btn btn-success' name="submitAdd" value="Опубликовать новость">
            </div>
        </form>
    </div>

<?php
}

if (isset($_SESSION['add']) && $_SESSION['add'] == true) {
    echo "Запис було додано успішно";
    $_SESSION['add'] = false;
}
include "footer.php";
