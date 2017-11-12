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
            newHTML += "<li id="+ task.taskId + " class= 'collection-item' style='touch-action: pan-y;'>";
            newHTML += "<input id=individual-task"+task.taskId+" type='checkbox'> <label for=individual-task"+task.taskId+">"+task.content+"</br>"+"<a href='#!' class='secondary-content'>";
            newHTML += "<span class='ultra-small right'>" + task.deadline +"</span></a></label></li>";
            $("#tasks").append(newHTML);
       }
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
    var jsons =jQuery.parseJSON(data.DATA);
    var newHTML = "";
    for(var i = 0; i < data.NUM_ROWS; i++) {
         var project = jQuery.parseJSON(jsons[i]);
         console.log("Hola");
         console.log(project);
         newHTML += "<li id="+ project.project_id + " class= 'collection-item' style='touch-action: pan-y;'>";
         newHTML += "<input id=project-tasks"+project.project_id+" type='checkbox'> <label for=project-tasks"+project.project_id+">"+project.name+"</br>"+"<a href='#!' class='secondary-content'>";
         newHTML += "<span class='ultra-small right'>" + project.description +"</span></a></label></li>";
         $("#projects").append(newHTML);
    }

       // La idea es exactamente igual que con tasks
       // Data contiene dos campos utiles
       // 1) data.NUM_ROWS contiene el numero de tasks que hay en la base
       //    de datos para este usuario en particular
       // 2) data.DATA contiene una string que representa un arreglo de jsons,
       //    para recuperarlo puedes usar la siguiente funcion:
       //    var jsons = jQuery.parseJSON(data.DATA).
       //
       //    Cada string dentro del arreglo es, a su vez, otro json que 
       //    representa un proyecto individual:
       //
       //    var proyecto1 = jQuery.parseJSON(jsons[0])
       //
       //    Cada proyecto tiene 4 atributos: id, name, description, y deadline
       //    console.log(proyecto1.id)
       //    console.log(proyecto1.name)
       //    console.log(proyecto1.description)
       //    console.log(proyecto1.deadline)
       //
       //    La idea es que iteres por el arreglo de jsons de tareas (var tarea1)
       //    y vayas recuperando cada json en base al numero de tareas (data.NUM_ROWS)
       //    y despliegues la informacion en el frontend
       console.log(data.DATA);
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
