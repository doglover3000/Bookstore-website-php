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
<center>
<div class="container" style="width: 100%;">
<h3 align="center">Выберите дату для бронирования</h3>
<form action="" method="post" name="bron">
<table align=center>
<tr><td>Дата получения:</td><td><input type="date" name="dataIn" placeholder="дд.мм.гггг"><br></td></tr
<tr><td colspan="2"><center><br><input type="submit" name="ok" value="OK"></center></td></tr>
</table>
</form>
<?php
include "connect.php";
session_start();
if(isset($_POST['ok'])){
$_SESSION['dateIN'] = $_POST['dataIn'];
header('Location: selection.php');
}
?>
</div></center>
<br>
<br>
<br>
<br>
<br>
</body>
</html>
