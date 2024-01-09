<?php
include_once('../../_helper/2step_com_conn.php');
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">


        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <?php
                    $headerType    = 'List';
                    $leftSideName  = 'User List';
                    $rightSideName = 'User Create';
                    $routePath     = 'user_module/view/create.php';
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
                                        <th>CREATED DATE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT UP.ID,
                                            UP.USER_NAME,
                                            UP.USER_MOBILE,
                                            UP.RML_ID,
                                            UP.CREATED_DATE,
                                            (SELECT TITLE
                                            FROM USER_BRAND
                                            WHERE ID = UP.USER_BRAND_ID)
                                            AS USER_BRAND, 
                                            ( SELECT TITLE FROM USER_TYPE WHERE ID = UP.USER_TYPE_ID) AS USER_TYPE
                                            FROM USER_PROFILE UP ORDER BY ID DESC";

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
                                                <a href="<?php echo $basePath . '/user_module/view/edit.php?id=' . $row['ID'] . '&actionType=edit' ?>"
                                                    class="btn btn-sm btn-gradient-warning text-white"><i class='bx bxs-edit-alt'></i></a>
                                                <button type="button" class="btn btn-sm btn-gradient-danger"><i class='bx bxs-trash'></i></button>
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
                                                <?php echo $row['CREATED_DATE']; ?>
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