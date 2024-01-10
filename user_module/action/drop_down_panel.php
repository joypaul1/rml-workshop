<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$basePath   = $_SESSION['basePath'];
$folderPath = $rs_img_path;
ini_set('memory_limit', '2560M');
$valid_formats = array( "jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP" );
$log_user_id   = $_SESSION['USER_INFO']['ID'];



if (($_GET["brand_ID"]) && ($_GET["type_ID"])) {
    $brand_ID = $_GET["brand_ID"];
    $type_ID  = $_GET["type_ID"];
    $query    = "SELECT ID,USER_NAME FROM USER_PROFILE WHERE USER_BRAND_ID = $brand_ID or USER_BRAND_ID = 1 AND USER_TYPE_ID = $type_ID";

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
    }
    else {
        $response['status']  = false;
        $response['message'] = 'Something went wrong! Please try again';
        echo json_encode($response);
        exit();
    }
}

function pathExitOrCreate($folderPath)
{
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }
}
function getExtension($str)
{
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l   = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

function compressImage($ext, $uploadedfile, $path, $actual_image_name, $newwidth, $newheight)
{
    if ($ext == "jpg" || $ext == "jpeg") {
        $src = imagecreatefromjpeg($uploadedfile);
    }
    else if ($ext == "png") {
        $src = imagecreatefrompng($uploadedfile);
    }
    else if ($ext == "gif") {
        $src = imagecreatefromgif($uploadedfile);
    }
    else {
        $src = imagecreatefrombmp($uploadedfile);
    }
    list( $width, $height ) = getimagesize($uploadedfile);
    if (!$newheight) {
        $newheight = ($height / $width) * $newwidth;
    }
    $tmp = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    $filename = $path . $actual_image_name; //PixelSize_TimeStamp.jpg
    imagejpeg($tmp, $filename, 100);
    imagedestroy($tmp);
    return str_replace('../', '', $filename);
}

function random_strings($length_of_string)
{
    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    // Shuffle the $str_result and returns substring
    // of specified length
    return substr(
        str_shuffle($str_result),
        0,
        $length_of_string
    );
}
