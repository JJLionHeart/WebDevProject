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
    <link rel="stylesheet" href="css/materialize-collection-actions-1.0.0.min.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
</head>

<body>
    <nav>
    <div class="nav-wrapper cyan">
        <a class="brand-logo">Space Unicorns</a>
        <img id="unicornio" src="unicornio.png" alt=""> 
        
        <ul id="nav" class="right hide-on-med-and-down cyan">
        <li><a href="agenda.php">Agenda</a></li>
        <li><a href="calendar.php">Calendar</a></li>
        <li id = "logout"><a>Logout</a></li>
        </ul>
    </div>
</nav>
<div class="row">
    <div id="individual-sidebar" class="col s6">
        <div class="collection with-header deep-purple white-text center">
                <h4 class="task-card-title">Your Tasks for today</h4>
        </div>
        <div  id="newTask-btn" class ="collection">
            <!-- Modal Trigger -->
            <button id="modal1" class="waves-effect waves-light btn modal-trigger deep-purple right offset-s1" data-target="createTask">Add New Task</button>

            <!-- Modal Structure -->
            <div id="createTask" class="modal">
                <div class="modal-content">
                    <nav>
                        <div class="nav-wrapper cyan">
                        <h3>Create Task</h3>
                        </div>
                    </nav>
                    <div class="row">
                        <form>
                            <p>Title<br/>
                                <input id="task-name" type="text">
                            </p>

                            <p>Start Date<br/>
                                <input type="text" id="task-startdate" class="datepicker">      
                            </p>

                            <p>Deadline<br/>
                                <input type="text" id="task-deadline" class="datepicker">  
                            </p>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="submit-task" href="#!" class="modal-action modal-close waves-effect cyan btn-flat">Submit</a>
                </div>
            </div>
        </div>
          
        <ul id="tasks" class="collection">
           
        </ul>
    </div>

    <div id="projects-sidebar" class="col s6">
        <div class="collection with-header orange white-text center">
                <h4 class="task-card-title">Your Projects</h4>
        </div>
        
        <div  id="newTask-btn" class ="collection">
            <!-- Modal Trigger -->
            <button id="modal2" class="waves-effect waves-light btn modal-trigger orange right offset-s1" data-target="createProject">Add Project</button>

            <!-- Modal Structure -->
            <div id="createProject" class="modal">
                <div class="modal-content">
                    <nav>
                        <div class="nav-wrapper cyan">
                        <h3>Create Project</h3>
                        </div>
                    </nav>
                    <div class="row">
                        <form>
                            <p>Title<br/>
                                <input id="project-name" type="text">
                            </p>
                            
                            <p>Description<br/>
                            <textarea id="project-description" class="materialize-textarea" data-length="120"></textarea>
                            </p>

                            <p>Start Date<br/>
                                <input type="text" id="project-startdate" class="datepicker">      
                            </p>

                            <p>Deadline<br/>
                                <input type="text" id="project-deadline" class="datepicker">  
                            </p>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="submit-project" href="#!" class="modal-action modal-close waves-effect waves-cyan btn-flat">Save</a>
                </div>
            </div>
        </div>
            
        <ul id="projects" class="collection">
        </ul> 
    </div>  
</div>
		
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/home.js"></script>
    <script src="js/materialize-collection-actions-1.0.0.min.js"></script>
</body>

</html>
