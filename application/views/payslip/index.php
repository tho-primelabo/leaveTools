<?php
/**
 * This view displays the list of users.
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license    http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link       https://github.com/tho-primelabo/leavetools
 * @since      0.1.0
 */
?>

<div class="row-fluid">
    <div class="span12">


<h2><?php echo lang('payslip_title');?> &nbsp;</h2>
<?php echo $flash_partial_view;?>

  <div class="span12">
       
        <div class="input-prepend input-append">
            <button id="cmdPrevious" class="btn btn-primary" title="<?php echo lang('calendar_tabular_button_previous');?>"><i class="mdi mdi-chevron-left"></i></button>
            <input type="text" id="txtMonthYear" style="cursor:pointer;" value="<?php echo $month . ' ' . $year;?>" class="input-medium" readonly />
            <button id="cmdNext" class="btn btn-primary" title="<?php echo lang('calendar_tabular_button_next');?>"><i class="mdi mdi-chevron-right"></i></button>
        </div>
    </div>
<br/>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered nowrap" id="users" width="100%">
    <thead>
        <tr>
            <th><?php echo lang('payslip_index_thead_id');?></th>
            <th><?php echo lang('payslip_field_firstname');?></th>
            <th><?php echo lang('payslip_field_lastname');?></th>
            <th><?php echo lang('payslip_gross_salary');?></th>
            <th><?php echo lang('payslip_net_salary');?></th>
            <th><?php echo lang('payslip_number_dependant');?></th>
        </tr>
    </thead>
    <tbody>

            </tbody>
        </table>
    </div>
</div>

<div class="row-fluid"><div class="span12">&nbsp;</div></div>

<div class="row-fluid">
    <div class="span12">
      <a href="<?php echo base_url();?>payslip/export" class="btn btn-primary"><i class="mdi mdi-download"></i>&nbsp;<?php echo lang('payslip_index_button_export');?></a>
      &nbsp;
      <a href="<?php echo base_url();?>payslip/bulkCreate/<?php echo date('Y-m-d')?>" class="btn btn-primary"><i class="mdi mdi-currency-usd"></i>&nbsp;<?php echo lang('payslip_index_button_payslip');?></a>
    </div>
</div>

<div class="row-fluid"><div class="span12">&nbsp;</div></div>





<link href="<?php echo base_url();?>assets/datatable/DataTables-1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar-2.8.0/lib/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/datatable/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    <?php if ($this->config->item('csrf_protection') == true) {?>
    $.ajaxSetup({
        data: {
            <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>",
        }
    });
    <?php }?>
    var table = $('#users').DataTable({
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
            url: "<?php echo base_url();?>payslip/ajax_list/",
            "type": "POST",
            "data": function ( data ) {
                data.userid = 12;
                data.date = $('#FirstName').val();
                
            }
        },
    });
        
    
    $('#cmdNext').click(function() {
            currentDate = currentDate.add(1, 'M');
            month = currentDate.month() +1;
            year = currentDate.year();
            var fullDate = currentDate.format("MMMM") + ' ' + year;
            date = year + '-' + month + '-' +'01';
            var table = $('#users').DataTable();
            $("#txtMonthYear").val(fullDate);
    })

        $('#cmdPrevious').click(function() {
            currentDate = currentDate.add(-1, 'M');
            month = currentDate.month();
            year = currentDate.year();
            var fullDate = currentDate.format("MMMM") + ' ' + year;
            $("#txtMonthYear").val(fullDate);
            //$('#calendar').fullCalendar('prev');
        });
</script>
