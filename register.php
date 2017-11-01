<!DOCTYPE>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Register page</title>

	<!-- CSS  -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
	<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection" />
</head>

<body>
	<div id="index-banner" class="parallax-container">
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

	<div class="container">
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
			<a id="submitBtn" class="btn-large waves-effect waves-light teal lighten-1">Register</a>
	</div>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
</body>

</html>