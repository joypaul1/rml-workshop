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



if (isset($_POST['submit_approval'])) {
    if (!empty($_POST['check_list'])) {
        foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
            $strSQL = oci_parse(
                $objConnect,
                "UPDATE COLL_VISIT_ASSIGN_APPROVAL
                SET    
                        APPROVAL_STATUS          = 1,
                        APPROVED_DATE            = SYSDATE,
                        APPROVED_BY_RML_ID       = '$emp_session_id'
                WHERE  ID ='$TT_ID_SELECTTED'"
            );

            oci_execute($strSQL);


            //echo 'Successfully Approved Visit Assign ID '.$TT_ID_SELECTTED."</br>";
            echo "<script>window.location = '$basePath/zh_module/view/visit_approval_list.php'</script>";
        }
    } else {
        echo 'Sorry! You have not select any ID Code.';
    }
}

// Denied option
if (isset($_POST['submit_denied'])) {
    if (!empty($_POST['check_list'])) {
        foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
            $strSQL = oci_parse(
                $objConnect,
                "UPDATE COLL_VISIT_ASSIGN_APPROVAL
                SET    
                        APPROVAL_STATUS          = 0,
                        APPROVED_DATE            = SYSDATE,
                        APPROVED_BY_RML_ID       = '$emp_session_id'
                WHERE  ID ='$TT_ID_SELECTTED'"
            );

            oci_execute($strSQL);

            echo "<script>window.location = '$basePath/zh_module/view/visit_approval_list.php'</script>";
        }
    } else {
        echo 'Sorry! You have not select any ID Code.';
    }
}




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
                    <!-- <h5 class="card-title">Accordion Example</h5> -->
                    <!-- <hr> -->
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">

                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-sm-4">
                                                <label>Select Your Concern:</label>
                                                <select name="emp_concern" class="form-control single-select">
                                                    <option hidden><- Select Concern -></option>
                                                    <?php
                                                    $strSQL = oci_parse($objConnect, "SELECT 
                                                    CONCERN,RML_ID FROM MONTLY_COLLECTION
                                                    WHERE IS_ACTIVE=1
                                                    AND ZONAL_HEAD='$emp_session_id'");
                                                    oci_execute($strSQL);

                                                    while ($row = oci_fetch_assoc($strSQL)) {
                                                        $selected = (isset($_POST['emp_concern']) && $_POST['emp_concern'] == $row['RML_ID']) ? 'selected' : '';
                                                    ?>
                                                        <option value="<?php echo $row['RML_ID']; ?>" <?php echo $selected; ?>>
                                                            <?php echo $row['CONCERN']; ?>
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

            <div class="card rounded-4">
                <?php

                $headerType   = 'List';
                $leftSideName = 'Visit Report List';
                include('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-cust text-uppercase text-center ">
                                <tr>
                                    <th>SL.</th>
                                    <th>Concern Information </th>
                                    <th>Assign Information</th>
                                    <th>Hot Information</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $v_start_date = date('01/m/Y');
                                $v_end_date   = date('t/m/Y');
                                if (isset($_POST['start_date'])) {
                                    $v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                }
                                if (isset($_POST['end_date'])) {
                                    $v_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
                                }
                                //query statement 
                                $query  = "SELECT 
                                            ZONE,
                                            RML_ID,
                                            CONCERN,
                                            CODE_ASSIGN_ERP(RML_ID) TOTAL_CODE,
                                            (select count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
                                                    WHERE B.CREATED_BY=A.RML_ID
                                                    AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY'))
                                                TOTAL_VISIT_ASSIGN,
                                                (select count(UNIQUE(B.REF_ID)) from RML_COLL_VISIT_ASSIGN B
                                                    WHERE B.CREATED_BY=A.RML_ID
                                                    AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY'))
                                                TOTAL_UNIQUE_ASSIGN,
                                                (select count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
                                                    WHERE B.VISIT_STATUS=1
                                                    AND B.CREATED_BY=A.RML_ID
                                                    AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY'))
                                                TOTAL_VISITED,
                                                (select count(unique(B.REF_ID)) from RML_COLL_VISIT_ASSIGN B
                                                    WHERE B.VISIT_STATUS=1
                                                    AND B.CREATED_BY=A.RML_ID
                                                    AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY'))
                                                UNIQUE_VISITED	
                                        FROM MONTLY_COLLECTION A
                                        WHERE IS_ACTIVE=1
                                        AND ZONAL_HEAD='$emp_session_id'";
                                // 
                                if (isset($_POST['emp_concern'])) {
                                    $emp_concern = $_REQUEST['emp_concern'];
                                    $query .= " AND ('$emp_concern' IS NULL OR RML_ID='$emp_concern')";
                                }
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

                                        <td class="customer-info">
                                            <?php
                                            echo 'Name: ' . $row['CONCERN'];
                                            echo '<br>';
                                            echo 'ID: ' . $row['RML_ID'];
                                            echo '<br>';
                                            echo 'Zone: <b style="color:red;">' . $row['ZONE'] . '</b>';
                                            ?>
                                        </td>
                                        <td class="concern-info">
                                            <u>
                                                <a href="cc_visit_code.php?<?php echo '&login_id=' . $row['RML_ID'] . '&start_date=' . $v_start_date . '&end_date=' . $v_end_date . '&want=total_code'; ?>">
                                                    <?php
                                                    echo 'Total Code: ' . $row['TOTAL_CODE'];
                                                    echo '<br>'; ?>
                                                </a>
                                            </u>
                                            <u>
                                                <a href="cc_visit_code.php?<?php echo '&login_id=' . $row['RML_ID'] . '&start_date=' . $v_start_date . '&end_date=' . $v_end_date . '&want=total_assign'; ?>">
                                                    <?php echo 'Total Assign: ' . $row['TOTAL_VISIT_ASSIGN']; ?>
                                                </a>
                                            </u>
                                            <br>
                                            <?php
                                            echo 'Unique Assign: ' . $row['TOTAL_UNIQUE_ASSIGN'];
                                            ?>
                                        </td>
                                        <td>
                                            <u>
                                                <a target="_blank" href="cc_visit_code.php?<?php echo '&login_id=' . $row['RML_ID'] . '&start_date=' . $v_start_date . '&end_date=' . $v_end_date . '&want=Not_Touching_Code'; ?>">
                                                    <?php echo 'Not Touching: ' . ($row['TOTAL_CODE'] - $row['TOTAL_UNIQUE_ASSIGN']); ?>
                                                </a>
                                            </u>

                                            <?php

                                            echo '<br>';
                                            echo 'Total Visited: ' . $row['TOTAL_VISITED'];
                                            echo '<br>';
                                            echo 'Unique Visited: ' . $row['UNIQUE_VISITED'];
                                            ?>
                                        </td>

                                    </tr>


                                <?php } ?>

                            </tbody>


                            <tfoot>
                                <tr>
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                        <td colspan="3">
                                            <button class="btn btn-sm btn-gradient-info" type="submit" name="submit_approval"><i class='bx bx-save'></i> Save & Approve</button>
                                        </td>
                                        <td colspan="3">
                                            <button class="btn btn-sm btn-gradient-danger" type="submit" name="submit_denied" value="Save &amp; Denied"> <i class='bx bx-message-alt-x'></i>Save & Denied</button>


                                        </td>
                                    </form>
                                </tr>
                            </tfoot>

                        </table>
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
    //delete data processing

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