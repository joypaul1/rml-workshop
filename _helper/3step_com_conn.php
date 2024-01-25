<?php
session_start();
if (!isset($_SESSION['USER_SFCM_INFO'])) {
    $currentScriptPath = __FILE__;
    $directoryPath     = dirname($currentScriptPath);
    $includeFilePath   = $directoryPath . '../../../config_file_path.php';
    $realIncludePath   = realpath($includeFilePath);
    require($includeFilePath);
    header("Location:" . $sfcmBasePath);
    exit;
}
include_once('../../../_config/connoracle.php');
$sfcmBasePath = $_SESSION['sfcmBasePath'];
include_once('../../../_includes/header.php');

if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == 'HOD') {
    include_once('../../../_includes/sidebar.php');
}
if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == 'COORDINATOR') {
    include_once('../../../_includes/coordinator_sidebar.php');
}
if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == 'SALE EXECUTIVE') {
    include_once('../../../_includes/executive_sidebar.php');
}
if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == 'RETAILER') {
    include_once('../../../_includes/retailer_sidebar.php');
}
if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == 'MECHANICS') {
    include_once('../../../_includes/mechanics_sidebar.php');
}
include_once('../../../_includes/top_header.php');
