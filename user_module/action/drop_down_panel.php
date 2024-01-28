<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$sfcmBasePath   = $_SESSION['sfcmBasePath'];
$folderPath = $rs_img_path;
ini_set('memory_limit', '2560M');
$log_user_id   = $_SESSION['USER_SFCM_INFO']['ID'];


// PRINT_R ($_GET);
if (isset($_GET["district_data"]  )) {
    $query    = "SELECT ID, NAME FROM DISTRICT WHERE STATUS = 1 ORDER BY ID";

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
// print_r($_GET);
if (isset($_GET["userId"]) && isset($_GET["brandAssignID"]) && isset($_GET["status"])) {
    $USER_PROFILE_ID = $_GET["userId"];
    $PRODUCT_BRAND_ID  = $_GET["brandAssignID"];
    $STATUS   = $_GET["status"];
    $query    = "SELECT 
    ID, USER_PROFILE_ID, PRODUCT_BRAND_ID
    FROM USER_BRAND_SETUP WHERE  USER_PROFILE_ID = '$USER_PROFILE_ID' AND PRODUCT_BRAND_ID = '$PRODUCT_BRAND_ID'
    FETCH FIRST 1 ROW only";

    $strSQL = @oci_parse($objConnect, $query);
    if (@oci_execute($strSQL)) {
        $data = array();
        while ($row = @oci_fetch_assoc($strSQL)) {
            $data[] = $row; // Append each row to the $data array
        }

        if (!empty($data) && count($data) > 0) {
            $updatequery    = "UPDATE USER_BRAND_SETUP
            SET 
                   ENTRY_DATE       = SYSDATE,
                   ENTRY_BY         = '$log_user_id' ,
                   STATUS           = '$STATUS'
            WHERE  USER_PROFILE_ID               = '$USER_PROFILE_ID' AND PRODUCT_BRAND_ID = '$PRODUCT_BRAND_ID'";
            $updatestrSQL = @oci_parse($objConnect, $updatequery);
            if (@oci_execute($updatestrSQL)) {
                // Data exists
                $response['status'] = true;
                $response['message'] = 'Data Updated Successfully';
                echo json_encode($response);
                exit();
            } else {
                $response['status']  = false;
                $response['message'] = 'Something went wrong! Please try again';
                echo json_encode($response);
                exit();
            }
        } else {
            $insertquery    = "INSERT INTO USER_BRAND_SETUP (USER_PROFILE_ID, PRODUCT_BRAND_ID,ENTRY_DATE, ENTRY_BY,    STATUS) 
             VALUES ( 
                '$USER_PROFILE_ID',
                '$PRODUCT_BRAND_ID',
                SYSDATE,
                '$log_user_id',
                '$STATUS' )";
            $insertquerystrSQL = @oci_parse($objConnect, $insertquery);
            if (@oci_execute($insertquerystrSQL)) {
                // Data insert
                $response['status'] = true;
                $response['message'] = 'Data Inserted Successfully';
                echo json_encode($response);
                exit();
            } else {
                $response['status']  = false;
                $response['message'] = 'Something went wrong! Please try again';
                echo json_encode($response);
                exit();
            }
        }
    } else {
        $response['status']  = false;
        $response['message'] = 'Something went wrong! Please try again';
        echo json_encode($response);
        exit();
    }
}





if (isset($_GET["brand_ID"]) && isset($_GET["type_ID"])) {
    $brand_ID = $_GET["brand_ID"];
    $type_ID  = $_GET["type_ID"];
    $query    = "SELECT ID,USER_NAME FROM USER_PROFILE WHERE USER_BRAND_ID = $brand_ID  AND USER_TYPE_ID = $type_ID";

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
