    <div class="row-fluid">
        <div class="span12">

            <!-- <div class="row-fluid">
                <div class="span6">
                    <button id="cmdPrevious" class="btn btn-primary"><i class="mdi mdi-chevron-left"></i></button>
                    <button id="cmdToday" class="btn btn-primary">today</button>
                    <button id="cmdNext" class="btn btn-primary"><i class="mdi mdi-chevron-right"></i></button>
                </div>
                <div class="span6">
                    <div class="pull-right">
                        <button id="cmdDisplayDayOff" class="btn btn-primary"><i class="mdi mdi-calendar"></i>&nbsp;Days off</button>
                    </div>
                </div>
            </div> -->
            <div class="row-fluid">
                <div class="span12">&nbsp;</div>
            </div>
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

            <input type="hidden" id="startTime"/>
            <input type="hidden" id="endTime"/>



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
        <input type="hidden" id="eventID"/>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <button type="submit" class="btn btn-danger" id="deleteButton">Delete</button>
        </div>
    </div>
</div>
</div>
<!--Modal-->
<script>
$(function() {
   <?php if ($this->config->item('csrf_protection') == TRUE) {?>
    $.ajaxSetup({
        data: {
            <?php echo $this->security->get_csrf_token_name();?>: "<?php echo $this->security->get_csrf_hash();?>",
        }
    });
<?php }?>
});
</script>
<link href="<?php echo base_url();?>assets/fullcalendar-2.8.0/fullcalendar.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar-2.8.0/lib/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar-2.8.0/fullcalendar.min.js"></script>
<?php if ($language_code != 'en') {?>
<script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar-2.8.0/lang/<?php echo strtolower($language_code);?>.js"></script>
<?php }?>
<script src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<script src="<?php echo base_url();?>assets/js/clipboard-1.6.1.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/book/js/script.js"></script>