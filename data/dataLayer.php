<?php
    function pg_connection_string(){
        extract(parse_url($_ENV["DATABASE_URL"]));
        return "user=$user password=$pass host=$host dbname=" . substr($path, 1);
    }

    $pg_conn = pg_connect(pg_connection_string());

    pg_query($pg_conn, "INSERT INTO wea(fome) VALUES('manco'");

?>
