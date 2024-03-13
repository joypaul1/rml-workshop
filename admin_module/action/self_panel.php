<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$sfcmBasePath   = $_SESSION['sfcmBasePath'];
$folderPath = $rs_img_path;
ini_set('memory_limit', '2560M');

$USER_LOGIN_ID   = $_SESSION['USER_SFCM_INFO']['ID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  $_POST["actionType"] == 'dis_create') {

    $NAME      = trim($_POST['NAME']);
    // Prepare the SQL statement
    $query = "INSERT INTO DISTRICT (NAME)  VALUES ('$NAME')";

    $strSQL = @oci_parse($objConnect, $query);

    // Execute the query
    if (@oci_execute($strSQL)) {

        $message = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/admin_module/view/district.php'</script>";
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  $_POST["actionType"] == 'dis_edit') {

    $editId     = $_POST['editId'];
    $NAME      = trim($_POST['NAME']);
    $STATUS     = $_POST['STATUS'];

    // Prepare the SQL statement
    $query = "UPDATE DISTRICT
    SET    
           NAME  = '$NAME',
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
        echo "<script> window.location.href = '{$sfcmBasePath}/admin_module/view/district.php'</script>";
    } else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/admin_module/view/dis_edit.php?id={$editId}&actionType=edit'</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  $_POST["actionType"] == 'ut_edit') {

    $editId     = $_POST['editId'];
    $TITLE      = trim($_POST['TITLE']);
    $STATUS     = $_POST['STATUS'];

    // Prepare the SQL statement
    $query = "UPDATE USER_TYPE
    SET    
           TITLE  = '$TITLE',
           STATUS = '$STATUS'
    WHERE ID      = $editId";

    $strSQL = @oci_parse($objConnect, $query);

    // Execute the query
    if (@oci_execute($strSQL)) {

        $message = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];

        $_SESSION['noti_message'] = $message;

        echo "<script> window.location.href = '{$sfcmBasePath}/admin_module/view/user_type.php'</script>";
    } else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/admin_module/view/ut_edit.php?id={$editId}&actionType=edit'</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  $_POST["actionType"] == 'vt_edit') {

    $editId     = $_POST['editId'];
    $TITLE      = trim($_POST['TITLE']);
    $STATUS     = $_POST['STATUS'];

    // Prepare the SQL statement
    $query = "UPDATE VISIT_TYPE
    SET    
           TITLE  = '$TITLE',
           STATUS = '$STATUS'
    WHERE ID      = $editId";

    $strSQL = @oci_parse($objConnect, $query);

    // Execute the query
    if (@oci_execute($strSQL)) {

        $message = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];

        $_SESSION['noti_message'] = $message;

        echo "<script> window.location.href = '{$sfcmBasePath}/admin_module/view/visit_type.php'</script>";
    } else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/admin_module/view/vt_edit.php?id={$editId}&actionType=edit'</script>";
    }
}
