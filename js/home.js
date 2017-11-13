$(document).ready(function() {
    MaterializeCollectionActions.configureActions($('#projects'), [
        {
            name: 'delete',
            callback: function (collectionItem, collection) {
                $(collectionItem).remove();
                console.log($(collectionItem).attr("id"));
                deleteProject($(collectionItem).attr("id"));
            }
            }
    ]);

    MaterializeCollectionActions.configureActions($('#tasks'), [
        {
            name: 'delete',
            callback: function (collectionItem, collection) {
                $(collectionItem).remove();
                console.log($(collectionItem).attr("id"));
                deleteTask($(collectionItem).attr("id"));
            }
            }
    ]);

//Create tasks
$("#modal1").click(function (){
    $("#createTask").modal();
    $("#task-name").val("");
    $("#task-deadline").val("");
    $("#task-startdate").val("");
    $("#submit-task").show();
    $("#modify-task").hide();
    $("#createTask").openModal();
});

$("#modal2").click(function (){
    $("#createProject").modal();
    $("#project-name").val("");
    $("#project-deadline").val("");
    $("#project-startdate").val("");
    $("#project-description").val("");
    $("#submit-project").show();
    $("#modify-project").hide();
    $("#createProject").openModal();
});


$('.datepicker').pickadate({
  format: 'mm/dd/yyyy',
  selectMonths: true,
  selectYears: 15,
});

$("#tasks").on("click",".collection-item", function(){
    var id = $(this).attr("id");
    var taskId = id.replace('<href=#','');
    $("#createTask").modal();
    var allTasks = localStorage.getItem("allTasks");
    var jsons = jQuery.parseJSON(allTasks);
    console.log(allTasks);
    for(var i = 0; i < jsons.length; i++) {
        var task = jQuery.parseJSON(jsons[i]);
        console.log(taskId);
        if(taskId == task.id) {
            console.log("n");
            localStorage.setItem("modifyIdTask", taskId);            
            $("#task-name").val(task.content);
            $("#task-deadline").val(task.deadline);
            $("#task-startdate").val(task.start_date);
            $("#submit-task").hide();
            $("#modify-task").show();
            $('.modal').modal('open');
        }
   }
});

$("#projects").on("click",".collection-item", function(){
    var id = $(this).attr("id");
    var projectId = id.replace('<href=#','');
    $("#createProject").modal();
    var allProjects = localStorage.getItem("allProjects");
    var jsons = jQuery.parseJSON(allProjects);
    console.log(allProjects);
    for(var i = 0; i < jsons.length; i++) {
        var project = jQuery.parseJSON(jsons[i]);
        console.log(projectId);
        if(projectId == project.id) {
            console.log("n");
            localStorage.setItem("modifyIdProject", projectId);            
            $("#project-name").val(project.name);
            $("#project-description").val(project.description);
            $("#project-startdate").val(project.start_date);
            $("#project-deadline").val(project.deadline);
            $("#submit-project").hide();
            $("#modify-project").show();
            $('.modal').modal('open');
        }
   }
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

       var allTasks = data.DATA;
       localStorage.setItem("allTasks", allTasks);

       var newHTML = "";
       for(var i = 0; i < data.NUM_ROWS; i++) {
            var task = jQuery.parseJSON(jsons[i]);
            newHTML += "<li id="+ task.id+ "<href=# data-toggle='modal' data-target='#createTask' class= 'collection-item' style='touch-action: pan-y;'>";
            newHTML += "<input id=project-tasks"+task.id + " type='checkbox'> <label for=project-tasks"+task.id+">"+task.content+"</br>"+"</label></li>";
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
    var allProjects = data.DATA;
    localStorage.setItem("allProjects", allProjects);

    var newHTML = "";
    for(var i = 0; i < data.NUM_ROWS; i++) {
         var project = jQuery.parseJSON(js[i]);
         newHTML += "<li id="+ project.id+ "<href=# data-toggle='modal' data-target='#createProject' class= 'collection-item' style='touch-action: pan-y;'>";
         newHTML += "<input id=project-tasks"+project.id + " type='checkbox'> <label for=project-tasks"+project.id+">"+project.name+":  </br>"+"<a href='#!' class='secondary-content'>";
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

//modify task
$("#modify-task").click(modifyTask);
$("#modify-project").click(modifyProject);


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

function modifyTask(){
    var content = $("#task-name").val();
    var deadline = $("#task-deadline").val();
    var start_date = $("#task-startdate").val();
    var id = Number(localStorage.getItem("modifyIdTask"));
    $.ajax({
        url : "./data/applicationLayer.php",
        type: "POST",
        dataType: "json",
        data: {
            "action" : "MODIFYTASK",
            "CONTENT" : content,
            "DEADLINE" : deadline,
            "START_DATE" : start_date,
            "ID" : id
        },
        ContentType: "application/json",
        success: function(data) {
            alert("Task modified.");
            location.reload();
        },
        error: function(data) {
           alert("An error ocurred while getting Tasks: "+data.statusText);
        }
     });
}

function modifyProject(){
    var name = $("#project-name").val();
    var deadline = $("#project-deadline").val();
    var start_date = $("#project-startdate").val();
    var description = $("#project-description").val();
    var id = Number(localStorage.getItem("modifyIdProject"));
    $.ajax({
        url : "./data/applicationLayer.php",
        type: "POST",
        dataType: "json",
        data: {
            "action" : "MODIFYPROJECT",
            "NAME" : name,
            "DESCRIPTION" : description,
            "START_DATE" : start_date,
            "DEADLINE" : deadline,
            "ID" : id
        },
        ContentType: "application/json",
        success: function(data) {
            alert("Task modified.");
            location.reload();
        },
        error: function(data) {
           alert("An error ocurred while getting Tasks: "+data.statusText);
        }
     });
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
