<?php
/**
 * Email template.You can change the content of this template
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.1.0
 */
?>
<html lang="en">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <meta charset="UTF-8">
        <style>
            table {width:60%;margin:5px;border-collapse:collapse;}
            table, th, td {border: 1px solid black;}
            th, td {padding: 20px;}
            h6 {color:blue;}
        </style>
    </head>
    <body>
        <!--<h3>{Title}</h3>-->
        Dear {Firstname} {Lastname}, <br />
        <br />
        <p style="color:blue;">The payslip of <strong>{date}.</strong></p><br />
        <table border="0">
            <tr>
                <td>GROSS &nbsp;</td><td>{GROSS}</td>
            </tr>
            <tr>
                <td>NET &nbsp;</td><td>{NET}</td>
            </tr>
            <tr>
                <td><?php echo lang('payslip_field_social_insurance');?> &nbsp;</td><td>{social_insurance}</td>
            </tr>
            <tr>
                <td><?php echo lang('payslip_field_health_insurance');?> &nbsp;</td><td>{health_insurance}</td>
            </tr>
            <tr>
                <td><?php echo lang('payslip_field_taxable_incom');?> &nbsp;</td><td>{taxable_incom}</td>
            </tr>
        </table>
        <hr>
        <h5>*** This is an automatically generated message, please do not reply to this message ***</h5>
    </body>
</html>
