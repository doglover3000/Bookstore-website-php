<!DOCTYPE html>
<html>
<?php
include 'funcitons.php';
include 'counter/counter.php';
session_start();
unset($_SESSION['mes']);
if(isset($_GET['exit']))
{
session_destroy();
header('Location: index.php');
}
else session_start();
if (isset($_POST['send']))
mail('info@gmail.com', 'Письмо', $_POST["sendComm"], 'From: '.$_POST["email"].'');
?>
<head>
<meta charset="utf-8">
<meta name="keywords" content="HTML, CSS, PHP">
<link rel="stylesheet" href="style.css">
<title>База отдыха</title>
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
<table width=60% align=center>
<tr>
<td align=center>
<h3>Email</h3>book-world-info@mail.ru
<h3>Телефон</h3>Отдел бронирования<br> +7 999 505 10 40
<br>
</td>
<td align=center>
<h3>Напишите нам</h3>
<form method="POST">
Email <input type="email" name="email" required="required">
<span id="valid_email_message" class="mesage_error"></span>
<br>
<br>
Сообщение<br> <textarea class='contacts__textarea' name="sendComm" cols="35" rows="7"></textarea>
<br><input type="submit" name="send" value="Отправить">
</form>
</td>
</tr>
</table>
</div>
<br>
<br>
<br>
<br>
<br>
</body>
</html>
