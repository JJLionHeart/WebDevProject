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
        <div class="nav-wrapper cyan">
            <a id="brand-logo">Space Unicorns</a>
            <img id="unicornio" src="unicornio.png" alt=""> 
            
            <ul id="nav" class="right hide-on-med-and-down cyan">
            <li><a href="agenda.php">Agenda</a></li>
            <li><a href="calendar.php">Calendar</a></li>
            <li id = "logout"><a>Logout</a></li>
            </ul>
        </div>
    </nav>

<div class="row">
        <h4 class="header teal-text text-lighten-2 col s6 offset-s1">Your Contacts</h4>
        <div class="col s6 offset-s1">
            <div class= "contacts">
            <ul class="collection">
                <li class="collection-item avatar">
                <img src="user.png" alt="" class="circle">
                <span class="title">Title</span>
                <p>First Line <br>
                    Second Line
                </p>
                <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
                </li>
                <li class="collection-item avatar">
                <i class="material-icons circle">folder</i>
                <span class="title">Title</span>
                <p>First Line <br>
                    Second Line
                </p>
                <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
                </li>
            </ul>
            </div>    
        </div>
    </div>
</div>
			
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
</body>

</html>