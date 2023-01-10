<?php
include_once "dbconnect.php";
if (!isset($_SESSION)) {
    session_start();
}

function pagination($posts, $count)
{
    global $conn;
    $postsID = [];
    $i = 0;
    $sql = "SELECT * FROM `gbooktable` ORDER BY date ASC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $postsID[$i] = $row["id"];
        $i++;
    }
    print_r($postsID);
    $sql = "SELECT * FROM gbooktable WHERE id BETWEEN " . $postsID[$count] . " AND " . $postsID[$count + 4] . " ORDER BY date DESC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $posts[$row["id"]] = $row;
    }
    // $numPages = ceil(count($posts) / $count);
    return [$posts, $count + 4];
}

function output($count) {
    [$posts, $count] = pagination($posts = [], $count);
    
    echo '<div class="container d-flex justify-content-center mt-3">';
if (count($posts) > 0) {
    $page_num = 1;
    $counter_times = 0;
    foreach ($posts as $row) {
        $counter_times++;

?>
        <div style="margin:10px; padding:5px;width:450px;background:f0f0f0;">
            <div style="color: #999999; border-bottom:1px solid #999999;padding:5px;">Опубликовал: <span style="color: #444;font-weight: bold;"><?php echo $row['username']; ?></span></div>
            <div style="background:#fafafa;padding:5px;"><?php echo $row['message']; ?></div>
            <div style="color: #999999; border-top:1px solid #999999;padding:5px;">Дата публикации: <?php echo $row['date']; ?>
            </div>
        </div>
<?php
        // if ($counter_times === count($func)) {
        //     break;
        // }
        if ($counter_times === 5) {
            echo "<form action=" . $_SERVER['PHP_SELF'] . " method='get'>
                <input type='submit' value='>' name='next' />
                <input type='hidden' value=" . $page_num . " name='page' />
            </form>";
            // $func = pagination($posts = [], 5);
        }
    }
} else {
    echo "Пока что нет новостей...<br>";
}
echo "</div>";
    return $count;
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
