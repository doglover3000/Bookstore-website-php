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
$arr = ["book_pic", "book_name", "author", "article", "price", "recieve_date", "section_name", "shop_name"];
$arr_m = ["book_pic", "book_name", "author", "article", "price", "recieve_date", "section_name"];
$shops_d = $conn->query($sql_shops);
$sections_d = $conn->query($sql_sections);
$sql_shop_sort = "SELECT books.book_name, books.author, books.article,
books.price, books.recieve_date, books.book_pic, sections.section_name
FROM books, sections, shops
WHERE books.section_id=sections.section_id
and sections.shop_id = shops.shop_id
and shops.shop_name = '$sh'";
$sql_section_sort = "SELECT books.book_name, books.author, books.article,
books.price, books.recieve_date, books.book_pic
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
<td><a href="contact.php" >Контакты</a></td>
<td><a href="index.php" >На главную</a></td>
</tr>
</center>
</table>
</div>
<br>
<div class=sorting align='center'>
<table>
<form action="" method="get">
<div class='radio_b'>
<tr><td>
<input type="radio" name="sort" checked <?php if ($sort == "0") echo "checked" ?> id="0" value="0">
<label for="0">По названию</label>
</td></tr>
</div>
<div class='radio_b'>
<tr><td>
<input type="radio" name="sort" <?php if ($sort == "1") echo "checked" ?> id="1" value="1">
<label for="1">По автору</label>
</td></tr>
</div>
<div>
<tr><td>
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
<tr><td><input type="submit" value="Отсортировать"></td></tr>
</div>
</div>
</table>
</form>
<br>
<div>
<table align='center' border="1" bordercolor="#4C3830" style="border-collapse: collapse">
<tr style = "background-color: #4C3830; color: #fff" >
<th>Обложка</th>
<th>Название</th>
<th>Автор</th>
<th>Артикуль</th>
<th>Цена, руб</th>
<th>Дата поступления</th>
<?php if (empty($sh)) { echo "<th>Секция</th><th>Магазин</th>";
} else if (empty($s)) echo "<th>Секция</th>"?>
</tr>
<?php if (empty($sh)) {
$result = $conn->query($sort == 1 ? $sql_std_get . " ORDER BY books.author" : $sql_std_get . " ORDER BY books.book_name");
if ($result) {
foreach ($result as $row) {
echo "<tr align = 'center'>";
$cntr = 0;
foreach ($arr as $column) {
$cntr++;
$value = $row[$column];
if ($cntr == 1){
echo "<td><img src='$value' width='100'></td>";
}elseif ($cntr == 6){
$newdate = date('d-m-y', strtotime($row[$column]));
echo "<td>$newdate</td>";
}else {echo "<td>$value</td>";}
}
echo "</tr>";
echo $conn->error;
}
}
} else if (!empty($s)){
$result = $conn->query($sort == 1 ? $sql_section_sort . " ORDER BY books.author" : $sql_section_sort . " ORDER BY books.book_name");
if ($result) {
foreach ($result as $row) {
$cntr = 0;
echo "<tr align = 'center'>";
foreach ($arr_m as $column) {
$cntr++;
$value = $row[$column];
if ($cntr == 1){
echo "<td><img src='$value' width='100'></td>";
}elseif ($cntr == 6){
$newdate = date('d-m-y', strtotime($row[$column]));
echo "<td>$newdate</td>";
}else {echo "<td>$value</td>";}
}
echo "</tr>";
}
}
}else{
$result = $conn->query($sort == 1 ? $sql_shop_sort . " ORDER BY books.author" : $sql_shop_sort . " ORDER BY books.book_name");
if ($result) {
foreach ($result as $row) {
$cntr = 0;
echo "<tr align = 'center'>";
foreach ($arr_m as $column) {
$cntr++;
$value = $row[$column];
if ($cntr == 1){
echo "<td><img src='$value' width='100'></td>";
}elseif ($cntr == 6){
$newdate = date('d-m-y', strtotime($row[$column]));
echo "<td>$newdate</td>";
}else {echo "<td>$value</td>";}
}
echo "</tr>";
}
}
} ?>
</table>
</div>
</body>
</html>
