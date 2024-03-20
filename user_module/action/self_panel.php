<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$sfcmBasePath   = $_SESSION['sfcmBasePath'];
$folderPath = $rs_img_path;
ini_set('memory_limit', '2560M');
$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
$USER_LOGIN_ID   = $_SESSION['USER_SFCM_INFO']['ID'];



if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'create') {

    $USER_NAME              = $_POST['USER_NAME'];
    $PENDRIVE_ID            = $_POST['USER_PASSWORD'];
    $USER_PASSWORD          = isset($_POST['USER_PASSWORD']) ? md5($_POST['USER_PASSWORD']) : '';
    $USER_MOBILE            = $_POST['USER_MOBILE'];
    $RML_ID                 = $_POST['RML_ID'];
    $USER_TYPE_ID           = $_POST['USER_TYPE_ID'];
    $RML_ID                 = isset($_POST['RML_ID']) ? $_POST['RML_ID'] : '';
    $IMAGE_LINK             = $_FILES['IMAGE_LINK'];
    $LANG                   = isset($_POST['LANG']) ? $_POST['LANG'] : '';
    $LAT                    = isset($_POST['LAT']) ? $_POST['LAT'] : '';
    $LOCATION_REMARKS       = isset($_POST['LOCATION_REMARKS']) ? $_POST['LOCATION_REMARKS'] : '';
    $DISTRICT_ID            = isset($_POST['DISTRICT_ID']) ? ($_POST['DISTRICT_ID']) : '';
    $PLAZA_PARENT_ID        = isset($_POST['PLAZA_PARENT_ID']) ? ($_POST['PLAZA_PARENT_ID']) : '';

    $filename       = null;

    if ($IMAGE_LINK) {
        $imagename = $IMAGE_LINK['name'];
        $size      = $IMAGE_LINK['size'];

        if (strlen($imagename)) {
            $ext = strtolower(getExtension($imagename));
            if (in_array($ext, $valid_formats)) {
                $imgStorePath = '../../user_profile_image/';

                pathExitOrCreate($imgStorePath); // check if folder exists or create
                $getLastUser = @oci_parse($objConnect, "SELECT ID from USER_PROFILE ORDER BY ID DESC FETCH FIRST 1 ROWS ONLY");
                @oci_execute($getLastUser);
                $getLastUserData   = @oci_fetch_assoc($getLastUser);
                $actual_image_name = 'user_' . $getLastUserData['ID'] + 1 . '_' . time() . "." . $ext;
                $uploadedfile      = $IMAGE_LINK['tmp_name'];
                //Re-sizing image. 
                $width    = 150; //You can change dimension here.
                $height   = 100; //You can change dimension here.
                $filename = compressImage($ext, $uploadedfile, $imgStorePath, $actual_image_name, $width, $height);


                if ($filename) {
                } else {

                    $imageStatus              = "Something went wrong file uploading!";
                    $_SESSION['noti_message'] = $imageStatus;
                    echo "<script> window.location.href = '{$sfcmBasePath}/user_module/view/create.php'</script>";
                    exit();
                }
            } else {
                $imageStatus              = 'Sorry, only JPG, JPEG, PNG, BMP,GIF, & PDF files are allowed to upload!';
                $_SESSION['noti_message'] = $imageStatus;
                echo "<script> window.location.href = '{$sfcmBasePath}/user_module/view/create.php'</script>";
                exit();
            }
        }
    }

    // Prepare the SQL statement
    $query = "INSERT INTO USER_PROFILE
            (USER_NAME, USER_MOBILE, USER_PASSWORD,PENDRIVE_ID,RML_IDENTITY_ID, USER_TYPE_ID, IMAGE_LINK,USER_STATUS,CREATED_BY_ID,CREATED_DATE,LANG, LAT,LOCATION_REMARKS,DISTRICT_ID, PLAZA_PARENT_ID) 
            VALUES  ('$USER_NAME', '$USER_MOBILE', '$USER_PASSWORD','$PENDRIVE_ID','$RML_ID','$USER_TYPE_ID', '$filename','1', $USER_LOGIN_ID,SYSDATE,'$LANG', '$LAT', '$LOCATION_REMARKS', '$DISTRICT_ID', '$PLAZA_PARENT_ID')";
            // echo $query ;
            // die();


    $strSQL = @oci_parse($objConnect, $query);

    // Execute the query
    if (@oci_execute($strSQL)) {

        $message = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];

        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/user_module/view/create.php'</script>";
        exit();
    } else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/user_module/view/create.php'</script>";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'edit') {

    $editId                 = $_POST['editId'];
    $USER_NAME              = $_POST['USER_NAME'];
    $USER_MOBILE            = $_POST['USER_MOBILE'];
    $PENDRIVE_ID            = $_POST['USER_PASSWORD'];
    $USER_PASSWORD          = isset($_POST['USER_PASSWORD']) ? md5($_POST['USER_PASSWORD']) : '';
    $RML_ID                 = isset($_POST['RML_ID']) ? $_POST['RML_ID'] : '';
    $USER_TYPE_ID           = $_POST['USER_TYPE_ID'];
    $LANG                   = isset($_POST['LANG']) ? $_POST['LANG'] : '';
    $LAT                    = isset($_POST['LAT']) ? $_POST['LAT'] : '';
    $LOCATION_REMARKS       = isset($_POST['LOCATION_REMARKS']) ? $_POST['LOCATION_REMARKS'] : '';
    $DISTRICT_ID            = isset($_POST['DISTRICT_ID']) ? ($_POST['DISTRICT_ID']) : '';
    $PLAZA_PARENT_ID        = isset($_POST['PLAZA_PARENT_ID']) ? ($_POST['PLAZA_PARENT_ID']) : '';


    // Prepare the SQL statement
    $query = "UPDATE USER_PROFILE SET 
    USER_NAME           = '$USER_NAME',
    USER_MOBILE         = '$USER_MOBILE',
    USER_PASSWORD       = '$USER_PASSWORD',
    PENDRIVE_ID         = '$PENDRIVE_ID',
    RML_IDENTITY_ID     = '$RML_ID',
    USER_TYPE_ID        = '$USER_TYPE_ID',  
    UPDATED_BY_ID       =  $USER_LOGIN_ID,
    LANG                = '$LANG',
    LAT                 = '$LAT',
    DISTRICT_ID         = '$DISTRICT_ID',
    LOCATION_REMARKS    = '$LOCATION_REMARKS',
    PLAZA_PARENT_ID     = '$PLAZA_PARENT_ID',
    UPDATED_DATE        = SYSDATE 
    WHERE ID            = $editId";

    $strSQL = @oci_parse($objConnect, $query);

    // Execute the query
    if (@oci_execute($strSQL)) {

        $message = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];

        $_SESSION['noti_message'] = $message;

        echo "<script> window.location.href = '{$sfcmBasePath}/user_module/view/edit.php?id={$editId}&actionType=edit'</script>";
    } else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/user_module/view/edit.php?id={$editId}&actionType=edit'</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'profileUpdate') {


    $editId        = $_POST['editId'];
    $USER_NAME     = $_POST['user_name'];
    $USER_PASSWORD = $_POST['user_password'];
    $IMAGE_LINK    = $_FILES['user_image'];
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
                    $_SESSION['USER_SFCM_INFO']['IMAGE_LINK'] = $filename;
                    $strSQL = @oci_parse($objConnect, $query);
                    if (@oci_execute($strSQL)) {
                    } else {
                        $e                        = @oci_error($strSQL);
                        $message                  = [
                            'text'   => htmlentities($e['message'], ENT_QUOTES),
                            'status' => 'false',
                        ];
                        $_SESSION['noti_message'] = $message;
                        echo "<script> window.location.href = '{$sfcmBasePath}/user_module/view/profile.php?id={$editId}&actionType=profileEdit'</script>";
                    }
                } else {

                    $imageStatus              = "Something went wrong file uploading!";
                    $_SESSION['noti_message'] = $imageStatus;
                    echo "<script> window.location.href = '{$sfcmBasePath}/user_module/view/profile.php?id={$editId}&actionType=profileEdit'</script>";
                    exit();
                }
            } else {
                $imageStatus              = 'Sorry, only JPG, JPEG, PNG, BMP,GIF, & PDF files are allowed to upload!';
                $_SESSION['noti_message'] = $imageStatus;
                echo "<script> window.location.href = '{$sfcmBasePath}/user_module/view/profile.php?id={$editId}&actionType=profileEdit'</script>";
            }
        }
    }

    if ($USER_PASSWORD) {
        // Prepare the SQL statement
        $query = "UPDATE USER_PROFILE SET 
        USER_NAME       = '$USER_NAME',
        USER_PASSWORD   = '$USER_PASSWORD',
        PENDRIVE_ID     = '$USER_PASSWORD'
        WHERE ID        = $editId";
    } else {
        $query = "UPDATE USER_PROFILE SET 
        USER_NAME       = '$USER_NAME'
        WHERE ID        = $editId";
    }
    $_SESSION['USER_SFCM_INFO']['USER_NAME'] = $USER_NAME;
    $strSQL = @oci_parse($objConnect, $query);

    // Execute the query
    if (@oci_execute($strSQL)) {

        $message = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];

        $_SESSION['noti_message'] = $message;

        echo "<script> window.location.href = '{$sfcmBasePath}/user_module/view/profile.php?id={$editId}&actionType=profileEdit'</script>";
    } else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/user_module/view/profile.php?id={$editId}&actionType=profileEdit'</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'resource_allocation') {

    $PARENT_USER_ID       = $_POST['PARENT_USER_ID'];
    $USER_ID              = $_POST['USER_ID'];
    $BRAND_ID             = $_POST['BRAND_ID'];

    // Prepare the SQL statement
    $query = "MERGE INTO USER_MANPOWER_SETUP UMS
          USING DUAL
          ON (UMS.USER_ID = :USER_ID AND UMS.BRAND_ID = :BRAND_ID)
          WHEN MATCHED THEN
                UPDATE SET UMS.ENTRY_DATE = SYSDATE,
                        UMS.PARENT_USER_ID = :PARENT_USER_ID,
                        UMS.ENTRY_BY_ID = :ENTRY_BY_ID,
                        UMS.STATUS = 1
          WHEN NOT MATCHED THEN
              INSERT (PARENT_USER_ID, USER_ID, ENTRY_DATE, ENTRY_BY_ID, STATUS, BRAND_ID)
              VALUES (:PARENT_USER_ID, :USER_ID, SYSDATE, :ENTRY_BY_ID, 1, :BRAND_ID)";

    // Prepare the statement
    $strSQL = oci_parse($objConnect, $query);

    // Bind parameters
    oci_bind_by_name($strSQL, ':PARENT_USER_ID', $PARENT_USER_ID);
    oci_bind_by_name($strSQL, ':USER_ID', $USER_ID);
    oci_bind_by_name($strSQL, ':ENTRY_BY_ID', $USER_LOGIN_ID);
    oci_bind_by_name($strSQL, ':BRAND_ID', $BRAND_ID);
    // echo $query;

    // die();
    // Execute the query
    if (oci_execute($strSQL)) {
        $message = [
            'text'   => 'Data Saved successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/user_module/view/resource_allocation.php'</script>";
        exit();
    } else {
        $e                        = @oci_error($strSQL);
        $message                  = [
            'text'   => htmlentities($e['message'], ENT_QUOTES),
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$sfcmBasePath}/user_module/view/resource_allocation.php'</script>";
        exit();
    }
}
if (($_GET["deleteID"]) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $editId = $_GET["deleteID"];
    $query  = "UPDATE USER_PROFILE SET USER_STATUS = '0' WHERE ID = $editId";

    $strSQL = @oci_parse($objConnect, $query);
    if (@oci_execute($strSQL)) {

        $response['status']  = 'success';
        $response['message'] = 'Deleted Successfully ...';
        echo json_encode($response);
        exit();
    } else {
        $response['status']  = 'error';
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
    } else if ($ext == "png") {
        $src = imagecreatefrompng($uploadedfile);
    } else if ($ext == "gif") {
        $src = imagecreatefromgif($uploadedfile);
    } else {
        $src = imagecreatefrombmp($uploadedfile);
    }
    list($width, $height) = getimagesize($uploadedfile);
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
