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

$sheet->setTitle(mb_strimwidth(lang('users_export_title'), 0, 28, "..."));  //Maximum 31 characters allowed in sheet title.
$sheet->setCellValue('A1', lang('users_export_thead_id'));
$sheet->setCellValue('B1', lang('users_export_thead_firstname'));
$sheet->setCellValue('C1', lang('users_export_thead_lastname'));
$sheet->setCellValue('D1', lang('users_export_thead_email'));
$sheet->setCellValue('E1', lang('users_export_thead_manager'));
$sheet->setCellValue('F1', lang('users_export_thead_annualleave'));
$sheet->setCellValue('G1', lang('users_myprofile_field_phoneNo'));

$sheet->getStyle('A1:G1')->getFont()->setBold(true);
$sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$users = $this->users_model->getUsers();
$line = 2;
foreach ($users as $user) {
    $sheet->setCellValue('A' . $line, $user['id']);
    $sheet->setCellValue('B' . $line, $user['firstname']);
    $sheet->setCellValue('C' . $line, $user['lastname']);
    $sheet->setCellValue('D' . $line, $user['email']);
    $sheet->setCellValue('E' . $line, $user['manager']);
    $sheet->setCellValue('F' . $line, $user['annualleave']);
    $sheet->setCellValue('G' . $line, $user['telephone']);
    $line++;
}

//Autofit
foreach(range('A', 'G') as $colD) {
    $sheet->getColumnDimension($colD)->setAutoSize(TRUE);
}

$spreadsheet->exportName = 'users';
writeSpreadsheet($spreadsheet);
