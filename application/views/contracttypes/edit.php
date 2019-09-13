<?php echo validation_errors(); ?>
<?php $attributes = array('id' => 'formEditContractType');
echo form_open('contracttypes/edit/' . $id, $attributes); ?>
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <label for="name"><?php echo lang('contracttypes_popup_update_field_name');?></label>
    <input type="text" name="name" id="name" value="<?php echo $contracttypes['name']; ?>" required/>
    <label for="alias"><?php echo lang('contracttypes_popup_update_field_alias');?></label>
    <input type="text" name="alias" id="alias" value="<?php echo $contracttypes['alias']; ?>" />
    <label for="description"><?php echo lang('contracttypes_popup_update_field_description');?></label>
    <textarea name="description" id="description"><?php echo $contracttypes['description']; ?></textarea>
    <br />
	<button id="cmdEditContractType" class="btn btn-primary"><?php echo lang('contracttypes_popup_update_button_update');?></button>
</form>