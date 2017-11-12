//$("#newTask-btn").click("on", createTask);

$(document).ready(function() {
    var colors = ['lightgrey', 'lightblue', 'lightgreen'];
    MaterializeCollectionActions.configureActions($('#tasks'), [
        {
            name: 'delete',
            callback: function (collectionItem, collection) {
                $(collectionItem).remove();
                console.log($(collectionItem).attr("id"));
                deleteTask($(collectionItem).attr("id"));
            }
            },
            {
            name: 'brush',
            callback: function (collectionItem, collection) {
                addTask($(collectionItem));
            }
        }
    ]);

    var colors = ['lightgrey', 'lightblue', 'lightgreen'];
    MaterializeCollectionActions.configureActions($('#projects'), [
        {
            name: 'delete',
            callback: function (collectionItem, collection) {
                $(collectionItem).remove();
                console.log($(collectionItem).attr("id"));
                deleteProject($(collectionItem).attr("id"));
            }
            },
            {
            name: 'brush',
            callback: function (collectionItem, collection) {
                addTask($(collectionItem));
            }
        }
    ]);

$('#modal1').on("click", $("#createTask").modal('open'));

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

$.ajax({
   url : "./data/applicationLayer.php",
   type: "POST",
   dataType: "json",
   data: {
       "action" : "GETTASKS"
   },
   ContentType: "application/json",
   success: function(data) {
       var jsons =jQuery.parseJSON(data.DATA);
       var newHTML = "";
       for(var i = 0; i < data.NUM_ROWS; i++) {
            var task = jQuery.parseJSON(jsons[i]);
            newHTML += "<li id="+ task.id + " class= 'collection-item' style='touch-action: pan-y;'>";
            newHTML += "<input id=individual-task"+task.id+" type='checkbox'> <label for=individual-task"+task.id+">"+task.content+"</br>"+"<a href='#!' class='secondary-content'>";
            newHTML += "<span class='ultra-small right'>" + task.deadline +"</span></a></label></li>";
       }
       $("#tasks").append(newHTML);
   },
   error: function(data) {
      alert("An error ocurred while getting Tasks: "+data.statusText);
   }
});

$.ajax({
   url : "./data/applicationLayer.php",
   type: "POST",
   dataType: "json",
   data: {
       "action" : "GETPROJECTS"
   },
   ContentType: "application/json",
   success: function(data) {
    var js =jQuery.parseJSON(data.DATA);
    var newHTML = "";
    for(var i = 0; i < data.NUM_ROWS; i++) {
         var project = jQuery.parseJSON(js[i]);
         newHTML += "<li id="+ project.id+ " class= 'collection-item' style='touch-action: pan-y;'>";
         newHTML += "<input id=project-tasks"+project.id + " type='checkbox'> <label for=project-tasks"+project.id+">"+project.name+"</br>"+"<a href='#!' class='secondary-content'>";
         newHTML += "<span class='ultra-small right'>" + project.description +"</span></a></label></li>";
         
    }
    $("#projects").append(newHTML);
   },
   error: function(data) {
      alert("An error ocurred while getting Tasks: "+data.statusText);
   }
});
});


function addTask(taskId){
    //Funcion que modifica o agrega una task

}

function deleteTask(taskId) {
    $.ajax({
        url : "./data/applicationLayer.php",
        type: "POST",
        dataType: "json",
        data: {
            "action" : "DELETETASK",
            "ID" : taskId
        },
        ContentType: "application/json",
        success: function(data) {
            console.log("Task deleted");
        },
        error: function(data) {
           alert("An error ocurred while getting Tasks: "+data.statusText);
        }
     });
}

function deleteProject(projectId) {
    $.ajax({
        url : "./data/applicationLayer.php",
        type: "POST",
        dataType: "json",
        data: {
            "action" : "DELETEPROJECT",
            "ID" : projectId
        },
        ContentType: "application/json",
        success: function(data) {
            console.log("Project deleted");
        },
        error: function(data) {
           alert("An error ocurred while getting Tasks: "+data.statusText);
        }
     });
}
