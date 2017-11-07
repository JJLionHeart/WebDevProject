<?php
header('Content-type: application/json');
header('Accept: application/json');
require_once __DIR__ . '/dataLayer.php';

$action = $_POST["action"];

switch($action)
{
case "LOGIN" : loginFunction();
    break;	
case "REGISTER" : registrationFunction();
    break;
case "LOGOUT" :
    logoutFunction();
    break;
case "GETTASKS" :
    getTasksFunction();
    break;
/*        case "GETCOMMENTS":
                getCommentsFunction();
                break;
        case "SEARCH":
                searchFunction();
                break;
        case "PROFILE":
                profileFunction();
                break;
        case "GETFRIENDREQUESTS":
                getFriendRequests();
                break;
        case "NUMBERFRIENDREQS":
                gettNumberFriendRequests();
                break;
        case "FRIENDREQUEST":
                friendRequest();
                break;
        case "ACCEPT":
                delete_request(true);
                break;
        case "REJECT":
                delete_request(false);
                break;
        case "GETFRIENDLIST":
                getFriendList();
break;*/
}

function loginFunction()
{
    $uName = $_POST["uName"];
    $uPassword = $_POST["uPassword"];

        /*
        $remember = $_POST["souviens"];

        if($remember == "true") {
            setcookie('remember', $uName, time()+2592000, '/'); 
        } else {
            setcookie('remember', '', time()-10, '/');
        }
         */

    $loginResponse = attemptLogin($uName, $uPassword);

    if ($loginResponse["MESSAGE"] == "SUCCESS")
    {
        $response = array("result" => "OK");

        session_start();
        $_SESSION['Username'] = $uName;
        echo json_encode($response);
    }
    else {
        genericErrorFunction($loginResponse["MESSAGE"]);
    }
}

function genericErrorFunction($errorCode)
{
    switch($errorCode)
    {
    case "500" : header("HTTP/1.1 500 Bad connection, portal down");
    die("The server is down, we couldn't stablish the data base connection.");
    break;
    case "406" : header("HTTP/1.1 406 User not found.");
    die("Wrong credentials provided.");
    break;
    case "409" : header("HTTP/1.1 409 User already in use");
    die("User already in use");
    break;
    case "407":
        header("HTTP/1.1 407 Cannot insert into database");
        die("Cannot insert into the database");
        break;

    }
}

function registrationFunction() {
    $uName = $_POST["userName"];
    $uPassword = $_POST["password"];
    $firstName = $_POST["fName"];
    $lastName = $_POST["lName"];
    $email = $_POST["email"];

    $register_response = attemptRegister($uName, $uPassword,
        $firstName, $lastName,
        $email);
    if ($register_response["MESSAGE"] == "SUCCESS") {
        $response = array("RESULT" => "OK");

        session_start();
        $_SESSION['Username'] = $uName;
        echo json_encode($response);
    } else {
        genericErrorFunction($register_response["MESSAGE"]);
    }
}

function logoutFunction() {
    session_start();
    session_destroy();
    $response = array("result" => "OK");
    echo json_encode($response);
}

function checkCredentials() {
    session_start();
    if(!isset($_SESSION['Username']) || $_SESSION['Username'] == '') {
        genericErrorFunction("403");
    }
}

# attempt to retrieve the tasks from the database.
function getTasksFunction() {
    checkCredentials();
    $result = attemptGetTasks();
    if($result["MESSAGE"] != "SUCCESS") {
        genericErrorFunction($result["MESSAGE"]);
    }

    $response = array("RESULT" => "OK", "DATA" => json_encode($result["INSTANCES"]));
    echo json_encode($response);


}
/*
    function sendCommentFunction() {
        session_start();
        if(!isset($_SESSION['Username']) || $_SESSION['Username'] == '') {
        genericErrorFunction("403");
        }

        $text = $_POST['comment_text'];
        $username = $_SESSION['Username'];

        $result = attemptPostcomment(time(), $text, $username);

        if($result["MESSAGE"] == "SUCCESS"){ 
            $response = array("RESULT" => "OK", "Username" => $username);
            echo json_encode($response);
        } else {
            genericErrorFunction($result["MESSAGE"]);
        }
    }

    function getCommentsFunction() {
        session_start();
        if(!isset($_SESSION['Username']) || $_SESSION['Username'] == '') {
        genericErrorFunction("403");
        }

        $result = attemptGetComments();

        if($result["MESSAGE"] != "SUCCESS") {
            genericErrorFunction($result["MESSAGE"]);
        }

        $response = array("RESULT" => "OK", "DATA" => $result["DATA"]);
        echo json_encode($response);

    }

    function searchFunction() {
        session_start();
        if(!isset($_SESSION['Username']) || $_SESSION['Username'] == '') {
        genericErrorFunction("403");
        }

        $username = $_POST["username"];
        $firstName = $_POST["first_name"];
        $lastName = $_POST["last_name"];
        $email = $_POST["email"];

        $result = attemptSearch($username, $firstName, $lastName, $email);

        if($result["MESSAGE"] != "SUCCESS") {
            genericErrorFunction($result["MESSAGE"]);
        }

        $response = array("RESULT" => "OK", "DATA" => $result["DATA"]);
        echo json_encode($response);
    }

    function profileFunction() {
        session_start();
        if(!isset($_SESSION['Username']) || $_SESSION['Username'] == '') {
        genericErrorFunction("403");
        }

        $username = $_SESSION['Username'];

        $result = attemptGetProfile();

        if($result["MESSAGE"] != "SUCCESS") {
           genericErrorFunction($result["MESSAGE"]);
        }

        $response = array("RESULT" => "OK", "DATA" => $result["DATA"]);
        echo json_encode($response);

    }

    function getFriendRequests() {
        session_start();
        if(!isset($_SESSION['Username']) || 
            $_SESSION['Username'] == '') {
            genericErrorFunction("403");
        }

        $result = attemptGetFriendRequests();

        if($result["MESSAGE"] != "SUCCESS") {
            genericErrorFunction($result["MESSAGE"]);
        }

        $response = array("RESULT" => "OK", "DATA" => $result["DATA"]);
        echo json_encode($response);
    }

    function friendRequest() {
        session_start();
        if(!isset($_SESSION['Username']) || 
            $_SESSION['Username'] == '') {
            genericErrorFunction("403");
        }
        $person = $_POST['person'];
        $result = attemptFriendRequest($person);

        if($result["MESSAGE"] != "SUCCESS") {
            genericErrorFunction($result["MESSAGE"]);
        }

        echo json_encode(array("RESULT"=> "OK"));


    }

    function gettNumberFriendRequests() {
        session_start();
        if(!isset($_SESSION['Username']) || 
            $_SESSION['Username'] == '') {
            genericErrorFunction("403");
        }

        $result = attemptGetNumberRequests();

        if($result["MESSAGE"] != "SUCCESS") {
            genericErrorFunction($result["MESSAGE"]);
        }

        echo json_encode(array("RESULT"=> "OK", "number" => $result["number"]));
    }

    function delete_request($accepted) {
        session_start();
        if(!isset($_SESSION['Username']) || 
            $_SESSION['Username'] == '') {
            genericErrorFunction("403");
        }

        $requester = $_POST['requester'];

        $result = attemptDeleteRequest($requester, $accepted);

        if($result['MESSAGE'] != "SUCCESS") {
            genericErrorFunction($result["MESSAGE"]);
        }   

        echo json_encode(array("RESULT" => "OK"));
    }

    function getFriendList() {
        session_start();
        if(!isset($_SESSION['Username']) || 
            $_SESSION['Username'] == '') {
            genericErrorFunction("403");
        }

        $result = attemptGetFriendList();

        if($result['MESSAGE'] != "SUCCESS") {
            genericErrorFunction($result["MESSAGE"]);
        }

        echo json_encode(array("RESULT" => "OK", "DATA" => $result["DATA"]));


}*/
?>
