<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$sfcmBasePath   = $_SESSION['sfcmBasePath'];
$folderPath = $rs_img_path;
ini_set('memory_limit', '2560M');

$log_user_id   = $_SESSION['USER_SFCM_INFO']['ID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  $_POST["actionType"] == 'create') {

    $TITLE      = trim($_POST['TITLE']);
    // Prepare the SQL statement
    $query = "INSERT INTO PLAZA_PARENT (TITLE, STATUS)  VALUES ('$TITLE', 1)";

    $strSQL = @oci_parse($objConnect, $query);

    // Execute the query
    if (@oci_execute($strSQL)) {

        $message = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/admin_module/view/plaza_retailer_type.php'</script>";
    } else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/admin_module/view/dis_create.php'</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  $_POST["actionType"] == 'edit') {

    $editId     = $_POST['editId'];
    $TITLE      = trim($_POST['TITLE']);
    $STATUS     = $_POST['STATUS'];

    // Prepare the SQL statement
    $query = "UPDATE PLAZA_PARENT
    SET    
           TITLE  = '$TITLE',
           STATUS = '$STATUS'
    WHERE ID      = $editId";

    $strSQL = @oci_parse($objConnect, $query);

    // Execute the query
    if (@oci_execute($strSQL)) {

        $message = [
            'text'   => 'Data Update successfully.',
            'status' => 'true',
        ];

        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/admin_module/view/plaza_retailer_type.php'</script>";
    } else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/admin_module/view/pr_edit.php?id={$editId}&actionType=edit'</script>";
    }
}
