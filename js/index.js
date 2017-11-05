$(".login-form").submit( function() {
    if($("#username").val() == "") {
        alert("username should not be empty");
        return;
    } 

    if($("#password").val() == "") {
        alert("Password should not be empty");
        return;
    }

   var username = $("#username").val();
   var password = $("#password").val();
   var souviens = $("#souviens").is(":checked"); 
   var jsonToSend = {
        "uName": username,
        "uPassword": password,
        //"souviens": souviens,
        "action": "LOGIN"
   }; 
   $.ajax({
       url: "./data/applicationLayer.php",
       type: "POST",
       data: jsonToSend,
       ContentType: "application/json",
       dataType: "json",
       success: function(dataReceived) {
            window.location = "home.php"; 
       },
       error: function(errorMessage) {
            alert("error:" + errorMessage.statusText);
       }
   });
});
