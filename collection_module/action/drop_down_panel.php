<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$sfcmBasePath   = $_SESSION['sfcmBasePath'];
$folderPath = $rs_img_path;
ini_set('memory_limit', '2560M');
$log_user_id   = $_SESSION['USER_SFCM_INFO']['ID'];


// retailer_plaza_data
if (isset($_GET["sale_executive_id"]) && $_GET["retailer_plaza_data"]) {
    $sale_executive_id = $_GET["sale_executive_id"];
    $query    = "SELECT UP.ID,UP.USER_NAME,UP.USER_MOBILE,
    (SELECT ID FROM PRODUCT_BRAND WHERE ID=UBS.PRODUCT_BRAND_ID) AS USER_BRAND_ID
    FROM USER_MANPOWER_SETUP UMP,USER_PROFILE UP
    LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
    WHERE UMP.USER_ID = UP.ID
    AND UBS.STATUS = 1
    AND UMP.PARENT_USER_ID = $sale_executive_id";

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
// plaza_data
if (isset($_GET["plaza_retailer_data_id"]) && $_GET["retailer_data"]) {
    $plaza_retailer_data_id = $_GET["plaza_retailer_data_id"];
    $query    = "SELECT UP.ID,UP.USER_NAME,UP.USER_MOBILE,
    (SELECT ID FROM PRODUCT_BRAND WHERE ID=UBS.PRODUCT_BRAND_ID) AS USER_BRAND_ID
    FROM USER_MANPOWER_SETUP UMP,USER_PROFILE UP
    LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
    WHERE UMP.USER_ID = UP.ID
    AND UBS.STATUS = 1
    AND UMP.PARENT_USER_ID = $plaza_retailer_data_id";

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
