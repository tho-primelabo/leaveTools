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
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Timesheet</h4>
            </div>
            <div class="modal-body">
                <div class="control-group">
                    <label class="control-label" for="inputProject">Project:</label>
                    <div class="controls">
                        <select name="project" id="project" class="selectized">
                        </select>
                    </div>
                    
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputActivity">Activity:</label>
                    <div class="controls">
                        <select name="activity" id="activity" class="selectized">                            
                        </select>
                    </div>
                    
                </div>
                <div class="control-group">
                    <label class="control-label" for="when">Hours:</label>
                    <div class="controls controls-row" id="when" style="margin-top:5px;">
                    <input class="form-control" id="hours" name="hours" type="number" value =0>
                    </div>
                </div>
               <div class="field desc">                   
                    <input class="form-control" id="comments" name="comments" placeholder="Comments" type="text">
                    <input type = "hidden" id ='date'/>
                     <input type = "hidden" id ='userid'/>
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
                <h4 class="modal-title">Timesheet Details</h4>
            </div>
            <div id="modalBody" class="modal-body">
                <h4 id="modalTitle" class="modal-title"></h4>
                 <div class="control-group">
                    <label class="control-label" for="inputProject">Project:</label>
                    <div class="controls">
                        <select name="eproject" id="eproject" class="selectPro">
                        </select>
                    </div>
                    
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputActivity">Activity:</label>
                    <div class="controls">
                        <select name="eactivity" id="eactivity" class="selectAct">                            
                        </select>
                    </div>
                    
                </div>
                <div class="control-group">
                    <label class="control-label" for="when">Hours:</label>
                    <div class="controls controls-row" id="when" style="margin-top:5px;">
                    <input class="form-control" id="ehours" name="ehours" type="number">
                    </div>
                </div>
               <div class="field desc">                   
                    <input class="form-control" id="ecomments" name="ecomments" placeholder="Comments" type="text">
                    <input type = "hidden" id ='date'/>
                     <input type = "hidden" id ='userid'/>
                </div>
            </div>
            <input type="hidden" id="eventID" />
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                 <button type="submit" class="btn btn-danger" id="updateButton">Update</button>
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
        $("#userid").val(userid);
            $('#calendar').fullCalendar({
                editable: true,
                selectable: true,
                droppable: true,
            events: "<?php echo base_url();?>timesheet/loadData?id=" + userid,
           
            eventClick: function(event, jsEvent, view) {
                //console.log(jsEvent );
                endtime = $.fullCalendar.moment(event.end).format('h:mm');
                starttime = $.fullCalendar.moment(event.start).format('dddd, MMMM Do YYYY, h:mm');
                var mywhen = starttime + ' - ' + endtime;
                $('#eventID').val(event.id);
                getProjects("eproject");
                getActivities("eactivity");
                getTimesheetById(event.id);
                $('#calendarModal').modal();
                
               //alert(mywhen);
            },
             //header and other values
            select: function (start, end, jsEvent, view) {
                // $("#calendar").fullCalendar('addEventSource', [{
                //     start: start,
                //     end: end,
                //     //rendering: 'background',
                //     block: true,
                // }, ]);
                // $("#calendar").fullCalendar("unselect");
                $("#date").val(new Date(start).toISOString().slice(0, 10));
                //alert(start);
                //alert(end);
                getProjects("project");
                getActivities("activity");
                $('#createEventModal').modal();
                
            },
             eventDrop: function(event, delta, revertFunc) {
                console.log(event);
                var start= moment(event.start).format();
                var end = moment(event.end).format();
                var txt = start + ":" + end;
                $('#createEventModal #when').text(txt);
                //$('#createEventModal').modal(toggle);

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

        function getProjects (name) {
          
            $.ajax({
               url  : "getProjects",
               type: "GET",
               success: function(json) {
                   //console.log(json);
                    projects = JSON.parse(json);
                    //console.log(projects);
                    var box = document.getElementById(name);
                   box.length = 0;
                    projects.forEach(function(item){
                        var opt = document.createElement("option");
                        opt.value = item.project_code;
                        opt.innerHTML = item.name;
                        box.appendChild(opt);
                    });
               }
           })
        }
        function getActivities(name) {
             $.ajax({
               url  : "getActivities",
               type: "GET",
               success: function(json) {
                  
                   //console.log(json);
                   var  projects = JSON.parse(json);
                    //console.log(projects);
                    var box = document.getElementById(name);
                    box.length = 0;
                    projects.forEach(function(item){
                        var opt = document.createElement("option");
                        opt.value = item.id;
                        opt.innerHTML = item.code;
                        //opt[value=val2]').attr('selected','selected');
                        box.appendChild(opt);
                    });
                //     $.each( function(index, value) {
                //        $('#project').append($('<option>').text(value.product).val(value.ID));
                // });
                    //if(json == 1)
                        //$('#createEventModal').modal('toggle');
                   //else
                       // return false;                   
                   
               }
           });
        }

        function getTimesheetById (id) {
          
            $.ajax({
               url  : "getTimesheetByID",
               type: "POST",
               data: { id : id },
               success: function(json) {
                   //console.log(json.comments);
                    json = JSON.parse(json);
                    //console.log(json.comments);
                    $('#ecomments').val(json.comments);
                    $('#ehours').val(json.hours);
                    $("#eproject").val(json.project_id);
                    //console.log(json.activity_id);
                    $("#eactivity").val(json.activity_id);
                    
               }
           })
        }
</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/timesheet/js/script.js"></script>