<?php

function databaseConnection()
{
        extract(parse_url($_ENV["DATABASE_URL"]));
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
        if (!pg_num_rows($result)){
            while ($row = pg_fetch_row($result))
            {
                $hash = $row[0];
                if(!password_verify($userPassword, $hash)) {
                    echo "lol nope";
                    return array("MESSAGE"=>"406");
                } else {
                    return array("MESSAGE" => "SUCCESS");
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

/*

function attemptPostcomment($id, $text, $username) {
    $conn = databaseConnection();

    if($conn == null) {
        return array("MESSAGE" => "500");
    }


    $sql = "INSERT INTO Comments(id, text, userName) VALUES('$id', '$text', '$username');";
    $result = $conn->query($sql);

    if(!$result) {
        pg_close($conn);
        return array("MESSAGE" => "407");
    }

    pg_close($conn);
    return array("MESSAGE" => "SUCCESS");

}

function attemptGetComments() {
    $conn = databaseConnection();
    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    $sql = "SELECT * FROM Comments;";

    $result = $conn->query($sql);

    if(!$result) {
        pg_close($conn);
        return array("MESSAGE" => "407");
    }

    $newHtml = "";
    while($row = $result->fetch_assoc()){
        $temp = '<div class="SingleComment"> <b>'. $row['userName'] . '</b>: '.$row['text'].'</div>';
        $newHtml = $newHtml . $temp;
    }

    pg_close($conn);

    return array("MESSAGE" => "SUCCESS", "DATA" => $newHtml);

}

function attemptSearch($username, $firstName, $lastName, $email) {
    $current_user = $_SESSION['Username'];

    $conn = databaseConnection();

    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    $sql = "SELECT fName, lName, userName FROM Users WHERE ";

    if($username != "") {
        $sql = $sql . " userName = '$username';";
    } else if($firstName != "" && $lastName != "") {
        $sql = $sql. "fName = '$firstName' AND lName = '$lastName';";
    } else if ($firstName != "") {
        $sql = $sql. "fName = '$firstName' ;";
    } else if ($lastName != "") {
        $sql = $sql. "lName = '$lastName' ;";
    } else {
        $sql = $sql. "email = '$email' ;";
    }

    $result = $conn->query($sql);

    if(!$result) {
        pg_close($conn);
        return array("MESSAGE" => "407");   
    }

    $newHtml = "";
    while($row = $result->fetch_assoc()) {
        if($row['userName'] != $current_user){
            $request = "<input type='button' id=".$row["userName"]." class='friendRequest' value = 'Send Friend Request'> ";
            // Check for already existing friend requests
            $sql = "SELECT * FROM FriendRequests WHERE (person = '".$row['userName'] . "' AND requester = '". $current_user . "') OR (
                person = '".$current_user. "' AND requester = '". $row['userName'] . "');";

            $temp_res1 = $conn->query($sql);
            if(!$temp_res1) {
                $conn-> close();
                return array("MESSAGE" => "407");
            }

            // Now check if they are already friends.
            $sql = "SELECT * FROM Friendship WHERE person = '". $current_user . "' AND friend = '". $row['userName'] . "';";

            $temp_res2 = $conn->query($sql);
            if(!$temp_res2) {
                $conn-> close();
                return array("MESSAGE" => "407");
            }

            if($temp_res1->num_rows == 0 && $temp_res2->num_rows == 0) {
                $temp = '<tr> <td>'. $row["fName"] . "</td><td>" .$row["lName"]. "</td><td> ".$row["userName"]."</td> <td>
                    ". $request . " </td> </tr>";
                $newHtml = $newHtml . $temp;
            }
        }
    }
    pg_close($conn);
    return array("MESSAGE" => "SUCCESS", "DATA" => $newHtml);

}

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

function attemptGetFriendRequests() {
    $current_user = $_SESSION['Username'];
    $conn = databaseConnection();
    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    $sql = "SELECT * FROM FriendRequests WHERE person = '$current_user'"; 

    $result = $conn->query($sql);

    echo mysqli_error($conn);

    if(!$result) {
        return array("MESSAGE" => "407");
    }

    $newHtml = "";
    while($row = $result->fetch_assoc()) {
        $sql = "SELECT * FROM Users WHERE userName = '".$row["requester"]."';";
        $temp_res = $conn->query($sql);

        if(!$temp_res) {
            return array("MESSAGE" => "407");
        }
        $row2 = $temp_res->fetch_assoc();
        $temp = '<tr> <td>'. $row2["fName"] . "</td><td>" . $row2["lName"]. "</td><td> ". $row2["userName"]."</td> <td>
            <input type='button' id=".$row2["userName"]." class='acceptRequest' value = 'Accept'>  </td> 
            <td><input type='button' id=".$row2["userName"]." class='rejectRequest' value = 'Reject'> </td></tr>";
        $newHtml = $newHtml . $temp;
    }

    $response = array("MESSAGE" => "SUCCESS", "DATA" => $newHtml);
    pg_close($conn);
    return $response;


}

function attemptFriendRequest($person){
    $conn = databaseConnection();
    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    $current_user = $_SESSION['Username'];

    $sql = "INSERT INTO FriendRequests(person, requester) 
        VALUES('$person', '$current_user');";
    $result = $conn->query($sql);

    if(!$result) {
        return array("MESSAGE" => "407");
    }

    return array("MESSAGE" => "SUCCESS");
}

function attemptGetNumberRequests() {
    $conn = databaseConnection();
    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    $current_user = $_SESSION['Username'];

    $sql = "SELECT * FROM FriendRequests WHERE person = '$current_user';";
    $result = $conn->query($sql);

    pg_close($conn);
    if(!$result) {
        return array("MESSAGE" => "407");
    }
    return array("MESSAGE" => "SUCCESS", "number" => $result->num_rows);
    

}

function attemptDeleteRequest($requester, $accepted) {
    $conn = databaseConnection();
    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    $current_user = $_SESSION['Username'];

    $sql = "DELETE FROM FriendRequests WHERE person='$current_user' AND requester='$requester';";

    $result = $conn->query($sql);

    if(!$result) {
       return array("MESSAGE" => "407");
    }

    if($accepted) {
        $sql = "INSERT INTO Friendship(person, friend) VALUES('$current_user', '$requester');";
        $result = $conn->query($sql);
        if(!$result) {
            return array("MESSAGE" => "407");
        }
        
        $sql = "INSERT INTO Friendship(person, friend) VALUES('$requester', '$current_user');";
        $result = $conn->query($sql);
        if(!$result) {
            return array("MESSAGE" => "407");
        }

    }
    return array("MESSAGE"=>"SUCCESS");
}

function attemptGetFriendList() {
    $conn = databaseConnection();
    if($conn == null) {
        return array("MESSAGE" => "500");
    }

    $current_user = $_SESSION['Username'];
    $sql = "SELECT * FROM Friendship WHERE person = '$current_user';";

    $result = $conn->query($sql);

    if(!$result) {
        pg_close($conn);
        return array("MESSAGE" => "407");
    }

    $newHtml = "";
    while($row = $result->fetch_assoc()) {
        $sql = "SELECT * FROM Users WHERE userName = '".$row["friend"]."';";
        $temp_res = $conn->query($sql);

        if(!$temp_res) {
            return array("MESSAGE" => "407");
        }
        $row2 = $temp_res->fetch_assoc();
        $temp = '<tr> <td>'. $row2["fName"] . "</td><td>" . $row2["lName"]. "</td><td> ". $row2["userName"]."</td></tr>";
        $newHtml = $newHtml . $temp;
    }
    return array("MESSAGE" => "SUCCESS", "DATA" => $newHtml);

}
 */
?>
