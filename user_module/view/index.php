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
                                        <th>RESponsible User</th>
                                        <th>Location of User</th>

                                        <?php if (($_SESSION['USER_INFO']['USER_TYPE'] == 'HOD')
                                            || ($_SESSION['USER_INFO']['USER_TYPE'] == 'COORDINATOR')
                                            || ($_SESSION['USER_INFO']['USER_TYPE'] == 'SALE EXECUTIVE')
                                        ) {
                                            echo '<th>Tree User</th>';
                                        }

                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT UP.ID,
                                            UP.USER_NAME,
                                            UP.USER_MOBILE,
                                            UP.RML_ID,
                                            UP.LAT,
                                            UP.LANG,
                                            UP.CREATED_DATE,
                                            (SELECT USER_NAME
                                            FROM USER_PROFILE
                                            WHERE ID = UP.RESPONSIBLE_ID)
                                            AS USER_RESPONSIBLE_NAME, 
                                            (SELECT TITLE
                                            FROM USER_BRAND
                                            WHERE ID = UP.USER_BRAND_ID)
                                            AS USER_BRAND, 
                                            ( SELECT TITLE FROM USER_TYPE WHERE ID = UP.USER_TYPE_ID) AS USER_TYPE
                                            FROM USER_PROFILE UP WHERE UP.USER_STATUS ='1' ";
                                    if ($_SESSION['USER_INFO']['USER_TYPE'] != 'HOD') {
                                        $log_user_id   = $_SESSION['USER_INFO']['ID'];
                                        $query .= " AND RESPONSIBLE_ID = $log_user_id";
                                    }
                                    $query .= " ORDER BY UP.USER_TYPE_ID";

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
                                                <a href="<?php echo $basePath . '/user_module/view/edit.php?id=' . $row['ID'] . '&actionType=edit' ?>" class="btn btn-sm btn-gradient-warning text-white"><i class='bx bxs-edit-alt'></i></a>
                                                <button type="button" data-id="<?php echo $row['ID'] ?>" data-href="<?php echo ($basePath . '/user_module/action/self_panel.php') ?>" class="btn btn-sm btn-gradient-danger delete_check"><i class='bx bxs-trash'></i></button>
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
                                                <?php echo $row['USER_RESPONSIBLE_NAME']; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $latitu = $row['LAT'];
                                                $lng = $row['LANG'];
                                                $url = "http://www.google.com/maps/place/" . $latitu . "," . $lng;
                                                ?>
                                                <a class="btn btn-sm btn-gradient-info text-white" href="<?php echo $url; ?>" target="_blank"><i class='bx bx-map'></i></a>
                                            </td>


                                            <?php if (($_SESSION['USER_INFO']['USER_TYPE'] == 'HOD')
                                                || ($_SESSION['USER_INFO']['USER_TYPE'] == 'COORDINATOR')
                                                || ($_SESSION['USER_INFO']['USER_TYPE'] == 'SALE EXECUTIVE')
                                            ) {
                                            ?>
                                                <?php if (($row['USER_TYPE'] == 'HOD')) {?>
                                                    <td class="text-center">
                                                        <a target="_blank" href="<?php echo $basePath . '/user_module/view/userTree.php?id=' . $row['ID']  ?>" class="btn btn-sm btn-gradient-primary text-white"><i class='bx bx-street-view'></i></a>
                                                    </td>
                                                <?php }  ?>
                                                <?php if (($row['USER_TYPE'] == 'COORDINATOR')) {?>
                                                    <td class="text-center">
                                                        <a target="_blank"  href="<?php echo $basePath . '/user_module/view/coo_userTree.php?id=' . $row['ID']  ?>" class="btn btn-sm btn-gradient-primary text-white"><i class='bx bx-street-view'></i></a>
                                                    </td>
                                                <?php }  ?>
                                                <?php if (($row['USER_TYPE'] == 'SALE EXECUTIVE')) {?>
                                                    <td class="text-center">
                                                        <a target="_blank"  href="<?php echo $basePath . '/user_module/view/saleex_userTree.php?id=' . $row['ID']  ?>" class="btn btn-sm btn-gradient-primary text-white"><i class='bx bx-street-view'></i></a>
                                                    </td>
                                                <?php }  ?>
                                                <?php if (($row['USER_TYPE'] == 'RETAILER')) {?>
                                                    <td class="text-center">
                                                        <a target="_blank"  href="<?php echo $basePath . '/user_module/view/retailer_userTree.php?id=' . $row['ID']  ?>" class="btn btn-sm btn-gradient-primary text-white"><i class='bx bx-street-view'></i></a>
                                                    </td>
                                                <?php }  ?>

                                            <?php }  ?>

                                        </tr>


                                    <?php
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
    //delete data processing

    $(document).on('click', '.delete_check', function() {
        var id = $(this).data('id');
        let url = $(this).data('href');
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            deleteID: id
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

        })

    });
</script>