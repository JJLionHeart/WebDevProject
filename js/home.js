$(document).ready(function() {
$("#logout").click(function() {
        var jsonToSend = {
            "action" : "LOGOUT"
        }

        $.ajax({
            url : "./data/applicationLayer.php",
            type: "POST",
            dataType: "json",
            data: jsonToSend,
            ContentType: "application/json",
            success : function(data) {
                window.location = "index.php";
            },
            error : function(data) {
                alert("Error to logout: " + data);
            }
        });
});
});
