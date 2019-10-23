<?php
/**
 * This view builds a Spreadsheet file containing the list of users.
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.2.0
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setTitle(mb_strimwidth(lang('payslip_export_title'), 0, 28, "..."));  //Maximum 31 characters allowed in sheet title.
//$sheet->setCellValue('A1', lang('payslip_export_thead_id'));
$sheet->setCellValue('A1', lang('payslip_employees_thead_date'));
$sheet->setCellValue('B1', lang('payslip_gross_salary'));
$sheet->setCellValue('C1', lang('payslip_net_salary'));
$sheet->setCellValue('D1', lang('payslip_field_social_insurance'));
$sheet->setCellValue('E1', lang('payslip_field_health_insurance'));
$sheet->setCellValue('F1', lang('payslip_field_taxable_incom'));
$sheet->setCellValue('G1', lang('payslip_field_personal_income_tax'));
$sheet->setCellValue('H1', lang('payslip_field_income_before_tax'));
$sheet->setCellValue('I1', lang('payslip_field_unEmployment_insurance'));
$sheet->setCellValue('J1', lang('payslip_field_reduction_family'));
$sheet->setCellValue('H1', lang('payslip_export_thead_number_depend'));


$sheet->getStyle('A1:H1')->getFont()->setBold(true);
$sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$payslips = $this->payslip_model->getSalaryByUserId($this->user_id);
//echo json_encode($users); die();
$line = 2;
foreach ($payslips as $user) {
    //$sheet->setCellValue('A' . $line, $user['employee_id']);
    $sheet->setCellValue('A' . $line, date("d/m/Y", strtotime($user['date'])));
    $sheet->setCellValue('B' . $line, number_format($user['salary_basic']));
    $sheet->setCellValue('C' . $line, number_format($user['salary_net']));
    $sheet->setCellValue('D' . $line, number_format($user['social_insurance']));
    $sheet->setCellValue('E' . $line, number_format($user['health_insurance']));
    $sheet->setCellValue('F' . $line, number_format($user['income_before_tax']));
    $sheet->setCellValue('G' . $line, number_format($user['personal_income_tax']));
    $sheet->setCellValue('H' . $line, number_format($user['taxable_incom']));
    $sheet->setCellValue('I' . $line, number_format($user['unEmployment_insurance']));
    $sheet->setCellValue('J' . $line, number_format($user['peson_tax_payer']));
    
    $sheet->setCellValue('H' . $line, $user['number_dependant']);
    
    $line++;
}

//Autofit
foreach(range('A', 'H') as $colD) {
    $sheet->getColumnDimension($colD)->setAutoSize(TRUE);
}

$spreadsheet->exportName = 'payslip-detail';
writeSpreadsheet($spreadsheet);
