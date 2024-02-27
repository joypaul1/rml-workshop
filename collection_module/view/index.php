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
$USER_BRANDS = $_SESSION["USER_SFCM_INFO"]["USER_BRANDS"]
    ? $_SESSION["USER_SFCM_INFO"]["USER_BRANDS"]
    : 0;
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">


        <div class="row">
            <div class="card rounded-4">
                <div class="card-body">

                    <button class="accordion-button" style="color:#0dcaf0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <strong><i class='bx bx-filter-alt'></i> Filter Data </strong>
                    </button>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">

                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
                                        <div class="row justify-content-center align-items-center">
                                            <!-- <div class="col-sm-4">
                                                <label> Sales Executive:</label>
                                                <select name="f_sales_executive" class="form-control single-select">
                                                    <option value="<?php echo null ?>" hidden><- Select Sales Executive -></option>
                                                    <?php
                                                    //$executiveID = $_SESSION['USER_SFCM_INFO']['ID'];
                                                    $query = "SELECT DISTINCT UP.ID, UP.USER_NAME, UP.USER_MOBILE
                                                    FROM USER_PROFILE UP
                                                    INNER JOIN USER_MANPOWER_SETUP UMS ON UP.ID = UMS.USER_ID
                                                    LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID =UP.ID
                                                    WHERE UBS.PRODUCT_BRAND_ID IN ($USER_BRANDS)
                                                    AND UBS.STATUS = 1
                                                    AND UP.USER_TYPE_ID = 3";
                                                    $strSQL = oci_parse($objConnect,  $query);
                                                    oci_execute($strSQL);

                                                    while ($row = oci_fetch_assoc($strSQL)) {
                                                    ?>
                                                        <option value="<?php echo $row['ID'] ?>" <?php echo isset($_POST['f_sales_executive']) && $_POST['f_sales_executive'] == $row['ID'] ? 'Selected' : '' ?>>
                                                            <?php echo $row['USER_NAME'] ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div> -->
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
                    $leftSideName  = 'Collection Target List';
                    $rightSideName = 'Collection Target Create';
                    $routePath     = 'collection_module/view/create.php';
                    include('../../_includes/com_header.php');


                    ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="table-light text-uppercase text-center ">
                                    <tr>
                                        <th>SL.</th>
                                        <th>ACTION</th>
                                        <th>Date</th>
                                        <th>Retailer Name</th>
                                        <th>Brand </th>
                                        <th>STATUS</th>
                                        <th>Amount</th>
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
                                    $query = "SELECT CA.ID,
                                    CA.START_DATE,
                                    CA.END_DATE,
                                    CA.TARGET_AMOUNT,
                                    CA.STATUS,
                                    CA.REMARKS,
                                    UP.USER_NAME,
                                    (SELECT TITLE
                                    FROM PRODUCT_BRAND PB
                                    WHERE PB.ID = CA.BRAND_ID)
                                    AS BRAND_NAME
                                    FROM COLLECTION_ASSIGN CA
                                            INNER JOIN USER_PROFILE UP ON CA.USER_ID = UP.ID
                                    WHERE  CA.BRAND_ID IN ($USER_BRANDS)
                                    AND TRUNC (CA.START_DATE) >= TO_DATE ('$v_start_date', 'DD/MM/YYYY')
                                    AND TRUNC (CA.END_DATE) <= TO_DATE ('$v_end_date', 'DD/MM/YYYY')";

                                    $query .= " ORDER BY CA.START_DATE ASC OFFSET $offset ROWS FETCH NEXT " . RECORDS_PER_PAGE . " ROWS ONLY";
                                    // echo  $query;
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

                                            <td class="text-center">
                                                <a href="<?php echo $sfcmBasePath . '/collection_module/view/edit.php?id=' . $row['ID'] . '&actionType=edit' ?>" class="btn btn-sm btn-gradient-warning text-white"><i class='bx bxs-edit-alt'></i></a>

                                            </td>
                                            <td>
                                                <?php echo $row['START_DATE']; ?> TO <?php echo $row['END_DATE']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['USER_NAME']; ?>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-gradient-primary">
                                                    <?php echo $row['BRAND_NAME']; ?>
                                                </button>


                                            </td>
                                            <td class="text-center">
                                                <?php if ($row['STATUS'] == '0') {
                                                    echo ' <button type="button" class="btn btn-sm btn-gradient-warning text-white"> Pending </button>';
                                                } else if ($row['STATUS'] == '1') {
                                                    echo ' <button type="button" class="btn btn-sm btn-gradient-success"> Success </button>';
                                                } else if ($row['STATUS'] == '2') {
                                                    echo ' <button type="button" class="btn btn-sm btn-gradient-danger"> Failed </button>';
                                                } ?>
                                            </td>
                                            <td>
                                                <?php echo number_format($row['TARGET_AMOUNT']) ?>
                                            </td>

                                        </tr>


                                    <?php } ?>

                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination round-pagination">
                                        <?php
                                        $countQuery = "SELECT COUNT(CA.ID) AS total  FROM COLLECTION_ASSIGN CA WHERE CA.STATUS = 1
                                        AND TRUNC(CA.START_DATE) >= TO_DATE('$v_start_date','DD/MM/YYYY') 
                                        AND TRUNC(CA.END_DATE) <= TO_DATE('$v_end_date','DD/MM/YYYY')";
                                        // check retailer data exist 
                                        if (isset($_POST['f_sales_executive']) && !empty($_POST['f_sales_executive'])) {
                                            $executiveID = $_POST['f_sales_executive'];
                                            $query .= " AND ( USER_ID = $executiveID)";
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