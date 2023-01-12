<?php
include_once "dbconnect.php";

try {
    $conn->query("SET NAMES utf8mb4");
    $conn->query("SET CHARACTER SET utf8mb4");
    if (!$conn->query("CREATE TABLE IF NOT EXISTS News (id INT NOT NULL AUTO_INCREMENT, username VARCHAR (100), date DATETIME, message TEXT, PRIMARY KEY (id))")) {
        throw new Exception('Error creation table News: [' . $conn->error . ']');
    }

    if (!$conn->query("CREATE TABLE  IF NOT EXISTS Users (user_id INT NOT NULL AUTO_INCREMENT, log VARCHAR(255), pas  VARCHAR(255), PRIMARY KEY (user_id))")) {
        throw new Exception('Error creation table  Users: [' . $conn->error . ']');
    }

    if (!$conn->query("INSERT INTO Users (log, pas) VALUES ('pit', '123')")) {
        throw new Exception('Error creation table  Users: [' . $conn->error . ']');
    }
    // INSERT INTO `gbooktable` (`id`, `username`, `date`, `message`) VALUES (NULL, 'admin', NULL, 'Hello');
    echo " Users and News tables created successfully";
    $conn->close();

} catch (Exception $e) {
    echo $e->getMessage();
}