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
    $sql = "SELECT * FROM gbooktable WHERE id BETWEEN " . $postsID[$count] . " AND " . $postsID[$count + 4] . " ORDER BY date DESC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $posts[$row["id"]] = $row;
    }
    // $numPages = ceil(count($posts) / $count);
    return $posts;
}

function out($count)
{
    global $conn;
    $arr_out = [];
    try {
        if (!$result = $conn->query("SELECT * FROM `gbooktable` ORDER BY date DESC")) {
            throw new Exception('Error selection from table  GBookTable: [' . $conn->error . ']');
        }
        while ($row = $result->fetch_assoc()) {
            $arr_out[] = $row;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return $arr_out;
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
