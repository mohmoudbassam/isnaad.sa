<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>


<?php

  $date1=date_create("2016-04-10");
$date2=date_create("2016-06-01");
$diff=date_diff($date1,$date2);
echo $diff->format("%R%a days");
?>

</body>
</html>