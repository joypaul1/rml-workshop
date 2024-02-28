<?php
$dynamic_link_js[]  = '../assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js';
$dynamic_link_js[]  = '../assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js';
$dynamic_link_js[]  = '../assets/plugins/apexcharts-bundle/js/apexcharts.min.js';
$dynamic_link_js[]  = '../assets/plugins/chartjs/js/Chart.min.js';
$dynamic_link_js[]  = '../assets/js/index2.js';

include_once('../_helper/com_conn.php');
$log_user_id   = $_SESSION['USER_SFCM_INFO']['ID'];
$user_type_brand_wise_data = [];
// COUNT QUERY USER TYPE WISE
$query = "SELECT b.ID, b.TITLE,
          COUNT(USER_TYPE_ID) AS TOTAL_USER,
          NUMBER_OF_USER(1, b.ID) AS MAHINDRA_USER,
          NUMBER_OF_USER(2, b.ID) AS EICHER_USER
          FROM USER_PROFILE a, USER_TYPE b
          WHERE a.USER_STATUS = 1
          AND a.USER_TYPE_ID = b.ID
          GROUP BY b.ID, b.TITLE";

$brandSQL = oci_parse($objConnect, $query);
oci_execute($brandSQL);

$user_type_brand_wise_data = array(); // Initialize the array

while ($brandRow = oci_fetch_assoc($brandSQL)) {
    array_push($user_type_brand_wise_data, $brandRow);
}


?>
<style>
    .card {
        margin-bottom: 0.5rem !important;
    }
</style>
<!--start page wrapper -->
<?php
if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == "HOD") {
    include_once('hod_dashboard.php');
} else if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == "COORDINATOR") {
    include_once('coo_dashboard.php');
} else if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == "SALE EXECUTIVE") {
    include_once('exe_dashboard.php');
} else if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == "RETAILER") {
    include_once('ret_dashboard.php');
} else if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == "MECHANICS") {
    include_once('mac_dashboard.php');
}

?>
<!--end page wrapper -->
<?php
include_once('../_includes/footer_info.php');
include_once('../_includes/footer.php');
?>