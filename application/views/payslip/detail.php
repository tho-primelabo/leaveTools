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
<br/>
<div class="row">
     <div class="span0">
        <label for="viz_startdate"><?php echo lang('payslip_employees_thead_date'); ?>:</label>
            
    </div>
    <div class="span12">
        <input type="text" name="salarydate" id="salarydate" autocomplete="off" required/>
        <input type="hidden" name="startdate" id="startdate" />
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
            <th><?php echo lang('payslip_field_unEmployment_insurance');?></th>            
            <th><?php echo lang('payslip_field_income_before_tax');?></th>
            <th><?php echo lang('payslip_field_reduction_family');?></th>
            <th><?php echo lang('payslip_field_salary_overtime');?></th>
            <th><?php echo lang('payslip_field_salary_other');?></th>
            
        </tr>
    </thead>
    <tbody>
       <?php foreach ($salaries as $salary): ?>
            <tr>
            <td><?php echo $salary['salary_id']; ?></td>
            <td><?php echo $salary['date']; ?></td>            
            <td><?php echo number_format($salary['salary_basic']); ?></td>
            <td><?php $sal = isset($salary['salary_basic']);
                    if($sal) echo number_format($salary['salary_net']);
                    else echo 0; ?></td>
            <td><?php echo number_format($salary['social_insurance']); ?></td>
            <td><?php echo number_format($salary['health_insurance']); ?></td>
            <td><?php echo number_format($salary['taxable_incom']); ?></td>
            <td><?php echo number_format($salary['personal_income_tax']); ?></td>
            <td><?php echo number_format($salary['unEmployment_insurance']); ?></td>
            <td><?php echo number_format($salary['income_before_tax']); ?></td>
            <td><?php echo number_format($salary['peson_tax_payer']); ?></td>
            <td><?php echo number_format($salary['salary_overtime']); ?></td>
            <td><?php echo number_format($salary['salary_other']); ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<div class="row">
     <div class="span0">
        <a href="<?php echo base_url(); ?>payslip" class="btn btn-primary">
            <i class="mdi mdi-arrow-left"></i>&nbsp;<?php echo lang('payslip_button_back');?>
        </a>
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
    $('#salary').dataTable({
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
    $(function() {
        <?php if ($this->config->item('csrf_protection') == true) {?>
            $.ajaxSetup({
                data: {
                    <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>",
                }
            });
            <?php }?>
    });
    //Intialize Month/Year selection
        $("#").datepicker({
            format: "MM yyyy",
            startView: 1,
            minViewMode: 1,
            todayBtn: 'linked',
            todayHighlight: true,
            language: "<?php echo $language_code;?>",
            autoclose: true
        }).on("changeDate", function(e) {
            month = new Date(e.date).getMonth();
            //Doesn't work : year = new Date(e.date).getYear();
            year = parseInt(String(e.date).split(" ")[3]);
            currentDate = moment().year(year).month(month).date(1);
            var fullDate = currentDate.format("MMMM") + ' ' + year;
            $("#txtMonthYear").val(fullDate);
            $('#calendar').fullCalendar('gotoDate', currentDate);
            
        });

        $("#salarydate").datepicker({

            onSelect: function(date, instance) {

                $.ajax
                ({
                    type: "Post",
                    url: "<?php echo base_url(); ?>/payslip/bydate/",
                    data: "date="+date,
                    success: function(result)
                    {
                        //do something
                    }
                });  
            }
        });
</script>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lms/leave.edit-1.0.js?v=<?= filemtime(dirname(BASEPATH) . '/assets/js/lms/leave.edit-1.0.js'); ?>" type="text/javascript"></script>-->
