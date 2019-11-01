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
            $('#calendar').fullCalendar({
            eventSources: [
                    {
                        color: '#306EFE',   
                        textColor: '#ffffff',
                        events: [
                            {
                                title: 'My Big Event',
                                start: '2019-02-09',
                                end: '2019-02-10'
                            },
                            {
                                title: 'My Second Big Event',
                                start: '2019-02-11',
                                end: '2019-02-13'
                            }  
                        ]
                    }
            ],
            header: {
                    left: 'prev,next',
                    center: 'title',
                    right: ''
                },
        
            });
        });

</script>

