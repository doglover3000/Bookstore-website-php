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
<form action="" method="post" name="register">
<?php
echo $_SESSION['mes'];
?>
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
<tr><td>Логин:</td><td><input type="text" name="login"><br>
<span id="valid_login_message" class="mesage_error"></span></td></tr>
<tr><td>Пароль:</td><td><input type="password" name="pass"><br>
<span id="valid_pass_message" class="mesage_error"></span></td></tr>
<tr><td colspan="2"><center><input type="submit" name="authorization" value="Авторизация"></center></td></tr>
<?php
if (isset($_POST['authorization']))
{
include "connect.php";
session_start();
$login = $_POST['login'];
$pass = $_POST['pass'];
$login = mysqli_real_escape_string($conn,$login);
$pass = mysqli_real_escape_string($conn,$pass);
clear($login);
clear($pass);
$quer = "SELECT COUNT(*) FROM `customers` WHERE `login` = '$login'";
$ch = mysqli_query($conn,$quer)or die("Ошибка авторизации" . mysqli_error($conn));
$row = mysqli_fetch_row($ch);
if($row[0] > 0)
{
$quer = "SELECT * FROM `customers` WHERE `login` = '$login'";
$user = mysqli_query($conn,$quer) or die("Ошибка авторизации" . mysqli_error($conn));
$users = mysqli_fetch_assoc($user);
if(($users['password'] == clear($pass)))
{
$_SESSION['login'] = $login;
$_SESSION['pass'] = $pass;
$_SESSION['id'] = $users['customer_id'];
unset($_SESSION['mes']);
header('Refresh: 0.1; URL = index.php');
}
else
{
$_SESSION['mes'] = 'Был введен неверный пароль';
header('Refresh: 0.1; URL = auth.php');
}
} else
{
$_SESSION['mes'] = 'Пользователь не найден';
header('Refresh: 0.1; URL = auth.php');
}
}
?>
</table>
<?php
}
?>
</td></tr>
</table>
</form>
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
<div style="width: 100%;">
<br>
<br>
<table width=90% align="center">
<tr><center><b style="font-size: 28px;">Добро пожаловать на сайт сети книжных магазинов "Книжный мир"!</b></center></tr>
<tr>
<br><td width=60%>
У нас есть что читать, чем творить, что дарить и где выбирать
Мы предлагаем большой выбор книг, поддерживая длительные и дружелюбные партнёрские отношения с большинством издательств, работающих на российском книжном рынке. Мы любим книги и ценим любовь к книгам наших покупателей, поэтому стараемся сделать всё возможное, чтобы каждая книга нашла своего читателя.<br><br>
Сложно представить настоящий книжный магазин без симпатичной канцелярии, которая так необходима дома, в учёбе и на работе, без забавных мелочей, которые будут радовать глаз, украшая книжный стол, книжную полку или целый книжный шкаф. Сложно представить книжный магазин без памятных сувениров, которые порадуют как гостей города, так и его жителей. И не нужно представлять! В наших магазинах вы найдете не только книги, но и все эти необходимые товары
</td>
<td width=20% align="right"><IMG src='https://kuda-kazan.ru/uploads/ab89fda3d2e8eab3f8b7fd37fd6d98b3.jpg' WIDTH=300></td>
</tr>
</table>
</div>
</body>
</html>
