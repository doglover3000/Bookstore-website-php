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
$sql_std_get = "SELECT shops.shop_name, shops.adress, shops.shop_pic from shops";
$sort = $_GET['sort'];
$arr = ["shop_name", "adress", "shop_pic"];
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
<?php
$sth = $conn->query("SELECT * FROM shops");
$list = $sth->fetch_all(MYSQLI_ASSOC);
?>
<div id="map" style="width: 100%; height:500px"></div>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript">
ymaps.ready(init);
function init() {
var myMap = new ymaps.Map("map", {center: [<?php echo $list[0]['coords']; ?>], zoom: 16 },
{ searchControlProvider: 'yandex#search'});
var myCollection = new ymaps.GeoObjectCollection();
<?php foreach ($list as $row): ?>
var myPlacemark = new ymaps.Placemark([
<?php echo $row['coords']; ?>
], {
balloonContent: '<?php echo $row['shop_name']; ?>'
}, {
preset: 'islands#icon',
iconColor: '#0000ff'
});
myCollection.add(myPlacemark);
<?php endforeach; ?>
myMap.geoObjects.add(myCollection);
// Сделаем у карты автомасштаб чтобы были видны все метки.
myMap.setBounds(myCollection.getBounds(),{checkZoomRange:true, zoomMargin:9});
}
</script>
<div>
<table align='center'>
<?php
$result = $conn->query($sql_std_get);
if ($result) {
foreach ($result as $row) {
$cntr = 1;
echo "<tr>";
foreach ($arr as $column) {
$value = $row[$column];
if($cntr == 3)
echo "<td><img src='$value' width='500'></td>";
if ($cntr == 1)
echo "<tr align='center'><td><b>$value</b></td></tr>";
if ($cntr == 2)
echo "<tr align='center'><td>$value</td></tr>";
$cntr++;
echo "</tr>";
}
}
}?>
</table>
</div>
</body>
</html>
