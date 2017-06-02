<?php
/*
*	Скрипт только забивает пустую базу данными из файла OUI
*	Надо дописать обновление существующей базы, добавить
*	wget http://standards-oui.ieee.org/oui.txt
*	и запустить в крон
*/
include './config.php';
//что парсить
$files = "oui.txt";
//переделываем в массив строк
$array_string=file("$files");
//считаем количество строк
$file_count = count($array_string);
for ($a = 0; $a < $file_count; $a++) {
    $country_flag = 0;
    $string = $array_string[$a];
    if (preg_match("([0-9a-fA-F]{2}([:-]|$)[0-9a-fA-F]{2}([:-]|$))", $string))
    {
        //$string = str_replace("(hex)", "|", $string);
        $mac = substr($string, 0, 8);
        $vowels = ["-", ":", ".", ",", "'"];
        $mac = str_replace($vowels, "", $mac);
        //убираем пробелы до и после
        $mac = trim($mac);
        
        $vendor = substr($string, 16);
        $vendor = trim($vendor);
        //echo $mac . "<br>";
        //echo $vendor . "<br>";
        
    } elseif (preg_match("(\t\t\t\t[A-Z]{2}\r\n)", $string)) {
        $country = trim($string);
        //echo $string . "<br><br>";
        $country_flag = 1;
    }
    if ($vendor_flag==1 || $country_flag == 1){
        //echo $country_flag;
        mysql_query("INSERT INTO mac (mac, vendor, country) VALUES ('$mac', '$vendor', '$country');") or die("DIE");
    }
}