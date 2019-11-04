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
        <h2><?php echo lang('timesheet_title'); ?></h2>
        <div class="row-fluid">
            <div class="span12">
                <?php echo lang('timesheet_description'); ?>
            </div>
        </div>  
    
        <div id='calendar'></div>
        <br/>
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
   
    $(document).ready(function() {
        var userid = <?php echo $this->session->userdata('id');?>;
            $('#calendar').fullCalendar({
                editable: true,
                selectable: true,
                droppable: true,
            events: "<?php echo base_url();?>project/loadData?id=" + userid,
            // events: function (start, end, timezone, callback) {
            //             $.ajax({
            //                 url: "<?php echo base_url();?>project/loadData?id=" + userid,
            //                 dataType: 'json',
                            
            //                 success: function (msg) {
            //                     var events = [];
            //                     var data = msg.events;
            //                     $.each(data, function (e) {
            //                         events.push({
            //                             title: data[e].title,
            //                             start: data[e].start_event
            //                         });
            //                     });
            //                     callback(events);
            //                 },
            //                 error: function () {
            //                     alert('there was an error while fetching events!');
            //                 },
            //             });

            //         },
            eventClick: function(event, jsEvent, view) {
                console.log(event.id );
                
              
                endtime = $.fullCalendar.moment(event.end).format('h:mm');
                starttime = $.fullCalendar.moment(event.start).format('dddd, MMMM Do YYYY, h:mm');
                var mywhen = starttime + ' - ' + endtime;
                 $('#calendarModal').modal();
               //alert(mywhen);
            },
             //header and other values
            select: function (start, end, jsEvent, view) {
                $("#calendar").fullCalendar('addEventSource', [{
                    start: start,
                    end: end,
                    //rendering: 'background',
                    block: true,
                }, ]);
            // $("#calendar").fullCalendar("unselect");
            //alert(start);
            //alert(end);
            },
            selectOverlap: function(event) {
                return ! event.block;
            },
             eventDrop: function(event, delta, revertFunc) {
                 console.log(event);
                var start= moment(event.start).format();
                 var end = moment(event.end).format();
                var txt = start + ":" + end;
                $('#createEventModal #when').text(txt);
               $('#createEventModal').modal();

                // if (!confirm("Are you sure about this change?")) {
                // info.revert();
                // }
            },
            header: {
                    left: 'prev,next',
                    center: 'title',
                    right: ''
                },
        
            });
        });

</script>

