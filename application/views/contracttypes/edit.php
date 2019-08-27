<?php $attributes = array('id' => 'formEditContractType');
echo form_open('contracttypes/edit/' . $id, $attributes); ?>
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <label for="name"><?php echo lang('contracttypes_popup_update_field_name');?></label>
    <input type="text" name="name" id="name" value="<?php echo $contracttypes['name']; ?>" />
    <label for="alias"><?php echo lang('contracttypes_popup_update_field_alias');?></label>
    <input type="text" name="alias" id="alias" value="<?php echo $contracttypes['alias']; ?>" />
    <label for="description"><?php echo lang('contracttypes_popup_update_field_description');?></label>
    <textarea name="description" id="description"><?php echo $contracttypes['description']; ?></textarea>
    <br />
</form>
<button id="cmdEditContractType" class="btn btn-primary"><?php echo lang('contracttypes_popup_update_button_update');?></button>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<script type="text/javascript">
    $(function () {
        //Check if the leave type is unique
        $('#cmdEditContractType').click(function() {
            $('#formEditContractType').submit();
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
