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

$log_user_id   = $_SESSION['USER_SFCM_INFO']['ID'];
$retailer_type  = 4;
if (isset($_POST['retailer_type'])) {
    $retailer_type = $_POST['retailer_type'];
}
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <div class="card rounded-4">
            <?php
            $headerType   = 'List';
            $leftSideName = 'Retailer Point Visit Assign Form';
            include('../../_includes/com_header.php');
            ?>
            <div class="cards rounded-4">
                <div class="card-body">

                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
                        <div class="row justify-content-center align-items-center text-centers">
                            <!-- <div class="col-3">
                                <label class="form-label"> Retailer Type:</label>
                                <select name="brand_id" class="form-control 
                                text-center single-select">
                                    <option value="<?php echo null ?>" hidden><- Select Brand -></option>
                                    <?php
                                    $strSQL = oci_parse($objConnect, "SELECT ID,TITLE FROM PRODUCT_BRAND WHERE STATUS =1");
                                    oci_execute($strSQL);

                                    while ($row = oci_fetch_assoc($strSQL)) {
                                    ?>
                                        <option value="<?php echo $row['ID'] ?>" <?php echo isset($_POST['brand_id']) && $_POST['brand_id'] == $row['ID'] ? 'Selected' : '' ?>>
                                            <?php echo $row['TITLE'] ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div> -->
                            <div class="col-3">
                                <label class="form-label"> Retailer Type:</label>
                                <select name="retailer_type" class="form-control 
                                text-center single-select">
                                    <option value="4" selected>Plaza Retiler</option>
                                    <option value="5"> Retiler</option>

                                </select>
                            </div>
                            <div class="col-3">
                                <label class="form-label"> Retailer Disctrict:</label>
                                <select name="disctrictID" class="form-control 
                                text-center single-select">
                                    <option value="<?php echo null ?>" hidden><- Select Disctrict -></option>
                                    <?php
                                    $strSQL = oci_parse($objConnect, "SELECT ID,NAME FROM DISTRICT WHERE STATUS =1");
                                    oci_execute($strSQL);

                                    while ($row = oci_fetch_assoc($strSQL)) {
                                    ?>
                                        <option value="<?php echo $row['ID'] ?>" <?php echo isset($_POST['disctrictID']) && $_POST['disctrictID'] == $row['ID'] ? 'Selected' : '' ?>>
                                            <?php echo $row['NAME'] ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Retailer Name/Mobile : </label>
                                <input class="form-control" name="USER_NAME_MOBILE" type="text" value='<?php echo isset($_POST['USER_NAME_MOBILE']) ? $_POST['USER_NAME_MOBILE'] : ''; ?>' />
                            </div>
                            <div class="col-sm-3 d-flex gap-2">
                                <button type="submit" class="form-control btn btn-sm btn-gradient-primary mt-4">Search Data</button>
                                <a href="<?php echo $sfcmBasePath  ?>/visit_module/view/create.php" class="form-control btn btn-sm btn-gradient-info mt-4">Reset Data</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class=" card card-body col-sm-12 col-md-12  col-xl-12 mx-auto p-4 border rounded">
                    <form method="POST" action="<?php echo ($sfcmBasePath . '/visit_module/action/self_panel.php') ?>">
                        <div class="row justify-content-end align-items-center ">
                            <input type="hidden" name="actionType" value="create">

                            <div class="shadow-sm p-2 mb-2 bg-white rounded text-center">

                                <strong class="text-primary rounded fs-6"> Please Select Your Retailer <i class='bx bx-select-multiple'></i></strong>

                            </div>
                            <div class="form-group mb-3">

                                <?php
                                // $USER_BRANDS = $_SESSION['USER_SFCM_INFO']['USER_BRANDS'] ? $_SESSION['USER_SFCM_INFO']['USER_BRANDS'] : 0;
                                // if (isset($_POST['brand_id'])) {
                                //     if (!empty($_POST['brand_id'])) {
                                //         $USER_BRANDS = $_POST['brand_id'];
                                //     }
                                // }
                                if ($retailer_type == 4) {
                                    $query =  "SELECT UP.ID,UMP.USER_ID,UP.USER_NAME,UP.DISTRICT_ID,
                                    (SELECT ID FROM PRODUCT_BRAND WHERE ID=UBS.PRODUCT_BRAND_ID) AS USER_BRAND_ID
                                    FROM USER_MANPOWER_SETUP UMP,USER_PROFILE UP
                                    LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
                                    WHERE UMP.USER_ID = UP.ID
                                    AND UBS.STATUS = 1
                                    AND UMP.PARENT_USER_ID =" . $log_user_id;
                                } else {
                                    $query = "SELECT UP.ID,UMP.USER_ID,UP.USER_NAME,UP.DISTRICT_ID,
                                    (SELECT ID FROM PRODUCT_BRAND WHERE ID=UBS.PRODUCT_BRAND_ID) AS USER_BRAND_ID
                                    FROM USER_MANPOWER_SETUP UMP,USER_PROFILE UP
                                    LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
                                    WHERE UMP.USER_ID=UP.ID
                                    AND UBS.STATUS = 1
                                    AND UMP.PARENT_USER_ID
                                    IN (SELECT UMP.USER_ID FROM USER_MANPOWER_SETUP UMS,USER_PROFILE UP
                                    WHERE UMP.USER_ID = UP.ID
                                    AND UMP.PARENT_USER_ID=$log_user_id)";
                                }
                                // ECHO $query;
                                // $query = "SELECT
                                //             UP.ID,
                                //             (UP.USER_NAME || ' ['||(SELECT TITLE FROM PRODUCT_BRAND WHERE ID=UBS.PRODUCT_BRAND_ID) || ']') USER_NAME,
                                //             (SELECT ID FROM PRODUCT_BRAND WHERE ID=UBS.PRODUCT_BRAND_ID) AS USER_BRAND_ID,
                                //             UP.USER_MOBILE
                                //         FROM
                                //             USER_PROFILE UP
                                //         LEFT JOIN
                                //             USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
                                //             LEFT JOIN USER_MANPOWER_SETUP UMS ON UMS.USER_ID = UP.ID
                                //         WHERE
                                //             UBS.PRODUCT_BRAND_ID IN ($USER_BRANDS)
                                //             AND UBS.STATUS = 1
                                //             AND UP.USER_TYPE_ID = 4";
                                // if ($_SESSION['USER_SFCM_INFO']['USER_TYPE'] == 'SALE EXECUTIVE') {
                                //     $query .= " AND UMS.PARENT_USER_ID  =" . $log_user_id;
                                // }

                                if (isset($_POST['USER_NAME_MOBILE'])) {
                                    if (!empty($_POST['USER_NAME_MOBILE'])) {
                                        $searchTerm = str_replace(" ", "_", trim($_POST['USER_NAME_MOBILE']));
                                        $query .= " AND (UP.USER_NAME LIKE '%" . $searchTerm . "%' OR UP.USER_MOBILE LIKE '%" . $searchTerm . "%')";
                                    }
                                }
                                if (isset($_POST['disctrictID'])) {
                                    if (!empty($_POST['disctrictID'])) {
                                        $searchTerm = trim($_POST['disctrictID']);
                                        $query .= " AND UP.DISTRICT_ID = " . $searchTerm;
                                        // $query .= and '' is null or UP.DISTRICT_ID=
                                    }
                                }
                                // $query .= " ORDER BY UP.USER_NAME";
                                // echo  $query;
                                $strSQL = oci_parse($objConnect, $query);
                                oci_execute($strSQL);

                                while ($row = oci_fetch_assoc($strSQL)) {

                                ?>
                                    <span class="row justify-content-center">
                                        <input type="hidden" name="user_brand_id[<?php echo $row['ID'] ?>][<?php echo $row['USER_BRAND_ID'] ?>]">
                                        <div class="col-6 form-check ">
                                            <i class='bx bxs-chevrons-right text-success'></i>
                                            <input class="form-check-input" name="user_id[<?php echo $row['ID'] ?>]" type="checkbox" value="<?php echo $row['ID'] ?>" id="flexCheckChecked_<?php echo $row['ID'] ?>">

                                            <label class="form-check-label" for="flexCheckChecked_<?php echo $row['ID'] ?>"><?php echo $row['USER_NAME'] ?></label>
                                        </div>
                                        <div class="col-4 form-check mb-2">
                                            <input type="text" name="user_remarks[<?php echo $row['ID'] ?>]" placeholder="Any Remarks?" class="form-control" id="inputFirstName">
                                        </div>
                                    </span>
                                <?php
                                }
                                ?>

                            </div>
                            <div class="col-3">
                                <label class="form-label">Select Visit Assign Date: </label>
                                <div class="input-group">
                                    <input required="" class="form-control datepicker" name="date" type="text" value='<?php echo isset($_POST['date']) ? $_POST['date'] : date('d-m-Y'); ?>' />
                                </div>
                            </div>

                            <div class="col-3">
                                <label class="form-label">Select Visit Type : </label>
                                <select id="inputState" required name="visit_type" class="form-control 
                                text-center single-select">
                                    <option hidden value="<?php echo null ?>"> <- Select Type Data -></option>
                                    <?php

                                    $strSQL = oci_parse($objConnect, "SELECT ID, TITLE FROM VISIT_TYPE WHERE STATUS = 1");
                                    oci_execute($strSQL);
                                    while ($typeRow = oci_fetch_assoc($strSQL)) {
                                    ?>
                                        <option <?php echo (isset($_POST['visit_type']) && $_POST['visit_type'] == $typeRow['ID']) ? 'selected' : '' ?> value="<?php echo $typeRow['ID']; ?>"><?php echo $typeRow['TITLE']; ?></option>

                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>

                        </div>
                        <div class="text-end ">
                            <button class=" btn btn-sm btn-gradient-primary mt-4" type="submit">Create Visit Assign<i class='bx bx-file-find'></i></button>
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
    //select 2
    $('.single-select').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
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
        min: new Date(today.getFullYear(), today.getMonth(), today.getDate()), // Set min date
        onClose: function() {
            // Trigger close event if needed
        }
    });

    // Set the initial value to today
    $('.datepicker').pickadate('picker').set('select', formattedToday);
</script>