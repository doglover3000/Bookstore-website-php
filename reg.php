<!DOCTYPE html>
<html>
<?php
include 'funcitons.php';
session_start();
unset($_SESSION['mes']);
if(isset($_GET['exit']))
{
session_destroy();
header('Location: index.php');
}
else session_start();
?>
<head>
<meta charset="utf-8">
<meta name="keywords" content="HTML, CSS, PHP">
<link rel="stylesheet" href="style.css">
<title>Книжный мир</title>
</head>
<body>
<header>
<div class="container">
<table width="100%">
<tr>
<td width=20% align="right"><IMG src="logo.png" WIDTH=200 HEIGHT=120></td>
<td align="left">
<b style="font-family: Constantia; font-size: 40px;">Книжный мир</b>
</td>
<td>
<?php
if(isset($_SESSION['login'])){
echo "<a href=\"lk.php\".>Личный кабинет</a>";
echo "<br><br><form metod = \"get\"><input type=\"submit\" name=\"exit\" value=\"Выход\"></form>";
}
else
{
?>
<table>
<tr>
<td><a href="index_log.php">Авторизация</a></td>
</tr>
<tr>
<td><a href="reg.php">Регистрация</a></td>
</tr>
</table>
<?php
}
?>
</tr>
</table>
</div>
</header>
<div class="navigation">
<center><table style="text-align: center; width: 60%;">
<tr>
<td><a href="books.php">Книги</a></td>
<td><a href="shops.php">Магазины</a></td>
<?php
if(isset($_SESSION['login'])){
?>
<td><a href="order.php">Бронировать</a></td>
<?php }
?>
<td><a href="contact.php">Контакты</a></td>
<td><a href="index.php">На главную</a></td>
</tr>
</center>
</table>
</div>
<br>
<br>
<div class="container" style="width: 100%;">
<h2 align="center">Форма регистрации</h2>
<form action="" method="post" name="register">
<table align=center>
<tr><td>Имя:</td><td><input type="text" name="name"><br></td></tr>
<tr><td>Контактный номер:</td><td><input type="text" name="phone"><br></td></tr>
<tr><td>Логин:</td><td><input type="text" name="login"><br>
<span id="valid_pass_message" class="mesage_error"></span></td></tr>
<tr><td>Пароль:</td><td><input type="password" name="pass" ><br>
<span id="valid_pass_message" class="mesage_error"></span></td></tr>
<tr><td colspan="2"><center><br><input type="submit" name="registration" value="Зарегистрироватся"></center></td></tr>
</table>
</form>
<?php
if (isset($_POST['registration']))
{
$n = clear($_POST['name']);
$l = clear($_POST['login']);
$p = clear($_POST['pass']);
$ph = clear($_POST['phone']);
if(!checkSize($_POST['name'], 2, 20))
echo "<center><i>Имя некорректно</i></center>";
elseif(!checkSize($_POST['login'],5,30))
echo "<center><i>Логин должен иметь длинну не больше 30 и не меньше 5 символов</i></center>";
elseif(!checkSize($_POST['pass'],5,15))
echo "<center><i>Пароль должен иметь длинну не больше 15 и не меньше 5 символов</i></center>";
else
{
include "connect.php" ;
$dat = strtotime('today');
$insert = "INSERT INTO customers (customer_name,login, password, phone) VALUES ('$n', '$l', '$p', '$ph')";
$insert = mysqli_query($conn, $insert) or die("Ошибка добавления данных " . mysqli_error($conn));
echo "<br><center>Успешная регистрация</center>";
header('Refresh: 3; URL = index.php');
}
}
?>
</div>
<br>
<br>
<br>
<br>
<br>
</body>
</html>
