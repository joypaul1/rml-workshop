<?php
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.css';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.date.css';

$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.js';
$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.date.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js';

include_once('../../_helper/2step_com_conn.php');
// if( $_SESSION['USER_SFCM_INFO']['USER_TYPE'] == "HOD" ||  $_SESSION['USER_SFCM_INFO']['USER_TYPE']== 'COORDINATOR'){

// }

?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <div class="card rounded-4">
            <?php
            $USER_BRANDS = $_SESSION['USER_SFCM_INFO']['USER_BRANDS'] ? $_SESSION['USER_SFCM_INFO']['USER_BRANDS'] : 0;
            $headerType   = 'List';
            $leftSideName = 'Set Collection Target Amount';
            include('../../_includes/com_header.php');
            ?>
            <div class="card card-body">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-sm-6  col-md-3">
                            <label for="validationCustom06" class="form-label">List of Disctrict </label>
                            <select class="form-select " id="validationCustom06" name="F_DISTRICT_ID">
                                <option value=""><- Select Disctrict -></option>
                                <?php
                                $brandRow = [];
                                $F_DISTRICT_ID = isset($_POST['F_DISTRICT_ID']) ? $_POST['F_DISTRICT_ID'] : 0;
                                $brandquery   = "SELECT ID,NAME FROM DISTRICT WHERE  STATUS = 1 ORDER BY ID ASC";
                                $brandSQL  = @oci_parse($objConnect, $brandquery);

                                @oci_execute($brandSQL);
                                while ($brandRow = @oci_fetch_assoc($brandSQL)) {
                                ?>
                                    <option value="<?php echo $brandRow['ID'] ?>" <?php echo $F_DISTRICT_ID == $brandRow['ID'] ? 'Selected' : ' ' ?>>
                                        <?php echo $brandRow['NAME'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback">Please select a User Type.</div>
                        </div>
                        <div class="col-sm-6  col-md-3">
                            <label for="validationCustom06" class="form-label">User Brand </label>
                            <select class="form-select " id="validationCustom06" name="F_BRAND_ID">
                                <option value=""><- Select Brand -></option>
                                <?php
                                $brandRow = [];
                                $F_BRAND_ID = isset($_POST['F_BRAND_ID']) ? $_POST['F_BRAND_ID'] : 0;
                                $brandquery   = "SELECT ID,TITLE FROM PRODUCT_BRAND WHERE ID IN ($USER_BRANDS) AND STATUS =1   ORDER BY ID ASC";
                                $brandSQL  = @oci_parse($objConnect, $brandquery);

                                @oci_execute($brandSQL);
                                while ($brandRow = @oci_fetch_assoc($brandSQL)) {
                                ?>
                                    <option value="<?php echo $brandRow['ID'] ?>" <?php echo $F_BRAND_ID == $brandRow['ID'] ? 'Selected' : ' ' ?>>
                                        <?php echo $brandRow['TITLE'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback">Please select Brand.</div>
                        </div>
                        <div class="col-sm-6  col-md-3">
                            <label>MOBILE : </label>
                            <input class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="USER_MOBILE" type="text" value='<?php echo isset($_POST['USER_MOBILE']) ? $_POST['USER_MOBILE'] : ''; ?>' />
                        </div>

                        <div class="col-sm-6 col-md-3 d-flex gap-2">
                            <button type="submit" class="form-control btn btn-sm btn-gradient-primary mt-4">Search Data<i class='bx bx-file-find'></i></button>
                            <a href="<?php echo $sfcmBasePath  ?>/user_module/view/brandAssign.php" class="form-control btn btn-sm btn-gradient-info mt-4">Reset Data<i class='bx bx-file'></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body p-4 border rounded">
                <div class="">
                    <form method="POST" action="<?php echo ($sfcmBasePath . '/collection_module/action/self_panel.php') ?>">
                        <div class="row justify-content-center align-items-center ">
                            <input type="hidden" name="actionType" value="create">

                            <div class="col-3 text-center form-group mb-3">
                                <label>Collection Start Date: </label>
                                <div class="input-group">
                                    <input required="" class="form-control text-center datepicker" name="date" type="text" value='<?php echo isset($_POST['date']) ? $_POST['date'] : date('d-m-Y'); ?>' />
                                </div>

                            </div>
                            <div class="col-3 text-center form-group mb-3">
                                <label>Collection End Date: </label>
                                <div class="input-group">
                                    <input required="" class="form-control text-center datepicker" name="date" type="text" value='<?php echo isset($_POST['date']) ? $_POST['date'] : date('d-m-Y'); ?>' />
                                </div>

                            </div>




                        </div>
                        <table class="table table-bordered align-middle">
                            <tbody>

                                <tr>
                                    <?php
                                    @oci_execute($brandSQL);
                                    while ($brandRow = @oci_fetch_assoc($brandSQL)) {
                                    ?>
                                        <td class="text-center text-success rounded fw-bold">
                                            <?= $brandRow['TITLE'] ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <?php
                                    @oci_execute($brandSQL);

                                    // Flag to check if any data is found for any brand
                                    $dataFound = false;

                                    while ($brandRow = @oci_fetch_assoc($brandSQL)) {
                                        $brandID = $brandRow['ID'];

                                        // Fetch data for the current brand
                                        $query = "SELECT 
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
                                        $query .= " GROUP BY 
                                        UP.ID, UP.DISTRICT_ID,
                                        UP.USER_NAME";
                                        $strSQL = oci_parse($objConnect, $query);
                                        oci_execute($strSQL);

                                        // Check if any data is found for the current brand
                                        if ($row = oci_fetch_assoc($strSQL)) {
                                            $dataFound = true;
                                    ?>
                                            <td>
                                                <div>
                                                    <?php
                                                    do {
                                                    ?>
                                                        <span class="d-flex flex-rows justify-content-start align-items-center ">
                                                            <div class="col-6 form-checks ">
                                                                <label class="form-check-label" for="flexCheckChecked_<?php echo $row['ID'] ?>">
                                                                    <?php echo $row['USER_NAME'] ?> [ <?php echo $row['DISTRICT_NAME'] ? $row['DISTRICT_NAME'] : "-" ?> ]
                                                                </label>
                                                            </div>
                                                            <div class="col-6 form-checks mb-2">
                                                                <input type="text" name="collection_amount[<?php echo $row['ID'] ?>]" placeholder="Collection Amount..." class="form-control" id="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                            </div>
                                                        </span>
                                                    <?php
                                                    } while ($row = oci_fetch_assoc($strSQL));
                                                    ?>
                                                </div>
                                            </td>
                                        <?php
                                        } else {
                                            // No data found for the current brand
                                        ?>
                                            <td class="text-danger fw-bold text-center">
                                                No Sale Executive data found ! &#128542;
                                            </td>
                                    <?php
                                        }
                                    }
                                    ?>

                                </tr>

                            </tbody>
                        </table>



                        <div class="form-group">
                            <button class="form-control  btn btn-sm btn-gradient-primary mt-4" type="submit">Create Visit Assign<i class='bx bx-file-find'></i></button>
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
    // Get the current date
    var today = new Date();

    // Format the date as 'dd-mm-yyyy'
    var formattedToday = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();

    // Initialize Pickadate with the min option set to today
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: true,
        format: 'dd-mm-yyyy', // Specify your desired date format
        min: new Date(today.getFullYear(), today.getMonth(), today.getDate()), // Set min date
        onClose: function() {
            // Trigger close event if needed
        }
    });

    // Set the initial value to today
    $('.datepicker').pickadate('picker').set('select', formattedToday);
</script>