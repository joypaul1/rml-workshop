<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$sfcmBasePath   = $_SESSION['sfcmBasePath'];
$log_user_id   = $_SESSION['USER_SFCM_INFO']['ID'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'create') {

    if (isset($_POST['user_id']) > 0) {

        $USER_NAME          = $_POST['date'];
        $VISIT_TYPE_ID      = $_POST['visit_type'];
        $user_ids           = $_POST['user_id'];
        $user_brand_ids     = $_POST['user_brand_id'];
        $user_remarks       = $_POST['user_remarks'];
        $VISIT_DATE         = date('Y-m-d', strtotime($_POST['date']));
        $ENTRY_BY_ID        = $log_user_id;
       

        foreach ($user_ids as $key => $user_id) {
            $user_remark    = $user_remarks[$key];
            $user_brand_id  = key($user_brand_ids[$key]);
            $query = "INSERT INTO VISIT_ASSIGN (USER_ID, VISIT_DATE, USER_REMARKS,RETAILER_ID, VISIT_TYPE_ID, ENTRY_DATE, ENTRY_BY_ID, PRODUCT_BRAND_ID) VALUES ('$log_user_id',TO_DATE('$VISIT_DATE','yyyy-mm-dd') , '$user_remark','$user_id','$VISIT_TYPE_ID',SYSDATE,'$ENTRY_BY_ID', $user_brand_id)";

            $strSQL = @oci_parse($objConnect, $query);
            // Execute the query
            if (@oci_execute($strSQL)) {
            } else {
                $e                        = @oci_error($strSQL);
                $message                  = [
                    'text'   => htmlentities($e['message'], ENT_QUOTES),
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script> window.location.href = '{$sfcmBasePath}/visit_module/view/create.php'</script>";
                exit();
            }
        }

        $message = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];

        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/visit_module/view/create.php'</script>";
        exit();
    } else {
        $message                  = [
            'text'   => "Please Select Retailer",
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/visit_module/view/create.php'</script>";
        exit();
    }
}
