<meta name="viewport" content="width=device-width, initial-scale=1">
<div class="row-fluid">
    <div class="span12">
        <h2><?php echo lang('payslip_title');?>: &nbsp;<?php echo $users_item['lastname']; ?></h2>

        <?php echo validation_errors(); ?>
    </div>
    <div class="row-fluid">
    <div class="span12">
        <?php echo lang('payslip_edit_description'); ?>
    </div>
</div> 
</div>
<?php
$attributes = array('class' => 'form-horizontal');
if (isset($_GET['source'])) {
    echo form_open('payslip/edit/' . $users_item['id'] .'?source=' . $_GET['source'], $attributes);
} else {
    echo form_open('users/edit/' . $users_item['id'], $attributes);
} ?>

<input type="hidden" name="id" value="<?php echo $users_item['id']; ?>" />

<div class="wrapper">
    <div class="row box-auto">
        <div class="column border-right">
            <div id="form_convert">
                <div class="f-boder">
                    <div class="title"><?php echo lang('payslip_income')?></div>
                    <div class="clearfix">
                        <span class="margin-top-5"><?php echo lang('payslip_gross_salary')?> </span>
                        <span id="idNhapLuong" data-toggle="tooltip" data-placement="top" data-title="<?php echo lang('payslip_employees_input_salary');?>">
                            <input name="txtSalary" type="text" value="<?php echo $users_item['salary']; ?>" maxlength="14" id="txtSalary" class="inputaspx w150" onkeydown="return MoveNextTextBox(event.keyCode);">
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
                            
                            <input name="txtNumberOfDep" id="txtNumberOfDep" value="<?php echo $users_item['number_dependant']; ?>" 
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                type = "number"
                                maxlength = "2"
                             />
                        </span>
                    </div>
                </div>
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
            <div id="blockUI">
                <div class="title" style="text-align: center"><?php echo lang('payslip_description')?> (VND)</div>
                <table class="datalist">
                    <tbody>
                        <tr class="rownote">
                            <th style="width: 300px;"><?php echo lang('payslip_gross_salary')?></th>
                            <td style="width: 105px;">
                                <strong><span id="lblGrossSalary"></span></strong>
                            </td>
                        </tr>
                        <tr style="background-color: #CDCDCD;">
                            <th><?php echo lang('payslip_social_insurance')?>    (8 %)</th>
                            <td>
                                <span id="lblSocialInsurance"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #CDCDCD;">
                            <th><?php echo lang('payslip_health_insurance')?>    (1.5 %)</th>
                            <td>
                                <span id="lblHealthInsurance"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #CDCDCD;">
                            <th><?php echo lang('payslip_unEmployment_insurance')?>   (1 %)</th>
                            <td>
                                <span id="lblThatNghiep"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #E6E6E6;">
                            <th><?php echo lang('payslip_health_insurance')?>For the tax payer</th>
                            <td>
                                <span id="lblGiamTruCaNhan">9.000.000</span>
                            </td>
                        </tr>
                        <tr style="background-color: #CCCCCC;">
                            <th><?php echo lang('payslip_number_dependant_tax')?></th>
                            <td>
                                <span id="lblGiamTruPhuThuoc"></span>
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
                        <span id="lblNetUsd">0.00</span>
                    </span>
                    <span>(USD)</span>
                    <span id="lblNetUsd">0.00</span>
                    </span>
                    <br/>
                    <span>
                        <div style="clear: both;"></div>
                        <a href="<?php echo base_url(); ?>payslip" class="btn btn-primary">
                            <i class="mdi mdi-arrow-left"></i>&nbsp;<?php echo lang('payslip_button_back');?>
                        </a>
                    </span>
                  
                   
                </div>
                
            </div>
            
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/payslip/js/accounting.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/payslip/css/payslip.css">
<script type="text/javascript">
    
     $(function MoveNextTextBox(_key) {
        if (_key == 13) {
            var _next = document.getElementById('txtNumberOfDep');
            if (_next != null) _next.focus();
            return false;
        }
        
    })
</script>