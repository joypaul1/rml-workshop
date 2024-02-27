<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$sfcmBasePath   = $_SESSION['sfcmBasePath'];
$log_user_id   = $_SESSION['USER_SFCM_INFO']['ID'];
$START_DATE    = $_POST['start_date'];
$END_DATE      = $_POST['end_date'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'create') {

    $collection_amounts          = $_POST['collection_amount'];

    try {
        foreach ($collection_amounts as $BRAND_ID => $USER_IDs) {
            foreach ($USER_IDs as $USER_ID => $TARGET_AMOUNT) {
                $TARGET_AMOUNT = $TARGET_AMOUNT ? $TARGET_AMOUNT : 0;
                $query = "INSERT INTO COLLECTION_ASSIGN (USER_ID, START_DATE, END_DATE, BRAND_ID, TARGET_AMOUNT, ENTRY_DATE, ENTRY_BY_ID, STATUS)
                        VALUES ($USER_ID, TO_DATE('$START_DATE','dd/mm/yyyy'), TO_DATE('$END_DATE','dd/mm/yyyy'), $BRAND_ID, $TARGET_AMOUNT, SYSDATE, $log_user_id, 0)";
                $strSQL = oci_parse($objConnect, $query);

                // Execute the query
                oci_execute($strSQL);

                // Check for errors after executing each query
                if (oci_error($strSQL)) {
                    throw new Exception("Failed to execute query: " . oci_error($objConnect)['message']);
                }
            }
        }

        $message = [
            'text'   => 'Collection Target Created Successfully.',
            'status' => 'true',
        ];

        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/collection_module/view/create.php'</script>";
        exit();
    } catch (Exception $e) {

        $message = [
            'text'   => htmlentities($e->getMessage(), ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/collection_module/view/create.php'</script>";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'edit') {
    $target_amount          = $_POST['target_amount'];
    $edit_id                = $_POST['editId'];
    $remarks                = $_POST['remarks'];
    try {
        $query = "UPDATE COLLECTION_ASSIGN
        SET START_DATE = TO_DATE('$START_DATE','dd/mm/RRRR'),
            END_DATE = TO_DATE('$END_DATE','dd/mm/RRRR'),
            TARGET_AMOUNT = $target_amount,
            REMARKS = '$remarks'
        WHERE ID = $edit_id";
        echo  $query;
        $strSQL = oci_parse($objConnect, $query);

        // Execute the query
        oci_execute($strSQL);

        // Check for errors after executing each query
        if (oci_error($strSQL)) {
            $e                        = @oci_error($strSQL);
            $message                  = [
                'text'   => htmlentities($e['message'], ENT_QUOTES),
                'status' => 'false',
            ];
            $_SESSION['noti_message'] = $message;
            echo "<script> window.location.href = '{$sfcmBasePath}/collection_module/view/edit.php?id=$edit_id&actionType=edit'</script>";
            exit();
        }
        $message = [
            'text'   => 'Collection Target Updated Successfully.',
            'status' => 'true',
        ];

        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/collection_module/view/edit.php?id=$edit_id&actionType=edit'</script>";
        exit();
    } catch (Exception $e) {

        $message = [
            'text'   => htmlentities($e->getMessage(), ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/collection_module/view/edit.php?id=$edit_id&actionType=edit'</script>";
        exit();
    }
}
