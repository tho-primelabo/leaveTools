<?php
/**
 * This view allows an employees (or HR admin/Manager) to create a new leave request
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.1.0
 */
?>

<h2><?php echo lang('payslip_title_detail'); ?> &nbsp;</h2>
<?php echo $flash_partial_view;?>
<div class="row-fluid">
    <div class="span12">
        <?php echo lang('payslip_description'); ?>
    </div>
</div> 
<br/>
<div class="row">
     <div class="span0">
        <label for="viz_startdate"><?php echo lang('payslip_employees_thead_date'); ?>:</label>
    </div>
    
    
         
    <div class="span4">
        <div class="input-append date" >
            <input type="text" name="salarydate" id="salarydate" autocomplete="off" required/>
            <span class="add-on"><i class="icon-calendar" id="cal"></i></span>
            <input type="hidden" name="userid" id="userid" value="<?php echo $userid ?>"/>
        </div>
    </div>

   
</div>

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered nowrap" id="salary" width="100%">
    <thead>
        <tr>
            <th><?php echo lang('payslip_index_thead_id');?></th>
            <th><?php echo lang('payslip_employees_thead_date');?></th>
            <th><?php echo lang('payslip_gross_salary');?></th>
            <th><?php echo lang('payslip_net_salary');?></th>
            
            <th><?php echo lang('payslip_field_social_insurance');?></th>
            <th><?php echo lang('payslip_field_health_insurance');?></th>
            <th><?php echo lang('payslip_field_taxable_incom');?></th>
            <th><?php echo lang('payslip_field_personal_income_tax');?></th>
            <th><?php echo lang('payslip_field_income_before_tax');?></th>
            <th><?php echo lang('payslip_field_unEmployment_insurance');?></th>  
            <th><?php echo lang('payslip_field_reduction_family');?></th>
            <th><?php echo lang('payslip_field_salary_overtime');?></th>
            <th><?php echo lang('payslip_field_salary_other');?></th>
            
        </tr>
    </thead>
    <tbody>
       
    </tbody>
    </table>

    <div class="row">
        <div class="span0">
            <a href="<?php echo base_url(); ?>payslip" class="btn btn-primary">
                <i class="mdi mdi-arrow-left"></i>&nbsp;<?php echo lang('payslip_button_back');?>
            </a>
            <!--<input id="back" class="btn btn-primary" type="button"  value="<?php echo lang('payslip_button_back')?>">-->
            &nbsp;
            <a href="<?php echo base_url();?>payslip/exportDetail/<?php echo $userid ?>" class="btn btn-primary"><i class="mdi mdi-download"></i>&nbsp;<?php echo lang('payslip_index_button_export');?></a>
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
<link href="<?php echo base_url();?>assets/datatable/DataTables-1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment-with-locales.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/datatable/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/select2-4.0.5/js/select2.full.min.js"></script>

<script type="text/javascript">
<?php if ($this->config->item('csrf_protection') == true) {?>
    $.ajaxSetup({
        data: {
            <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>",
        }
    });
    <?php }?>
var table;

$(document).ready(function() {
    //$('#salarydate').val(new Date().toISOString().slice(0,10));
    //datatables
    table = $('#salary').DataTable({ 

        stateSave: true,
            language: {
                decimal:            "<?php echo lang('datatable_sInfoThousands');?>",
                processing:       "<?php echo lang('datatable_sProcessing');?>",
                search:              "<?php echo lang('datatable_sSearch');?>",
                lengthMenu:     "<?php echo lang('datatable_sLengthMenu');?>",
                info:                   "<?php echo lang('datatable_sInfo');?>",
                infoEmpty:          "<?php echo lang('datatable_sInfoEmpty');?>",
                infoFiltered:       "<?php echo lang('datatable_sInfoFiltered');?>",
                infoPostFix:        "<?php echo lang('datatable_sInfoPostFix');?>",
                loadingRecords: "<?php echo lang('datatable_sLoadingRecords');?>",
                zeroRecords:    "<?php echo lang('datatable_sZeroRecords');?>",
                emptyTable:     "<?php echo lang('datatable_sEmptyTable');?>",
                paginate: {
                    first:          "<?php echo lang('datatable_sFirst');?>",
                    previous:   "<?php echo lang('datatable_sPrevious');?>",
                    next:           "<?php echo lang('datatable_sNext');?>",
                    last:           "<?php echo lang('datatable_sLast');?>"
                },
                aria: {
                    sortAscending:  "<?php echo lang('datatable_sSortAscending');?>",
                    sortDescending: "<?php echo lang('datatable_sSortDescending');?>"
                }
            },

        // Load data for the table's content from an Ajax source
        "ajax": {
            url: "<?php echo base_url();?>payslip/filterdate/",
            "type": "POST",
            "data": function ( data ) {
                data.userid = $('#userid').val();;
                data.date = $('#salarydate').val();
                
            }
        },

    });
    
   $("#salarydate").datepicker({
        dateFormat: '<?php echo lang('global_date_js_format');?>',
        altFormat: "yy-mm-dd",
        //uiLibrary: 'bootstrap4',
        onSelect: function(date, instance) {
            //console.log(date);
            selectedDate = $.datepicker.formatDate("yy-mm-dd", $(this).datepicker('getDate'));
            
            $('#salarydate').val(selectedDate);

             table.ajax.reload();  //just reload table
            //  if ($('#salarydate').val() == undefined) {
            //      alert('test');
            //  }
        }
    });
    $('#back').on('click', function() {
            // Load data for the table's content from an Ajax source
            $.ajax({
                url: "<?php echo base_url();?>payslip/",
                type: 'POST',
                data: {
                    date: $('#salarydate').val()
                
                },
                dataType : 'json',
                beforeSend: function() {
                    // setting a timeout
                $('#frmModalAjaxWait').modal('show');
                },
                complete: function() {
                    $('#frmModalAjaxWait').modal('hide');
                    table.ajax.reload();  //just reload table
                
                },
            })
    
        });

    $("#cal").click(function(){
         $("#salarydate").trigger("select");
    });

});

</script>

<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lms/leave.edit-1.0.js?v=<?= filemtime(dirname(BASEPATH) . '/assets/js/lms/leave.edit-1.0.js'); ?>" type="text/javascript"></script>-->
