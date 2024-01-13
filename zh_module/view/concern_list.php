<?php

include_once('../../_helper/2step_com_conn.php');
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

                                            <div class="col-sm-3">
                                                <label class="form-label" for="r_rml_id">
                                                    Search By Concern ID :
                                                </label>
                                                <input placeholder="" type="text" name="r_rml_id" class="form-control  cust-control" id="r_rml_id" autocomplete="off" <?php
                                                                                                                                                                        if (isset($_POST['r_rml_id'])) {
                                                                                                                                                                            echo 'value="' . htmlspecialchars($_POST['r_rml_id']) . '"';
                                                                                                                                                                        }                                                                                                                    ?>>
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
                $headerType    = 'List';
                $leftSideName  = 'Last Assign Information List';
                include('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-cust text-uppercase text-center ">
                                <tr>
                                    <th>SL.</th>
                                    <th>User Information</th>
                                    <th>Code Information</th>
                                    <th>Collection Information</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // print_r($_SESSION['USER_INFO']);
                                $query =    "SELECT ID,TARGET,TARGETSHOW,
                                                ZONE,RML_ID,CONCERN,OVER_DUE,
                                                CURRENT_MONTH_DUE,
                                                START_DATE,END_DATE,
                                                ENTRY_DATE,VISIT_UNIT,
                                                AREA_HEAD,DATA_ADMIN
                                                FROM MONTLY_COLLECTION
                                                WHERE IS_ACTIVE=1
                                                AND ZONAL_HEAD='$emp_session_id'";
                                // 
                                if (isset($_POST['r_rml_id'])) {
                                    $r_concern = $_REQUEST['r_rml_id'];
                                    $query .= " AND ('$r_concern' IS NULL OR RML_ID='$r_concern')";
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
                                        <td class="text-start">
                                            <?php
                                            echo 'Name: ' . $row['CONCERN'];
                                            echo '<br>';
                                            echo 'Login ID: ' . $row['RML_ID'];
                                            echo '<br>';
                                            echo 'User Zone: ' . $row['ZONE'];
                                            echo '<br>';
                                            echo 'Area Head: ' . $row['AREA_HEAD'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo 'Target: ' . $row['TARGET'];
                                            echo '<br>';
                                            echo 'Display Target: ' . $row['TARGETSHOW'];
                                            echo '<br>';
                                            echo 'Overdue: ' . $row['OVER_DUE'];
                                            echo '<br>';
                                            echo 'Current Month Due: ' . $row['CURRENT_MONTH_DUE'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo 'Start Date: ' . $row['START_DATE'];
                                            echo '<br>';
                                            echo 'End Date: ' . $row['END_DATE'];
                                            echo '<br>';
                                            echo 'Visit Unit: ' . $row['VISIT_UNIT'];

                                            echo '<br>';
                                            echo 'Data Admin: ' . $row['DATA_ADMIN'];
                                            ?>
                                        </td>
                                        <td class='text-center'>
                                            <!-- <a href="apps_user_edit.php?emp_ref_id=<?php echo $row['ID'] ?>"> -->
                                            <button disabled class="btn btn-sm btn-gradient-info text-white">Update</button>
                                            <!-- </a> -->
                                        </td>


                                    </tr>


                                <?php } ?>

                            </tbody>
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