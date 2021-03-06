$(document).ready(function() {
    var SITEURL = '<?php echo base_url(); ?>';
    var base_url = window.location.origin;


    $('#submitButton').on('click', function(e) {
        // We don't want this to act as a link so cancel the link action
        e.preventDefault();
        doSubmit();
    });

    $('#deleteButton').on('click', function(e) {
        // We don't want this to act as a link so cancel the link action
        e.preventDefault();
        doDelete();
    });

    function doDelete() {

        $("#calendarModal").modal('hide');
        var eventID = $('#eventID').val();
        $.ajax({
            url: base_url+"/booking/delete",
            data: { id: eventID },
            type: "POST",
            success: function(json) {
                //console.log(json);
                if (json)
                    $("#calendar").fullCalendar('removeEvents', eventID);
                else
                    return false;

            }
        });
    }

    function doSubmit() {
        $("#createEventModal").modal('hide');
        var title = $('#title').val();
        var startTime = $('#startTime').val();
        var endTime = $('#endTime').val();
		var roomid = $('#roomid').val();
        $.ajax({
            url: base_url+"/booking/insert",
            data: { 'title': title, 'start': startTime, 'end': endTime, 'roomid': roomid },
            type: "POST",
            success: function(json) {
				//console.log(JSON.parse(json));
                json = JSON.parse(json);
                var id = json.id;
                $("#calendar").fullCalendar('renderEvent', {
                        id: id,
                        title: title,
                        start: startTime,
                        end: endTime,
                        uid: json.uid
                    },
                    true);
            }
        });

    }
});