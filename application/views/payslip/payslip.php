<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./css/style.css">
</head>
<body>
<div class="wrapper">
    <div class="row box-auto">
        <div class="column border-right">
            <div id="form_convert">
                <div class="f-boder">
                    <div class="title">Income</div>
                    <div class="clearfix">
                        <span class="margin-top-5">Salary </span>
                        <span id="idNhapLuong" data-toggle="tooltip" data-placement="top" data-title="Please enter number to salary">
                            <input name="ctl00$ContentPlaceHolder1$txtSalary" type="text" maxlength="14" id="ctl00_ContentPlaceHolder1_txtSalary" class="inputaspx w150" onkeydown="return MoveNextTextBox(event.keyCode);">
                        </span>
                        <span>
                            <select name="ctl00$ContentPlaceHolder1$ddlUnit" id="ctl00_ContentPlaceHolder1_ddlUnit" class="selectaspx w70" onchange="chonTienTe()">
                                <option value="VND">VND</option>
                                <option value="USD">USD</option>
                            </select>
                        </span>
                    </div>
                    <div class="clearfix">
                        <span class="margin-top-5">Exchange rate </span>
                        <span>1 USD =
                            <input name="ctl00$ContentPlaceHolder1$txtExchangeRate" type="text" value="23260" maxlength="5" id="ctl00_ContentPlaceHolder1_txtExchangeRate" class="inputaspx w170" disabled="disabled"> VND
                        </span>
                    </div>
                </div>
            
                <div class="f-boder">
                    <div class="title">Insurance</div>
                    <div class="clearfix">             
                        <span class="margin-top-5 mt-2">Pay for</span>
                        <span>
                            <input id="ctl00_ContentPlaceHolder1_RadioButton1" type="radio" name="ctl00$ContentPlaceHolder1$rdbPayfor" value="RadioButton1" checked="checked" onclick="chonLuongDongBaoHiem();"><label for="ctl00_ContentPlaceHolder1_RadioButton1"><strong>full wage</strong></label>
                        </span>
                        <span>
                            <input id="ctl00_ContentPlaceHolder1_RadioButton2" type="radio" name="ctl00$ContentPlaceHolder1$rdbPayfor" value="RadioButton2" onclick="chonLuongDongBaoHiem();"><label for="ctl00_ContentPlaceHolder1_RadioButton2"><strong>Other</strong></label>
                        </span>
                        <span id="idSalaryBasic" data-toggle="tooltip" data-placement="top" data-title="Please enter number salary basic">
                            <input name="ctl00$ContentPlaceHolder1$txtSalaryBasic" type="text" maxlength="13" id="ctl00_ContentPlaceHolder1_txtSalaryBasic" class="w70" disabled="disabled"> VND
                        </span>                                
                    </div>
                    <div class="clearfix mt-2">
                        <span>Included UnEmployement Insurance</span> <span>
                            <input id="ctl00_ContentPlaceHolder1_chkIncludedIns" type="checkbox" name="ctl00$ContentPlaceHolder1$chkIncludedIns" checked="checked">
                        </span>
                    </div>
                </div>
                <div class="f-boder">
                    <div class="title">Reduction based on family circumstances</div>
                    <div class="clearfix">
                        <span class="margin-top-5">Number of dependant :</span>
                        <span>
                            <input name="ctl00$ContentPlaceHolder1$txtNumberOfDep" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtNumberOfDep" class="inputaspx w70" onfocus="SearchOnFocus(this)" onblur="SearchOnBlur(this)">
                        </span>
                    </div>
                </div>
                <div class="style-btn clearfix">
                    <input id="clienGrossi" onclick="clickso1()" class="form-control btn-primary bg-orange" type="button" value="Gross to Net">
                    <input id="clientNet" onclick="clickso2()" class="form-control btn-primary bg-orange" type="button" value="Net To Gross">
                    <div style="display:none">
                        <input type="submit" name="ctl00$ContentPlaceHolder1$btnCalculator" value="Gross to Net" id="ctl00_ContentPlaceHolder1_btnCalculator" cclass="form-control btn-primary bg-orange">
                        <input type="submit" name="ctl00$ContentPlaceHolder1$btnNetToGross" value="Net To Gross" id="ctl00_ContentPlaceHolder1_btnNetToGross" class="form-control btn-primary bg-orange">
                    </div>
                </div>
                <script>
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
                    function clickso1() {
                        var bCheck = CheckLuong();
                        if (bCheck == true) {
                            $('input[id*="btnCalculator"]').click();
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
        <div class="column">
            <div id="blockUI">
                <div class="title" style="text-align: center">Description (VND)</div>
                <table class="datalist">
                    <tbody>
                        <tr class="rownote">
                            <th style="width: 300px;">GROSS Salary</th>
                            <td style="width: 105px;">
                                <strong><span id="ctl00_ContentPlaceHolder1_lblGrossSalary"></span></strong>
                            </td>
                        </tr>
                        <tr style="background-color: #CDCDCD;">
                            <th>Social insurance    (8 %)</th>
                            <td>
                                <span id="ctl00_ContentPlaceHolder1_lblSocialInsurance"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #CDCDCD;">
                            <th>Health Insurance    (1.5 %)</th>
                            <td>
                                <span id="ctl00_ContentPlaceHolder1_lblHealthInsurance"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #CDCDCD;">
                            <th>UnEmployment Insurance    (1 %)</th>
                            <td>
                                <span id="ctl00_ContentPlaceHolder1_lblThatNghiep"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #E6E6E6;">
                            <th>For the tax payer</th>
                            <td>
                                <span id="ctl00_ContentPlaceHolder1_lblGiamTruCaNhan"></span>
                            </td>
                        </tr>
                        <tr style="background-color: #CCCCCC;">
                            <th>For per person that depends on the tax payer</th>
                            <td>
                                <span id="ctl00_ContentPlaceHolder1_lblGiamTruPhuThuoc"></span>
                            </td>
                        </tr>
                        <tr class="rownote" style="background-color: #E7E7E7">
                            <th>Taxable income</th>
                            <td>
                                <span id="ctl00_ContentPlaceHolder1_lblTaxableIncome"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Personal income tax</th>
                            <td>
                                <span id="ctl00_ContentPlaceHolder1_lblIncomeTax"></span>
                            </td>
                        </tr>
                        <tr class="rownote" style="background-color: #CCCCCC">
                            <th><strong>Net salary</strong></th>
                            <td>
                                <strong><span id="ctl00_ContentPlaceHolder1_lblNetSalary"></span></strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div id="salary_comment">
                    <span>(*) GROSS:</span><span>
                        <span id="ctl00_ContentPlaceHolder1_lblGrossVnd">0</span></span><span>(VND) ≈ </span><span>
                            <span id="ctl00_ContentPlaceHolder1_lblGrossUsd">0.00</span></span><span>(USD)</span>
                    <div style="clear: both;"></div>
                    <span>(**) NET:</span><span>
                        <span id="ctl00_ContentPlaceHolder1_lblNetVnd">0</span></span><span>(VND) ≈</span><span>
                            <span id="ctl00_ContentPlaceHolder1_lblNetUsd">0.00</span></span><span>(USD)</span>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>