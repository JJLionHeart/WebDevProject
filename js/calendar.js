$(document).ready(function() {
    var myevents = [];
    $.ajax({
        url : "./data/applicationLayer.php",
        type: "POST",
        dataType: "json",
        data: {
            "action" : "GETTASKS"
        },
        ContentType: "application/json",
        success: function(data) {
            var jsons = jQuery.parseJSON(data.DATA);
            console.log(jsons);
            var newHTML = "";
            for(var i = 0; i < data.NUM_ROWS; i++) {
                var task = jQuery.parseJSON(jsons[i]);
                console.log(task);
                myevents.push({
                    title: task.content,
                    start: task.start_date, //No debe de incluir la hora
                    color:"#673ab7",
                    end: task.deadline
                })
                console.log(events);
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
            var jsons = jQuery.parseJSON(data.DATA);
            console.log(jsons);
            var newHTML = "";
            for(var i = 0; i < data.NUM_ROWS; i++) {
                var task = jQuery.parseJSON(jsons[i]);
                myevents.push({
                    title: task.name,
                    start: task.start_date, //No debe de incluir la hora
                    color:"#ff9800",
                    end: task.deadline
                })
            }
        },
        error: function(data) {
           alert("An error ocurred while getting Tasks: "+ data.statusText);
        }
     });
    
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        defaultDate: '2017-11-13',
        navLinks: true, // can click day/week names to navigate views
        eventLimit: false, // allow "more" link when too many events
        handleWindowResize: true,
        weekends: false, // Hide weekends
        defaultView: 'month', // Only show week view
        displayEventTime: true, // Display event time
        editable: false,
        minTime: '07:30:00', // Start time for the calendar
        maxTime: '22:00:00', // End time for the calendar
        events : myevents
    });
    
});