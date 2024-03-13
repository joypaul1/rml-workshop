<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$sfcmBasePath   = $_SESSION['sfcmBasePath'];
$folderPath = $rs_img_path;
ini_set('memory_limit', '2560M');
$USER_LOGIN_ID   = $_SESSION['USER_SFCM_INFO']['ID'];

// && isset($_GET["brand_ID"])

if (isset($_GET["plaza_retailer"])) {
    $PARENT_USER_ID = $_GET["sale_executive"];
    $query    = "SELECT B.USER_NAME,B.USER_MOBILE FROM USER_MANPOWER_SETUP A,USER_PROFILE B
    WHERE A.USER_ID=B.ID AND A.PARENT_USER_ID='$PARENT_USER_ID'";

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

if (isset($_GET["retailer"])) {
    $PARENT_USER_ID = $_GET["plaza_retailer"];
    $query    = "SELECT B.USER_NAME,B.USER_MOBILE FROM USER_MANPOWER_SETUP A,USER_PROFILE B
    WHERE A.USER_ID=B.ID AND A.PARENT_USER_ID='$PARENT_USER_ID'";

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
// get retailer  by sale_executive
// if (isset($_GET["sale_executive"])) {
//     $sale_executiveID = $_GET["sale_executive"];
//     $query    = "SELECT ID,USER_NAME FROM USER_PROFILE WHERE USER_TYPE_ID = 3";

//     $strSQL = @oci_parse($objConnect, $query);
//     if (@oci_execute($strSQL)) {
//         $data = array();
//         while ($row = @oci_fetch_assoc($strSQL)) {
//             $data[] = $row; // Append each row to the $data array
//         }

//         $response['status'] = true;
//         $response['data']   = $data;
//         echo json_encode($response);
//         exit();
//     } else {
//         $response['status']  = false;
//         $response['message'] = 'Something went wrong! Please try again';
//         echo json_encode($response);
//         exit();
//     }
// }
// get mechanic  by retailer
// if (isset($_GET["retailer"])) {
//     $retailerID = $_GET["retailer"];
//     $query    = "SELECT ID,USER_NAME FROM USER_PROFILE WHERE USER_TYPE_ID = 5 AND RESPONSIBLE_ID = $retailerID";

//     $strSQL = @oci_parse($objConnect, $query);
//     if (@oci_execute($strSQL)) {
//         $data = array();
//         while ($row = @oci_fetch_assoc($strSQL)) {
//             $data[] = $row; // Append each row to the $data array
//         }

//         $response['status'] = true;
//         $response['data']   = $data;
//         echo json_encode($response);
//         exit();
//     } else {
//         $response['status']  = false;
//         $response['message'] = 'Something went wrong! Please try again';
//         echo json_encode($response);
//         exit();
//     }
// }
