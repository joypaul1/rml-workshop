<?php 
session_start();
if (!isset($_SESSION['USER_SFCM_INFO'])) {
    $currentScriptPath = __FILE__;
    $directoryPath     = dirname($currentScriptPath);
    $includeFilePath   = $directoryPath . '../../config_file_path.php';
    $realIncludePath   = realpath($includeFilePath);
    require($includeFilePath);
    header("Location:" . $sfcmBasePath);
    exit;
}
include_once('../../_config/connoracle.php');


$sfcmBasePath   = $_SESSION['sfcmBasePath'];
$log_user_id    = $_SESSION['USER_SFCM_INFO']['ID'];
$USER_BRANDS    = $_SESSION["USER_SFCM_INFO"]["USER_BRANDS"] ? $_SESSION["USER_SFCM_INFO"]["USER_BRANDS"] : 0;

include_once('../../_includes/header.php');
include_once('../../_includes/sidebar.php');
include_once('../../_includes/top_header.php');



