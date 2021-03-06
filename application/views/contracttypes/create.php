<?php 
/**
 * This view allows an HR admin to create a new leave type.
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.2.0
 */
?>

<?php $attributes = array('id' => 'formCreateLeaveType');
echo form_open('contracttypes/create', $attributes); ?>
    <label for="name"><?php echo lang('leavetypes_popup_create_field_name');?></label>
    <input type="text" name="name" id="name" pattern=".{1,}" required />
   <label for="alias"><?php echo lang('contracttypes_popup_update_field_alias');?></label>
   <input type="text" name="alias" id="alias"  />
    <label for="description"><?php echo lang('contracttypes_popup_update_field_description');?></label>
    <textarea name="description" id="description"></textarea>
    <br />
	<button id="cmdCreateLeaveType" class="btn btn-primary"><?php echo lang('contracttypes_popup_create_button_create');?></button>
</form>


<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<script type="text/javascript">
    $(function () {
        //Check if the leave type is unique
        $('#cmdCreateLeaveType').click(function() {
            var typeNames = [<?php echo implode(', ', array_map(function ($entry) { return '"' . $entry['name'] . '"'; }, $leavetypes)); ?>];
            if (typeNames.indexOf($('#name').val()) > -1) {
                bootbox.alert("<?php echo lang('leavetypes_js_unique_error_msg');?>");
            } else {
                //$('#formCreateLeaveType').submit();
            }
        });
        
        //Suggest an acronym by using the first letters of the leave type name
        $('#cmdSuggestAcronym').click(function() {
            var toMatch = $('#name').val();
            var result = toMatch.replace(/(\w)\w*\W*/g, function (_, i) {
                return i.toUpperCase();
              });
            $('#acronym').val(result);
        });
    });
</script>
