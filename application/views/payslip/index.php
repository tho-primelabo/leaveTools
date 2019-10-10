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
<?php foreach ($users as $users_item): ?>
    <tr>
        <td data-order="<?php echo $users_item['id']; ?>">
            <?php echo $users_item['id'] ?>&nbsp;
            <div class="pull-right">                
                <a href="<?php echo base_url();?>payslip/edit/<?php echo $users_item['id'] ?>" title="<?php echo lang('payslip_index_thead_tip_edit');?>"><i class="mdi mdi-currency-usd nolink"></i></a>
            </div>
        </td>
        <td><?php echo $users_item['firstname']; ?></td>
        <td><?php echo $users_item['lastname']; ?></td>
        <td><?php echo number_format($users_item['salary']); ?></td>
        <td><?php $sal = isset($users_item['salaryNet']);
                  if($sal) echo number_format($users_item['salaryNet']);
                  else echo 0; ?></td>
        <td><?php echo $users_item['number_dependant']; ?></td>
    </tr>
<?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row-fluid"><div class="span12">&nbsp;</div></div>

<div class="row-fluid">
    <div class="span12">
      <a href="<?php echo base_url();?>payslip/export" class="btn btn-primary"><i class="mdi mdi-download"></i>&nbsp;<?php echo lang('payslip_index_button_export');?></a>
      &nbsp;
      <a href="<?php echo base_url();?>payslip/bulkCreate" class="btn btn-primary"><i class="mdi mdi-currency-usd"></i>&nbsp;<?php echo lang('payslip_index_button_payslip');?></a>
    </div>
</div>

<div class="row-fluid"><div class="span12">&nbsp;</div></div>

<div id="frmConfirmDelete" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmConfirmDelete').modal('hide');" class="close">&times;</a>
         <h3><?php echo lang('users_index_popup_delete_title');?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo lang('users_index_popup_delete_message');?></p>
        <p><?php echo lang('users_index_popup_delete_question');?></p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-danger" id="lnkDeleteUser"><?php echo lang('users_index_popup_delete_button_yes');?></a>
        <a href="#" onclick="$('#frmConfirmDelete').modal('hide');" class="btn"><?php echo lang('users_index_popup_delete_button_no');?></a>
    </div>
</div>

<div id="frmResetPwd" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h3><?php echo lang('users_index_popup_password_title');?></h3>
    </div>
    <div class="modal-body">
        <img src="<?php echo base_url();?>assets/images/loading.gif">
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><?php echo lang('users_index_popup_password_button_cancel');?></button>
    </div>
</div>



<link href="<?php echo base_url();?>assets/datatable/DataTables-1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar-2.8.0/lib/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/datatable/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    var month = "<?php echo $month;?>"; //Momentjs uses a zero-based number
    var year = "<?php echo $year;?>";
    var currentDate = moment().year(year).month(month).date(1);
    //var table = $('#users').DataTable();
    $(document).ready(function() {
         
        <?php if ($this->config->item('csrf_protection') == TRUE) {?>
          $.ajaxSetup({
              data: {
                  <?php echo $this->security->get_csrf_token_name();?>: "<?php echo $this->security->get_csrf_hash();?>",
              }
          });
      <?php }?>
        //Transform the HTML table in a fancy datatable
        $('#users').dataTable({
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
        });
        
    });
    $('#cmdNext').click(function() {
            currentDate = currentDate.add(1, 'M');
            month = currentDate.month() +1;
            year = currentDate.year();
            var fullDate = currentDate.format("MMMM") + ' ' + year;
            date = year + '-' + month + '-' +'01';
            $("#txtMonthYear").val(fullDate);
            $.ajax({
                            url: "<?php echo base_url(); ?>/payslip/bydate/" + date,
                             beforeSend: function(){
                                $('#frmModalAjaxWait').modal('show');
                                },
                            data: {
                                'userid': <?php echo $users_item['id'];?>,
                                'date': year + '-' + month + '-' +'01'
                            },
                            type: "POST",
                            success: function(json) {
                                console.log(json);
                               $('#frmModalAjaxWait').modal('hide');
                               $('#users').DataTable().clear().draw();
                                //$('#users').DataTable().rows.add(json).draw();
                               //Table.rows.add(result).draw();
                                // console.log(json.salary_basic);
                            }
                        });
            //$('#calendar').fullCalendar('next');
        });

        $('#cmdPrevious').click(function() {
            currentDate = currentDate.add(-1, 'M');
            month = currentDate.month();
            year = currentDate.year();
            var fullDate = currentDate.format("MMMM") + ' ' + year;
            $("#txtMonthYear").val(fullDate);
            //$('#calendar').fullCalendar('prev');
        });
</script>
