<?php
    session_start();
        if(isset($_SESSION['Username']) || $_SESSION['Username'] != '') {
            header("Location: home.php");
            die();
        }
?>
<html>
<head>
	<title> Web project </title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
	<link href="css/mystyle.css" type="text/css" rel="stylesheet" media="screen,projection" />
</head>
<body>
	<div id="login" class="row scrollspy deep-purple2">
		<div class="section no-pad-bot">
			<div class="container">
				<h1 class="header center white-text">Welcome to our web page </h1>
			</div>
		</div>
		<div class="card-panel col s4 z-depth-4 offset-s4">
			<center><h4 class="deep-purple-text">Sign in</h4></center>
			<fieldset>
			<form class= "login-form">
				<div class="row margin">
					<div class="input-field col s12">
						<!--<i class="mdi-social-person-outline prefix"> </i>   Add the image-->
						<input id="username-login" type="text">
						<label for="username-logim" class="center-align deep-purple-text">Username</label>
					</div>
				</div>
				<div class="row margin">
					<div class="input-field col s12">
						<!--<i class="mdi-action-lock-outline prefix"> </i>  Add image-->
						<input id="password-login" type="password">
						<label for="password-login" class="center-align deep-purple-text">Password</label>
					</div>
				</div>
			</form>
			</fieldset>
			</br>
			<a id="submit" class="btn-large waves-effect waves-light deep-purple col s4 offset-s4">Enter</a>
			</br>
		</div>
	</div>

<div id="index-banner" class="parallax-container white">
	<div class="section no-pad-bot">
		<div class="container">
			<br><br>
			<h1 class="header center teal-text text-lighten-2">Welcome to our web page </h1>
			<div class="row center">
				<h5 class="header col s12 light">Create an account</h5>
			</div>
		</div>
	</div>
</div>
<div id= "register" class="container white">
	<div class="section">
		<fieldset>
			<legend>Register your account</legend>
			<br>
			<p>First Name<br/>
				<input id="firstName" type="text">
				<span id="errorFirstName"></span>
			</p>

			<p>Last Name<br/>
				<input id="lastName" type="text">
				<span id="errorLastName"></span>
			</p>

			<p>Username<br/>
				<input id="userName" type="text">
				<span id="errorUserName"></span>
			</p>

			<p>Email<br/>
				<input id="email" type="text">
				<span id="errorEmail"></span>
			</p>

			<p>Password<br/>
				<input id="password" type="password">
				<span id="errorPassword"></span>
			</p>

			<p>Password confirmation<br/>
				<input id="password2" type="password">
				<span id="errorPassword2"></span>
			</p>
		</fieldset>
	</div>
</div>
<div class="row center">
		<a id="submitBtn" class="btn-large waves-effect waves-light ">Register</a>
</div>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<script type="text/javascript" src="js/register.js"></script>
	<script  type="text/javascript" src='js/index.js'></script>

</body>
</html>
