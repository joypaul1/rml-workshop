<?php
// $dynamic_link_js[]  = '../assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js';
// $dynamic_link_js[]  = '../assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js';
$dynamic_link_js[]  = '../assets/plugins/apexcharts-bundle/js/apexcharts.min.js';
$dynamic_link_js[]  = '../assets/plugins/chartjs/js/Chart.min.js';
$dynamic_link_js[]  = '../assets/js/tableManager.js';
include_once('../_helper/com_conn.php');

$user_type_brand_wise_data = [];
// COUNT QUERY USER TYPE WISE
$query = "SELECT UT.ID, UT.TITLE,
        COUNT(USER_TYPE_ID) AS TOTAL_USER,
        NVL(NUMBER_OF_USER(1, UT.ID),0) AS MAHINDRA_USER,
        NVL(NUMBER_OF_USER(2, UT.ID),0) AS EICHER_USER
        FROM USER_PROFILE UP, USER_TYPE UT
        WHERE UP.USER_STATUS = 1
        AND UP.USER_TYPE_ID = UT.ID
        GROUP BY UT.ID, UT.TITLE";

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

    /*Style disabled*/
    .tablemanager th.disableSort {}

    #for_numrows {
        padding: 10px;
        float: left;
    }

    #for_filter_by {
        padding: 10px;
        float: right;
    }

    #pagesControllers {
        display: block;
        text-align: center;
    }
</style>
<!--start page wrapper -->
<?php
if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == "HOD") {
    include_once('hod_dashboard.php');
} else if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == "COORDINATOR") {
    include_once('coo_dashboard.php');
} else if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == "SALE EXECUTIVE") {
    include_once('exe_dashboard.php');
} else if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == "RETAILER") {
    include_once('ret_dashboard.php');
} else if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == "MECHANICS") {
    include_once('mac_dashboard.php');
}

?>
<!--end page wrapper -->
<?php
include_once('../_includes/footer_info.php');
include_once('../_includes/footer.php');
?>
<script type="text/javascript">
    // basic usage
    $(".tablemanager").tablemanager({
        firstSort: [
            [0, 0],
            [0, 0],
            [0, "asc"],
        ],
        disable: ["last"],
        appendFilterby: true,
        debug: true,
        vocabulary: {
            voc_filter_by: "Filter By Retailer Name",
            voc_type_here_filter: "Filter Data...",
            voc_show_rows: "Rows Per Page ",
        },
        pagination: true,
        showrows: [25, 50, 100, 200, 500, 700, 1000],
        disableFilterBy: [1],
    });
    // $('.tablemanager').tablemanager();
</script>