<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$sfcmBasePath   = $_SESSION['sfcmBasePath'];
$USER_LOGIN_ID   = $_SESSION['USER_SFCM_INFO']['ID'];
$START_DATE    = $_POST['start_date'];
$END_DATE      = $_POST['end_date'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'create') {

    $collection_target_amounts   = $_POST['collection_target_amount'];
    $sale_target_amounts         = $_POST['sale_target_amount'];
    try {
        foreach ($collection_target_amounts as $BRAND_ID => $USER_IDs) {
            foreach ($USER_IDs as $USER_ID => $COLLECTON_TARGET_AMOUNT) {
                if ($COLLECTON_TARGET_AMOUNT > 0) {
                    $COLLECTON_TARGET_AMOUNT = $COLLECTON_TARGET_AMOUNT ? $COLLECTON_TARGET_AMOUNT : 0;
                    $SALES_TARGET_AMOUNT = $sale_target_amounts[$BRAND_ID][$USER_ID] ? $sale_target_amounts[$BRAND_ID][$USER_ID] : 0;
                    $query = "INSERT INTO COLLECTION_ASSIGN (USER_ID, START_DATE, END_DATE, BRAND_ID, COLLECTON_TARGET_AMOUNT, SALES_TARGET_AMOUNT, ENTRY_DATE, ENTRY_BY_ID, STATUS)
                VALUES (
                    $USER_ID,
                    TO_DATE('$START_DATE','dd/mm/yyyy'),
                    TO_DATE('$END_DATE','dd/mm/yyyy'),
                    $BRAND_ID,
                    $COLLECTON_TARGET_AMOUNT,
                    $SALES_TARGET_AMOUNT,
                    SYSDATE,
                    $USER_LOGIN_ID,
                    0
                )";

                    $strSQL = oci_parse($objConnect, $query);
                    // Execute the query
                    oci_execute($strSQL);

                    // Check for errors after executing each query
                    if (oci_error($strSQL)) {
                        throw new Exception("Failed to execute query: " . oci_error($objConnect)['message']);
                    }
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
    $collection_target_amount           = $_POST['collection_target_amount'];
    $sale_target_amount                 = $_POST['sale_target_amount'];
    $edit_id                            = $_POST['editId'];
    $remarks                            = $_POST['remarks'];
    try {
        $query = "UPDATE COLLECTION_ASSIGN SET START_DATE = TO_DATE('$START_DATE','dd/mm/RRRR'),
            END_DATE = TO_DATE('$END_DATE','dd/mm/RRRR'),
            COLLECTON_TARGET_AMOUNT = $collection_target_amount,
            SALES_TARGET_AMOUNT = $sale_target_amount,
            REMARKS = '$remarks'
        WHERE ID = $edit_id";
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
