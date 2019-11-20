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
        <div class="span6">
        <?php echo form_open_multipart('project/import'); ?>
        
            <div class="list-group">
            
            <input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
            
            </div>

            <button type="submit" class="btn btn-primary">Import</button>
        </div>
        <?php echo form_close(); ?>
        <div class="span6">
            <a href="<?=base_url ()?>project/download/projects.xlsx" class="mdi mdi-file-excel-box">sample</a>
        </div>
        
        <div class="table-responsive" id="customer_data">
        <div class="span6">

            <button type="button" id="btnAdd" class="btn-primary" title="<?php echo lang('project_index_thead_add'); ?>"><i class='mdi mdi-plus nolink'></i></button>
      
        </div>
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

<div id="frmConfirmDelete" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmConfirmDelete').modal('hide');" class="close">&times;</a>
         <h3 ><?php echo lang('project_index_popup_delete_title');?></h3>
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
         <h3 id="title"></h3>
    </div>
    <input type ="hidden" id = "id"/>
    <div class="modal-body ">
        
        <div class="row-fluid">
            <br/>
            <div class="span12">
                <div class="span6">
                    <label class="col-xs-4" for="title">Project Code</label>
                    <input type="text" name="project_code" id="project_code"  />
                </div>
                <div class="span6">
                    <label class="col-xs-4" for="title">Name</label>
                    <input type="text" name="name" id="name"  />
                </div>
            </div>
            <div class="span12">
                <div class="span6">
                    <label class="col-xs-4" for="title">Location</label>
                    <input type="text" name="location" id="location"  />
                </div>
                <div class="span6">
                    <label class="col-xs-4" for="title">Manager Id</label>
                    <input type="text" name="manager_id" id="manager_id"  />
                </div>
            </div>
            <div class="span12">
                <div class="span6">
                    <label class="col-xs-4" for="title">Start Date</label>
                    <input type="text" name="start_date" id="start_date" class="form-control datepicker" />
                </div>
                <div class="span6">
                    <label class="col-xs-4" for="title">End Date</label>
                    <input type="text" name="end_date" id="end_date"  />
                </div>
            </div>
            <div class="span12">
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
        <button type="button"  id ="frmConfirmSave" class="btn btn-primary waves-effect waves-light"><?php echo lang('project_index_popup_update_save')?></button>
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
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.custom.min.js"></script>
<link href="<?php echo base_url();?>assets/datatable/DataTables-1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo base_url();?>assets/datatable/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<?php
    //Prevent HTTP-404 when localization isn't needed
    if ($language_code != 'en') {
        ?>
        <script src="<?php echo base_url(); ?>assets/js/i18n/jquery.ui.datepicker-<?php echo $language_code; ?>.js"></script>
    <?php } ?>
<script type="text/javascript">
$(document).ready(function() {
    
    //load_data();
    var table;
    var selectedDate;
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
    $('#btnAdd').on('click', function() {
        $('#start_date').val(new Date().toISOString().slice(0, 10));
        $('#end_date').val(new Date().toISOString().slice(0, 10));
        $('#id').val("");
        $('#title').text('<?php echo lang('project_index_thead_add');?>');
        $('#gridSystemModal').modal('show');
    })
    $('#frmConfirmSave').on('click', function() {
        $.ajax({
                url: "<?php echo base_url();?>project/update",
                type: 'POST',
                data: {
                    id: $('#id').val(),
                    project_code: $('#project_code').val(),
                    name: $('#name').val(),
                    location: $('#location').val(),
                    manager_id: $('#manager_id').val(),
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    other: $('#other').val()
                },
                dataType : 'json',
                beforeSend: function() {
                    // setting a timeout
                     $('#frmModalAjaxWait').modal('show');
                },
                complete: function() {
                    $('#frmModalAjaxWait').modal('hide');
                   
                    $('#gridSystemModal').modal('hide');
                    table.ajax.reload();  //just reload table
                
                },
            })
    })
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
        $('#id').val(id[0]);
        $('#project_code').val(id[1]);
        $('#name').val(id[2]);
        $('#location').val(id[3]);
        $('#manager_id').val(id[4]);
        $('#start_date').val(id[5]);
        $('#end_date').val(id[6]);
        $('#other').val(id[7]);
        $('#title').text('<?php echo lang('project_index_popup_update_title');?>');
        $('#gridSystemModal').modal('show');
    }
    $("#start_date").datepicker({
        dateFormat: 'yy-mm-dd',
          language: "<?php echo $language_code;?>",
        
          autoclose: true,
          onSelect: function(date, instance) {
            //console.log(date);
            selectedDate = $.datepicker.formatDate("yy-mm-dd", $(this).datepicker('getDate'));
            
            $('#start_date').val(selectedDate);
          }
        
        }).datepicker("setDate", new Date());

    $("#end_date").datepicker({
        dateFormat: 'yy-mm-dd',
          language: "<?php echo $language_code;?>",
        
          autoclose: true,
          onSelect: function(date, instance) {
            //console.log(date);
            selectedDate = $.datepicker.formatDate("yy-mm-dd", $(this).datepicker('getDate'));
            
            $('#end_date').val(selectedDate);
          }
        
        }).datepicker("setDate", new Date());

   
</script>
