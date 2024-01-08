<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$basePath = $_SESSION['basePath'];
$folderPath     = $rs_img_path;

ini_set('memory_limit', '2560M');

print_r($_FILES);
die();
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
        echo $imagename;
        echo $size;
        die();
        if (strlen($imagename)) {
            $ext = strtolower(getExtension($imagename));
            if (in_array($ext, $valid_formats)) {
                $imgStorePath = $basePath . '/user_profile';
                pathExitOrCreate($imgStorePath); // check if folder exists or create


                $actual_image_name = time() . "." . $ext;
                $uploadedfile      = $_FILES['IMAGE_LINK']['tmp_name'];
                //Re-sizing image. 
                $width    = 125; //You can change dimension here.
                $height   = 80; //You can change dimension here.
                $filename = compressImage($ext, $uploadedfile, $folderPath, $actual_image_name, $width, $height);
                $insert   = false; //
                if ($filename) {
                    // delet previous image
                    $sql   = "select * from tbl_users where emp_id='$emp_sesssion_id'";
                    $query = mysqli_query($conn_hr, $sql);
                    $data  = mysqli_fetch_assoc($query);

                    if ($data['image_url']) {
                        $file = $folderPath . $data['image_url'];
                        if (file_exists($file)) {
                            unlink($file); // delete image if exist
                        }
                    }  // end delet previous image
                    // update image 
                    $sql    = "update tbl_users set image_url='$filename' where emp_id = '$emp_sesssion_id' ";
                    $insert = mysqli_query($conn_hr, $sql);
                    if ($insert) {
                        $_SESSION['HR']['emp_image_hr'] = $filename;
                        $imageStatus                    = "The file has been uploaded successfully.";
                        session_start();
                        $_SESSION['imageStatus'] = $imageStatus;
                        header("location:" . $basePath . "/imageChange.php");
                        exit();
                    }
                    else {
                        $imageStatus = "Data Not Updated!";
                        session_start();
                        $_SESSION['imageStatus'] = $imageStatus;
                        header("location:" . $basePath . "/imageChange.php");
                        exit();
                    }
                }
                else {

                    $imageStatus = "Something went wrong file uploading!";
                    session_start();
                    $_SESSION['imageStatus'] = $imageStatus;
                    header("location:" . $basePath . "/imageChange.php");
                    exit();
                }
               
            }
            else {
                $imageStatus = 'Sorry, only JPG, JPEG, PNG, BMP,GIF, & PDF files are allowed to upload!';
                session_start();
                $_SESSION['imageStatus'] = $imageStatus;
                header("location:" . $basePath . "/imageChange.php");
                exit();
            }
        }
        else {
            $imageStatus = "Please select image..!";
            session_start();
            $_SESSION['imageStatus'] = $imageStatus;
            header("location:" . $basePath . "/imageChange.php");
            exit();
        }
      
    }

    // Prepare the SQL statement
    $query = "UPDATE USER_PROFILE SET 
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'pro_edit_2') {


    $valid_formats = array( "jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP" );

    $editId = $_POST['editId'];


    if ($_POST['new_image_or_old_image'] == '1') {

        foreach ($_FILES['new_image_detials']['name'] as $key => $new_image) {

            $image       = $_FILES['new_image_detials'];
            $fileName    = $image["name"][$key];
            $fileTmpName = $image["tmp_name"][$key];
            $fileSize    = $image["size"][$key];
            $fileType    = $image["type"][$key];
            $fileError   = $image["error"][$key];
            //Check if the file is an actual image
            $validExtensions = array( "jpg", "jpeg", "png", "gif" );
            $fileExtension   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $validExtensions)) {
                $imageStatus             = 'Invalid file_' . $key . 'format. Allowed formats: JPG, JPEG, PNG, GIF';
                $_SESSION['imageStatus'] = $imageStatus;
                echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
                exit();
            }

            $imgStorePath = $folderPath . 'product_details/';
            pathExitOrCreate($imgStorePath); // check if folder exists or create

            // Define a custom file name
            $customFileName = 'pro_d_' . $editId . '_' . random_strings(4) . '_' . time() . "." . $fileExtension;

            // Define the target path with the custom file name
            $targetPath_fullImgName = $imgStorePath . $customFileName;
            // image store folder path name is relative to  the image store
            if (move_uploaded_file($fileTmpName, $targetPath_fullImgName)) {

                // image final name for database store name
                $imageFinalName = str_replace('../', '', $targetPath_fullImgName);
                $insertQuery    = "INSERT INTO PRODUCT_PICTURE (URL, PRODUCT_ID, PIC_ORDER, STATUS) VALUES ('$imageFinalName', '$editId', '1', 'Y')";

                // echo "Full Raw Query: " . $insertQuery;
                // Prepare and execute the query
                $insertSQL = oci_parse($objConnect, $insertQuery);

                if (@oci_execute($insertSQL)) {
                    @oci_free_statement($insertSQL);
                    // @oci_close($objConnect);
                }
                else {
                    $e                        = @oci_error($insertSQL);
                    $message                  = [
                        'text'   => htmlentities($e['message'], ENT_QUOTES),
                        'status' => 'false',
                    ];
                    $_SESSION['noti_message'] = $message;
                    echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
                }


            }
            else {
                $imageStatus             = "Something went wrong file uploading!";
                $_SESSION['imageStatus'] = $imageStatus;
                echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
                exit();
            }

        }

    }
    else if ($_POST['new_image_or_old_image'] == '0') {

        foreach (($_FILES['old_img_detials']) as $key => $old_img_value) {
            foreach ($old_img_value as $pr_d_id => $value) {

                $image = $_FILES['old_img_detials'];

                $fileName = $image["name"][$pr_d_id];
                if (!empty($fileName)) {
                    $fileTmpName = $image["tmp_name"][$pr_d_id];
                    $fileSize    = $image["size"][$pr_d_id];
                    $fileType    = $image["type"][$pr_d_id];
                    $fileError   = $image["error"][$pr_d_id];

                    $validExtensions = array( "jpg", "jpeg", "png", "gif" );
                    $fileExtension   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    if (!in_array($fileExtension, $validExtensions)) {
                        $imageStatus             = 'Invalid file_' . $key . 'format. Allowed formats: JPG, JPEG, PNG, GIF';
                        $_SESSION['imageStatus'] = $imageStatus;
                        echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
                        exit();
                    }

                    $imgStorePath = $folderPath . 'product_details/';
                    pathExitOrCreate($imgStorePath); // check if folder exists or create

                    // Define a custom file name
                    $customFileName = 'pro_d_' . $editId . '_' . random_strings(4) . '_' . time() . "." . $fileExtension;

                    // Define the target path with the custom file name
                    $targetPath_fullImgName = $imgStorePath . $customFileName;
                    // image store folder path name is relative to  the image store
                    if (move_uploaded_file($fileTmpName, $targetPath_fullImgName)) {

                        // image final name for database store name
                        $imageFinalName = str_replace('../', '', $targetPath_fullImgName);

                        $picurlSQL = "UPDATE PRODUCT_PICTURE SET URL = '$imageFinalName' WHERE ID = '$pr_d_id'";
                        // Prepare and execute the query
                        $updateSQL = oci_parse($objConnect, $picurlSQL);

                        if (@oci_execute($updateSQL)) {
                            @oci_free_statement($updateSQL);
                            // @oci_close($objConnect);
                        }
                        else {
                            $e                        = @oci_error($updateSQL);
                            $message                  = [
                                'text'   => htmlentities($e['message'], ENT_QUOTES),
                                'status' => 'false',
                            ];
                            $_SESSION['noti_message'] = $message;
                            echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
                        }


                    }
                    else {

                        $imageStatus             = "Something went wrong file uploading! old image deatils update:'$fileName','$pr_d_id'";
                        $_SESSION['imageStatus'] = $imageStatus;
                        echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
                        exit();
                    }
                }

            }
        }

    }


    if (!empty($_FILES["PIC_URL"]["name"])) {

        $image       = $_FILES['PIC_URL'];
        $fileName    = $image["name"];
        $fileTmpName = $image["tmp_name"];
        $fileSize    = $image["size"];
        $fileType    = $image["type"];
        $fileError   = $image["error"];
        //Check if the file is an actual image
        $validExtensions = array( "jpg", "jpeg", "png", "gif" );
        $fileExtension   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $validExtensions)) {
            $imageStatus             = 'Invalid file_' . $key . 'format. Allowed formats: JPG, JPEG, PNG, GIF';
            $_SESSION['imageStatus'] = $imageStatus;
            echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
            exit();
        }

        $imgStorePath = $folderPath . 'product_image/';
        pathExitOrCreate($imgStorePath); // check if folder exists or create

        // Define a custom file name
        $customFileName = 'pro_' . $editId . '_' . random_strings(4) . '_' . time() . "." . $fileExtension;

        // Define the target path with the custom file name
        $targetPath_fullImgName = $imgStorePath . $customFileName;
        // image store folder path name is relative to  the image store
        if (move_uploaded_file($fileTmpName, $targetPath_fullImgName)) {

            // image final name for database store name
            $imageFinalName = str_replace('../', '', $targetPath_fullImgName);
            // Prepare and execute the query

            $picurlSQL = "UPDATE PRODUCT SET PIC_URL = '$imageFinalName' WHERE ID = '$editId'";
            // echo "Full Raw Query: " .$picurlSQL;
            // die();
            $updatePicSQL = oci_parse($objConnect, $picurlSQL);
            if (@oci_execute($updatePicSQL)) {
                @oci_free_statement($updatePicSQL);
            }
            else {
                $e                        = @oci_error($updatePicSQL);
                $message                  = [
                    'text'   => htmlentities($e['message'], ENT_QUOTES),
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
            }

        }
        else {
            $imageStatus             = "Something went wrong file uploading!";
            $_SESSION['imageStatus'] = $imageStatus;
            echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";
            exit();
        }

    }
    $message                  = [
        'text'   => 'Data Saved successfully.',
        'status' => 'true',
    ];
    $_SESSION['noti_message'] = $message;
    echo "<script> window.location.href = '{$basePath}/resale_module/view/self_panel/edit.php?id={$editId}&actionType=edit'</script>";

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

function compressImage($ext, $uploadedfile, $path, $actual_image_name, $newwidth)
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
    $newheight              = ($height / $width) * $newwidth;
    $tmp                    = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    $filename = $path . $newwidth . '_' . $actual_image_name; //PixelSize_TimeStamp.jpg
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
