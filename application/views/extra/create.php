<?php
/**
 * This view allows the creation of a new overtime request.
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.2.0
 */
?>
<div class="container h-100 d-flex justify-content-center">
    <div class="row-fluid">
        <div class="span12">

    <h2><?php echo lang('extra_create_title');?>&nbsp;<?php echo $help;?></h2>

    <?php echo validation_errors(); ?>

    <?php
    $attributes = array('id' => 'frmCreateExtra');
    echo form_open('extra/create', $attributes) ?>
        <div class="input-append date">
            <label for="viz_date" ><?php echo lang('extra_create_field_date');?></label>
            <input type="text" name="viz_date" required id="viz_date" value="<?php echo set_value('date'); ?>" />
             <span class="add-on"><i class="icon-calendar" id="cal1"></i></span>
            <input type="hidden" name="date" id="date" />
        </div>
        <label for="duration" required><?php echo lang('extra_create_field_duration');?></label>
        <input type="text" name="duration" id="duration"  required />&nbsp;<span><?php echo lang('extra_create_field_duration_description');?></span>
        
        <label for="cause"><?php echo lang('extra_create_field_cause');?></label>
        <textarea name="cause" id="cause"><?php echo set_value('cause'); ?></textarea>
        
        <label for="status" required><?php echo lang('extra_create_field_status');?></label>
        <select name="status">

            <option value="1" <?php if ($this->config->item('extra_status_requested') == FALSE) echo 'selected'; ?>><?php echo lang('Planned');?></option>
            <option value="2" <?php if ($this->config->item('extra_status_requested') == TRUE) echo 'selected'; ?>><?php echo lang('Requested');?></option>
        </select>
    </form>

        <div class="row-fluid"><div class="span12">&nbsp;</div></div>
        <div class="row-fluid"><div class="span12">
            <button id="cmdCreateExtra" class="btn btn-primary"><i class="mdi mdi-check"></i>&nbsp; <?php echo lang('extra_create_button_create');?></button>
            &nbsp;
            <a href="<?php echo base_url(); ?>extra" class="btn btn-danger"><i class="mdi mdi-close"></i>&nbsp; <?php echo lang('extra_create_button_cancel');?></a>
        </div></div>
        <div class="row-fluid"><div class="span12">&nbsp;</div></div>
        </div>
    </div>
</div>
    
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/flick/jquery-ui.custom.min.css">
<script src="<?php echo base_url();?>assets/js/jquery-ui.custom.min.js"></script>
<?php //Prevent HTTP-404 when localization isn't needed
if ($language_code != 'en') { ?>
<script src="<?php echo base_url();?>assets/js/i18n/jquery.ui.datepicker-<?php echo $language_code;?>.js"></script>
<?php } ?>
<script src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>

<?php require_once dirname(BASEPATH) . "/local/triggers/extra_view.php"; ?>

<script type="text/javascript">
    function validate_form() {
        var fieldname = "";
        
        //Call custom trigger defined into local/triggers/leave.js
        if (typeof triggerValidateCreateForm == 'function') { 
           if (triggerValidateCreateForm() == false) return false;
        }
        
        if ($('#viz_date').val() == "") fieldname = "<?php echo lang('extra_create_field_date');?>";
        if ($('#duration').val() == "") fieldname = "<?php echo lang('extra_create_field_duration');?>";
        if ($('#cause').val() == "") fieldname = "<?php echo lang('extra_create_field_cause');?>";
        if (fieldname == "") {
            return true;
        } else {
            bootbox.alert(<?php echo lang('extra_create_mandatory_js_msg');?>);
            return false;
        }
    }


    //Disallow the use of negative symbols (through a whitelist of symbols)
    function keyAllowed(key) {
    var keys = [8, 9, 13, 16, 17, 18, 19, 20, 27, 46, 48, 49, 50,
        51, 52, 53, 54, 55, 56, 57, 91, 92, 93
    ];
    if (key && keys.indexOf(key) === -1)
        return false;
    else
        return true;
    }
    
    $(function () {
		var dateToday = new Date();
        $("#viz_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: '<?php echo lang('global_date_js_format');?>',
            altFormat: "dd-mm-yyyy",
            altField: "#date",
			minDate: dateToday
			
        }, $.datepicker.regional['<?php echo $language_code;?>']).datepicker({ dateFormat: 'dd-mm-yy'}).datepicker("setDate", new Date());
        
        //Force decimal separator whatever the locale is
        $("#duration").keyup(function() {
            var value = $("#duration").val();
            value = value.replace(",", ".");
            $("#duration").val(value);
        });
        
        $("#cmdCreateExtra").click(function() {
            if (validate_form()) {
                $("#frmCreateExtra").submit();
            }
        });

<?php if ($this->config->item('disallow_requests_without_credit') == TRUE) {?>
        var durationField = document.getElementById("duration");
        durationField.setAttribute("min", "0");
        durationField.addEventListener('keypress', function(e) {
            var key = !isNaN(e.charCode) ? e.charCode : e.keyCode;
            if (!keyAllowed(key))
            e.preventDefault();
        }, false);

        // Disable pasting of non-numbers
        durationField.addEventListener('paste', function(e) {
            var pasteData = e.clipboardData.getData('text/plain');
            if (pasteData.match(/[^0-9]/))
            e.preventDefault();
        }, false);
<?php }?>
    });
</script>
