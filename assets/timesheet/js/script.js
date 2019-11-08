$(document).ready(function(){
    
       $('#submitButton').on('click', function(e){
           // We don't want this to act as a link so cancel the link action
           e.preventDefault();
           doSubmit();
       });
       
        $('#updateButton').on('click', function(e){
           // We don't want this to act as a link so cancel the link action
           e.preventDefault();
           doUpdate();
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
               url  : "delete",
               data: { id : eventID },
               type: "POST",
               success: function(json) {
                   //console.log(json);
                    if(json)
                        $("#calendar").fullCalendar('removeEvents',eventID);
                   else
                        return false;                   
                   
               }
           });
       }
       function doSubmit(){
           $("#createEventModal").modal('hide');
           var activity_id = $( "#activity option:selected" ).val();          
           var date = $('#date').val();
           var userid = $('#userid').val();
           var curDate = new Date().toISOString().slice(0, 10);
           var comments = $('#comments').val();
           var hours = $('#hours').val();
           var project_id = $( "#project option:selected" ).val();
           $.ajax({
               url  : "insert",
               data: { 'date': date, 'curDate':curDate, 'comments':comments,'hours':hours,
                     'id':userid, 'project_id': project_id,'activity_id':activity_id
                     },
               type: "POST",
               success: function(json) {
                   //console.log(json);
                   json = JSON.parse(json);
                   var id = json.id;
                   var uid = json.uid;
                   $("#calendar").fullCalendar('renderEvent',
                   {
                       id: id,                       
                       uid: uid,
                       date:date,
                       title: project_id,
                       activity_id: activity_id
                   },
                   true);
                   location.reload();
                  // console.louid: json.uid(json);
                   //doReload();
               }
           });
           
       }

        function doUpdate(){
           $("#createEventModal").modal('hide');
           var activity_id = $( "#eactivity option:selected" ).val();          
           var date = $('#date').val();
           var eventID = $('#eventID').val();
           var curDate = new Date().toISOString().slice(0, 10);
           var comments = $('#ecomments').val();
           var hours = $('#ehours').val();
           var project_id = $( "#eproject option:selected" ).val();
           $.ajax({
               url  : "update",
              async: false,
               data: { 'curDate':curDate, 'comments':comments,'hours':hours,'date':date,
                     'id':eventID, 'project_id': project_id,'activity_id':activity_id
                     },
               type: "POST",
               success: function(json) {
                   //console.log(json);
                   location.reload();
                  // console.louid: json.uid(json);
                   //doReload();
               }
           });
           
       }

       function doReload(){
           $.ajax({
               url  : "loadData",              
               type: "GET",
               success: function(json) {
                  
                   //console.log(json);
               }
           });
           
       }
    });