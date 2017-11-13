<?php
    session_start();
        if(!isset($_SESSION['Username']) || $_SESSION['Username'] == '') {
            header("Location: index.php");
            die();
        }
?>

<!DOCTYPE>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Home page</title>

	<!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Sacramento" rel="stylesheet">
	<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
	<link href="css/mystyle.css" type="text/css" rel="stylesheet" media="screen,projection" />
</head>

<body>
    <nav>
        <div class="nav-wrapper cyan">
        <div class="row">
            <div class="col s4"> 
                <a class="brand-logo">Space Unicorns</a>
                <img id="unicornio" src="unicornio.png" alt=""> 
            </div>
            <div class="col s4">
                <form>
                    <div class="input-field">
                        <input id="search" type="search" required>
                        <label id="search-icon" class="label-icon" for="search"><i class="material-icons">search</i></label>
                        <i class="material-icons">close</i>
                    </div>
                </form>
            </div>  
            <div class="col s4">
                <ul id="nav" class="right hide-on-med-and-down cyan">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="calendar.php">Calendar</a></li>
                    <li id = "logout"><a>Logout</a></li>
                </ul>
            </div>          
        </div>
        </div>    
    </nav>
<div class="section">
<div class="row">
    <div class= "contacts">
        <div class="collection with-header deep-purple white-text center">
            <h4 class="task-card-title">Contact List</h4>
        </div>

        <ul id="agenda" class="collection">

        </ul> 
    </div>  
</div>
</div>
			
	<script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/agenda.js"></script>
</body>

</html>