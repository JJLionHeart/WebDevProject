<?php

    function connection_string() {
        extract(parse_url($_ENV["DATABASE_URL"]));
        return "user=$user password=$pass host=$host dbname=". substr($path, 1);
    }   
    
    $pg_conn = pg_connect(connection_string());

    $result = pg_query($pg_conn, "INSERT INTO Users(id, name) VALUES('aa', 'wea')");
    
    
?>
<html>
    <head>
        <title> Web project </title>
    </head>
    <body>
        <center><h1>Hello world!</h1></center>
    </body>
</html>
