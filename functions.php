<?php
function clear($string)
{
$string = trim($string); // для удаления пробелов из начала и конца строки
$string = stripslashes($string); // для удаления экранированных символов
$string = strip_tags($string); // для удаления HTML и PHP тегов
$string = htmlspecialchars($string); // преобразует специальные символы в HTML-сущности
return $string;
}
function checkSize($string,$min,$max) //для проверки длинны строки
{
$result = (mb_strlen($string) > $min && mb_strlen($string) <= $max);
return $result;
}
