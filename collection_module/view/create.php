<?php
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2.min.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2-bootstrap4.css';
$dynamic_link_js[]  = '../../assets/plugins/select2/js/select2.min.js';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.css';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.date.css';
$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.js';
$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.date.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js';

include_once('../../_helper/2step_com_conn.php');

$brandquery = "SELECT ID, TITLE FROM PRODUCT_BRAND WHERE ID IN ($USER_BRANDS) AND STATUS = 1 ORDER BY ID ASC";
$F_SALE_EXECUTIVE_ID = isset($_GET['F_SALE_EXECUTIVE']) ? $_GET['F_SALE_EXECUTIVE'] : null;
$F_PLAZA_RETAILER_ID = isset($_GET['F_PLAZA_RETAILER']) ? $_GET['F_PLAZA_RETAILER'] : null;
$F_REATILER_ID       = isset($_GET['F_REATILER']) ? $_GET['F_REATILER'] : null;

?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <div class="card rounded-4">
            <?php
            $headerType = "List";
            $leftSideName = "Set Collection Target Amount";
            include "../../_includes/com_header.php";
            ?>
            <div class="card card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "UTF-8"); ?>" method="GET">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-sm-6 col-md-3">
                            <label for="validationCustom06" class="form-label"> Sale Executive : <span class="text-danger">*</span> </label>
                            <select class="form-select single-select" id="validationCustom06" name="F_SALE_EXECUTIVE" required>
                                <option value="<?php echo null ?>"><- Select Sale Executive -></option>
                                <?php
                                $executiveRow = [];
                                $F_SALE_EXECUTIVE = isset($_GET["F_SALE_EXECUTIVE"]) ? $_GET["F_SALE_EXECUTIVE"] : 0;
                                $executiveQuery = "SELECT DISTINCT UP.ID, UP.USER_NAME, UP.USER_MOBILE
                                                    FROM USER_PROFILE UP, USER_MANPOWER_SETUP UMS
                                                    WHERE UP.ID = UMS.USER_ID
                                                    AND  UP.USER_TYPE_ID = 3";

                                if ($_SESSION["USER_CSPD_INFO"]["USER_TYPE"] == "COORDINATOR") {
                                    $executiveQuery .= " AND UMS.USER_ID = UP.ID AND UMS.PARENT_USER_ID = $USER_LOGIN_ID";
                                }
                                $executiveSql = @oci_parse($objConnect, $executiveQuery);
                                @oci_execute($executiveSql);
                                while (
                                    $executiveRow = @oci_fetch_assoc($executiveSql)
                                ) { ?>
                                    <option value="<?php echo $executiveRow["ID"]; ?>" <?php echo $F_SALE_EXECUTIVE == $executiveRow["ID"] ? "Selected" : " "; ?>>
                                        <?php echo $executiveRow["USER_NAME"]; ?>
                                    </option>
                                <?php }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please select Brand.</div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <span id="add_plazaretiler"></span>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <span id="add_retiler"></span>
                        </div>

                        <div class="col-sm-6 col-md-3 d-flex gap-2">
                            <button type="submit" class="form-control btn btn-sm btn-gradient-primary mt-4">Search <i class='bx bx-file-find'></i></button>
                            <a href="<?php echo $cspdBasePath ?>/collection_module/view/create.php" class="form-control btn btn-sm btn-gradient-info mt-4">Reset <i class='bx bx-file'></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body p-4 border rounded">
                <div class="">
                    <form method="POST" action="<?php echo $cspdBasePath . "/collection_module/action/self_panel.php"; ?>">
                        <div class="row justify-content-center align-items-center ">
                            <input type="hidden" name="actionType" value="create">

                            <div class="col-4 text-center form-group mb-3">
                                <label> Collection Start Date: </label>
                                <div class="input-group">
                                    <input required="" class="form-control text-center datepicker start_date" name="start_date" type="text" value='<?php echo date("01/m/Y"); ?>' />
                                </div>
                            </div>

                            <div class="col-4 text-center form-group mb-3">
                                <label>Collection End Date: </label>
                                <div class="input-group">
                                    <input required="" class="form-control text-center datepicker end_date" name="end_date" type="text" value='<?php echo date("t/m/Y"); ?>' />
                                </div>
                            </div>

                        </div>
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <?php

                                    $brandSQL = oci_parse($objConnect, $brandquery);
                                    oci_execute($brandSQL);
                                    while ($brandRow = oci_fetch_assoc($brandSQL)) {
                                    ?>
                                        <th class="text-center text-success rounded fw-bold">
                                            <?= $brandRow["TITLE"] ?>
                                        </th>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($F_SALE_EXECUTIVE_ID && $F_PLAZA_RETAILER_ID ==  null) { ?>
                                    <tr>
                                        <?php
                                        @oci_execute($brandSQL);
                                        $dataFound = false;// Flag to check if any data is found for any brand

                                        while (
                                            $brandRow = @oci_fetch_assoc($brandSQL)
                                        ) {
                                            $brandID = $brandRow["ID"];
                                            // Fetch data for the current brand
                                            $query = "SELECT UP.ID,UP.USER_NAME,UP.USER_MOBILE, (SELECT NAME FROM DISTRICT WHERE ID = UP.DISTRICT_ID) AS DISTRICT_NAME,
                                            (SELECT ID FROM PRODUCT_BRAND WHERE ID=UBS.PRODUCT_BRAND_ID) AS USER_BRAND_ID
                                            FROM USER_MANPOWER_SETUP UMP,USER_PROFILE UP
                                            LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
                                            WHERE UMP.USER_ID = UP.ID
                                            AND UBS.STATUS = 1
                                            AND UBS.PRODUCT_BRAND_ID IN ($brandID)
                                            AND UMP.PARENT_USER_ID = $F_SALE_EXECUTIVE_ID";

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
                                                            <span class="d-flex flex-rows justify-content-start align-items-center">
                                                                <div class="col-6 form-checks ">
                                                                    <label class="form-check-label" for="flexCheckChecked_<?php echo $row["ID"]; ?>">
                                                                        <?php echo $row["USER_NAME"]; ?> [ <?php echo $row["DISTRICT_NAME"] ? $row["DISTRICT_NAME"] : "-"; ?> ]
                                                                    </label>
                                                                </div>
                                                                <div class="col-3 form-checks mb-2">
                                                                    <input type="text"  name="collection_target_amount[<?= $brandID ?>][<?php echo $row["ID"]; ?>]" placeholder="Collection Target Amount..." class="form-control" id="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                </div>
                                                                <div class="col-3 form-checks mb-2">
                                                                    <input type="text"  name="sale_target_amount[<?= $brandID ?>][<?php echo $row["ID"]; ?>]" placeholder="Sale Target Amount..." class="form-control" id="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                </div>
                                                            </span>
                                                        <?php } while (
                                                            $row = @oci_fetch_assoc(
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
                                <?php } ?>
                                <?php if ($F_PLAZA_RETAILER_ID) { ?>
                                    <tr>
                                        <?php
                                        @oci_execute($brandSQL); // Flag to check if any data is found for any brand
                                        $dataFound = false;

                                        while (
                                            $brandRow = @oci_fetch_assoc($brandSQL)
                                        ) {
                                            $brandID = $brandRow["ID"];
                                            // Fetch data for the current brand
                                            $query = "SELECT UP.ID,UP.USER_NAME,UP.USER_MOBILE, (SELECT NAME FROM DISTRICT WHERE ID = UP.DISTRICT_ID) AS DISTRICT_NAME,
                                            (SELECT ID FROM PRODUCT_BRAND WHERE ID=UBS.PRODUCT_BRAND_ID) AS USER_BRAND_ID
                                            FROM USER_MANPOWER_SETUP UMP,USER_PROFILE UP
                                            LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
                                            WHERE UMP.USER_ID = UP.ID
                                            AND UBS.STATUS = 1
                                            AND UBS.PRODUCT_BRAND_ID IN ($brandID)
                                            AND UMP.PARENT_USER_ID = $F_PLAZA_RETAILER_ID";

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
                                                            <span class="d-flex flex-rows justify-content-start align-items-center gap-2">
                                                                <div class="col-6 form-checks ">
                                                                    <label class="form-check-label" for="flexCheckChecked_<?php echo $row["ID"]; ?>">
                                                                        <?php echo $row["USER_NAME"]; ?> [ <?php echo $row["DISTRICT_NAME"] ? $row["DISTRICT_NAME"] : "-"; ?> ]
                                                                    </label>
                                                                </div>
                                                                <div class="col-3 form-checks mb-2">
                                                                    <input type="text"  name="collection_target_amount[<?= $brandID ?>][<?php echo $row["ID"]; ?>]" placeholder="Collection Target Amount..." class="form-control" id="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                </div>
                                                                <div class="col-3 form-checks mb-2">
                                                                    <input type="text"  name="sale_target_amount[<?= $brandID ?>][<?php echo $row["ID"]; ?>]" placeholder="Sale Target Amount..." class="form-control" id="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                </div>
                                                            </span>
                                                        <?php } while (
                                                            $row = @oci_fetch_assoc(
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
                                <?php } ?>
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
    const $URL = "<?php echo ($cspdBasePath . '/collection_module/action/drop_down_panel.php') ?>";
    const $F_SALE_EXECUTIVE = $('select[name="F_SALE_EXECUTIVE"]');
    const $F_PLAZA_RETAILER_ID = "<?php echo $F_PLAZA_RETAILER_ID ? $F_PLAZA_RETAILER_ID : null ?>";

    if ($F_PLAZA_RETAILER_ID) {
        let htmlTag = ""; // Initialize htmlTag here
        // getPlazaRetailerData();
        $('#add_plazaretiler').empty('');
        $('#add_retiler').empty('');
        $.ajax({
            type: "GET",
            url: $URL,
            dataType: "JSON",
            data: {
                sale_executive_id: $F_SALE_EXECUTIVE.val(),
                retailer_plaza_data: true
            },
            success: function(res) {
                var htmlTag = ''; // Initialize htmlTag variable
                htmlTag += `<label for="F_PLAZA_RETAILER" class="form-label"> Plaza Retailer
                        </label>
                        <select class="form-select single-select" name="F_PLAZA_RETAILER" id="F_PLAZA_RETAILER">
                    <option hidden value="<?php echo Null ?>"> <- Select Plaza Retailer -></option>`;
                if (res.status) {
                    (res.data).forEach(element => {
                        htmlTag += '<option value="' + element.ID + '"' + ($F_PLAZA_RETAILER_ID == element.ID ? "selected" : "") + ' > ' + element.USER_NAME + ' </option>';
                    });

                }
                htmlTag += `</select></div>`;
                $('#add_plazaretiler').append(htmlTag);
                // Initialize Select2 for the appended dropdown element
                $('#add_plazaretiler').find('#F_PLAZA_RETAILER').select2({
                    theme: 'bootstrap4',
                    width: '100%', // Set the width as needed
                    placeholder: 'Select Plaza Retailer', // Set the placeholder text
                    allowClear: true, // Enable clearing the selection
                });
            }
        });
    }

    // const $F_REATILER = $('select[name="F_REATILER"]');


    $('.single-select').each(function(event) {
        $(this).select2({
            theme: 'bootstrap4',
            width: '100%', // Set the width as needed
            allowClear: true, // Enable clearing the selection
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
        format: 'dd/mm/yyyy', // Specify your desired date format
        min: new Date(today.getFullYear(), today.getMonth(), 1), // Set min date to the first day of the current month
        onClose: function() {
            // Trigger close event if needed
        }
    });

    // Set the initial value to today
    $('.start_date').pickadate('picker').set('select', [today.getFullYear(), today.getMonth(), 1]);

    $('select[name="F_SALE_EXECUTIVE"]').on('change', function() {
        getPlazaRetailerData();
    });

    // $(document).on('change', 'select[name="F_PLAZA_RETAILER"]', function() {
    //     const $F_PLAZA_RETAILER = $('select[name="F_PLAZA_RETAILER"]');
    //     getRetailerData($F_PLAZA_RETAILER.val());
    // })

    // function getRetailerData(plazaRetailerId) {
    //     let htmlTag = ""; // Initialize htmlTag here
    //     $('#add_retiler').empty('');
    //     $.ajax({
    //         type: "GET",
    //         url: $URL,
    //         dataType: "JSON",
    //         data: {
    //             plaza_retailer_data_id: plazaRetailerId,
    //             retailer_data: true
    //         },
    //         success: function(res) {
    //             htmlTag += `<label for="F_REATILER" class="form-label"> Retailer </label>
    //                             <select class="form-select single-select" name="F_REATILER" id="F_REATILER">
    //                         <option  hidden value="<?php echo Null ?>"> <- Selecte Retailer -></option>`;
    //             if (res.status) {
    //                 (res.data).forEach(element => {
    //                     htmlTag += '<option value="' + element.ID + '"> ' + element.USER_NAME + ' </option>';
    //                 });
    //             }
    //             htmlTag += `</select></div>`;
    //             $('#add_retiler').append(htmlTag);
    //             // Initialize Select2 for the appended dropdown element
    //             $('#add_retiler').find('#F_REATILER').select2({
    //                 theme: 'bootstrap4',
    //                 width: '100%', // Set the width as needed
    //                 placeholder: 'Select Retailer', // Set the placeholder text
    //                 allowClear: true, // Enable clearing the selection
    //             });
    //         }

    //     });
    // }

    function getPlazaRetailerData() {
        let htmlTag = ""; // Initialize htmlTag here
        $('#add_plazaretiler').empty('');
        $('#add_retiler').empty('');
        $.ajax({
            type: "GET",
            url: $URL,
            dataType: "JSON",
            data: {
                sale_executive_id: $F_SALE_EXECUTIVE.val(),
                retailer_plaza_data: true
            },
            success: function(res) {
                htmlTag += `<label for="F_PLAZA_RETAILER" class="form-label"> Plaza Retailer
                                </label>
                                <select class="form-select single-select" name="F_PLAZA_RETAILER" id="F_PLAZA_RETAILER">
                            <option  hidden value="<?php echo Null ?>"> <- Selecte Plaza Retailer -></option>`;
                if (res.status) {
                    (res.data).forEach(element => {
                        htmlTag += '<option value="' + element.ID + '"> ' + element.USER_NAME + ' </option>';
                    });
                }
                htmlTag += `</select></div>`;
                $('#add_plazaretiler').append(htmlTag);
                // Initialize Select2 for the appended dropdown element
                $('#add_plazaretiler').find('#F_PLAZA_RETAILER').select2({
                    theme: 'bootstrap4',
                    width: '100%', // Set the width as needed
                    placeholder: 'Select Plaza Retailer ', // Set the placeholder text
                    allowClear: true, // Enable clearing the selection
                });
            }

        });
    }
</script>