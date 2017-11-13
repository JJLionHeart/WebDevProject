$(document).ready(function() {
    $.ajax({
        url : "./data/applicationLayer.php",
        type: "POST",
        dataType: "json",
        data: {
            "action" : "GETFRIENDLIST"
        },
        ContentType: "application/json",
        success: function(data) {
            var jsons =jQuery.parseJSON(data.DATA);
            var newHTML = "";
            for(var i = 0; i < data.COUNT; i++) {
                 var contacto = jQuery.parseJSON(jsons[i]);
                 newHTML += "<li class='collection-item avatar'> <img src='user.png' alt='' class='circle'><span class='title'>"+ contacto.USERNAME+"</span>";
                 newHTML += "<p>"+contacto.FIRST_NAME+" "+contacto.LAST_NAME+"<br>"+contacto.EMAIL+"</p><a href='#!' class='secondary-content'><i class='material-icons'>grade</i></a></li>'";
            }
            $("#agenda").append(newHTML);
        },
        error: function(data) {
           alert("An error ocurred while getting Tasks: "+data.statusText);
        }
     });

     $("#search").keypress(function (e) {
        if (e.which == 13) {
          findFriend($("#search").val());
          return false;    //<---- Add this line
        }
      });
});
function findFriend(name) {
   alert("HELLO");
}
