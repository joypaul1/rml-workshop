<?php 
session_start();
if (!isset($_SESSION['USER_INFO'])) {
    $currentScriptPath = __FILE__;
    $directoryPath     = dirname($currentScriptPath);
    $includeFilePath   = $directoryPath . '../../config_file_path.php';
    $realIncludePath   = realpath($includeFilePath);
    require($includeFilePath);
    header("Location:" . $basePath);
    exit;
}
include_once('../../_config/connoracle.php');
$basePath = $_SESSION['basePath'];
include_once('../../_includes/header.php');
include_once('../../_includes/sidebar.php');
include_once('../../_includes/top_header.php');



