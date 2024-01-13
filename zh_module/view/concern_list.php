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
                    $leftSideName  = 'Last Assign Information List';
                    include('../../_includes/com_header.php');

                    ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="table-light text-uppercase text-center ">
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
                                    // AND ('$r_concern' IS NULL OR RML_ID='$r_concern')
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
                                            <td>
                                                <a href="apps_user_edit.php?emp_ref_id=<?php echo $row['ID'] ?>">
                                                   <button class="edit-user">update</button>
                                                </a>
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