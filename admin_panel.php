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
    include "action.php";
    backToMainPage();
?>
    <div class="container-fluid d-flex justify-content-center mt-3">
        <h3>Добавить новость</h3>
    </div>
    <div class="container-fluid d-flex justify-content-center mt-3 input-group mb-3">
        <form name="myForm" action="action.php" method="post" onSubmit="return overify_message(this);">
            <input type=hidden name="action" value="add">
            <?php
            $categoriesList = getCategories();
            ?>
            <div>Категория новости:</div>
            <select class="form-control" style="width:100%" name="categories" place>
                <option class="form-control" disabled selected>Выберите категорию</option>
                <?php
                foreach ($categoriesList as $key1 => $key2) {
                    foreach ($key2 as $value) {
                ?>
                        <option class="form-control" value="<?= $value ?>"><?= $value ?></option>
                <?php
                    }
                }
                ?>
            </select>
            <div>Имя автора:</div>
            <input name="username" class="form-control" style="width: 300px;">
            <div>Название:</div>
            <input name="name" class="form-control" style="width: 300px;">
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

// $categoriesList = getCategories();
include "footer.php";
