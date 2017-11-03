<?php
    function connect_pg(){
        extract(parse_url($_ENV["DATABASE_URL"]));
        $pg_string =  "user=$user password=$pass host=$host dbname=" . substr($path, 1);
        $pg_conn = pg_connect($pg_string);

    }

?>
