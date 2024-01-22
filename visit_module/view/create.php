<?php
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.css';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.date.css';

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

            $headerType   = 'List';
            $leftSideName = 'Visit Create or Assign For Me.';
            include('../../_includes/com_header.php');
            ?>
            <div class="card-body">
                <div class=" card card-body col-sm-12 col-md-9 col-xl-9 mx-auto p-4 border rounded">
                    <form method="POST" action="<?php echo ($basePath . '/visit_module/action/self_panel.php') ?>">
                        <div class="row justify-content-center align-items-center ">
                            <input type="hidden" name="actionType" value="create">

                            <div class="col-5 text-center form-group mb-3">
                                <label>Select Date: </label>
                                <div class="input-group">
                                    <input required="" class="form-control datepicker" name="date" type="text" value='<?php echo isset($_POST['date']) ? $_POST['date'] : date('d-m-Y'); ?>' />
                                </div>

                            </div>

                            <div class="col-5 text-center form-group mb-3">
                                <label>Select Visit Type : </label>
                                <select id="inputState" required name="visit_type" class="form-select text-center">
                                    <option hidden value="<?php echo null ?>"> <- Select Type Data -></option>
                                    <?php
                                    $executiveID = $_SESSION['USER_SFCM_INFO']['ID'];
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
                            <div class="shadow-sm p-2 mb-2 bg-white rounded text-center">

                                <strong class="text-success rounded fs-6"> Select Your Retailer <i class='bx bx-select-multiple'></i></strong>

                            </div>
                            <div class="form-group mb-3">


                                <?php
                                $executiveID = $_SESSION['USER_SFCM_INFO']['ID'];
                                $strSQL = oci_parse($objConnect, "SELECT ID, USER_NAME FROM USER_PROFILE WHERE  RESPONSIBLE_ID = $executiveID");
                                oci_execute($strSQL);

                                while ($row = oci_fetch_assoc($strSQL)) {

                                ?>
                                    <span class="row">
                                        <div class="col-6 form-check ">
                                            <input class="form-check-input" name="user_id[<?php echo $row['ID'] ?>]" type="checkbox" value="<?php echo $row['ID'] ?>" id="flexCheckChecked_<?php echo $row['ID'] ?>">
                                            <label class="form-check-label" for="flexCheckChecked_<?php echo $row['ID'] ?>"><?php echo $row['USER_NAME'] ?></label>
                                        </div>
                                        <div class="col-6 form-check mb-2">
                                            <input type="text" name="user_remarks[<?php echo $row['ID'] ?>]" placeholder="Any Remarks?" class="form-control" id="inputFirstName">
                                            <!-- <label class="form-check-label" for="flexCheckChecked_<?php echo $row['ID'] ?>"><?php echo $row['USER_NAME'] ?></label> -->
                                        </div>
                                    </span>
                                <?php
                                }
                                ?>

                            </div>


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