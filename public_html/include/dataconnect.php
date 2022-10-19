<?php
error_reporting (E_ALL ^ E_DEPRECATED);
$link=mysqli_connect("localhost","uwnbpe6ahxm46","xa9p47c3ayf5","dbdzkjrg9dfqkn");

//$link=mysql_connect("localhost","root","");
//$db=mysql_select_db("isnaad",$link);
$link->query("SET NAMES 'utf8'");
$link->query("SET CHARACTER SET utf8");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8'); 
header("Pragma: no-cache");
?>