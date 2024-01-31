<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$sfcmBasePath   = $_SESSION['sfcmBasePath'];
$log_user_id   = $_SESSION['USER_SFCM_INFO']['ID'];

$START_DATE                  = $_POST['start_date'];
$END_DATE                    = $_POST['end_date'];
$collection_amounts          = $_POST['collection_amount'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'create') {

    // Start the transaction
    // oci_execute(oci_parse($objConnect, 'BEGIN'));

    try {
        foreach ($collection_amounts as $BRAND_ID => $USER_IDs) {
            foreach ($USER_IDs as $USER_ID => $TARGET_AMOUNT) {
                $TARGET_AMOUNT = $TARGET_AMOUNT ? $TARGET_AMOUNT : 0;
                $query = "INSERT INTO COLLECTION_ASSIGN (USER_ID, START_DATE, END_DATE, BRAND_ID, TARGET_AMOUNT, ENTRY_DATE, ENTRY_BY_ID, STATUS) 
                          VALUES ($USER_ID, TO_DATE('$START_DATE','dd/mm/yyyy'), TO_DATE('$END_DATE','dd/mm/yyyy'), $BRAND_ID, $TARGET_AMOUNT, SYSDATE, $log_user_id, 1)";
                $strSQL = oci_parse($objConnect, $query);

                // Execute the query
                oci_execute($strSQL);

                // Check for errors after executing each query
                if (oci_error($strSQL)) {
                    throw new Exception("Failed to execute query: " . oci_error($objConnect)['message']);
                }
            }
        }

        // Commit the transaction
        // oci_commit($objConnect);

        $message = [
            'text'   => 'Collection Target Created Successfully.',
            'status' => 'true',
        ];

        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/collection_module/view/create.php'</script>";
        exit();
    } catch (Exception $e) {
        // An error occurred, rollback the transaction
        // oci_rollback($objConnect);

        $message = [
            'text'   => htmlentities($e->getMessage(), ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/collection_module/view/create.php'</script>";
        exit();
    }
}
