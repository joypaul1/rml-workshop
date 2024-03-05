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
                    $headerType    = 'List'; // or Edit
                    $leftSideName  = 'User List';
                    $rightSideName = 'User Create';
                    $routePath     = 'leave_module/view/self_panel/create.php'; // path name for redirect
                    include('../../_includes/com_header.php');

                    ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="text-white text-uppercase text-center" style="background-color: #3b005c !important">
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