<?php
$host = 'localhost';
$database = 'bs';
$username = 'root';
$password = 'root';
$conn = mysqli_connect($host,$username,$password,$database);
if(!$conn) die("Ошибка соединения с базой данных". mysqli_connect_error());
?>
