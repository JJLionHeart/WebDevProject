<?php
    session_start();
        if(!isset($_SESSION['Username']) || $_SESSION['Username'] == '') {
            header("Location: index.php");
            die();
        }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='css/fullcalendar.min.css' rel='stylesheet' />
<link href='css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Sacramento" rel="stylesheet">
<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
<link href="css/mystyle.css" type="text/css" rel="stylesheet" media="screen,projection" />
<script src='js/moment.min.js'></script>
<script src='js/jquery.js'></script>
<script src='js/fullcalendar.min.js'></script>
<script src='js/calendar.js'></script>	
</head>
<body>
<nav>
    <div class="nav-wrapper cyan">
        <a id="brand-logo">Space Unicorns</a>
        <img id="unicornio" src="unicornio.png" alt=""> 
        
        <ul id="nav" class="right hide-on-med-and-down cyan">
        <li><a href="agenda.php">Agenda</a></li>
        <li><a href="home.php">Home</a></li>
        <li id = "logout"><a>Logout</a></li>
        </ul>
    </div>
</nav>
	
	<div class="container">
		<div class="section">
			<div id='calendar'></div>
		</div>
	</div>

</body>
</html>
