$(document).ready(function(){
				
        var calendar = $('#calendar').fullCalendar({
            header:{
                left: 'prev,next today',
                center: 'title',
                right: 'agendaWeek,agendaDay'
            },
            defaultView: 'agendaWeek',
            editable: true,
            selectable: true,
            allDaySlot: false,
            
            events:  "/booking/loadData",
   
            
            eventClick:  function(event, jsEvent, view) {
                console.log(event.id + ":" +event.start);
                endtime = $.fullCalendar.moment(event.end).format('h:mm');
                starttime = $.fullCalendar.moment(event.start).format('dddd, MMMM Do YYYY, h:mm');
                var mywhen = starttime + ' - ' + endtime;
                $('#modalTitle').html(event.title);
                $('#modalWhen').text(mywhen);
                $('#eventID').val(event.id);
                $('#calendarModal').modal();
            },
            
            //header and other values
            select: function(start, end, jsEvent) {
                endtime = $.fullCalendar.moment(end).format('h:mm');
                starttime = $.fullCalendar.moment(start).format('dddd, MMMM Do YYYY, h:mm');
                var mywhen = starttime + ' - ' + endtime;
                start = moment(start).format();
                end = moment(end).format();
                $('#createEventModal #startTime').val(start);
                $('#createEventModal #endTime').val(end);
                $('#createEventModal #when').text(mywhen);
                $('#createEventModal').modal('toggle');
           },
           eventDrop: function(event, delta){
			   console.log(event);
               $.ajax({
                   url  : "booking/update",
                   data: {'title': event.title,'start': moment(event.start).format(),'end':moment(event.end).format(),
                   'id':event.id },
                   type: "POST",
                   success: function(json) {
                   //alert(json);
                   }
               });
           },
           eventResize: function(event) {
			   console.log(event);
               $.ajax({
                   url  : "booking/update",
                   data: {'title':event.title,'start':moment(event.start).format(),
                   'end': moment(event.end).format(),'id':event.id},
                   type: "POST",
                   success: function(json) {
                       //alert(json);
                   }
               });
           }
        });
               
       $('#submitButton').on('click', function(e){
           // We don't want this to act as a link so cancel the link action
           e.preventDefault();
           doSubmit();
       });
       
       $('#deleteButton').on('click', function(e){
           // We don't want this to act as a link so cancel the link action
           e.preventDefault();
           doDelete();
       });
       
       function doDelete(){
           
           $("#calendarModal").modal('hide');
           var eventID = $('#eventID').val();
           
           $.ajax({
               url  : "/booking/delete",
               data: { id : eventID },
               type: "POST",
               success: function(json) {
                   //console.log(json);
                    if(json == 1)
                        $("#calendar").fullCalendar('removeEvents',eventID);
                   else
                        return false;                   
                   
               }
           });
       }
       function doSubmit(){
           $("#createEventModal").modal('hide');
           var title = $('#title').val();
           var startTime = $('#startTime').val();
           var endTime = $('#endTime').val();
           
           $.ajax({
               url  : "booking/insert",
               data: {'title':title, 'start':startTime, 'end':endTime},
               type: "POST",
               success: function(json) {
                   //console.log(json);
                   $("#calendar").fullCalendar('renderEvent',
                   {
                       id: json.id,
                       title: title,
                       start: startTime,
                       end: endTime,
                   },
                   true);
                   console.log(json);
                   doReoald();
               }
           });
           
       }
       function doReoald(){
           $.ajax({
               url  : "booking/loadData",              
               type: "GET",
               success: function(json) {
                  
                   //console.log(json);
               }
           });
           
       }
    });