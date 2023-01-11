<?php
include_once "dbconnect.php";
if (!isset($_SESSION)) {
    session_start();
}

function check_autorize($log, $pas)
{
    global $conn;
    $sql = "SELECT log FROM Users WHERE log = '" . $log . "' AND pas='" . $pas . "';";

    if ($result = $conn->query($sql)) {
        $n = $result->num_rows;
        if ($n != 0) {
            $_SESSION['user_login'] = $log;
            return true;
        } else {
            return false;
        }
    }
}

function check_log($log)
{
    global $conn;
    try {
        $sql = "SELECT log FROM Users WHERE log = '" . $log . "'";
        $result = $conn->query($sql);
        $n = $result->num_rows;
        if ($n != 0) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function registration($log, $pas)
{
    global $conn;
    $sql = "INSERT INTO Users (log, pas) VALUES (" . "'" . $log . "', " . "'" . $pas . "')";
    if (!$conn->query($sql)) {
        return false;
    } else {
        $_SESSION['user_login'] = $log;
        return true;
    }
}

function add()
{
    global $conn;

    $username = $_REQUEST['username'];
    $message = $_REQUEST['message'];

    try {
        if (!$conn->query("INSERT INTO GBookTable(username, date, message) VALUES ('$username', NOW(), '$message')")) {
            throw new Exception('Помилка заповнення  таблиці GBookTable: [' . $conn->error . ']');
        }

        $_SESSION['add'] = true;
        header("Location: admin_panel.php");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function logout()
{
    unset($_SESSION['user_login']);
    session_unset();
    header("Location: index.php");
}

if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
    switch ($action) {
        case 'add':
            add();
            break;
        case 'logout':
            logout();
            break;
        default:
            header("Location: index.php");
    }
}

function pagination($posts)
{
    global $conn;
    $postsID = [];
    $i = 0;
    $sql = "SELECT * FROM `gbooktable` ORDER BY date DESC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $posts[$i] = $row;
        $i++;
    }
    return $posts;
}

function output($pagination, $page, $fragmentLen)
{
    echo '<div class="container d-flex justify-content-center mt-3">';
    // $func = pagination($posts);
    if (count($pagination) > 0) {
        // foreach ($func as $row) {
        for ($i = $page * $fragmentLen; $i < ($page + 1) * $fragmentLen; $i++) {
            if (isset($pagination[$i])) {
?>
                <div style="margin:10px; padding:5px;width:450px;background:f0f0f0;">
                    <div style="color: #999999; border-bottom:1px solid #999999;padding:5px;">Опубликовал: <span style="color: #444;font-weight: bold;"><?php echo $pagination[$i]['username']; ?></span></div>
                    <div style="background:#fafafa;padding:5px;"><?php echo $pagination[$i]['message']; ?></div>
                    <div style="color: #999999; border-top:1px solid #999999;padding:5px;">Дата публикации: <?php echo $pagination[$i]['date']; ?>
                    </div>
                </div>
<?php
            } else {
                break;
            }
        }
    } else {
        echo "Пока что нет новостей...<br>";
    }
    echo "</div>";
    return $pagination;
}
