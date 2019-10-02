<?php
/**
 * This view allows an employees (or HR admin/Manager) to create a new leave request
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.1.0
 */
?>
<div class="container h-100 d-flex justify-content-center">
   <h2><?php echo lang('contract_create_title');?></h2>

    <div class="row">
        <div class="span8">

            <?php echo validation_errors(); ?>

            <?php
            $attributes = array('id' => 'frmLeaveForm');
            echo form_open('contracts/create', $attributes)
            ?>

           <label for="name"><?php echo lang('contract_create_field_name');?></label>
            <input type="text" name="name" id="name" autofocus required /><br />         

            <label for="viz_startdate"><?php echo lang('contract_create_field_start_day'); ?></label>
            <input type="text" name="viz_startdate" id="viz_startdate" value="<?php echo set_value('startdate'); ?>" autocomplete="off" required/>
            <input type="hidden" name="startdate" id="startdate" />
            <br/>
            <label for="default_contract_type"><?php echo lang('contract_edit_default_contract_type');?></label>
           
            <select class="" name="default_leave_type" id="default_leave_type">
            <?php foreach ($contract_types as $typeId => $TypeName): ?>
                <option value="<?php echo $typeId; ?>" <?php if ($typeId == $defaultType) echo "selected"; ?>><?php echo $TypeName; ?></option>
            <?php endforeach ?>
            </select>
            <br/>

            <label for="viz_enddate"><?php echo lang('contract_create_field_end_day'); ?></label>
            <input type="text" name="viz_enddate" id="viz_enddate" value="<?php echo set_value('enddate'); ?>" autocomplete="off" required/>
            <input type="hidden" name="enddate" id="enddate" />

            
            <br/><br/>
            <button id="send" class="btn btn-primary"><i class="mdi mdi-check"></i>&nbsp;<?php echo lang('contract_create_button_create');?></button>
                &nbsp;
                <a href="<?php echo base_url(); ?>contracts" class="btn btn-danger"><i class="mdi mdi-close"></i>&nbsp;<?php echo lang('contract_create_button_cancel');?></a>
            </form>

        </div>
    </div>

    
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/flick/jquery-ui.custom.min.css">
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.custom.min.js"></script>
<?php
//Prevent HTTP-404 when localization isn't needed
if ($language_code != 'en') {
    ?>
    <script src="<?php echo base_url(); ?>assets/js/i18n/jquery.ui.datepicker-<?php echo $language_code; ?>.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment-with-locales.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/select2-4.0.5/css/select2.min.css">
<script src="<?php echo base_url(); ?>assets/select2-4.0.5/js/select2.full.min.js"></script>

<?php require_once dirname(BASEPATH) . "/local/triggers/leave_view.php"; ?>
<script>
            $(document).on("click", "#showNoneWorkedDay", function (e) {
                showListDayOffHTML();
            });
</script>
<script type="text/javascript">
    var baseURL = '<?php echo base_url(); ?>';
    var userId = <?php echo $user_id; ?>;
    var leaveId = null;
    var languageCode = '<?php echo $language_code; ?>';
    var dateJsFormat = '<?php echo lang('global_date_js_format'); ?>';
    var dateMomentJsFormat = '<?php echo lang('global_date_momentjs_format'); ?>';

    var noContractMsg = "<?php echo lang('leaves_validate_flash_msg_no_contract'); ?>";
    var noTwoPeriodsMsg = "<?php echo lang('leaves_validate_flash_msg_overlap_period'); ?>";
    

    function validate_form() {
        var fieldname = "";

        //Call custom trigger defined into local/triggers/leave.js
        if (typeof triggerValidateCreateForm == 'function') {
            if (triggerValidateCreateForm() == false)
                return false;
        }

        if ($('#viz_startdate').val() == "")
            fieldname = "<?php echo lang('leaves_create_field_start'); ?>";
        if ($('#viz_enddate').val() == "")
            fieldname = "<?php echo lang('leaves_create_field_end'); ?>";
       
        if (fieldname == "") {
            return true;
        } else {
            bootbox.alert(<?php echo lang('leaves_validate_mandatory_js_msg'); ?>);
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



<?php if ($this->config->item('csrf_protection') == TRUE) { ?>
        $(function () {
            $.ajaxSetup({
                data: {
    <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>",
                }
            });
        });
<?php } ?>
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lms/leave.edit-1.0.js?v=<?= filemtime(dirname(BASEPATH) . '/assets/js/lms/leave.edit-1.0.js'); ?>" type="text/javascript"></script>
