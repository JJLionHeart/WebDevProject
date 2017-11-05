$("#submitBtn").click("on", validateRegistrationForm); 

function validateRegistrationForm() {

	var isValid = true;
	if($("#firstName").val().length == 0) {
		$("#errorFirstName").html("Enter your first name");
		$("#errorFirstName").css("color", "red");
		$("#errorFirstName").css("fontSize", "small");
		isValid = false;
	}

	if($("#lastName").val().length == 0) {
		$("#errorLastName").html("Enter your last name");
		$("#errorLastName").css("color", "red");
		$("#errorLastName").css("fontSize", "small");
		isValid = false;
	}

	if($("#userName").val().length == 0) {
		$("#errorUserName").html("Enter your user name");
		$("#errorUserName").css("color", "red");
		$("#errorUserName").css("fontSize", "small");
		isValid = false;
	}

	if($("#email").val().length == 0) {
		$("#errorEmail").html("Enter your email");
		$("#errorEmail").css("color", "red");
		$("#errorEmail").css("fontSize", "small");
		isValid = false;
	}

	if($("#password").val().length == 0) {
		$("#errorPassword").html("Enter your password");
		$("#errorPassword").css("color", "red");
		$("#errorPassword").css("fontSize", "small");
		isValid = false;
	}

	if($("#password2").val().length == 0) {
		$("#errorPassword2").html("Re-enter your password");
		$("#errorPassword2").css("color", "red");
		$("#errorPassword2").css("fontSize", "small");
		isValid = false;
	}

	if ($("#password").val() != $("#password2").val()) {
		$("#errorPassword").html("Passwords do not match");
		$("#errorPassword").css("color", "red");
		$("#errorPassword").css("fontSize", "small");
		isValid = false;
	}

	goHome(isValid);
}


function goHome(isValid) {
	if(isValid) {
		window.location.replace("home.html");
	}
}