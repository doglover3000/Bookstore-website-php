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
echo "<br><a href=\"sh_card.php\".>Корзина</a>";
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
<center>
<div class="container" style="width: 100%;">
<br><h3><center>Бронирование </h3>
<?php
include "connect.php";
$dt = date("d.m.Y", strtotime($_SESSION['dateIN']));
if(!empty($_SESSION['books_ordr']))
{
$sum = 0;
echo "<table><center><tr><th>Дата получения</th><th>Название</th><th>Автор</th><th>Цена</th></tr>";
foreach ($_SESSION['books_ordr'] as $key => $value)
{
$select = "SELECT * FROM `books` WHERE `book_id` = ".$value."";
$sel = mysqli_query($conn,$select) or die("Ошибка запроса". mysqli_error($conn));
$s = mysqli_fetch_assoc($sel);
echo "<tr><td>$dt</td>
<td allign=center>".$s['book_name']."</td>
<td allign=center>".$s['author']."</td>
<td allign=center>".$s['price']." руб.</td></tr>";
$sum+=$s['price'];
}
echo "</center></table>";
echo "<br><b>Сумма: ".$sum." руб.</b>";
?>
<br><br>
<form method="POST"><input type="submit" name="z" value="Оформить"><br><br>
<input type="submit" name="x" value="Закрыть">
</form>
<?php
}
else
{
echo "Корзина пуста";
}
if(isset($_POST['x'])){
unset($_SESSION['books_ordr']);
header('Location: index.php');
}
if(isset($_POST['z']))
{
include "connect.php";
$insert = "INSERT INTO reservations (customer_id, reservation_date, total_price) VALUES
('".$_SESSION['id']."', '".$_SESSION['dateIN']."', '".$sum."')";
$insert = mysqli_query($conn, $insert) or die("Ошибка добавления данных " . mysqli_error($conn));
$select = "SELECT * FROM `reservations` ORDER BY `reservation_id` DESC LIMIT 1";
$sel = mysqli_query($conn,$select) or die("Ошибка запроса". mysqli_error($conn));
$s = mysqli_fetch_assoc($sel);
foreach ($_SESSION['books_ordr'] as $i => $idR){
$insert = "INSERT INTO `orders` (`reservation_id`, `book_id`) VALUES
('".$s['reservation_id']."','".$idR."')";
$insert = mysqli_query($conn, $insert) or die("Ошибка добавления данных " . mysqli_error($conn));
}
echo "<br>Успешно оформлено! <b>Номер бронирования: '".$s['reservation_id']."' </b>";
unset($_SESSION['books_ordr']);
//header('Location: lk.php');
}
?>
<br>
<br>
</div>
<br>
<br>
<br>
<br>
<br>
</body>
</html>
