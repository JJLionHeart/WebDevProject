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
       var jsons = jQuery.parseJSON(jQuery.parseJSON(data.DATA));
       console.log(jsons);
       var newHTML = "";
       console.log(jsons[0].deadline);
       for(var i = 0; i < data.NUM_ROWS; i++) {
            newHTML += "<li id="+ i + " class= 'collection-item' style='touch-action: pan-y;'>";
            newHTML += "<input id=individual-task"+i+" type='checkbox'> <label for=individual-task"+i+">"+jsons[i].content+"<a href='#!' class='secondary-content'>";
            newHTML += "<span class='ultra-small right'>" + jsons[i].deadline +"</span></a></label></li>";
            $("#tasks").append(newHTML);
       }


   
       // Data contiene dos campos utiles
       // 1) data.NUM_ROWS contiene el numero de tasks que hay en la base
       //    de datos para este usuario en particular
       // 2) data.DATA contiene una string que representa un arreglo de jsons,
       //    para recuperarlo puedes usar la siguiente funcion:
       //    var jsons = jQuery.parseJSON(data.DATA).
       //
       //    Cada string dentro del arreglo es, a su vez, otro json que 
       //    representa una tarea individual:
       //
       //    var tarea1 = jQuery.parseJSON(jsons[0])
       //
       //    Cada tarea tiene 2 atributos: content y deadline
       //    console.log(tarea1.content)
       //    console.log(tarea1.deadline)
       //
       //    La idea es que iteres por el arreglo de jsons de tareas (var tarea1)
       //    y vayas recuperando cada json en base al numero de tareas (data.NUM_ROWS)
       //    y despliegues la informacion en el frontend
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

}
