<?php 
/**
 * This view allows an HR admin to modify a position (occupied by an employee).
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/tho-primelabo/leavetools
 * @since         0.2.0
 */
?>

<h2><?php echo lang('rooms_edit_title');?><?php echo $rooms['id']; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('rooms/edit/' . $rooms['id']) ?>

    <label for="name"><?php echo lang('rooms_edit_field_name');?></label>
    <input type="text" name="name" id="name" value="<?php echo $rooms['name']; ?>" autofocus required /><br />

   

    <br /><br />
    <button type="submit" class="btn btn-primary"><i class="mdi mdi-check"></i>&nbsp;<?php echo lang('rooms_edit_button_update');?></button>
    &nbsp;
    <a href="<?php echo base_url();?>rooms" class="btn btn-danger"><i class="mdi mdi-close"></i>&nbsp;<?php echo lang('rooms_edit_button_cancel');?></a>
</form>
