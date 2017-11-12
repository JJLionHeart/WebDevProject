<!DOCTYPE>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Home page</title>

	<!-- CSS  -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
	<link href="css/mystyle.css" type="text/css" rel="stylesheet" media="screen,projection" />
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
        <div class= "contacts">
        <div class="collection with-header deep-purple white-text center">
                <h4 class="task-card-title">Your Contacts</h4>
        </div>
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
            <img src="user.png" alt="" class="circle">
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
			
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
</body>

</html>