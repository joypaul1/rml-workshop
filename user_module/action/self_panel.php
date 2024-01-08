<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$basePath   = $_SESSION['basePath'];
$folderPath = $rs_img_path;

ini_set('memory_limit', '2560M');
$valid_formats = array( "jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP" );
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'create') {

    $USER_NAME     = $_POST['USER_NAME'];
    $USER_MOBILE   = $_POST['USER_MOBILE'];
    $USER_BRAND_ID = $_POST['USER_BRAND_ID'];
    $USER_TYPE_ID  = $_POST['USER_TYPE_ID'];
    $IMAGE_LINK    = $_FILES['IMAGE_LINK'];
    $filename      = null;

    if ($IMAGE_LINK) {
        $imagename = $IMAGE_LINK['name'];
        $size      = $IMAGE_LINK['size'];

        if (strlen($imagename)) {
            $ext = strtolower(getExtension($imagename));
            if (in_array($ext, $valid_formats)) {
                $imgStorePath = '../../user_profile_image/';

                pathExitOrCreate($imgStorePath); // check if folder exists or create

                $actual_image_name = 'user_' . $editId . '_' . time() . "." . $ext;
                $uploadedfile      = $IMAGE_LINK['tmp_name'];
                //Re-sizing image. 
                $width    = 150; //You can change dimension here.
                $height   = 100; //You can change dimension here.
                $filename = compressImage($ext, $uploadedfile, $imgStorePath, $actual_image_name, $width, $height);


                if ($filename) {

                }
                else {

                    $imageStatus              = "Something went wrong file uploading!";
                    $_SESSION['noti_message'] = $imageStatus;
                    echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
                    exit();
                }
            }
            else {
                $imageStatus              = 'Sorry, only JPG, JPEG, PNG, BMP,GIF, & PDF files are allowed to upload!';
                $_SESSION['noti_message'] = $imageStatus;
                echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
            }
        }

    }

    // Prepare the SQL statement
    $query = "INSERT INTO USER_PROFILE 
            (USER_NAME, USER_MOBILE, USER_BRAND_ID, USER_TYPE_ID, IMAGE_LINK) 
            VALUES  ('$USER_NAME', '$USER_MOBILE', '$USER_BRAND_ID', '$USER_TYPE_ID', '$filename')";

    $strSQL = @oci_parse($objConnect, $query);

    // Execute the query
    if (@oci_execute($strSQL)) {

        $message = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];

        $_SESSION['noti_message'] = $message;

        echo "<script> window.location.href = '{$basePath}/user_module/view/edit.php?id={$editId}&actionType=edit'</script>";
    }
    else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'edit') {

    $editId        = $_POST['editId'];
    $USER_NAME     = $_POST['USER_NAME'];
    $USER_MOBILE   = $_POST['USER_MOBILE'];
    $USER_BRAND_ID = $_POST['USER_BRAND_ID'];
    $USER_TYPE_ID  = $_POST['USER_TYPE_ID'];
    $IMAGE_LINK    = $_FILES['IMAGE_LINK'];
    if ($IMAGE_LINK) {
        $imagename = $IMAGE_LINK['name'];
        $size      = $IMAGE_LINK['size'];

        if (strlen($imagename)) {
            $ext = strtolower(getExtension($imagename));
            if (in_array($ext, $valid_formats)) {
                $imgStorePath = '../../user_profile_image/';

                pathExitOrCreate($imgStorePath); // check if folder exists or create

                $actual_image_name = 'user_' . $editId . '_' . time() . "." . $ext;
                $uploadedfile      = $IMAGE_LINK['tmp_name'];
                //Re-sizing image. 
                $width    = 150; //You can change dimension here.
                $height   = 100; //You can change dimension here.
                $filename = compressImage($ext, $uploadedfile, $imgStorePath, $actual_image_name, $width, $height);
                $insert   = false; //

                if ($filename) {
                    // delet previous image
                    $query  = "SELECT UP.ID,UP.IMAGE_LINK
                    FROM USER_PROFILE UP WHERE ID = $editId";
                    $strSQL = @oci_parse($objConnect, $query);
                    @oci_execute($strSQL);
                    $data = @oci_fetch_assoc($strSQL);

                    if ($data['IMAGE_LINK']) {
                        $file = '../../user_profile_image/' . $data['IMAGE_LINK'];
                        if (file_exists($file)) {
                            unlink($file); // delete image if exist
                        }
                    }  // end delet previous image
                    // update image  link
                    $query = "UPDATE USER_PROFILE SET IMAGE_LINK = '$filename' WHERE ID = $editId";

                    $strSQL = @oci_parse($objConnect, $query);
                    if (@oci_execute($strSQL)) {
                    }
                    else {
                        $e                        = @oci_error($strSQL);
                        $message                  = [
                            'text'   => htmlentities($e['message'], ENT_QUOTES),
                            'status' => 'false',
                        ];
                        $_SESSION['noti_message'] = $message;
                        echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
                    }
                }
                else {

                    $imageStatus              = "Something went wrong file uploading!";
                    $_SESSION['noti_message'] = $imageStatus;
                    echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
                    exit();
                }
            }
            else {
                $imageStatus              = 'Sorry, only JPG, JPEG, PNG, BMP,GIF, & PDF files are allowed to upload!';
                $_SESSION['noti_message'] = $imageStatus;
                echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
            }
        }


    }

    // Prepare the SQL statement
    $query  = "UPDATE USER_PROFILE SET 
    USER_NAME       = '$USER_NAME',
    USER_MOBILE     = '$USER_MOBILE',
    USER_BRAND_ID   = '$USER_BRAND_ID',
    USER_TYPE_ID    = '$USER_TYPE_ID'          
    WHERE ID        = $editId";
    $strSQL = @oci_parse($objConnect, $query);

    // Execute the query
    if (@oci_execute($strSQL)) {

        $message = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];

        $_SESSION['noti_message'] = $message;

        echo "<script> window.location.href = '{$basePath}/user_module/view/edit.php?id={$editId}&actionType=edit'</script>";
    }
    else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
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
