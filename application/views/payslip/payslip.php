<meta name="viewport" content="width=device-width, initial-scale=1">
<h2><?php echo lang('payslip_title');?>&nbsp;</h2>


<div class="wrapper">
    <div class="row box-auto">
        <div class="column border-right">
            <div id="form_convert">
                <div class="f-boder">
                    <div class="title">Income</div>
                    <div class="clearfix">
                        <span class="margin-top-5">Salary </span>
                        <span id="idNhapLuong" data-toggle="tooltip" data-placement="top" data-title="Please enter number to salary">
                            <input name="txtSalary" type="text" maxlength="14" id="txtSalary" class="inputaspx w150" onkeydown="return MoveNextTextBox(event.keyCode);">
                        </span>
                        <span>
                            <select name="ddlUnit" id="ddlUnit" class="selectaspx w70" onchange="chonTienTe()">
                                <option value="VND">VND</option>
                                <option value="USD">USD</option>
                            </select>
                        </span>
                    </div>
                    <div class="clearfix">
                        <span class="margin-top-5">Exchange rate </span>
                        <span>1 USD =
                            <input name="txtExchangeRate" type="text" value="23260" maxlength="5" id="txtExchangeRate" class="inputaspx w170" disabled="disabled"> VND
                        </span>
                    </div>
                </div>
            
                <div class="f-boder">
                    <div class="title">Insurance</div>
                    <div class="clearfix">             
                        <span class="margin-top-5 mt-2">Pay for</span>
                        <span>
                            <input id="RadioButton1" type="radio" name="rdbPayfor" value="RadioButton1" checked="checked" onclick="chonLuongDongBaoHiem();"><label for="RadioButton1"><strong>full wage</strong></label>
                        </span>
                        <span>
                            <input id="RadioButton2" type="radio" name="rdbPayfor" value="RadioButton2" onclick="chonLuongDongBaoHiem();"><label for="RadioButton2"><strong>Other</strong></label>
                        </span>
                        <span id="idSalaryBasic" data-toggle="tooltip" data-placement="top" data-title="Please enter number salary basic">
                            <input name="txtSalaryBasic" type="text" maxlength="13" id="txtSalaryBasic" class="w70" disabled="disabled"> VND
                        </span>                                
                    </div>
                    <div class="clearfix mt-2">
                        <span>Included UnEmployement Insurance</span> <span>
                            <input id="chkIncludedIns" type="checkbox" name="chkIncludedIns" checked="checked">
                        </span>
                    </div>
                </div>
                <div class="f-boder">
                    <div class="title">Reduction based on family circumstances</div>
                    <div class="clearfix">
                        <span class="margin-top-5">Number of dependant :</span>
                        <span>
                            <input name="txtNumberOfDep" type="text" value="0" maxlength="2" id="txtNumberOfDep" class="inputaspx w70" onfocus="SearchOnFocus(this)" onblur="SearchOnBlur(this)">
                        </span>
                    </div>
                </div>
                <div class="style-btn clearfix">
                    <input id="clienGrossi" onclick="clickso1()" class="form-control btn-primary bg-orange" type="button" value="Gross to Net">
                    <input id="clientNet" onclick="clickso2()" class="form-control btn-primary bg-orange" type="button" value="Net To Gross">
                    <div style="display:none">
                        <input type="submit" name="btnCalculator" value="Gross to Net" id="btnCalculator" cclass="form-control btn-primary bg-orange">
                        <input type="submit" name="btnNetToGross" value="Net To Gross" id="btnNetToGross" class="form-control btn-primary bg-orange">
                    </div>
                </div>
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
                        //var date = new Date();
                        if ($('#chkIncludedIns').is(":checked")) {
                            chkIncludedIns  = 1;
                        }
                        console.log(sal + ":" + chkIncludedIns +":" + txtNumberOfDep);
                        $.ajax({
                            url: "payslip/create",
                            data: {
                                'userid': <?php echo $this->session->userdata('id');?>,
                                'salary': sal,
                                'chkIncludedIns': chkIncludedIns,
                                'txtNumberOfDep': txtNumberOfDep
                            },
                            type: "POST",
                            success: function(json) {
                                //console.log(JSON.parse(json));
                                json = JSON.parse(json);
                                $('#lblGrossSalary').html(accounting.formatNumber(json.salary_basic));
                                $('#lblSocialInsurance').html(accounting.formatNumber(json.social_insurance));
                                $('#lblHealthInsurance').html(accounting.formatNumber(json.health_insurance));
                                $('#lblThatNghiep').html(accounting.formatNumber(json.unEmployment_insurance));
                                $('#lblGiamTruPhuThuoc').html(accounting.formatNumber(json.peson_tax_payer));
                                $('#lblTaxableIncome').html(accounting.formatNumber(json.taxable_incom));
                                $('#lblIncomeTax').html(accounting.formatNumber(json.personal_income_tax));
                                $('#lblNetSalary').html(accounting.formatNumber(json.salary_net));
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
                </script>
            </div>
        </div>
        <?php
            // var_dump($payslip); exit();
        ?>
        <div class="column">
            <div id="blockUI">
                <div class="title" style="text-align: center">Description (VND)</div>
                <table class="datalist">
                    <tbody>
                        <tr class="rownote">
                            <th style="width: 300px;">GROSS Salary</th>
                            <td style="width: 105px;">
                                <strong><span id="lblGrossSalary"></span></strong>
                            </td>
                        </tr>
                        <tr style="background-color: #CDCDCD;">
                            <th>Social insurance    (8 %)</th>
                            <td>
                                <span id="lblSocialInsurance"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #CDCDCD;">
                            <th>Health Insurance    (1.5 %)</th>
                            <td>
                                <span id="lblHealthInsurance"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #CDCDCD;">
                            <th>UnEmployment Insurance    (1 %)</th>
                            <td>
                                <span id="lblThatNghiep"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #E6E6E6;">
                            <th>For the tax payer</th>
                            <td>
                                <span id="lblGiamTruCaNhan">9.000.000</span>
                            </td>
                        </tr>
                        <tr style="background-color: #CCCCCC;">
                            <th>For per person that depends on the tax payer</th>
                            <td>
                                <span id="lblGiamTruPhuThuoc"></span>
                            </td>
                        </tr>
                        <tr class="rownote" style="background-color: #E7E7E7">
                            <th>Taxable income</th>
                            <td>
                                <span id="lblTaxableIncome"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Personal income tax</th>
                            <td>
                                <span id="lblIncomeTax"></span>
                            </td>
                        </tr>
                        <tr class="rownote" style="background-color: #CCCCCC">
                            <th><strong>Net salary</strong></th>
                            <td>
                                <strong><span id="lblNetSalary"></span></strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div id="salary_comment">
                    <span>(*) GROSS:</span><span>
                        <span id="lblGrossVnd">0</span></span><span>(VND) ≈ </span><span>
                            <span id="lblGrossUsd">0.00</span></span><span>(USD)</span>
                    <div style="clear: both;"></div>
                    <span>(**) NET:</span><span>
                        <span id="lblNetVnd">0</span></span><span>(VND) ≈</span><span>
                            <span id="lblNetUsd">0.00</span></span><span>(USD)</span>
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
<script>