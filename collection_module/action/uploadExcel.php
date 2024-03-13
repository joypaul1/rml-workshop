<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$sfcmBasePath   = $_SESSION['sfcmBasePath'];
$USER_LOGIN_ID   = $_SESSION['USER_SFCM_INFO']['ID'];
require_once '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (isset($_POST['importSubmit'])) {

    // Allowed mime types 
    $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    // Validate whether selected file is a Excel file 
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes)) {

        // If the file is uploaded 
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $reader = new Xlsx();
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();
            $worksheet_arr = $worksheet->toArray();
            // Get the highest row and column numbers referenced in the worksheet
            $highestRow = $worksheet->getHighestRow();
            // $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            // $highestColumnIndex = PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
            $workingRow = 1;

            unset($worksheet_arr[0]);


            foreach ($worksheet_arr as $key => $row) {
                $workingRow++;
                if ($row[0] && $row[1] && $row[3] && $row[4] && $row[5]) {

                    $USER_ID            = $row[0];
                    $BRAND_ID           = $row[1];
                    $START_DATE         = $row[3];
                    $END_DATE           = $row[4];
                    $COLLECTON_TARGET_AMOUNT      = $row[5];
                    $REMARKS            = $row[6];

                    $query = "INSERT INTO COLLECTION_ASSIGN (USER_ID, START_DATE, END_DATE, BRAND_ID, COLLECTON_TARGET_AMOUNT, REMARKS,ENTRY_DATE, ENTRY_BY_ID, STATUS) 
                    VALUES ($USER_ID, TO_DATE('$START_DATE','dd/mm/yyyy'), TO_DATE('$END_DATE','dd/mm/yyyy'), $BRAND_ID, $COLLECTON_TARGET_AMOUNT,'$REMARKS', SYSDATE, $USER_LOGIN_ID, 1)";
                    $strSQL = oci_parse($objConnect, $query);

                    // Execute the query
                    oci_execute($strSQL);

                    // Check for errors after executing each query
                    if (oci_error($strSQL)) {

                        // throw new Exception("Failed to execute query: " . oci_error($objConnect)['message']);
                        $message = [
                            'text'   => "Data Uploaded Successfully row : " . ($workingRow - 1) . " .Problem Create in row :" . ($workingRow) . "& Problem is : " . oci_error($objConnect)['message'],
                            'status' => 'false',
                        ];
                        $_SESSION['noti_message'] = $message;
                        echo "<script> window.location.href = '{$sfcmBasePath}/collection_module/view/excel_upload.php'</script>";
                        exit();
                    }
                }

                $message = [
                    'text'   =>  "Data Uploaded Successfully.Total row : " . ($workingRow - 1),
                    'status' => 'true',
                ];

                $_SESSION['noti_message'] = $message;
                echo "<script> window.location.href = '{$sfcmBasePath}/collection_module/view/excel_upload.php'</script>";
                exit();
            }

            $message = [
                'text'   => 'Collection Target Created Successfully.',
                'status' => 'true',
            ];

            $_SESSION['noti_message'] = $message;
            echo "<script> window.location.href = '{$sfcmBasePath}/collection_module/view/excel_upload.php'</script>";
            exit();
        } else {
            $message = [
                'text'   => 'File Not Uploded Properly.',
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            echo "<script> window.location.href = '{$sfcmBasePath}/collection_module/view/excel_upload.php'</script>";
            exit();
        }
    } else {
        $message = [
            'text'   => 'Invalid File or File Format',
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/collection_module/view/excel_upload.php'</script>";
        exit();
    }
}
