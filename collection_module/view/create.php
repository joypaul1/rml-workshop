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


?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <div class="card rounded-4">
            <?php
            $USER_BRANDS = $_SESSION["USER_SFCM_INFO"]["USER_BRANDS"]
                ? $_SESSION["USER_SFCM_INFO"]["USER_BRANDS"]
                : 0;
            $headerType = "List";
            $leftSideName = "Set Collection Target Amount";
            include "../../_includes/com_header.php";
            ?>
            <div class="card card-body">
                <form action="<?php echo htmlspecialchars(
                                    $_SERVER["PHP_SELF"],
                                    ENT_QUOTES,
                                    "UTF-8"
                                ); ?>" method="GET">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-sm-6  col-md-3">
                            <label for="validationCustom06" class="form-label">User Brand </label>
                            <select class="form-select single-select" id="validationCustom06" name="F_BRAND_ID">
                                <option value=""><- Select Brand -></option>
                                <?php
                                $brandRow = [];
                                $F_BRAND_ID = isset($_GET["F_BRAND_ID"])
                                    ? $_GET["F_BRAND_ID"]
                                    : 0;
                                $brandquery = "SELECT ID,TITLE FROM PRODUCT_BRAND WHERE ID IN ($USER_BRANDS) AND STATUS =1   ORDER BY ID ASC";
                                $brandSQL = @oci_parse(
                                    $objConnect,
                                    $brandquery
                                );

                                @oci_execute($brandSQL);
                                while (
                                    $brandRow = @oci_fetch_assoc($brandSQL)
                                ) { ?>
                                    <option value="<?php echo $brandRow["ID"]; ?>" <?php echo $F_BRAND_ID ==
                                                                                        $brandRow["ID"]
                                                                                        ? "Selected"
                                                                                        : " "; ?>>
                                        <?php echo $brandRow["TITLE"]; ?>
                                    </option>
                                <?php }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please select Brand.</div>
                        </div>
                        <div class="col-sm-6  col-md-3">
                            <label>MOBILE : </label>
                            <input class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="F_USER_MOBILE" type="text" value='<?php echo isset(
                                                                                                                                                                        $_GET["F_USER_MOBILE"]
                                                                                                                                                                    )
                                                                                                                                                                        ? $_GET["F_USER_MOBILE"]
                                                                                                                                                                        : ""; ?>' />
                        </div>

                        <div class="col-sm-6 col-md-3 d-flex gap-2">
                            <button type="submit" class="form-control btn btn-sm btn-gradient-primary mt-4">Search <i class='bx bx-file-find'></i></button>
                            <a href="<?php echo $sfcmBasePath; ?>/collection_module/view/create.php" class="form-control btn btn-sm btn-gradient-info mt-4">Reset <i class='bx bx-file'></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body p-4 border rounded">
                <div class="">
                    <form method="POST" action="<?php echo $sfcmBasePath . "/collection_module/action/self_panel.php"; ?>">
                        <div class="row justify-content-center align-items-center ">
                            <input type="hidden" name="actionType" value="create">

                            <div class="col-4 text-center form-group mb-3">
                                <label>Collection Start Date: </label>
                                <div class="input-group">
                                    <input required="" class="form-control text-center datepicker start_date" name="start_date" type="text" value='<?php echo date(
                                                                                                                                                        "01-m-Y"
                                                                                                                                                    ); ?>' />
                                </div>
                            </div>

                            <div class="col-4 text-center form-group mb-3">
                                <label>Collection End Date: </label>
                                <div class="input-group">
                                    <input required="" class="form-control text-center datepicker end_date" name="end_date" type="text" value='<?php echo date(
                                                                                                                                                    "t-m-Y"
                                                                                                                                                ); ?>' />
                                </div>
                            </div>

                        </div>
                        <table class="table table-bordered align-middle">
                            <tbody>

                                <tr>
                                    <?php
                                    @oci_execute($brandSQL);
                                    while (
                                        $brandRow = @oci_fetch_assoc($brandSQL)
                                    ) { ?>
                                        <td class="text-center text-success rounded fw-bold">
                                            <?= $brandRow["TITLE"] ?>
                                        </td>
                                    <?php }
                                    ?>
                                </tr>
                                <tr>
                                    <?php
                                    @oci_execute($brandSQL);

                                    // Flag to check if any data is found for any brand
                                    $dataFound = false;

                                    while (
                                        $brandRow = @oci_fetch_assoc($brandSQL)
                                    ) {
                                        $brandID = $brandRow["ID"];

                                        // Fetch data for the current brand
                                        $query ="SELECT 
                                                    UP.ID, 
                                                    UP.USER_NAME,
                                                    (SELECT NAME FROM DISTRICT WHERE ID = UP.DISTRICT_ID) AS DISTRICT_NAME 
                                                    FROM 
                                                        USER_PROFILE UP
                                                    LEFT JOIN 
                                                        USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
                                                    WHERE 
                                                        UBS.PRODUCT_BRAND_ID IN ($brandID)
                                                        AND UBS.STATUS = 1
                                                        AND UP.USER_TYPE_ID = 3";
                                        if (isset($_GET["F_BRAND_ID"])) {
                                            if ($_GET["F_BRAND_ID"]) {
                                                $query .=
                                                    " AND UBS.PRODUCT_BRAND_ID = " .
                                                    $_GET["F_BRAND_ID"];
                                            }
                                        }
                                        if (isset($_GET["F_USER_MOBILE"])) {
                                            if ($_GET["F_USER_MOBILE"]) {
                                                $query .= " AND UP.USER_MOBILE LIKE '%" . $_GET["F_USER_MOBILE"] . "%'";
                                            }
                                        }

                                        $strSQL = oci_parse(
                                            $objConnect,
                                            $query
                                        );
                                        oci_execute($strSQL);

                                        // Check if any data is found for the current brand
                                        if ($row = oci_fetch_assoc($strSQL)) {
                                            $dataFound = true; ?>
                                            <td>
                                                <div>
                                                    <?php do { ?>
                                                        <span class="d-flex flex-rows justify-content-start align-items-center ">
                                                            <div class="col-6 form-checks ">
                                                                <label class="form-check-label" for="flexCheckChecked_<?php echo $row["ID"]; ?>">
                                                                    <?php echo $row["USER_NAME"]; ?> [ <?php echo $row["DISTRICT_NAME"]? $row["DISTRICT_NAME"]: "-"; ?> ]
                                                                </label>
                                                            </div>
                                                            <div class="col-6 form-checks mb-2">
                                                                <input type="text" name="collection_amount[<?= $brandID ?>][<?php echo $row["ID"]; ?>]" placeholder="Collection Amount..." class="form-control" id="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                               
                                                            </div>
                                                        </span>
                                                    <?php } while (
                                                        $row = oci_fetch_assoc(
                                                            $strSQL
                                                        )
                                                    ); ?>
                                                </div>
                                            </td>
                                    <?php
                                        } else {

                                            echo '<td class="text-danger fw-bold text-center">
                                            No Sale Executive data found ! &#128542;
                                        </td>';
                                        }
                                    }
                                    ?>

                                </tr>

                            </tbody>
                        </table>


                        <div class="d-flex justify-content-center ">
                            <div class="">
                                <button class="form-control  btn btn-sm btn-gradient-primary mt-4" type="submit">
                                    Submit Target <i class='bx bx-file-find'></i></button>
                            </div>
                        </div>




                    </form>
                </div>

            </div>

        </div>
    </div>

</div>

<!--end page wrapper -->
<?php
include_once('../../_includes/footer_info.php');
include_once('../../_includes/footer.php');
?>
<script>
    $('.single-select').each(function(event) {
        console.log($(this), 'ssss');
        $(this).select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
    });
    // Get the current date
    var today = new Date();

    // Format the date as 'dd-mm-yyyy'
    var formattedToday = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();

    // Initialize Pickadate with the min option set to today
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: true,
        format: 'dd-mm-yyyy', // Specify your desired date format
        min: new Date(today.getFullYear(), today.getMonth(), 1), // Set min date to the first day of the current month
        onClose: function() {
            // Trigger close event if needed
        }
    });

    // Set the initial value to today
    $('.start_date').pickadate('picker').set('select', [today.getFullYear(), today.getMonth(), 1]);
</script>