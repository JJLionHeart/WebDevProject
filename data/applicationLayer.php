<?php
    header('Content-type: application/json');
    header('Accept: application/json');
    require_once __DIR__ . '/dataLayer.php';

    $action = $_POST["action"];

    switch($action) {
        CASE: "REGISTER" :
            registerFunction();
            break;
    }

    function registerFunction() {

    }

?>
