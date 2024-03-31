<?php
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
// $cspdBasePath =  $baseUrl . '/rml_apps'; // --> live server
$cspdBasePath    = $baseUrl . '/cspd'; //--> test server 
$rs_img_path = "../../../cspd/";  // --> live server
// $rs_img_path = "../resale_product_image/";  // --> test server

?>