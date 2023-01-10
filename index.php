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

$out = out(5);
$page_num = 1;
echo '<div class="container d-flex justify-content-center mt-3">';
if (count($out) > 0) {
    $func = pagination($posts = []);
    echo count($func);
    $counter_times = 0;
    foreach ($out as $row) {
        $counter_times++;

?>
        <div style="margin:10px; padding:5px;width:450px;background:f0f0f0;">
            <div style="color: #999999; border-bottom:1px solid #999999;padding:5px;">Опубликовал: <span style="color: #444;font-weight: bold;"><?php echo $row['username']; ?></span></div>
            <div style="background:#fafafa;padding:5px;"><?php echo $row['message']; ?></div>
            <div style="color: #999999; border-top:1px solid #999999;padding:5px;">Дата публикации: <?php echo $row['date']; ?>
            </div>
        </div>
<?php
    }
    if ($counter_times === 5) {
        echo "<form action=" . $_SERVER['PHP_SELF'] . " method='get'>
        <input type='submit' value='>' name='next' />
        <input type='hidden' value=" . $page_num . " name='page' />
        </form>";
    }
} else {
    echo "Пока что нет новостей...<br>";
}
echo "</div>";

if (isset($_GET['next'])) {
    $page_num = $_GET['page'];
    $page_num++;
}

include "footer.php";
