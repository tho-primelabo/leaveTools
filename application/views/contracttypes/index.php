<h2><?php echo lang('contracttypes_type_title'); ?></h2>
<p><?php echo lang('contracttypes_type_description'); ?></p>
<?php echo $flash_partial_view; ?>
<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th scope="col"><?php echo lang('contracttypes_type_thead_id'); ?></th>
            <th scope="col"><?php echo lang('contracttypes_type_thead_name'); ?></th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contracttypes as $type) { ?>
        <tr>
            <td scope="row"><?php echo $type['id'] ?></td>
            <td><?php echo $type['name']; ?></td>
            <td><a href="<?php echo base_url(); ?>contracttypes/edit/<?php echo $type['id'] ?>" data-target="#frmEditContractType" data-toggle="modal" title="<?php echo lang('leavetypes_type_thead_tip_edit'); ?>"><i class="mdi mdi-pencil nolink"></i></a></td>
            <td><a href="#" class="confirm-delete" data-id="<?php echo $type['id']; ?>" title="<?php echo lang('leavetypes_type_thead_tip_delete'); ?>"><i class="mdi mdi-delete nolink"></i></a></td>
        </tr>
        <?php } ?>
        <?php if (count($contracttypes) == 0) { ?>
        <tr>
            <td colspan="5"><?php echo lang('contracttypes_type_not_found'); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<div class="row-fluid">
    <div class="span12">&nbsp;</div>
</div>

<div class="row-fluid">
    <div class="span12">
        <a href="<?php echo base_url(); ?>contracttypes/export" class="btn btn-primary"><i class="mdi mdi-download"></i>&nbsp; <?php echo lang('contracttypes_type_button_export'); ?></a>
        &nbsp;
        <a href="<?php echo base_url(); ?>contracttypes/create" class="btn btn-primary" data-target="#frmAddContractType" data-toggle="modal"><i class="mdi mdi-plus-circle"></i>&nbsp; <?php echo lang('contracttypes_type_button_create'); ?></a>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">&nbsp;</div>
</div>

<div id="frmAddContractType" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmAddContractType').modal('hide');" class="close">&times;</a>
        <h3><?php echo lang('contracttypes_popup_create_title'); ?></h3>
    </div>
    <div class="modal-body">
        <img src="<?php echo base_url(); ?>assets/images/loading.gif">
    </div>
    <div class="modal-footer">
        <a href="#" onclick="$('#frmAddContractType').modal('hide');" class="btn btn-danger"><?php echo lang('contracttypes_popup_create_button_cancel'); ?></a>
    </div>
</div>

<div id="frmEditContractType" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmEditContractType').modal('hide');" class="close">&times;</a>
        <h3><?php echo lang('contracttypes_popup_update_title'); ?></h3>
    </div>
    <div class="modal-body">
        <img src="<?php echo base_url(); ?>assets/images/loading.gif">
    </div>
    <div class="modal-footer">
        <a href="#" onclick="$('#frmEditContractType').modal('hide');" class="btn"><?php echo lang('contracttypes_popup_update_button_cancel'); ?></a>
    </div>
</div>

<div id="frmDeleteContractType" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmDeleteContractType').modal('hide');" class="close">&times;</a>
        <h3><?php echo lang('lcontracttypes_popup_delete_title'); ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo lang('contracttypes_popup_delete_description'); ?></p>
        <p><?php echo lang('contracttypes_popup_delete_confirm'); ?></p>
    </div>
    <div class="modal-footer">
        <a href="#" id="lnkDeleteLeaveType" class="btn btn-danger"><?php echo lang('contracttypes_popup_delete_button_yes'); ?></a>
        <a href="#" onclick="$('#frmDeleteContractType').modal('hide');" class="btn"><?php echo lang('contracttypes_popup_delete_button_no'); ?></a>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#frmAddContractType").alert();
        $("#frmEditContractType").alert();
        $("#frmDeleteContractType").alert();

        //On showing the confirmation pop-up, add the type id at the end of the delete url action
        $('#frmDeleteContractType').on('show', function() {
            var link = "<?php echo base_url(); ?>contracttypes/delete/" + $(this).data('id');
            $("#lnkDeleteLeaveType").attr('href', link);
        })

        //Display a modal pop-up so as to confirm if a type has to be deleted or not
        $('.confirm-delete').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#frmDeleteContractType').data('id', id).modal('show');
        });

        //Prevent to load always the same content (refreshed each time)
        $('#frmAddContractType').on('hidden', function() {
            $(this).removeData('modal');
        });
        $('#frmEditContractType').on('hidden', function() {
            $(this).removeData('modal');
        });
        $('#frmDeleteContractType').on('hidden', function() {
            $(this).removeData('modal');
        });

        //Give focus on first field on opening modal forms
        $('#frmAddContractType').on('shown', function() {
            $('input:text:visible:first', this).focus();
        });
        $('#frmEditContractType').on('shown', function() {
            $('input:text:visible:first', this).focus();
        });
    });
</script>