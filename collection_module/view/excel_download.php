<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
require_once '../../vendor/autoload.php';
$sfcmBasePath   = $_SESSION['sfcmBasePath'];


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$fileName = $_GET['brand_name'] . "_" . date("Y-m-d") . '.xlsx'; // Set the desired file name
$dataSource  = [];
$brand_ID = $_GET['brand_type'];
$query = "SELECT UP.ID, UP.USER_NAME, UP.USER_MOBILE
        FROM
            USER_PROFILE UP
        LEFT JOIN
            USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
        WHERE
            UBS.PRODUCT_BRAND_ID IN ($brand_ID)
            AND UBS.STATUS = 1
            AND UP.USER_TYPE_ID = 3";
$strSQL = oci_parse(
    $objConnect,
    $query
);
oci_execute($strSQL);
$modifyRow = [];
while ($row = oci_fetch_assoc($strSQL)) {

    $modifyRow['ID'] = $row['ID'];
    $modifyRow['BRAND_ID']      = $brand_ID;
    $modifyRow['USER_NAME']     = $row['USER_NAME'] . '-' . $row['USER_MOBILE'];
    $modifyRow['Start_date']    = date("01/m/Y");
    $modifyRow['end_date']    = date("t/m/Y");
}


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$headers = ['USER_ID', 'BRAND_ID', 'USER_INFO', 'START_DATE', 'END_DATE', 'COLLECTON_TARGET_AMOUNT', 'REMARKS'];

// Set headers in the first row
$sheet->fromArray([$headers], null, 'A1');

// Set data starting from the second row
$sheet->fromArray($modifyRow, null, 'A2');

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
$writer->save('php://output');
exit();
