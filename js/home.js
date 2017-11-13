$(document).ready(function() {
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

    MaterializeCollectionActions.configureActions($('#tasks'), [
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

//Create tasks
$("#modal1").click(function (){
    $("#createTask").modal();
    $("#createTask").openModal();
});

$("#modal2").click(function (){
    $("#createProject").modal();
    $("#createProject").openModal();
});


$('.datepicker').pickadate({
  format: 'mm/dd/yyyy',
  selectMonths: true,
  selectYears: 15,
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
            newHTML += "<li id="+ task.id+ " class= 'collection-item' style='touch-action: pan-y;'>";
            newHTML += "<input id=project-tasks"+task.id + " type='checkbox'> <label for=project-tasks"+task.id+">"+task.content+"</br>"+"<a href='#!' class='secondary-content'>";
            newHTML += "<span class='ultra-small right'>  " + task.deadline +"</span></a></label></li>";
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

//Add new task
$("#submit-task").click(addTask);
$("#submit-project").click(addProject);
});


function addTask(){
    var content = $("#task-name").val();
    var deadline = $("#task-deadline").val();
    var start_date = $("#task-startdate").val();
    $.ajax({
        url : "./data/applicationLayer.php",
        type: "POST",
        dataType: "json",
        data: {
            "action" : "ADDTASK",
            "CONTENT" : content,
            "DEADLINE" : deadline,
            "START_DATE" : start_date
        },
        ContentType: "application/json",
        success: function(data) {
            alert("Task created.");
            location.reload();
        },
        error: function(data) {
           alert("An error ocurred while getting Tasks: "+data.statusText);
        }
     });
}

function modifyTask(taskId) {

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

function addProject(){
    var content = $("#project-name").val();
    var description = $("#project-description").val();
    var deadline = $("#project-deadline").val();
    var start_date = $("#project-startdate").val();
    $.ajax({
        url : "./data/applicationLayer.php",
        type: "POST",
        dataType: "json",
        data: {
            "action" : "ADDPROJECT",
            "NAME" : content,
            "DESCRIPTION" : description,
            "START_DATE" : start_date,
            "DEADLINE" : deadline
        },
        ContentType: "application/json",
        success: function(data) {
            alert("Project created.");
            location.reload();
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
