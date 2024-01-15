<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$basePath   = $_SESSION['basePath'];
$folderPath = $rs_img_path;
ini_set('memory_limit', '2560M');
$log_user_id   = $_SESSION['USER_INFO']['ID'];

if (isset($_GET["brand_ID"]) && isset($_GET["type_ID"])) {
    $brand_ID = $_GET["brand_ID"];
    $type_ID  = $_GET["type_ID"];
    $query    = "SELECT ID,USER_NAME FROM USER_PROFILE WHERE USER_BRAND_ID = $brand_ID AND USER_TYPE_ID = $type_ID";

    $strSQL = @oci_parse($objConnect, $query);
    if (@oci_execute($strSQL)) {
        $data = array();
        while ($row = @oci_fetch_assoc($strSQL)) {
            $data[] = $row; // Append each row to the $data array
        }

        $response['status'] = true;
        $response['data']   = $data;
        echo json_encode($response);
        exit();
    } else {
        $response['status']  = false;
        $response['message'] = 'Something went wrong! Please try again';
        echo json_encode($response);
        exit();
    }
}
