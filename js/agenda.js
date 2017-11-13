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

      $("#contactsInfo").on("click",".button",function(){
           var user = $(this).parent().attr('id');
           console.log(user);
           $.ajax({
            url : "./data/applicationLayer.php",
            type: "POST",
            dataType: "json",
            data: {
                "action" : "FRIENDREQUEST",
                "PERSON": user
            },
            ContentType: "application/json",
            success: function(data) {
                alert("New contact");
            },
            error: function(data) {
               alert("An error ocurred while getting Tasks: "+data.statusText);
            }
         });
      });

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
function findFriend(name) {
    var index = name.indexOf(" ");  // Gets the first index where a space occours
    var first = name.substr(0, index); // Gets the first part
    var last = name.substr(index + 1);  // Gets the text part

    $.ajax({
        url : "./data/applicationLayer.php",
        type: "POST",
        dataType: "json",
        data: {
            "action" : "SEARCH",
            "FIRST_NAME": first,
            "LAST_NAME" : last
        },
        ContentType: "application/json",
        success: function(data) {
            var jsons =jQuery.parseJSON(data.DATA);
            var newHTML = "";
            for(var i = 0; i < data.COUNT; i++) {
                 var contacto = jQuery.parseJSON(jsons[i]);
                 console.log(contacto);
                 newHTML += "<li id='"+contacto.USERNAME+"' class='collection-item avatar'> <img src='user.png' alt='' class='circle'><span class='title'>"+ contacto.USERNAME+"</span>";
                 newHTML += "<p>"+contacto.FIRST_NAME+" "+contacto.LAST_NAME+"<br>"+contacto.EMAIL+"</p><button class='button' type='button'>Add</button></li>'";
            }
            $("#contactsInfo").append(newHTML);
        },
        error: function(data) {
           alert("An error ocurred while getting Tasks: "+data.statusText);
        }
     });
}