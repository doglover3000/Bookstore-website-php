<!DOCTYPE html>
<html>
<?php
include 'funcitons.php';
include 'connect.php';
session_start();
unset($_SESSION['mes']);
if(isset($_GET['exit']))
{
session_destroy();
header('Location: index.php');
}
else session_start();
?>
<?php
$sql_std_get = "SELECT books.book_id, books.book_name, books.author, books.article, books.price,
books.recieve_date, books.book_pic, sections.section_name, shops.shop_name
FROM books, shops, sections
WHERE books.section_id=sections.section_id
AND sections.shop_id=shops.shop_id";
$sql_shops = "SELECT DISTINCT shops.shop_name FROM shops";
$sql_sections = "SELECT DISTINCT sections.section_name FROM sections";
$sort = $_GET['sort'];
$sh = $_GET['shop'];
$s = $_GET['section'];
$shops_d = $conn->query($sql_shops);
$sections_d = $conn->query($sql_sections);
$sql_shop_sort = "SELECT books.book_name, books.author, books.article,
books.price, books.recieve_date, books.book_pic, sections.section_name, books.book_id
FROM books, sections, shops
WHERE books.section_id=sections.section_id
and sections.shop_id = shops.shop_id
and shops.shop_name = '$sh'";
$sql_section_sort = "SELECT books.book_name, books.author, books.article,
books.price, books.recieve_date, books.book_pic, books.book_id
FROM books, sections, shops
WHERE books.section_id=sections.section_id
and sections.shop_id = shops.shop_id
and sections.section_name = '$s'";
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
<div class=sorting align='center'>
<h2><center>Выберите книги для заказа</center></h2>
<table>
<form action="" method="get">
<div class='radio_b'>
<tr><td align="center">
<input type="radio" name="sort" checked <?php if ($sort == "0") echo "checked" ?> id="0" value="0">
<label for="0">По названию</label>
</td></tr>
</div>
<div class='radio_b'>
<tr><td align="center">
<input type="radio" name="sort" <?php if ($sort == "1") echo "checked" ?> id="1" value="1">
<label for="1">По автору</label>
</td></tr>
</div>
<div>
<tr><td align="center">
<label for="shops">Магазин</label>
<select name="shop" id="">
<?php
echo "<option value=0>---</option>";
foreach ($shops_d as $row) {
$value = $row['shop_name'];
if ($_GET['shop'] == $value) {
echo "<option value=$value selected>$value</option>";
} else {
echo "<option value=$value>$value</option>";
}
} ?>
</select>
</td></tr>
<?php
$sections_d = $conn->query("SELECT DISTINCT sections.section_name FROM sections, shops WHERE sections.shop_id = shops.shop_id and shops.shop_name = '$sh'");
if (!empty($sh)){
echo "<tr><td><label for='sections'>Секции</label>
<select name='section' id=''>
<option value=0>---</option>";
foreach ($sections_d as $row) {
$value = $row['section_name'];
if ($_GET['section'] == $value) {echo "<option value=$value selected>$value</option>";
} else {echo "<option value=$value>$value</option>";}
}
echo "</select></td></tr>";
}?>
</div>
<div>
<tr><td><input type="submit" name = "srt" value="Отсортировать">
<input type="submit" name = "clr" value="Сбросить фильтр"></td></tr>
<?php
if ($sort == 1)
$quer = $sql_std_get . " ORDER BY books.author";
else
$quer = $sql_std_get . " ORDER BY books.book_name";
if (isset($_GET['clr']))
{
if ($sort == 1)
$quer = $sql_std_get . " ORDER BY books.author";
else
$quer = $sql_std_get . " ORDER BY books.book_name";
header('Location: selection.php');
}
if (isset($_GET['srt']))
{
if (!empty($sh) && $sort == 1)
$quer = $sql_shop_sort . " ORDER BY books.author";
if (!empty($sh) && $sort == 0)
$quer = $sql_shop_sort . " ORDER BY books.book_name";
if (!empty($s) && $sort == 1)
$quer = $sql_section_sort . " ORDER BY books.author";
if (!empty($s) && $sort == 0)
$quer = $sql_section_sort . " ORDER BY books.book_name";
}
?>
</div>
</div>
</form>
<div>
<center>
<form method = 'GET'>
<table align='center'>
<tr align="center" style = "background-color: #4C3830; color: #fff">
<td><b>Обложка</td><td><b>Название</td><td><b>Автор</td><td><b>Цена</td><td><b>Дата поступления</td></tr>
<?php
$result = $conn->query($quer);
while ($r = mysqli_fetch_assoc($result))
{
$newd = date('d-m-y', strtotime($r['recieve_date']));
echo "<tr align = 'center'><td><img src=".$r['book_pic']." width='80'></td>
<td>".$r['book_name']."</td>
<td>".$r['author']."</td>
<td>".$r['price']." руб.</td>
<td>$newd</td>
<td><input type='checkbox' name='f[]' value = \"".$r['book_id']."\"></td>
</tr>";
}
?>
</div>
<div><center><input type= "submit" name="add" value="Добавить"></center>
</center><br>
<?php
if(!empty($_GET['add']))
{
if(!empty($_GET['f']))
{
if(isset($_SESSION['id']))
{
$_SESSION['books_ordr'] = $_GET['f'];
echo "<br>Добавлено";
}
}
else echo "<b>Ничего не выбрано :(</b>";
}
?>
</form></div>
</body>
</html>
