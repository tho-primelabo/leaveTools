<?php 
/**
 * This view allows an HR admin to create a new position (occupied by an employee).
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.2.0
 */
?>

<div class="container h-100 d-flex justify-content-center">
<h2><?php echo lang('positions_create_title');?></h2>

<?php echo validation_errors(); ?>

<?php
$attributes = array('id' => 'target');
echo form_open('rooms/create', $attributes); ?>

    <label for="name"><?php echo lang('rooms_create_field_name');?></label>
    <input type="text" name="name" id="name" autofocus required /><br />

        
    <br />
    <button id="send" class="btn btn-primary"><i class="mdi mdi-check"></i>&nbsp;<?php echo lang('rooms_create_button_create');?></button>
    &nbsp;
    <a href="<?php echo base_url(); ?>rooms" class="btn btn-danger"><i class="mdi mdi-close"></i>&nbsp;<?php echo lang('rooms_create_button_cancel');?></a>
</form>
 </div>