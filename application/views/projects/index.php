<?php
/**
 * This view displays the leave balance report.
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.2.0
 */
?>

<h2><?php echo lang('project_index_title');?> &nbsp;</h2>


<div class="row-fluid">

    <div class="span12">

        <?php echo form_open_multipart('project/import'); ?>
        
            <div class="list-group">
            
            <input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
            
            </div>

            <button type="submit" class="btn btn-primary">Import</button>

        <?php echo form_close(); ?>
        <div class="col-md-12">
                
                <a href="<?=base_url ()?>project/download/projects.xlsx" class="mdi mdi-file-excel-box">sample</a>
            </div>
        <div class="table-responsive" id="customer_data">
        <br/>
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered nowrap" id="projects" width="100%">
        <thead>
            <tr>
                <th><?php echo lang('project_index_thead_id'); ?></th>
                <th><?php echo lang('project_field_project_code'); ?></th>
                <th><?php echo lang('project_field_name'); ?></th>
                <th><?php echo lang('project_filed_location'); ?></th>
                <th><?php echo lang('project_field_manager_id'); ?></th>
                <th><?php echo lang('project_field_start_date'); ?></th>
                 <th><?php echo lang('project_field_end_date'); ?></th>
                <th><?php echo lang('project_field_other'); ?></th>
                <th>Action</th>
                
            </tr>
        </thead>
            <tbody>
            </tbody>
        </table>
</div>
<div class="row-fluid"><div class="span12">&nbsp;</div></div>
<div id="frmConfirmDelete" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmConfirmDelete').modal('hide');" class="close">&times;</a>
         <h3><?php echo lang('project_index_popup_delete_title');?></h3>
    </div>
    <div class="modal-body">
        <input type ="hidden" id = "id"/>
        <p><?php echo lang('project_index_popup_delete_message');?></p>
        <p><?php echo lang('project_index_popup_delete_question');?></p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-danger" id="lnkDeleteUser"><?php echo lang('project_index_popup_update_save')?></a>
        <a href="#" onclick="$('#frmConfirmDelete').modal('hide');" class="btn"><?php echo lang('project_index_popup_update_close')?></a>
    </div>
</div>

<div id="gridSystemModal" class="modal hide fade ">
    <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h3><?php echo lang('project_index_popup_update_title');?></h3>
    </div>
    <div class="modal-body ">
        <input type ="hidden" id = "id"/>
        <div class="row-fluid">
            <div class="col-xs-6">
                <label class="col-xs-4" for="title">Project Code</label>
                <input type="text" name="project_code" id="project_code"  />
            </div>
            <div class="col-xs-6">
                <label class="col-xs-4" for="title">Name</label>
                <input type="text" name="name" id="name"  />
            </div>
            <div class="col-xs-6">
                <label class="col-xs-4" for="title">Location</label>
                <input type="text" name="location" id="location"  />
            </div>
            <div class="col-xs-6">
                <label class="col-xs-4" for="title">Manager Id</label>
                <input type="text" name="manager_id" id="manager_id"  />
            </div>
            <div class="col-xs-6">
                <label class="col-xs-4" for="title">End Date</label>
                <input type="text" name="end_date" id="end_date"  />
            </div>
            <div class="col-xs-6">
                <label class="col-xs-4" for="title">Start Date</label>
                <input type="text" name="start_date" id="start_date"  />
            </div>
            <div class="col-xs-6">
                <label class="col-xs-4" for="title">Other</label>
                <input type="text" name="other" id="other"  />
            </div>
        </div>
        <p><?php echo lang('project_index_popup_update_message');?></p>
        
    </div>
    <div class="modal-footer">
        <!-- <a href="#" class="btn btn-danger" id="lnkDeleteUser"><?php echo lang('project_index_popup_delete_button_yes');?></a>
        <a href="#" onclick="$('#frmConfirmDelete').modal('hide');" class="btn"><?php echo lang('project_index_popup_delete_button_no');?></a> -->
        <button type="button" class="btn btn-default waves-effect waves-light" data-dismiss="modal"><?php echo lang('project_index_popup_update_close')?></button>
        <button type="button" class="btn btn-primary waves-effect waves-light"><?php echo lang('project_index_popup_update_save')?></button>
    </div>
</div>


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
</script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/flick/jquery-ui.custom.min.css">
<link href="<?php echo base_url();?>assets/datatable/DataTables-1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo base_url();?>assets/datatable/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">


$(document).ready(function() {
    
    //load_data();
    var table;
    table = $('#projects').DataTable({
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            url: "<?php echo base_url();?>project/loadData/",
            "type": "POST",
            // "data": function ( data ) {
            //     //data.userid = 12;
            //     data.date = $('#monthYear').val();
            // },
             beforeSend: function() {
                // setting a timeout
               $('#frmModalAjaxWait').modal('show');
            },            
            complete: function() {
                $('#frmModalAjaxWait').modal('hide');
                //dateBack = new Date(dateS);
                
                //$('#txtMonthYear').val(dateS);
            },
        },
    });
    function load_data()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>project/fetch",
            method:"GET",
            success:function(data){
                $('#customer_data').html(data);
            }
        })
    }$('#import_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"import",
                method:"POST",
                data:new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                success:function(data){
                    $('#file').val('');
                    //load_data();
                    table.ajax.reload();
                    //alert(data);
                }
            })
        });
    

    //Prevent to load always the same content (refreshed each time)
    $('#frmDeleteLeaveRequest').on('hidden', function() {
        $(this).removeData('modal');
    });
    $('#lnkDeleteUser').on('click', function() {
        var id = $('#id').val();
        $.ajax({
            url: "<?php echo base_url();?>project/delete/" + id,
            success:function(data){
                $('#frmConfirmDelete').modal('hide');
                    //load_data();
                    table.ajax.reload();
                    //alert(data);
                }
            }).done(function() {
                //oTable.rows('tr[data-id="' + id + '"]').remove().draw();
               
                //table.ajax.reload();
                //location.reload();
            });
    });
});
    function deleteDialog(id){
        // a global function
        console.log(id);
        $('#id').val(id);
        $('#frmConfirmDelete').modal('show');
    }

    function editDialog(id){
        // a global function
        console.log(id);
        $('#project_code').val(id[1]);
        $('#name').val(id[2]);
        $('#location').val(id[3]);
        $('#manager_id').val(id[4]);
        $('#start_date').val(id[5]);
        $('#end_date').val(id[6]);
        $('#other').val(id[7]);
        $('#gridSystemModal').modal('show');
    }

</script>
