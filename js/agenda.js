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
                 var task = jQuery.parseJSON(jsons[i]);
                 newHTML += "<li class='collection-item avatar'> <img src='user.png' alt='' class='circle'><span class='title'>Title</span>";
                 newHTML += "<p>First Line <br>Second Line</p><a href='#!' class='secondary-content'><i class='material-icons'>grade</i></a></li>'";
            }
            $("#agenda").append(newHTML);
        },
        error: function(data) {
           alert("An error ocurred while getting Tasks: "+data.statusText);
        }
     });
     $("#search").click(findFriend(name));
});
function findFriend(name) {
    
}
