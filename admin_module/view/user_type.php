<?php
include_once('../../_helper/2step_com_conn.php');
$number = 0;
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">


        <div class="row">

            <div class="col-12">
                <div class="card rounded-4">
                    <?php
                    $headerType    = 'List';
                    $leftSideName  = 'User Type List';
                    include('../../_includes/com_header.php');

                    ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0">
                                <thead class="text-white text-uppercase text-center" style="background-color: #3b005c !important">
                                    <tr>
                                        <th>SL.</th>
                                        <th>TITLE</th>
                                        <th>STATUS</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM USER_TYPE ORDER BY ID";
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
                                                <?php echo $row['TITLE']; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($row['STATUS']) {
                                                    echo '<span class="badge bg-success">Active</span>';
                                                } else {
                                                    echo '<span class="badge bg-danger">Deactive</span>';
                                                } ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo $cspdBasePath . '/admin_module/view/ut_edit.php?id=' . $row['ID'] . '&actionType=edit' ?>" class="btn btn-sm btn-gradient-warning text-white"><i class='bx bxs-edit-alt'></i></a>

                                            </td>

                                        </tr>


                                    <?php
                                    }
                                    if ($number == 0) {
                                        echo '<tr><td colspan="9" class="text-center text-danger fw-bold"> !</td></tr>';
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