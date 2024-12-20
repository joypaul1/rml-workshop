<?php
session_start();
if (!isset($_SESSION['USER_CSPD_INFO'])) {
    $currentScriptPath = __FILE__;
    $directoryPath     = dirname($currentScriptPath);
    $includeFilePath   = $directoryPath . '../../config_file_path.php';
    $realIncludePath   = realpath($includeFilePath);
    require($includeFilePath);
    header("Location:" . $cspdBasePath);
    exit;
}
include_once('../../_config/connoracle.php');

$cspdBasePath   = $_SESSION['cspdBasePath'];
$USER_LOGIN_ID    = $_SESSION['USER_CSPD_INFO']['ID'];
$USER_BRANDS    = $_SESSION["USER_CSPD_INFO"]["USER_BRANDS"] ? $_SESSION["USER_CSPD_INFO"]["USER_BRANDS"] : 0;

include_once('../../_includes/header.php');
if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == 'HOD') {
    include_once('../../_includes/sidebar.php');
}
if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == 'COORDINATOR') {
    include_once('../../_includes/coordinator_sidebar.php');
}
if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == 'SALE EXECUTIVE') {
    include_once('../../_includes/executive_sidebar.php');
}
if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == 'RETAILER') {
    include_once('../../_includes/retailer_sidebar.php');
}
if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == 'MECHANICS') {
    include_once('../../_includes/mechanics_sidebar.php');
}
include_once('../../_includes/top_header.php');
