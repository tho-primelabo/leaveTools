<?php
/**
 * This view displays the leave requests of the connected user.
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.1.0
 */
?>
<div class="row-fluid">
    <div class="span12">
        <h2>Booking</h2>
        <div class="row-fluid">
            <div class="span12">
                <?php echo lang('booking_description'); ?>
            </div>
        </div>
        <!-- <div class="row-fluid">
            <div class="span6">
                <button id="cmdPrevious" class="btn btn-primary"><i class="mdi mdi-chevron-left"></i></button>
                <button id="cmdToday" class="btn btn-primary">
                    <?php echo lang('today'); ?>
                </button>
                <button id="cmdNext" class="btn btn-primary"><i class="mdi mdi-chevron-right"></i></button>
            </div>
            <div class="span6">
                <div class="pull-right">
                    <button id="cmdDisplayDayOff" class="btn btn-primary"><i class="mdi mdi-calendar"></i>&nbsp;<?php echo lang('calendar_individual_day_offs'); ?></button>
                </div>
            </div>
        </div> -->
        <div id='calendar'></div>
    </div>
</div>
<!-- Modal -->
<div id="createEventModal" class="modal hide fade">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Event</h4>
            </div>
            <div class="modal-body">
                <div class="control-group">
                    <label class="control-label" for="inputPatient">Event:</label>
                    <div class="field desc">
                        <input class="form-control" id="title" name="title" placeholder="Event" type="text" value="">
                    </div>
                </div>

                <input type="hidden" id="startTime" />
                <input type="hidden" id="endTime" />
                <input type="hidden" id="roomid" />

                <div class="control-group">
                    <label class="control-label" for="when">When:</label>
                    <div class="controls controls-row" id="when" style="margin-top:5px;">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button type="submit" class="btn btn-primary" id="submitButton">Save</button>
            </div>
        </div>

    </div>
</div>

<div id="calendarModal" class="modal hide fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Event Details</h4>
            </div>
            <div id="modalBody" class="modal-body">
                <h4 id="modalTitle" class="modal-title"></h4>
                <div id="modalWhen" style="margin-top:5px;"></div>
            </div>
            <input type="hidden" id="eventID" />
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button type="submit" class="btn btn-danger" id="deleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>
<!--Modal-->
<link href="<?php echo base_url(); ?>assets/fullcalendar-2.8.0/fullcalendar.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fullcalendar-2.8.0/lib/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fullcalendar-2.8.0/fullcalendar.min.js"></script>
<?php if ($language_code != 'en') {?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fullcalendar-2.8.0/lang/<?php echo strtolower($language_code); ?>.js"></script>
<?php }?>
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/clipboard-1.6.1.min.js"></script>
<script type="text/javascript">
	$(function() {
   <?php if ($this->config->item('csrf_protection') == true) {?>
    $.ajaxSetup({
        data: {
            <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>",
        }
    });
	<?php }?>
	});
	//Global Ajax error handling mainly used for session expiration
    $(document).ajaxError(function(event, jqXHR, settings, errorThrown) {
        $('#frmModalAjaxWait').modal('hide');
        if (jqXHR.status == 401) {
            bootbox.alert("<?php echo lang('global_ajax_timeout'); ?>", function() {
                //After the login page, we'll be redirected to the current page
                location.reload();
            });
        } else { //Oups
            bootbox.alert("<?php echo lang('global_ajax_error'); ?>");
        }
    });

    $(document).ready(function() {
        var url = window.location;
        var url_array = url.toString().split('/') // Split the string into an array with / as separator
        var roomid = url_array[url_array.length - 1]
        $('#roomid').val(roomid);
        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,today,next',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'agendaWeek',
            editable: true,
            selectable: true,
            selectOverlap: false,
            allDaySlot: false,

            events: "<?php echo base_url();?>booking/loadData?roomid=" + roomid,

            eventClick: function(event, jsEvent, view) {
                //console.log(event.id + ":" +event.start.format('dddd, MMMM Do YYYY, h:mm'));
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
                if (start.isBefore(moment())) {
                    $('#calendar').fullCalendar('unselect');
                    return false;
                }
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
            eventDrop: function(event, delta) {
                console.log(event);
                $.ajax({
                    url: "update",
                    data: {
                        'title': event.title,
                        'start': moment(event.start).format(),
                        'end': moment(event.end).format(),
                        'id': event.id,
                        'roomid': roomid
                    },
                    type: "POST",
                    success: function(json) {
                        //alert(json);
                    }
                });
            },
            eventResize: function(event) {
                console.log(event);
                $.ajax({
                    url: "update",
                    data: {
                        'title': event.title,
                        'start': moment(event.start).format(),
                        'end': moment(event.end).format(),
                        'id': event.id,
                        'roomid': roomid
                    },
                    type: "POST",
                    success: function(json) {
                        //alert(json);
                    }
                });
            }
        });

        //Manage Prev/Next buttons
        $('#cmdNext').click(function() {
            $('#calendar').fullCalendar('next');
        });
        $('#cmdPrevious').click(function() {
            $('#calendar').fullCalendar('prev');
        });

        //On click on today, if the current month is the same than the displayed month, we refetch the events
        $('#cmdToday').click(function() {
            var displayedDate = new Date($('#calendar').fullCalendar('getDate'));
            var currentDate = new Date();
            if (displayedDate.getMonth() == currentDate.getMonth()) {
                $('#calendar').fullCalendar('refetchEvents');
            } else {
                $('#calendar').fullCalendar('today');
            }
        });
    });

</script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/book/js/script.js"></script>