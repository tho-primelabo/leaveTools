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
<h2><?php echo lang('payslip_title'); ?> &nbsp;</h2>
<div class="row-fluid">
    <div class="span12">
        <?php echo lang('payslip_description'); ?>
    </div>
</div>
<br/>
<!--<?php echo $this->session->flashdata('dateSession');?>-->

  <div class="input-prepend input-append">
    <div>
        <label for="viz_startdate"><?php echo lang('payslip_employees_thead_date'); ?>:</label>
    <!--</div>
    <div class="input-prepend input-append">-->
        <button id="cmdPrevious" class="btn btn-primary" title="<?php echo lang('calendar_tabular_button_previous');?>"><i class="mdi mdi-chevron-left"></i></button>
        <input type="text" id="txtMonthYear" style="cursor:pointer;" value="<?php echo $month . ' ' . $year;?>" class="input-medium" readonly />
        <button id="cmdNext" class="btn btn-primary" title="<?php echo lang('calendar_tabular_button_next');?>"><i class="mdi mdi-chevron-right"></i></button>
        <input type ='hidden' id='monthYear'/>
    </div>
</div>
<br/>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered nowrap" id="users" width="100%">
    <thead>
        <tr>
            <th><?php echo lang('payslip_index_thead_id'); ?></th>
            <th><?php echo lang('payslip_field_firstname'); ?></th>
            <th><?php echo lang('payslip_field_lastname'); ?></th>
            <th><?php echo lang('payslip_gross_salary'); ?></th>
            <th><?php echo lang('payslip_net_salary'); ?></th>
            <th><?php echo lang('payslip_number_dependant'); ?></th>
        </tr>
    </thead>
        <tbody>
        </tbody>
    </table>
    </div>


<div class="row-fluid"><div class="span12">&nbsp;</div></div>

<div class="row-fluid">
    <div class="span12">
      <a href="<?php echo base_url(); ?>payslip/export" class="btn btn-primary"><i class="mdi mdi-download"></i>&nbsp;<?php echo lang('payslip_index_button_export'); ?></a>
      &nbsp;
      <!--<a href="<?php echo base_url();?>payslip/bulkCreate/<?php echo date('Y-m-d')?>" class="btn btn-primary"><i class="mdi mdi-currency-usd"></i>&nbsp;<?php echo lang('payslip_index_button_payslip');?></a>-->
    <button id="bulkCreate" class="btn btn-primary"title="<?php echo lang('payslip_index_button_hint_payslip');?>"><i class="mdi mdi-currency-usd"></i><?php echo lang('payslip_index_button_payslip');?></button>
     &nbsp;
    <button id="sendMail" class="btn btn-primary"title="<?php echo lang('payslip_index_button_hint_senmail');?>"><i class="mdi mdi-email nolink"></i>&nbsp;<?php echo lang('payslip_index_button_sendmail');?></button>
    </div>
</div>
</div>


<div class="row-fluid"><div class="span12">&nbsp;</div></div>
 <div class="modal hide" id="frmModalAjaxWait" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <h1><?php echo lang('global_msg_wait'); ?></h1>
    </div>
    <div class="modal-body">
        <img src="<?php echo base_url(); ?>assets/images/loading.gif"  align="middle">
    </div>
</div>

<div id="frmShowHistory" class="modal hide fade">
    <div class="modal-body" id="frmShowHistoryBody">
        <img src="<?php echo base_url();?>assets/images/loading.gif">
    </div>
    <div class="modal-footer">
        <a href="#" onclick="$('#frmShowHistory').modal('hide');" class="btn"><?php echo lang('OK');?></a>
    </div>
</div>

<link href="<?php echo base_url();?>assets/datatable/DataTables-1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar-2.8.0/lib/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/datatable/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<script type="text/javascript">
    var table;
     var dateS = "<?php echo $this->session->flashdata('dateSession');?>";
     var day = new Date();
    $(document).ready(function() {
        //console.log($('#monthYear').val());
       
        
        if (dateS != '') {
             //$("#monthYear").val(dateS);
             console.log(dateS);
        }
        table = $('#users').DataTable({
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
                //data.userid = 12;
                data.date = $('#monthYear').val();
            },
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
    });
    var month = "<?php echo $month;?>"; //Momentjs uses a zero-based number
    var year = "<?php echo $year;?>";
    var currentDate = moment().year(year).month(month).date(1);
    //console.log(currentDate);
    //$('#txtMonthYear').val(currentDate.format("MMMM Y"));
    <?php if ($this->config->item('csrf_protection') == true) {?>
    $.ajaxSetup({
        data: {
            <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>",
        }
    });
    <?php }?>
    
        
    
    $('#cmdNext').click(function() {
            
        currentDate = currentDate.add(1, 'M');
        month = currentDate.month() +1;
        year = currentDate.year();
        var fullDate = currentDate.format("MMMM") + ' ' + year;
        date = year + '-' + currentDate.format("M") + '-' + '01';//day.getDate();
        
        $("#txtMonthYear").val(fullDate);
        $("#monthYear").val(date);
            //console.log(date);
            table.ajax.reload();  //just reload table
        //alert(month+ ':' +year);
    })

    $('#cmdPrevious').click(function() {
        
        currentDate = currentDate.add(-1, 'M');
        month = currentDate.month();
        year = currentDate.year();
        var fullDate = currentDate.format("MMMM") + ' ' + year;
        
        date = year + '-' + currentDate.format("M") + '-' + '01';//day.getDate();
        $("#txtMonthYear").val(fullDate);
        $("#monthYear").val(date);
            //console.log(date);
        table.ajax.reload();  //just reload table
        //$('#calendar').fullCalendar('prev');
    });
    
    $('#bulkCreate').click(function() {
   
        //var Status = $(this).val();
        //alert($("#monthYear").val());
       // Load data for the table's content from an Ajax source
       $.ajax({
            url: "<?php echo base_url();?>payslip/bulkCreate/",
            type: 'POST',
            data: {
                date: $("#monthYear").val()
               
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
     $('#sendMail').click(function() {        
       $.ajax({
            url: "<?php echo base_url();?>payslip/sendMail2AllUsers/",
            type: 'POST',
            data: {
                date: $("#monthYear").val()
               
            },
            dataType : 'json',
            beforeSend: function() {
                // setting a timeout
               $('#frmModalAjaxWait').modal('show');
            },
            complete: function() {
                $('#frmModalAjaxWait').modal('hide');
                bootbox.alert("<?php echo lang('paslip_email_flash_msg_all_success');?>", function() {
                    //After the login page, we'll be redirected to the current page
                   //location.reload();
                });
            },
        })
   
    });
 
    
    function displayDialog(id){
    // a global function
    console.log(id + " " + $("#monthYear").val());
    var date = $("#monthYear").val();
    $("#frmShowHistory").modal('show');
        $("#frmShowHistoryBody").load('<?php echo base_url();?>payslip/history/' + id +'/'+ date, function(response, status, xhr) {
            if (xhr.status == 401) {
                $("#frmShowHistory").modal('hide');
                bootbox.alert("<?php echo lang('global_ajax_timeout');?>", function() {
                    //After the login page, we'll be redirected to the current page
                   //location.reload();
                });
            }
          });
    //alert(id + ":" + $("#monthYear").val());
    }
</script>
