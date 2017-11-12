<?php

function databaseConnection()
{
    extract(parse_url(getenv("DATABASE_URL")));
    $pg_string =  "user=$user password=$pass host=$host dbname=" . substr($path, 1);
    $pg_conn = pg_connect($pg_string);
    return $pg_conn;
}

function attemptLogin($userName, $userPassword)
{
    $connection = databaseConnection();
    if ($connection != null)
    {
        $sql = "SELECT password FROM Users WHERE username = '$userName'";
        $result = pg_query($connection, $sql);
        if (pg_num_rows($result)){
            while ($row = pg_fetch_row($result))
            {
                $hash = $row[0];
                if(!password_verify($userPassword, $hash)) {
                    return array("MESSAGE"=>"406");
                } else {
                    return array("MESSAGE" => "SUCCESS", "username" => $userName);
                }
            }

            pg_close($connection);
            return $response;
        }
        else
        {
            pg_close($connection);
            return array("MESSAGE"=>"406");
        }
    }
    else
    {
        return array("MESSAGE"=>"500");
    }

}

function attemptRegister($uName, $uPassword, $firstName, $lastName, $email) {

    $sql = "SELECT username FROM Users WHERE username = '$uName'";

    $conn = databaseConnection();

    if($conn == null){
        return array("MESSAGE"=>"500");
    }

    $result = pg_query($conn, $sql);


    if(pg_num_rows($result)){
        return array("MESSAGE" => "409");
    }
    /* Please read:
     * 
     * I decided to use password hashing instead of encryption because of the following reasons:
     * 1) I think it is safer to store a hashed password instead of an encrypted one, this is 
     *    because with encryption we would have to store the key to encrypt and decrypt the data
     *    somewhere on the server. If an attacker would get into our server and somehow retrieve
     *    the key then he would have the power to decrypt all the passwords on the database.
     *    On the other hand if we only hash the keys then the attacker would have to run a dictionary
     *    attack agains the hashed passwords, which would not stop him from retreiving the data
     *    bug will make his attack harder.
     * 2) Hashing is faster than encryption for some algorithms.
     * 3) We also save computational resources by hashing instead of encrypting.
     */
    $password_hash = password_hash($uPassword, PASSWORD_BCRYPT);

    $sql = "INSERT INTO Users(first_name, last_name, username, password, email)
        VALUES ('$firstName', '$lastName', '$uName', '$password_hash', '$email');";

    $result = pg_query($conn, $sql);

    // Making sure that we got something as response
    if($result) {
        pg_close($conn);
        return array("MESSAGE"=> "SUCCESS");
    }

    pg_close($conn);
    return array("MESSAGE" => "407");
}

function attemptGetTasks() {
    $conn = databaseConnection();
    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    # Get the username out of this session.
    $username = $_SESSION['Username'];
    $sql = "SELECT content, deadline, start_date FROM Tasks WHERE username = '$username';";


    $result = pg_query($conn, $sql);

    if(!$result) {
        pg_close($conn);
        return array("MESSAGE" => "407");
    }

    # Prepare a return value for the function.
    $ret_value = array("MESSAGE" => "SUCCESS", "NUM_ROWS" => pg_num_rows($result));

    # Variable used to index all the json encodes of the
    # objects in the return string.
    $index = 0;
    $instancias = array();
    # retrieve each result of the query
    while ($row = pg_fetch_row($result)) {
        $instancia = array("content" => $row[0],
            "deadline"=> $row[1],
            "start_date" => $row[2]);
        array_push($instancias, json_encode($instancia));
    }

    $ret_value["INSTANCES"] = json_encode($instancias);

    pg_close($conn);
    return $ret_value;

}

function attemptGetProjects() {
    $conn = databaseConnection();
    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    # Get the username out of this session.
    $username = $_SESSION['Username'];
    $sql = "SELECT project_id FROM UsersAndProjects WHERE username = '$username'";

    $result = pg_query($conn, $sql);
    # Prepare a return value for the function.
    $ret_value = array("MESSAGE" => "SUCCESS", "NUM_ROWS" => pg_num_rows($result));

    # Variable used to index all the json encodes of the
    # objects in the return string.
    $instancias = array();
    while ($row = pg_fetch_row($result)) {
        $sql = "SELECT project_id, name, description, deadline, start_date FROM Projects WHERE project_id = '$row[0]';";

        $result2 = pg_query($conn, $sql);
        # retrieve each result of the query
        while ($row2 = pg_fetch_row($result2)) {
            $instancia = array(
                "id" => $row2[0],
                "name" => $row2[1],
                "description"=> $row2[2],
                "deadline" => $row2[3],
                "start_date" => $row2[4]);
            array_push($instancias, json_encode($instancia));
        }

    }    

    $ret_value["INSTANCES"] = json_encode($instancias);

    pg_close($conn);
    return $ret_value;

}

// The second argument indicates if we are going to delete a task
// if it is set to false, we instead try to delete a project.
function attemptDelete($id, $task) {
    $username = $_SESSION['Username'];
    $sql = "";
    $sql2 = "";
    if($task) {
        $sql = "DELETE FROM Tasks WHERE username = '$username' AND taskid = '$id'";
    } else {
        $sql = "DELETE FROM Projects where project_id = '$id'";
        $sql2 = "DELETE FROM UsersAndProjects where username = '$username' AND project_id = '$id';"; 
    }

    $conn = databaseConnection();
    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    if($sql2 != "") {
        $result = pg_query($conn, $sql2);
        if(!$result) {
            return array("MESSAGE" => "407");
        }
    }

    $result = pg_query($conn, $sql);
    if(!$result) {
        return array("MESSAGE" => "407");
    }

    pg_close($conn);
    return array("MESSAGE" => "SUCCESS");

}

function attemptModify($task, $new) {
    $username = $_SESSION['Username'];
    $conn = databaseConnection();
    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    if($task) {
        $content = $_POST["CONTENT"];
        $deadline = $_POST["DEADLINE"];
        $start_date = $_POST["START_DATE"];
        $sql = "";
        if ($new) {
            $sql = "INSERT INTO Tasks(content, deadline, start_date, username) VALUES('$content', '$deadline', '$start_date', '$username');";
        } else {
            $id = $_POST["ID"];
            $sql = "UPDATE Tasks SET content = '$content', deadline = '$deadline', start_date = '$start_date' WHERE taskid = '$id' AND username = '$username';";
        }

        $result = pg_query($conn, $sql);

        if(!$result) {
            return array("MESSAGE" => "407");
        }
    } else {

        $id = "";
        if (!$new) {
            // Primero nos tenemos que asegurar que este proyecto
            // corresponda al usuario.
            $id = $_POST["ID"];
            $sql = "SELECT username FROM UsersAndPRojects WHERE project_id = '$id';";

            $result = pg_query($conn, $sql);

            if(!$result) {
                return array("MESSAGE" => "408");
            }

            $rows = pg_num_rows($result);

            if($rows != 1) {
                return array("MESSAGE" => "403");
            }

            $row = pg_fetch_row($result);

            if($row[0] != $username) {
                return array("MESSAGE" => "403");
            }
        } else {
            $id = (string)(time() + rand(1, 100000));
        }

        // Now that we are certain that this project belongs to the
        // user, update the info.
        $name = $_POST["NAME"];
        $description = $_POST["DESCRIPTION"];
        $start_date = $_POST["START_DATE"];
        $deadline = $_POST["DEADLINE"];

        $sql = "";
        if ($new) {
            $sql = "INSERT INTO Projects(project_id, name, description, start_date, deadline) 
                VALUES('$id', '$name', '$description', '$start_date', '$deadline')";
            $result = pg_query($conn, $sql);
            if (!$result) {
                return array("MESSAGE" => "407");
            }

            $sql = "INSERT INTO UsersAndProjects(project_id, username) VALUES('$id', '$username');";
            $result = pg_query($conn, $sql);
            if (!$result) {
                return array("MESSAGE" => "407");
            }
        } else {
            $sql = "UPDATE Projects SET name = '$name', description = '$description', start_date = '$start_date', deadline = '$deadline' WHERE project_id = '$id';";

            $result = pg_query($conn, $sql);
            if (!$result) {
                return array("MESSAGE" => "407");
            }
        }


        return array("MESSAGE" => "SUCCESS");

    }
}

function attemptSearch() {
    $current_user = $_SESSION['Username'];

    $conn = databaseConnection();

    $username = $_POST["USERNAME"];
    $firstName = $_POST["FIRST_NAME"];
    $lastName = $_POST["LAST_NAME"];
    $email = $_POST["EMAIL"];

    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    $sql = "SELECT first_name, last_name, username, email FROM Users WHERE ";

    if($username != "") {
        $sql = $sql . " username = '$username';";
    } else if($firstName != "" && $lastName != "") {
        $sql = $sql. "first_name = '$firstName' AND last_name = '$lastName';";
    } else if ($firstName != "") {
        $sql = $sql. "first_name = '$firstName' ;";
    } else if ($lastName != "") {
        $sql = $sql. "last_name = '$lastName' ;";
    } else {
        $sql = $sql. "email = '$email' ;";
    }

    $result = pg_query($conn, $sql);

    if(!$result) {
        pg_close($conn);
        return array("MESSAGE" => "407");   
    }

    $count = 0;
    $instancias = array();
    while($row = pg_fetch_row($result)) {
        if($row[2] != $current_user){

            // Now check if they are already friends.
            $sql = "SELECT * FROM Friendship WHERE username = '". $current_user . "' AND friend = '". $row[2] . "';";

            $temp_res2 = pg_query($conn, $sql);
            if(!$temp_res2) {
                $conn-> close();
                return array("MESSAGE" => "407");
            }

            if(pg_num_rows($temp_res2) == 0) {
                $count = $count + 1;
                $instancia = array("FIRST_NAME" => $row[0],
                    "LAST_NAME" => $row[1],
                    "USERNAME" => $row[2],
                    "EMAIL" => $row[3]);
                array_push($instancias, json_encode($instancia));
            }
        }
    }
    pg_close($conn);
    return array("MESSAGE" => "SUCCESS", "COUNT"=>$count, "DATA" => json_encode($instancias));

}

function attemptFriendRequest($person){
    $conn = databaseConnection();
    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    $current_user = $_SESSION['Username'];

    $sql = "INSERT INTO Friendship(friend, username) 
        VALUES('$person', '$current_user');";
    $result = pg_query($conn, $sql);

    if(!$result) {
        return array("MESSAGE" => "407");
    }

    return array("MESSAGE" => "SUCCESS");
}

function attemptGetFriendList() {
    $conn = databaseConnection();
    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    $current_user = $_SESSION['Username'];
    $sql = "SELECT friend FROM Friendship WHERE username = '$current_user';";

    $result = pg_query($conn, $sql);

    if(!$result) {
        pg_close($conn);
        return array("MESSAGE" => "407");
    }

    $count = pg_num_rows($result);
    $instances = array();
    while($row = pg_fetch_row($result)) {
        $sql = "SELECT username, first_name, last_name, email FROM Users WHERE username = '".$row[0]."';";
        $temp_res = pg_query($conn, $sql);

        if(!$temp_res) {
            return array("MESSAGE" => "407");
        }
        $row2 = pg_fetch_row($temp_res);
        $instance = array("FIRST_NAME" => $row2[1], "USERNAME" => $row2[0], "LAST_NAME" => $row2[2], "EMAIL" => $row2[3]);
        array_push($instances, json_encode($instance));
    }
    return array("MESSAGE" => "SUCCESS", "DATA" => json_encode($instances), "COUNT" => $count);

}
/*

function attemptGetProfile() {
    $current_user = $_SESSION['Username'];

    $conn = databaseConnection();

    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    $sql = "SELECT * FROM Users WHERE userName = '$current_user';";
    $result = $conn->query($sql);

    if(!$result) {
        return array("MESSAGE" => "407");
    }

    $row = $result->fetch_assoc();

    $json1 = array("username" => $row['userName'],
        "name" => $row['fName'] . ' ' . $row['lName'],
        "email" => $row['email'],
        "gender" => $row['gender'],
        "country" => $row['country']);

    $response = array("MESSAGE" => "SUCCESS", "DATA" => json_encode($json1));
    pg_close($conn);

    return $response; 

}

 */
?>
