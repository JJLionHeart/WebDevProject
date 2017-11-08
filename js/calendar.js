$(document).ready(function() {
    
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        defaultDate: '2017-10-12',
        navLinks: true, // can click day/week names to navigate views
        eventLimit: true, // allow "more" link when too many events
        handleWindowResize: true,
        weekends: false, // Hide weekends
        defaultView: 'month', // Only show week view
        displayEventTime: true, // Display event time
        editable: false,
        minTime: '07:30:00', // Start time for the calendar
        maxTime: '22:00:00', // End time for the calendar

        events: [
            {
                title: 'All Day Event',
                start: '2017-10-01',
                color: '#FF1744'
            },
            {
                title: 'Long Event',
                start: '2017-10-07',
                end: '2017-10-10',
                color: '#FF1744'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2017-10-09T16:00:00'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2017-10-16T16:00:00',
                color: '#FF1744'
            },
            {
                title: 'Conference',
                start: '2017-10-11',
                end: '2017-10-13'
            },
            {
                title: 'Meeting',
                start: '2017-10-12T10:30:00',
                end: '2017-10-12T12:30:00'
            },
            {
                title: 'Lunch',
                start: '2017-10-12T12:00:00'
            },
            {
                title: 'Meeting',
                start: '2017-10-12T14:30:00'
            },
            {
                title: 'Happy Hour',
                start: '2017-10-12T17:30:00'
            },
            {
                title: 'Dinner',
                start: '2017-10-12T20:00:00'
            },
            {
                title: 'Birthday Party',
                start: '2017-10-13T07:00:00'
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2017-10-28'
            }
        ]
    });
    
});