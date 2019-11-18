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
                
            </tr>
        </thead>
            <tbody>
            </tbody>
        </table>

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
    
});
</script>
