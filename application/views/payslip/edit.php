<meta name="viewport" content="width=device-width, initial-scale=1">
<div class="row-fluid">
    <div class="span12">
        <h2><?php echo lang('payslip_title');?>: &nbsp;<?php echo date("m-Y", strtotime($date)) ?></h2>

        <?php echo validation_errors(); ?>
    </div>
    <div class="row-fluid">
    <div class="span12">
        <!--<?php echo lang('payslip_edit_description'); ?>-->
    </div>
</div> 
</div>
<?php
$attributes = array('class' => 'form-horizontal');
if (isset($_GET['source'])) {
    echo form_open('payslip/edit/' . $id .'?source=' . $_GET['source'], $attributes);
} else {
    echo form_open('users/edit/' . $id, $attributes);
} ?>

<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="date" id="date" value="<?php echo $date; ?>" />
<div class="wrapper">
    <div class="row box-auto">
        <div class="column border-right">
            <div id="form_convert">
                <div class="f-boder">
                    <div class="title"><?php echo lang('payslip_income')?></div>
                    <div class="clearfix">
                        <span class="margin-top-5"><?php echo lang('payslip_gross_salary')?> </span>
                        <span id="idNhapLuong" data-toggle="tooltip" data-placement="top" data-title="<?php echo lang('payslip_employees_input_salary');?>">
                            <input name="txtSalary" type="text" value="<?php echo $salary; ?>" maxlength="14" id="txtSalary" class="inputaspx w150" onkeydown="return MoveNextTextBox(event.keyCode);">
                        </span>
                        <span>
                            <select name="ddlUnit" id="ddlUnit" class="selectaspx w70" onchange="chonTienTe()">
                                <option value="VND">VND</option>
                                <option value="USD">USD</option>
                            </select>
                        </span>
                    </div>
                    <div class="clearfix">
                        <span class="margin-top-5"><?php echo lang('payslip_exchange_rate')?> </span>
                        <span>1 USD =
                            <input name="txtExchangeRate" type="text" value="23260" maxlength="5" id="txtExchangeRate" class="inputaspx w170" disabled="disabled"> VND
                        </span>
                    </div>
                </div>
            
                <div class="f-boder">
                    <div class="title"><?php echo lang('payslip_insurance')?></div>
                    <div class="clearfix">             
                        <span class="margin-top-5 mt-2"><?php echo lang('payslip_pay_for')?></span>
                        <span>
                            <input id="RadioButton1" type="radio" name="rdbPayfor" value="RadioButton1" checked="checked" ><label for="RadioButton1"><strong><?php echo lang('payslip_full_wage')?></strong></label>
                        </span>
                        <span>
                            <input id="RadioButton2" type="radio" name="rdbPayfor" value="RadioButton2" ><label for="RadioButton2"><strong>Other</strong></label>
                        </span>
                        <span id="idSalaryBasic" data-toggle="tooltip" data-placement="top" data-title="Please enter number salary basic">
                            <input name="txtSalaryBasic" type="text" maxlength="13" id="txtSalaryBasic" class="w70" disabled="disabled"> VND
                        </span>                                
                    </div>
                    <div class="clearfix mt-2">
                        <span><?php echo lang('payslip_included_unEmployement_insurance')?></span> <span>
                            <input id="chkIncludedIns" type="checkbox" name="chkIncludedIns" checked="checked">
                        </span>
                    </div>
                </div>
                <div class="f-boder">
                    <div class="title"><?php echo lang('payslip_reduction_family_circumstances')?></div>
                    <div class="clearfix">
                        <span class="margin-top-5"><?php echo lang('payslip_number_dependant')?> :</span>
                        <span>
                            
                            <input name="txtNumberOfDep" id="txtNumberOfDep" value="<?php echo $NoDepend; ?>" 
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                type = "number"
                                maxlength = "2"
                             />
                        </span>
                    </div>
                </div><br/><br/>
                <div class="style-btn clearfix">
                    <input id="clienGrossi" onclick="clickso1()" class="form-control btn-primary bg-orange" type="button" value="Gross to Net">
                    <input id="clientNet" onclick="clickso2()" class="form-control btn-primary bg-orange"  type="hidden" value="Net To Gross">
                    
                </div>
              <div class="modal hide" id="frmModalAjaxWait" data-backdrop="static" data-keyboard="false"/>
                <div class="modal-header">
                    <h1><?php echo lang('global_msg_wait');?></h1>
                </div>
                <div class="modal-body">
                    <img src="<?php echo base_url();?>assets/images/loading.gif"  align="middle">
                </div>
            </div>
                
            </div>
        </div>
       
        <div class="column">
            <div id="form_convert">
                <div class="title" style="text-align: center"><?php echo lang('payslip_edit_description')?> (VND)</div>
                <table class="datalist">
                    <tbody>
                        <tr class="rownote">
                            <th style="width: 300px;"><?php echo lang('payslip_gross_salary')?></th>
                            <td style="width: 105px;">
                                <strong><span id="lblGrossSalary"></span></strong>
                            </td>
                        </tr>
                        <tr style="background-color: #CDCDCD;">
                            <th><?php echo lang('payslip_social_insurance')?>    (<?=LMS_SOCIAL_INSURANCE?> %)</th>
                            <td>
                                <span id="lblSocialInsurance"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #CDCDCD;">
                            <th><?php echo lang('payslip_health_insurance')?>    (<?=LMS_HEALTH_INSURANCE?> %)</th>
                            <td>
                                <span id="lblHealthInsurance"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #CDCDCD;">
                            <th><?php echo lang('payslip_unEmployment_insurance')?>   (<?=LMS_UNEMPLOYMENT_INSURANCE?> %)</th>
                            <td>
                                <span id="lblThatNghiep"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #E6E6E6;">
                            <th><?php echo lang('payslip_youself_dependant')?></th>
                            <td>
                                <span id="lblGiamTruCaNhan"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #CCCCCC;">
                            <th><?php echo lang('payslip_number_dependant_tax')?></th>
                            <td>
                                <span id="lblGiamTruPhuThuoc"><?=number_format(LMS_TAX_PERSON)?></span>
                            </td>
                        </tr>
                        <tr class="rownote" style="background-color: #E7E7E7">
                            <th><?php echo lang('payslip_taxable_income')?></th>
                            <td>
                                <span id="lblTaxableIncome"></span>
                            </td>
                        </tr>
                        <tr>
                            <th><?php echo lang('payslip_personal_income_tax')?></th>
                            <td>
                                <span id="lblIncomeTax"></span>
                            </td>
                        </tr>
                        <tr class="rownote" style="background-color: #CCCCCC">
                            <th><strong><?php echo lang('payslip_net_salary')?></strong></th>
                            <td>
                                <strong><span id="lblNetSalary"></span></strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div id="salary_comment">
                    <span>(*) GROSS:</span>
                    <span>
                        <span id="lblGrossVnd"></span>
                    </span>
                    <span>(VND) ≈ </span>
                    <span>
                            <span id="lblGrossUsd"></span>
                    </span>
                    <span>(USD)</span>
                    <div style="clear: both;"></div>
                    <span>(**) NET:</span>
                    <span>
                        <span id="lblNetVnd"></span>
                    </span>
                    <span>(VND) ≈</span>
                    <span>
                        <span id="lblNetUsd"></span>
                    </span>
                    <span>(USD)</span>
                    <span id="lblNetUsd"></span>
                    </span>
                        <div class="style-btn clearfix">
                            <input id="back" class="form-control btn-primary bg-orange" type="button"  value="<?php echo lang('payslip_button_back')?>">
                        
                        <!--<a href="<?php echo base_url(); ?>payslip" class="btn btn-primary">
                            <i class="mdi mdi-arrow-left"></i>&nbsp;<?php echo lang('payslip_button_back');?>
                        </a>-->
                        
                        </div>
                </div>
                
            </div>
            
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/payslip/js/accounting.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/payslip/css/payslip.css">
<script>
                  
    $(function() {
        <?php if ($this->config->item('csrf_protection') == true) {?>
            $.ajaxSetup({
                data: {
                    <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>",
                }
            });
            <?php }?>
            });
    function CheckLuong() {
        var strLuong = $('input[id*="txtSalary"]').val();
        if ($.trim(strLuong) == "") {
            var title = $('#idNhapLuong').attr("data-title");
            $('#idNhapLuong').attr('title', title);
            $('#idNhapLuong').tooltip('show');
            return false;
        }
        // neu nhap la so 
        if (isNaN(strLuong)) {
            var title = $('#idNhapLuong').attr("data-title");

            $('#idNhapLuong').attr('title', title);
            $('#idNhapLuong').tooltip('show');
            return false;
        }
        return true;
    }
    function go2Net() {
        var sal = $('#txtSalary').val();
        var chkIncludedIns = 0;
        var txtNumberOfDep = $('#txtNumberOfDep').val();
        var txtDate = $('#date').val();
        //var date = new Date();
        if ($('#chkIncludedIns').is(":checked")) {
            chkIncludedIns  = 1;
        }
        console.log(sal + ":" + chkIncludedIns +":" + txtNumberOfDep+ ":" + txtDate);
        $.ajax({
            url: "<?php echo base_url(); ?>/payslip/create",
                beforeSend: function(){
                $('#frmModalAjaxWait').modal('show');
                },
            data: {
                'userid': <?php echo $id;?>,
                'salary': sal,
                'chkIncludedIns': chkIncludedIns,
                'txtNumberOfDep': txtNumberOfDep,
                'date': txtDate
            },
            type: "POST",
            success: function(json) {
                //console.log(JSON.parse(json));
                $('#frmModalAjaxWait').modal('hide');
                json = JSON.parse(json);
                $('#lblGrossVnd').html(accounting.formatNumber(json.salary_basic));
                $('#lblGrossUsd').html(accounting.formatNumber(json.salary_basic/23260));
                $('#lblGrossSalary').html(accounting.formatNumber(json.salary_basic));
                $('#lblSocialInsurance').html(accounting.formatNumber(json.social_insurance));
                $('#lblHealthInsurance').html(accounting.formatNumber(json.health_insurance));
                $('#lblThatNghiep').html(accounting.formatNumber(json.unEmployment_insurance));
                $('#lblGiamTruCaNhan').html(accounting.formatNumber(json.peson_tax_payer));
                $('#lblTaxableIncome').html(accounting.formatNumber(json.taxable_incom));
                $('#lblIncomeTax').html(accounting.formatNumber(json.personal_income_tax));
                $('#lblNetSalary').html(accounting.formatNumber(json.salary_net));
                $('#lblNetVnd').html(accounting.formatNumber(json.salary_net));
                $('#lblNetUsd').html(accounting.formatNumber(json.salary_net/23260));
                // console.log(json.salary_basic);
            }
        });
        
    }
    function clickso1() {
        var bCheck = CheckLuong();
        if (bCheck == true) {
            //$('input[id*="btnCalculator"]').click();
            go2Net();
        }
    }
    function clickso2() {
        //$('input[id*="btnNetToGross"]').click();
        var bCheck = CheckLuong();
        if (bCheck == true) {
            $('input[id*="btnNetToGross"]').click();
        }
    }
    $('#back').on('click', function() {
        // Load data for the table's content from an Ajax source

        $.ajax({
            url: "<?php echo base_url();?>payslip/back",
            type: 'POST',
            data: {
                date: '<?php echo $date ?>'
               
            },
            dataType : 'json',
            beforeSend: function() {
                // setting a timeout
            //    $('#frmModalAjaxWait').modal('show');
            },
            complete: function(responseJSON) {
                // $('#frmModalAjaxWait').modal('hide');
                //console.log(responseJSON);
               window.location.href = '/payslip/index';
            },
           
        })
   
    });
      
    
        
    
</script>
<script type="text/javascript">
    
     $(function MoveNextTextBox(_key) {
        if (_key == 13) {
            var _next = document.getElementById('txtNumberOfDep');
            if (_next != null) _next.focus();
            return false;
        }
        
    })
</script>