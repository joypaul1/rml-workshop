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
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-sm-4">
                                                <label>Select Your Retailer:</label>
                                                <select name="emp_concern" class="form-control single-select">
                                                    <option value="<?php echo null ?>" hidden><- Select Retailer -></option>
                                                    <?php
                                                    $executiveID = $_SESSION['USER_INFO']['ID'];
                                                    $strSQL = oci_parse($objConnect, "SELECT ID, USER_NAME FROM USER_PROFILE WHERE  RESPONSIBLE_ID = $executiveID");
                                                    oci_execute($strSQL);
                    
                                                    while ($row = oci_fetch_assoc($strSQL)) {
                                                    ?>
                                                        <option value="<?php echo $row['ID'] ?>"<?php echo isset($_POST['emp_concern']) && $_POST['emp_concern'] == $row['ID']?'Selected' : '' ?>>
                                                            <?php echo $row['USER_NAME'] ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="col-sm-3">
                                                <label>Start Data: </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar">
                                                        </i>
                                                    </div>
                                                    <input required="" class="form-control datepicker" form="Form1" name="start_date" type="text" value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : date('01-m-Y'); ?>' />
                                                </div>

                                            </div>
                                            <div class="col-sm-3">
                                                <label>End Data: </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar">
                                                        </i>
                                                    </div>
                                                    <input required="" class="form-control datepicker" form="Form1" name="end_date" type="text" value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : date('t-m-Y'); ?>' />
                                                </div>

                                            </div>

                                            <div class="col-sm-2">
                                                <button class="form-control  btn btn-sm btn-gradient-primary mt-4" type="submit">Search Data<i class='bx bx-file-find'></i></button>
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
                                        <th>Action</th>
                                        <th>Name</th>
                                        <th>mobile</th>
                                        <th>RML ID</th>
                                        <th>BRAND</th>
                                        <th>TYPE</th>
                                        <th>RESponsible User</th>
                                        <th>Tree User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT UP.ID,
                                            UP.USER_NAME,
                                            UP.USER_MOBILE,
                                            UP.RML_ID,
                                            UP.CREATED_DATE,
                                            (SELECT USER_NAME
                                            FROM USER_PROFILE
                                            WHERE ID = UP.RESPONSIBLE_ID)
                                            AS USER_RESPONSIBLE_NAME, 
                                            (SELECT TITLE
                                            FROM USER_BRAND
                                            WHERE ID = UP.USER_BRAND_ID)
                                            AS USER_BRAND, 
                                            (SELECT TITLE FROM USER_TYPE WHERE ID = UP.USER_TYPE_ID) AS USER_TYPE
                                            FROM USER_PROFILE UP WHERE UP.USER_STATUS ='1' ORDER BY UP.USER_TYPE_ID";

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
                                                <a href="<?php echo $basePath . '/visit_module/view/edit.php?id=' . $row['ID'] . '&actionType=edit' ?>" class="btn btn-sm btn-gradient-warning text-white"><i class='bx bxs-edit-alt'></i></a>
                                                <button type="button" data-id="<?php echo $row['ID'] ?>" data-href="<?php echo ($basePath . '/visit_module/action/self_panel.php') ?>" class="btn btn-sm btn-gradient-danger delete_check"><i class='bx bxs-trash'></i></button>
                                            </td>
                                            <td>
                                                <?php echo $row['USER_NAME']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['USER_MOBILE']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['RML_ID']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['USER_BRAND']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['USER_TYPE']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['USER_RESPONSIBLE_NAME']; ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo $basePath . '/visit_module/view/userTree.php?id=' . $row['ID']  ?>" class="btn btn-sm btn-gradient-info text-white"><i class='bx bx-street-view'></i></a>
                                            </td>

                                        </tr>


                                    <?php } ?>

                                </tbody>
                            </table>
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