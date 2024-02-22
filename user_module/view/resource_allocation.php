<?php
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2.min.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2-bootstrap4.css';
$dynamic_link_js[]  = '../../assets/plugins/select2/js/select2.min.js';
include_once('../../_helper/2step_com_conn.php');
$number = 0;
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
                                            <div class="col-sm-12  col-md-4">
                                                <label for="validationCustom06" class="form-label">User Type </label>
                                                <select class="form-select " id="validationCustom06" name="USER_TYPE_ID">
                                                    <option value=""><- Select Type -></option>
                                                    <?php
                                                    $typeRow = [];
                                                    $currentUserTypeID = $_SESSION['USER_SFCM_INFO']['USER_TYPE_ID'];
                                                    $USER_TYPE_ID = $_POST['USER_TYPE_ID'] ? $_POST['USER_TYPE_ID'] : '';
                                                    $query   = "SELECT ID,TITLE FROM USER_TYPE WHERE STATUS ='1'  
                                        AND ID > '$currentUserTypeID'  ORDER BY ID ASC ";
                                                    $strSQL  = @oci_parse($objConnect, $query);

                                                    @oci_execute($strSQL);
                                                    while ($typeRow = @oci_fetch_assoc($strSQL)) {
                                                    ?>
                                                        <option value="<?php echo $typeRow['ID'] ?>" <?php echo $USER_TYPE_ID == $typeRow['ID'] ? 'Selected' : ' ' ?>>
                                                            <?php echo $typeRow['TITLE'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <div class="invalid-feedback">Please select a User Type.</div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>MOBILE : </label>
                                                <input class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="USER_MOBILE" type="text" value='<?php echo isset($_POST['USER_MOBILE']) ? $_POST['USER_MOBILE'] : ''; ?>' />
                                            </div>
                                            <div class="col-sm-4 d-flex gap-2">
                                                <button type="submit" class="form-control btn btn-sm btn-gradient-primary mt-4">Search Data<i class='bx bx-file-find'></i></button>
                                                <a href="<?php echo $sfcmBasePath  ?>/user_module/view/brandAssign.php" class="form-control btn btn-sm btn-gradient-info mt-4">Reset Data<i class='bx bx-file'></i></a>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="">
                <div class="card rounded-4">
                    <?php
                    $headerType    = 'List';
                    $leftSideName  = 'Resource Allocation List';
                    include('../../_includes/com_header.php');
                    ?>
                    <div class="card-body">
                        <div class="table-responsives ">
                            <table class="table table-sm table-bordered align-middle mb-0">
                                <thead class="table-light text-uppercase text-center ">
                                    <tr>
                                        <th>SL.</th>
                                        <th>User info</th>
                                        <th>Assign Responsible ID </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT UP.ID,
                                                        UP.USER_NAME,
                                                        UP.USER_MOBILE,
                                                        UP.RML_IDENTITY_ID AS RML_ID,
                                                        (SELECT TITLE
                                                        FROM USER_TYPE
                                                        WHERE ID = UP.USER_TYPE_ID)
                                                        AS USER_TYPE,
                                                        (SELECT TITLE FROM USER_TYPE WHERE ID = (UP.USER_TYPE_ID - 1) ) AS RES_USER_TYPE,
                                                        LISTAGG (UBS.PRODUCT_BRAND_ID, ',')
                                                        WITHIN GROUP (ORDER BY UBS.PRODUCT_BRAND_ID)
                                                        AS USER_BRANDS
                                                FROM USER_PROFILE UP
                                                        LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
                                                WHERE UBS.STATUS = 1 AND UP.USER_STATUS = 1 AND UP.USER_TYPE_ID != '1'";


                                    if (isset($_POST['USER_TYPE_ID']) && !empty($_POST['USER_TYPE_ID'])) {
                                        $USER_TYPE_ID   = $_POST['USER_TYPE_ID'];
                                        $query .= " AND UP.USER_TYPE_ID = $USER_TYPE_ID";
                                    }

                                    if (isset($_POST['USER_MOBILE']) && !empty($_POST['USER_MOBILE'])) {
                                        $USER_MOBILE = $_POST['USER_MOBILE'];
                                        $query .= " AND UP.USER_MOBILE LIKE '%" . $USER_MOBILE . "%'";
                                    }

                                    $query .= " GROUP BY UP.ID,
                                                UP.USER_NAME,
                                                UP.USER_MOBILE,
                                                UP.RML_IDENTITY_ID,
                                                UP.USER_TYPE_ID
                                                ORDER BY UP.USER_TYPE_ID";
                                    $strSQL = @oci_parse($objConnect, $query);

                                    @oci_execute($strSQL);

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
                                                <?php echo $row['USER_NAME']; ?>
                                                <br>

                                                Mobile : <?php echo $row['USER_MOBILE']; ?>
                                                <br>
                                                Type : <?php echo $row['USER_TYPE']; ?>
                                                <br>
                                                ID : <?php echo $row['RML_ID']; ?>
                                                <br>
                                                BRAND-IDs : <?php echo $row['USER_BRANDS']; ?>

                                            </td>
                                            <td>
                                                <form action="" method="post" class="d-flex gap-3">
                                                    <select class="form-select text-center RESPONSIBLE_ID" id="" name="USER_RESPONSIBLE_ID">

                                                        <option><-- Select <?php echo ucwords(strtolower($row['RES_USER_TYPE'])) ?> --></option>
                                                        <?php
                                                        $resRow = [];
                                                        $currentUserBrandID = $row['USER_BRANDS'];
                                                        $currentUserTypeID = $row['USER_TYPE_ID'];
                                                        $USER_TYPE_ID = $row['USER_TYPE_ID'] ? $row['USER_TYPE_ID']  - 1 : '';
                                                        $query = "SELECT
                                                                    UP.USER_NAME,
                                                                    UP.USER_MOBILE,
                                                                    UP.ID
                                                                    FROM USER_PROFILE UP
                                                                    LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
                                                                    WHERE UP.USER_STATUS = 1
                                                                    and  UBS.PRODUCT_BRAND_ID IN ($currentUserBrandID)
                                                                    AND UP.USER_MOBILE NOT IN ('01735699133','123456789')
                                                                    AND UP.USER_TYPE_ID = '$USER_TYPE_ID'
                                                                    ORDER BY UP.ID ASC";
                                                        $strSQL2  = @oci_parse($objConnect, $query);

                                                        @oci_execute($strSQL2);
                                                        while ($resRow = @oci_fetch_assoc($strSQL2)) {
                                                        ?>
                                                            <option value="<?php echo $resRow['ID'] ?>" <?php echo $USER_TYPE_ID == $resRow['ID'] ? 'Selected' : ' ' ?>>
                                                                <?php echo $resRow['USER_NAME'] ?>
                                                                - <?php echo $resRow['USER_MOBILE'] ?>
                                                            </option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                    <button class="btn btn-sm btn-gradient-primary">
                                                        <i class='bx bx-check-double'></i>
                                                    </button>
                                                </form>

                                            </td>

                                        </tr>

                                    <?php
                                    }
                                    if ($number == 0) {
                                        echo '<tr><td colspan="9" class="text-center text-danger fw-bold">No Data Found !</td></tr>';
                                    } ?>
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
    $('.RESPONSIBLE_ID').each(function() {
        console.log($(this));
        $(this).select2({
            theme: 'bootstrap4',
            width: '100%', // Set the width as needed
            // Set the width as needed
            // placeholder: 'Select Resposible ID', // Set the placeholder text
            allowClear: true, // Enable clearing the selection
        }).addClass("text-center");
    });
</script>
<script>
    //delete data processing

    $(document).on('click', '.delete_check', function() {
        var userID = $(this).attr('data-userId');
        let url = "<?php echo ($sfcmBasePath . '/user_module/action/drop_down_panel.php') ?>";
        //console.log($(this).is(":checked"));
        if ($(this).is(":checked")) {
            $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        userId: userID,
                        brandAssignID: $(this).val(),
                        status: '1'

                    },
                    dataType: 'json'
                })
                .done(function(response) {
                    swal.fire('Success!', response.message, response.status);
                    // location.reload(); // Reload the page
                })
                .fail(function() {
                    swal.fire('Oops...', 'Something went wrong!', 'error');
                });
        } else {
            $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        userId: userID,
                        brandAssignID: $(this).val(),
                        status: '0'

                    },
                    dataType: 'json'
                })
                .done(function(response) {
                    swal.fire('Deleted!', response.message, response.status);
                    location.reload(); // Reload the page
                })
                .fail(function() {
                    swal.fire('Oops...', 'Something went wrong!', 'error');
                });
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



    });
</script>