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
	<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection" />

</head>

<body>
    <nav>
    <div class="nav-wrapper deep-purple2">
        <a href="#" class="brand-logo">Logo</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down deep-purple2">
        <li><a>New Task</a></li>
        <li><a>Agenda</a></li>
        <li><a>Calendar</a></li>
        <li id = "logout"><a>Logout</a></li>
        </ul>
    </div>
</nav>
<div class="row">
    <div class= "col s6">
        <h4 class="header teal-text text-lighten-2">Your Tasks for today...</h4>
        <div class="individual-tasks">
            <div class= "col s5 offset-s1 orange lighten-3 white-text">
                    Aqui se crean las tasks individuales...
            </div>    
        </div>
    </div>

    <div class="col s6 ">
        <h4 class="header teal-text text-lighten-2">Your projects</h4>
        <div class= "projects">
            <div class= "col s5 orange lighten-3 white-text">
                    Aqui se crean las tasks de proyectos...
            </div>  
        </div>
    </div>
</div>
			
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<script type="text/javascript" src="js/home.js"></script>
</body>

</html>
