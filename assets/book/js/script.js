$(document).ready(function() {
    var SITEURL = '<?php echo base_url(); ?>';



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
            url: "/booking/delete",
            data: { id: eventID },
            type: "POST",
            success: function(json) {
                //console.log(json);
                if (json == 1)
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

        $.ajax({
            url: "booking/insert",
            data: { 'title': title, 'start': startTime, 'end': endTime },
            type: "POST",
            success: function(json) {
                $("#calendar").fullCalendar('renderEvent', {
                        id: json.id,
                        title: title,
                        start: startTime,
                        end: endTime,
                    },
                    true);
            }
        });

    }
});