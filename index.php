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
<tr align="right">
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
<div style="width: 100%;">
<br>
<br>
<table width=90% align="center">
<tr><center><b style="font-size: 28px;">Добро пожаловать на сайт сети книжных магазинов "Книжный мир"!</b></center></tr>
<tr>
<br><td width=60%>
У нас есть что читать, чем творить, что дарить и где выбирать
Мы предлагаем большой выбор книг, поддерживая длительные и дружелюбные партнёрские отношения с большинством издательств, работающих на российском книжном
рынке. Мы любим книги и ценим любовь к книгам наших покупателей, поэтому стараемся сделать всё возможное, чтобы каждая книга нашла своего читателя.<br><br>
Сложно представить настоящий книжный магазин без симпатичной канцелярии, которая так необходима дома, в учёбе и на работе, без забавных мелочей, которые будут радовать глаз, украшая книжный стол, книжную полку или целый книжный шкаф. Сложно представить книжный магазин без памятных сувениров, которые порадуют как гостей города, так и его жителей. И не нужно представлять! В наших магазинах вы найдете не только книги, но и все эти необходимые товары
</td>
<td width=20% align="right"><IMG src='https://kuda-kazan.ru/uploads/ab89fda3d2e8eab3f8b7fd37fd6d98b3.jpg' WIDTH=300></td>
</tr>
</table>
</div>
</body>
</html>
