<!DOCTYPE html>
<html>
<?php
include 'funcitons.php';
session_start();
if(isset($_GET['exit'])){
session_destroy();
header('Location: index.php');
exit;
}
else session_start();
if(!isset($_SESSION['id']))
header("Location: auth.php");
?>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<meta name="keywords" content="HTML, CSS, PHP">
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
<td><a href="auth.php">Авторизация</a></td>
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
<form method="post">
<input type='submit' value='Мои данные' name='ok'>
<input type='submit' value='Редактировать данные' name='red'>
<input type='submit' value='Мои бронирования' name='ord'>
</form>
<?php
include "connect.php";
$quer = "SELECT * FROM customers WHERE customer_id = ".$_SESSION['id'];
$sql = mysqli_query($conn,$quer)or die("Ошибка запроса поиска" . mysqli_error($conn));
$user = mysqli_fetch_array($sql);
if (isset($_POST['ok']))
{
echo "<div style='text-align: left; margin-left:650px;'><br><b>Ваше имя:</b> ".$user['customer_name']."<br>";
echo "<b>Ваш контактный номер</b>: ".$user['phone']."<br>";
echo "<b>Ваш логин</b>: ".$user['login']."<br>";
echo "<b>Ваш пароль</b>: ".$user['password']."<br></div>";
}
elseif (isset($_POST['red']))
{
echo"
<form method='post' name='form_red'>
<table>
<tbody>
<br><tr>
<td> Имя: </td>
<td><input type='text' name='nameU' value='".$user['name']."' required='required'></td>
</tr>
<tr>
<td> Номер телефона: </td>
<td><input type='text' name='phone' value='".$user['phone']."' required='required'></td>
</tr>
<tr> <td> Логин: </td>
<td><input type='text' name='login' value='".$user['login']."' required='required'><br></td>
</tr>
<tr>
<td> Пароль: </td>
<td> <input type='password' name='parol' value='".$user['password']."' required='required'><br>
<span id='valid_parol_message' class='mesage_error'></span>
</td>
</tr>
<tr>
<td colspan='2'>
<input type='submit' name='ch' value='Изменить'>
</td>
</tr> </table> </form>
";
}
if(isset($_POST['ch'])) {
$newid = $_SESSION['id'];
$qu=mysqli_query($conn,"UPDATE customers
SET customer_name='$_POST[nameU]',
phone='$_POST[phone]',
login='$_POST[login]',
password='$_POST[parol]'
WHERE customer_id='$newid'");
if($qu)
{
echo "<br> Данные успешно изменены!";
echo"</form>";
}
else echo "Ошибка - ".mysqli_error($conn);
}
if (isset($_POST['ord'])){
include "connect.php";
$quer = "SELECT COUNT(*) FROM customers WHERE customer_id = ".$_SESSION['id'] ;
$result = mysqli_query($conn,$quer)or die("Ошибка запроса 1" . mysqli_error($conn));
$row = mysqli_fetch_row($result);
echo "<form metod = \"GET\">";
if($row[0] > 0)
{
$s_id = $_SESSION['id'];
$quer = "SELECT reservations.reservation_date, books.book_name, books.author, books.price, reservations.reservation_id
from books, orders, customers, reservations
WHERE books.book_id = orders.book_id AND
orders.reservation_id = reservations.reservation_id and
reservations.customer_id = customers.customer_id and customers.customer_id = '$s_id'and reservations.visible = '1' order by reservations.reservation_date";
$arr = ["reservation_date", "reservation_id", "book_name", "author", "price"];
$result = mysqli_query($conn,$quer)or die("Ошибка запроса 1 " . mysqli_error($conn));
if ($result->num_rows > 0)
{
echo "<br><b>Ваши бронирования</b>";
echo "<table align='center' border='1' bordercolor='#4C3830'>";
$current = NULL;
$sum = 0;
$tmp = 0;
foreach ($result as $row) {
$cntr = 0;
foreach ($arr as $column) {
$cntr++;
$value = $row[$column];
if ($cntr == 1){
$dt = date("d.m.Y", strtotime($value));
if ($dt != $tmp)
{
echo "<tr align='center' style = 'background-color: #4C3830; color: #fff'><td colspan='3'>$dt</td>";
$tmp = $dt;
$ch = 1;
} else $ch = 0;
} elseif ($cntr == 2) {
if ($ch == 1)
echo "<td><input type='checkbox' name='f[]' value = '$value'></td></tr><tr>";
} elseif ($cntr == 5) {
echo "<td>$value руб.</td>";
$sum += $value;
} else {echo "<td>$value</td>";}
}
echo "</tr>";
}
echo "</table>";
echo "<div style='text-align: left; margin-left:820px'><b>Сумма заказов</b>: <i>$sum</i></div>";
echo "<div><center><input type= 'submit' name='remove' value='Удалить заказ'></center>";
if(!empty($_GET['remove']))
{
if(!empty($_GET['f']))
{
$_SESSION['rm_books'] = $_GET['f'];
foreach ($_SESSION['rm_books'] as $i => $ir) {
$qu=mysqli_query($conn,"UPDATE reservations SET visible='0' WHERE reservation_id='$ir'");
}
} else echo "<b>Ничего не выбрано :(</b>";
}
} else echo "<br><b>У вас нет заказов</b>";
} else echo "<br><b>У вас нет заказов</b>";
}
?>
</td>
</table>
</div>
</center>
<br>
</body>
</html>
