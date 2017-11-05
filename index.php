<html>
	<head>
		<title> Web project </title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
	    <script type="text/javascript" src="js/jquery.js"></script>
	    <script type="text/javascript" src="js/index.js"></script>
	</head>
	<body class="deep-purple2">
		<div class="rootContainer center">
			<div class="header">
				<span class="header">
						<h1> Web page title goes here</h1>
			     </span>
			</div>
			<div id="login" class="row">
				<div class="card-panel col s4 z-depth-4 offset-s4">
				<center><h4>Sign in</h4></center>
				<fieldset>
					<form class= "login-form">
						<div class="row margin">
								<div class="input-field col s12">
									<!--<i class="mdi-social-person-outline prefix"> </i>   Add the image-->
									<input id="username" type="text">
									<label for="username" class="center-align">Username</label>
								</div>
						</div>
						<div class="row margin">
								<div class="input-field col s12">
									<!--<i class="mdi-action-lock-outline prefix"> </i>  Add image-->
									<input id="password" type="password">
									<label for="password">Password</label>
								</div>
						</div>
						<center>
							<input type="submit" class="btn-large waves-effect waves-light deep-purple" value="Enter"/>
						</center>
					</form>
				</fieldset>
				</div>
			</div>
		</div>
	</body>
</html>
