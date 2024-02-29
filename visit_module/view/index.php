<?php
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2.min.css';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.css';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.date.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2-bootstrap4.css';
$dynamic_link_js[]  = '../../assets/plugins/select2/js/select2.min.js';
$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.js';
$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.date.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js';
include_once('../../_helper/2step_com_conn.php');
define('RECORDS_PER_PAGE', 10);
$currentPage  = isset($_GET['page']) ? $_GET['page'] : 1;
$log_user_id   = $_SESSION['USER_SFCM_INFO']['ID'];
?>

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
                                                    $query = "SELECT UP.ID, UMP.USER_ID, UP.USER_NAME, UP.DISTRICT_ID
                                                    FROM USER_MANPOWER_SETUP UMP
                                                    INNER JOIN USER_PROFILE UP ON UMP.USER_ID = UP.ID
                                                    LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
                                                    WHERE UBS.STATUS = 1
                                                    AND (UMP.PARENT_USER_ID = $log_user_id
                                                        OR UMP.PARENT_USER_ID IN
                                                        (SELECT UMP.USER_ID FROM USER_MANPOWER_SETUP UMS
                                                        INNER JOIN USER_PROFILE UP ON UMS.USER_ID = UP.ID
                                                        WHERE UMS.PARENT_USER_ID = $log_user_id))";

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
                                                <input required="" class="form-control datepicker" name="start_date" type="text" value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : date('01-m-Y'); ?>' />
                                            </div>
                                            <div class="col-sm-3">
                                                <label>End Date: </label>
                                                <input required="" class="form-control datepicker" name="end_date" type="text" value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : date('t-m-Y'); ?>' />
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
                    $headerType    = 'List';
                    $leftSideName  = 'Visit List';
                    $rightSideName = 'Visit Create';
                    $routePath     = 'visit_module/view/create.php';
                    include('../../_includes/com_header.php');


                    ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="table-light text-uppercase text-center ">
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

                                    $v_start_date = date('01/m/Y');
                                    $v_end_date   = date('t/m/Y');
                                    if (isset($_POST['start_date'])) {
                                        $v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                    }
                                    if (isset($_POST['end_date'])) {
                                        $v_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
                                    }

                                    $query = "SELECT VA.ID, VA.VISIT_DATE,
                                        VA.USER_REMARKS, VA.VISIT_STATUS, VA.ENTRY_DATE,
                                        VA.ENTRY_BY_ID,
                                        (SELECT VT.TITLE FROM VISIT_TYPE VT WHERE VT.ID = VA.VISIT_TYPE_ID) AS VISIT_TYPE,
                                        (SELECT UP.USER_NAME FROM USER_PROFILE UP WHERE UP.ID = VA.RETAILER_ID) AS RETAILER_NAME,
                                        (SELECT TITLE FROM PRODUCT_BRAND WHERE ID=VA.PRODUCT_BRAND_ID) AS RETAILER_BRAND
                                        FROM VISIT_ASSIGN VA
                                        WHERE VA.USER_ID = '$log_user_id'
                                        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')
                                        ";
                                    if (isset($_POST['retailer']) && !empty($_POST['retailer'])) {
                                        $retailerID = $_POST['retailer'];
                                        $query .= " AND (VA.RETAILER_ID= $retailerID)";
                                    }
                                    $query .= " ORDER BY VA.VISIT_DATE DESC OFFSET $offset ROWS FETCH NEXT " . RECORDS_PER_PAGE . " ROWS ONLY";

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
                                                <?php echo $row['VISIT_DATE']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['RETAILER_NAME']; ?>
                                                <br />
                                                <span class="badge bg-success"><?php echo $row['RETAILER_BRAND']; ?></span></h6>

                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-gradient-primary">
                                                    <?php echo $row['VISIT_TYPE']; ?>
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
                                                <?php echo $row['USER_REMARKS']; ?>
                                            </td>

                                            <!-- <td class="text-center">
                                                <a href="<?php echo $sfcmBasePath . '/visit_module/view/userTree.php?id=' . $row['ID']  ?>" class="btn btn-sm btn-gradient-info text-white"><i class='bx bx-street-view'></i></a>
                                            </td> -->

                                        </tr>


                                    <?php } ?>

                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination round-pagination">
                                        <?php
                                        $countQuery = "SELECT  COUNT(VA.ID) AS total
                                                    FROM VISIT_ASSIGN VA WHERE VA.USER_ID = '$log_user_id'
                                                    AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')
                                                    ";
                                    
                                        // check retailer data exist 
                                        if (isset($_POST['retailer']) && !empty($_POST['retailer'])) {
                                            $retailerID = $_POST['retailer'];
                                            $countQuery .= " AND (VA.RETAILER_ID= $retailerID)";
                                        }

                                        $countResult = oci_parse($objConnect, $countQuery);
                                        oci_execute($countResult);
                                        $countData = oci_fetch_assoc($countResult);
                                        $totalRecords = $countData['TOTAL'];


                                        for ($i = 1; $i <= ceil($totalRecords / RECORDS_PER_PAGE); $i++) {
                                            $activeClass = ($i == $currentPage) ? 'active' : '';
                                            echo "<li class='page-item $activeClass'><a class='page-link' href='index.php?page=$i'>$i</a></li>";
                                        }


                                        ?>


                                    </ul>
                                </nav>
                            </div>
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

    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: true,
        format: 'dd-mm-yyyy' // Specify your desired date format
    });
</script>