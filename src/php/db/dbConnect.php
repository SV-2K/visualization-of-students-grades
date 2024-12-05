<?php
$host = "localhost"; //Если ошибка, то ввести 127.0.0.1
$user = "root";
$password = "12345678";
$dbname = "monitoring";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password); #Подключение к БД
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage());
}
