<?php
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2.min.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2-bootstrap4.css';
$dynamic_link_js[]  = '../../assets/plugins/select2/js/select2.min.js';

$dynamic_link_js[]  = 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js';
$dynamic_link_css[]  = 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css';
$dynamic_link_css[]  = 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css';
$dynamic_link_js[]  = 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js';

include_once('../../_helper/2step_com_conn.php');
define('RECORDS_PER_PAGE', 10);
$currentPage  = isset($_GET['page']) ? $_GET['page'] : 1;

$v_start_date = date('d/m/Y');
$v_end_date   = date('d/m/Y');
$sale_executive_all_retailer_query = "SELECT A.USER_ID
FROM USER_MANPOWER_SETUP A,
USER_PROFILE B
WHERE A.USER_ID = B.ID AND PARENT_USER_ID IN
    (SELECT A.USER_ID FROM USER_MANPOWER_SETUP A, USER_PROFILE B
    WHERE A.USER_ID = B.ID AND PARENT_USER_ID = $log_user_id)
UNION
SELECT B.ID
FROM USER_MANPOWER_SETUP A, USER_PROFILE B
WHERE A.USER_ID = B.ID
    AND PARENT_USER_ID IN
        (SELECT USER_ID FROM USER_MANPOWER_SETUP A, USER_PROFILE B
        WHERE A.USER_ID = B.ID AND PARENT_USER_ID IN
            (SELECT A.USER_ID FROM USER_MANPOWER_SETUP A, USER_PROFILE B
            WHERE A.USER_ID = B.ID AND PARENT_USER_ID = $log_user_id))";
$strSQL3 = @oci_parse($objConnect, $sale_executive_all_retailer_query);
@oci_execute($strSQL3);

while ($row = oci_fetch_assoc($strSQL3)) {
    $sale_executive_all_retailer_ids[] = $row['USER_ID'];
}
if (count($sale_executive_all_retailer_ids) > 0) {
    $sale_executive_all_retailer_ids_str = implode(',', $sale_executive_all_retailer_ids);
}
?>
<style type="text/css">
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">


        <div class="row">
            <div class="card rounded-4">
                <div class="card-body">
                    <button class="accordion-button" style="color:#0dcaf0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <strong><i class='bx bx-filter-alt'></i> Filter Data</strong>
                    </button>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">

                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-sm-4">
                                                <label>Select Your Retailer:</label>
                                                <select name="retailer" class="form-control single-select">
                                                    <option value="<?php echo null ?>" hidden><- Select Retailer -></option>
                                                    <?php
                                                    if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == "HOD") {
                                                        $query = "SELECT  DISTINCT
                                                        (SELECT DISTINCT UP.USER_NAME
                                                        FROM USER_PROFILE UP
                                                        WHERE UP.ID = VA.RETAILER_ID) AS USER_NAME,
                                                        (SELECT DISTINCT UP.ID
                                                        FROM USER_PROFILE UP
                                                        WHERE UP.ID = VA.RETAILER_ID) AS ID
                                                    FROM VISIT_ASSIGN VA
                                                    WHERE
                                                        VA.USER_ID IN (
                                                            SELECT DISTINCT B.ID
                                                            FROM USER_MANPOWER_SETUP A, USER_PROFILE B
                                                            WHERE A.USER_ID = B.ID
                                                            AND PARENT_USER_ID IN (
                                                                SELECT DISTINCT A.USER_ID
                                                                FROM USER_MANPOWER_SETUP A, USER_PROFILE B
                                                                WHERE A.USER_ID = B.ID
                                                                AND PARENT_USER_ID = '$log_user_id'
                                                            )
                                                        )";
                                                    } else if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == "COORDINATOR") {
                                                        $query = "SELECT  UP.ID, UP.USER_NAME
                                                                FROM USER_PROFILE UP WHERE UP.ID IN
                                                                ($sale_executive_all_retailer_ids_str)";
                                                    } else {
                                                        $query = "SELECT UP.ID, UMP.USER_ID, UP.USER_NAME
                                                                    FROM USER_MANPOWER_SETUP UMP
                                                                    INNER JOIN USER_PROFILE UP ON UMP.USER_ID = UP.ID
                                                                    LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
                                                                    WHERE UBS.STATUS = 1
                                                                AND (UMP.PARENT_USER_ID = '$log_user_id'
                                                                    OR UMP.PARENT_USER_ID IN
                                                                    (SELECT UMP.USER_ID FROM USER_MANPOWER_SETUP UMS
                                                                    INNER JOIN USER_PROFILE UP ON UMS.USER_ID = UP.ID
                                                                    WHERE UMS.PARENT_USER_ID = '$log_user_id'))";
                                                    }

                                                    $strSQL = @oci_parse($objConnect, $query);
                                                    @oci_execute($strSQL);
                                                    while ($row = oci_fetch_assoc($strSQL)) {
                                                    ?>
                                                        <option value="<?php echo $row['ID'] ?>" <?php echo isset($_POST['retailer']) && $_POST['retailer'] == $row['ID'] ? 'Selected' : '' ?>>
                                                            <?php echo $row['USER_NAME'] ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-3">
                                                <label>Start Date: </label>
                                                <input required="" class="form-control datepicker" name="start_date" type="text" value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : date('d/m/Y'); ?>' />
                                            </div>
                                            <div class="col-sm-3">
                                                <label>End Date: </label>
                                                <input required="" class="form-control datepicker" name="end_date" type="text" value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : date('d/m/Y'); ?>' />
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="submit" class="form-control btn btn-sm btn-gradient-primary mt-4">Search Data<i class='bx bx-file-find'></i></button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card rounded-4">
                    <?php

                    if (isset($_POST['start_date'])) {
                        $v_start_date = $_POST['start_date'];
                    }
                    if (isset($_POST['end_date'])) {
                        $v_end_date = $_POST['end_date'];
                    }
                    $headerType    = 'List';
                    $leftSideName  = 'Visit List';
                    if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == "SALE EXECUTIVE") {
                        $rightSideName = 'Visit Create';
                        $routePath     = 'visit_module/view/create.php';
                    }
                    include('../../_includes/com_header.php');


                    ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0" id="downloadData">
                                <thead class="text-white text-uppercase text-center" style="background-color: #3b005c !important">
                                    <tr>
                                        <th colspan="6">Start Date : <?php echo $v_start_date ?> - End Date : <?php echo $v_end_date ?></th>
                                    </tr>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Date</th>
                                        <th>Retailer Name</th>
                                        <th>VISIT TYPE</th>
                                        <th>STATUS</th>
                                        <th>USER REMARKS</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $offset = ($currentPage  - 1) * RECORDS_PER_PAGE;

                                    if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == "HOD") {
                                        $query = "SELECT VA.ID, VA.VISIT_DATE,
                                        VA.USER_REMARKS, VA.VISIT_STATUS, VA.ENTRY_DATE,
                                        VA.ENTRY_BY_ID,
                                        (SELECT VT.TITLE FROM VISIT_TYPE VT WHERE VT.ID = VA.VISIT_TYPE_ID) AS VISIT_TYPE,
                                        (SELECT UP.USER_NAME FROM USER_PROFILE UP WHERE UP.ID = VA.RETAILER_ID) AS RETAILER_NAME,
                                        (SELECT TITLE FROM PRODUCT_BRAND WHERE ID=VA.PRODUCT_BRAND_ID) AS RETAILER_BRAND
                                        FROM VISIT_ASSIGN VA
                                        WHERE VA.USER_ID  IN (SELECT B.ID
                                            FROM USER_MANPOWER_SETUP A,USER_PROFILE B
                                            WHERE A.USER_ID = B.ID
                                            AND PARENT_USER_ID IN
                                            (SELECT A.USER_ID FROM USER_MANPOWER_SETUP A, USER_PROFILE B WHERE A.USER_ID=B.ID AND PARENT_USER_ID = $log_user_id))
                                        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')";
                                    } else if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == "COORDINATOR") {
                                        $query = "SELECT VA.ID, VA.VISIT_DATE,
                                        VA.USER_REMARKS, VA.VISIT_STATUS, VA.ENTRY_DATE,
                                        VA.ENTRY_BY_ID,
                                        (SELECT VT.TITLE FROM VISIT_TYPE VT WHERE VT.ID = VA.VISIT_TYPE_ID) AS VISIT_TYPE,
                                        (SELECT UP.USER_NAME FROM USER_PROFILE UP WHERE UP.ID = VA.RETAILER_ID) AS RETAILER_NAME,
                                        (SELECT TITLE FROM PRODUCT_BRAND WHERE ID=VA.PRODUCT_BRAND_ID) AS RETAILER_BRAND
                                        FROM VISIT_ASSIGN VA
                                        WHERE VA.USER_ID  IN
                                        (SELECT B.ID FROM USER_MANPOWER_SETUP A,USER_PROFILE B WHERE A.USER_ID=B.ID AND PARENT_USER_ID='$log_user_id')
                                        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')";
                                    } else {
                                        $query = "SELECT VA.ID, VA.VISIT_DATE,
                                        VA.USER_REMARKS, VA.VISIT_STATUS, VA.ENTRY_DATE,
                                        VA.ENTRY_BY_ID,
                                        (SELECT VT.TITLE FROM VISIT_TYPE VT WHERE VT.ID = VA.VISIT_TYPE_ID) AS VISIT_TYPE,
                                        (SELECT UP.USER_NAME FROM USER_PROFILE UP WHERE UP.ID = VA.RETAILER_ID) AS RETAILER_NAME,
                                        (SELECT TITLE FROM PRODUCT_BRAND WHERE ID=VA.PRODUCT_BRAND_ID) AS RETAILER_BRAND
                                        FROM VISIT_ASSIGN VA
                                        WHERE VA.USER_ID = '$log_user_id'
                                        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')";
                                    }

                                    if (isset($_POST['retailer']) && !empty($_POST['retailer'])) {
                                        $retailerID = $_POST['retailer'];
                                        $query .= " AND (VA.RETAILER_ID= $retailerID)";
                                    }
                                    $query .= " ORDER BY VA.VISIT_DATE DESC";
                                    // $query .= " ORDER BY VA.VISIT_DATE DESC OFFSET $offset ROWS FETCH NEXT " . RECORDS_PER_PAGE . " ROWS ONLY";
                                    $strSQL = @oci_parse($objConnect, $query);

                                    @oci_execute($strSQL);
                                    $number = 0;
                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                        $number++;
                                    ?>
                                        <tr>
                                            <td class="text-center">
                                                <strong>
                                                    <?php echo $number; ?>
                                                </strong>
                                            </td>

                                            <td>
                                                <?= $row['VISIT_DATE']; ?>
                                            </td>
                                            <td>
                                                <h6>
                                                    <?=  $row['RETAILER_NAME'] ?>
                                                    <br />
                                                    <span class="badge bg-success"><?=  $row['RETAILER_BRAND'] ?></span>
                                                </h6>

                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-gradient-primary">
                                                    <?= $row['VISIT_TYPE'] ?>
                                                </button>


                                            </td>
                                            <td class="text-center">
                                                <?php if ($row['VISIT_STATUS'] == '0') {
                                                    echo ' <button type="button" class="btn btn-sm btn-gradient-warning text-white "> Pending </button>';
                                                } else if ($row['VISIT_STATUS'] == '1') {
                                                    echo ' <button type="button" class="btn btn-sm btn-gradient-success"> Success </button>';
                                                } else if ($row['VISIT_STATUS'] == '2') {
                                                    echo ' <button type="button" class="btn btn-sm btn-gradient-danger"> Failed </button>';
                                                } ?>
                                            </td>
                                            <td>
                                                <?=  $row['USER_REMARKS']; ?>
                                            </td>

                                        </tr>


                                    <?php } ?>

                                </tbody>
                            </table>
                            <!-- <div class="d-flex justify-content-center mt-3">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination round-pagination">
                                        <?php
                                        // $countQuery = "SELECT  COUNT(VA.ID) AS total
                                        //             FROM VISIT_ASSIGN VA WHERE VA.USER_ID = '$log_user_id'
                                        //             AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')
                                        //             ";

                                        // // check retailer data exist 
                                        // if (isset($_POST['retailer']) && !empty($_POST['retailer'])) {
                                        //     $retailerID = $_POST['retailer'];
                                        //     $countQuery .= " AND (VA.RETAILER_ID= $retailerID)";
                                        // }

                                        // $countResult = oci_parse($objConnect, $countQuery);
                                        // oci_execute($countResult);
                                        // $countData = oci_fetch_assoc($countResult);
                                        // $totalRecords = $countData['TOTAL'];


                                        // for ($i = 1; $i <= ceil($totalRecords / RECORDS_PER_PAGE); $i++) {
                                        //     $activeClass = ($i == $currentPage) ? 'active' : '';
                                        //     echo "<li class='page-item $activeClass'><a class='page-link' href='index.php?page=$i'>$i</a></li>";
                                        // }


                                        ?>


                                    </ul>
                                </nav>
                            </div> -->
                            <span class="d-block text-end mt-3">
                                <a class="btn btn-sm btn-gradient-info" onclick="exportF(this)">
                                    Export To Excel <i class='bx bxs-cloud-download'></i> </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->

    </div>
</div>
<!--end page wrapper -->
<?php
include_once('../../_includes/footer_info.php');
include_once('../../_includes/footer.php');
?>
<script>
    //select 2
    $('.single-select').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
    });

    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        // minViewMode: 'months',
        // changeMonth: true,
        // changeYear: true,
        // showButtonPanel: true,
        autoclose: true
    });

    function exportF(elem) {
        var table = document.getElementById("downloadData");
        var html = table.outerHTML;
        var utf8BOM = "\uFEFF"; // Byte Order Mark (BOM) for UTF-8
        var blob = new Blob([utf8BOM + html], {
            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8'
        });
        var url = URL.createObjectURL(blob);

        // Get today's date
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var yyyy = today.getFullYear();
        var currentDate = yyyy + '-' + mm + '-' + dd;

        // Modify download attribute to include today's date in the file name
        var fileName = "visit_List_" + currentDate + ".xls";
        elem.setAttribute("href", url);
        elem.setAttribute("download", fileName); // Choose the file name

        return false;
    }
</script>