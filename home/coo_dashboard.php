<style>
    .nav-link {
        color: #4f4c4c;
        font-weight: 600;
    }

    .nav-primary.nav-tabs .nav-link.active {
        color: #2fb839 !important;
        border-color: #b82fa8 #b82fa8 #fff !important;
        background: floralwhite !important;
        font-weight: 600 !important;
    }
</style>

<?php

$v_start_date = date("01/m/Y");
$v_end_date = date("t/m/Y");

//Start total visit row
$totalvisitQuery = "SELECT
(
    SELECT NVL(COUNT(VA.ID), 0) AS TOTAL_VISIT_OF_MAHINDRA
    FROM VISIT_ASSIGN VA
    WHERE PRODUCT_BRAND_ID = 1
        AND VA.USER_ID IN (
            SELECT B.ID
            FROM USER_MANPOWER_SETUP A, USER_PROFILE B
            WHERE A.USER_ID = B.ID AND PARENT_USER_ID = '$log_user_id'
        )
        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_v_start_date', 'DD/MM/YYYY') AND TO_DATE('$v_v_end_date', 'DD/MM/YYYY')
) AS TOTAL_VISIT_OF_MAHINDRA,
(
    SELECT NVL(COUNT(VA.ID), 0) AS TOTAL_VISIT_OF_EICHER
    FROM VISIT_ASSIGN VA
    WHERE PRODUCT_BRAND_ID = 2
        AND VA.USER_ID IN (
            SELECT B.ID
            FROM USER_MANPOWER_SETUP A, USER_PROFILE B
            WHERE A.USER_ID = B.ID AND PARENT_USER_ID = '$log_user_id'
        )
        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_v_start_date', 'DD/MM/YYYY') AND TO_DATE('$v_v_end_date', 'DD/MM/YYYY')
) AS TOTAL_VISIT_OF_EICHER
FROM DUAL";

$strSQL2 = @oci_parse($objConnect, $totalvisitQuery);
@oci_execute($strSQL2);
$visitRow = @oci_fetch_assoc($strSQL2);

// End total visit row

// Start visit collection queries

//End visit collection queries 

?>
<div class="page-wrapper">
    <div class="page-content">


        <div class="card">
            <div class="card-body" style="paddings:0 1%">
                <ul class="nav nav-tabs nav-primary" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon">
                                    <i class='bx bxs-hand-down  me-1'></i>
                                </div>
                                <div class="tab-title">MAHINDRA </div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab" aria-selected="false" tabindex="-1">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon">
                                    <i class='bx bxs-hand-down  me-1'></i>
                                </div>
                                <div class="tab-title">EICHER</div>
                            </div>
                        </a>
                    </li>

                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade active show" id="primaryhome" role="tabpanel">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                            <div class="col">
                                <div class="card rounded-4 bg-gradient-worldcup">
                                    <div class="card-body" style="padding: 2% 10%;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0 text-white">Total Orders</p>
                                                <h4 class="my-1 text-white">0 </h4>
                                                <p class="mb-0 font-10 text-white">Current Month </p>
                                            </div>
                                            <div class="fs-1 text-white"><i class='bx bxs-cart'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card rounded-4 bg-gradient-rainbow">
                                    <div class="card-body" style="padding: 2% 10%;">

                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0 text-white">Total Visit</p>
                                                <h4 class="my-1 text-white">
                                                    <?php print_r($visitRow['TOTAL_VISIT_OF_MAHINDRA'] ? $visitRow['TOTAL_VISIT_OF_MAHINDRA'] : 0) ?>
                                                </h4>
                                                <p class="mb-0 font-13 text-white">Current Month </p>
                                            </div>
                                            <div class="fs-1 text-white"><i class='bx bxs-group'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card rounded-4 bg-gradient-smile">
                                    <div class="card-body" style="padding: 2% 10%;">

                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0 text-white">Total Collection</p>
                                                <h4 class="my-1 text-white">0</h4>
                                                <p class="mb-0 font-13 text-white">Current Month </p>

                                            </div>
                                            <div class="fs-1 text-white"><i class='bx bxs-wallet'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card rounded-4 bg-gradient-pinki">
                                    <div class="card-body" style="padding: 2% 10%;">

                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0 text-white">Product Stock </p>
                                                <h4 class="my-1 text-white">0 </h4>
                                                <p class="mb-0 font-13 text-white">Current Month </p>
                                            </div>
                                            <div class="fs-1 text-white"><i class='bx bxs-bar-chart-alt-2'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div>
                    <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                            <div class="col">
                                <div class="card rounded-4 bg-gradient-worldcup">
                                    <div class="card-body" style="padding: 2% 10%;">

                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0 text-white">Total Orders</p>
                                                <h4 class="my-1 text-white">0</h4>
                                                <p class="mb-0 font-13 text-white">Current Month </p>
                                            </div>
                                            <div class="fs-1 text-white"><i class='bx bxs-cart'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card rounded-4 bg-gradient-rainbow">
                                    <div class="card-body" style="padding: 2% 10%;">

                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0 text-white">Total Visit</p>
                                                <h4 class="my-1 text-white">
                                                    <?php print_r($visitRow['TOTAL_VISIT_OF_EICHER'] ? $visitRow['TOTAL_VISIT_OF_EICHER'] : 0) ?>
                                                </h4>
                                                <p class="mb-0 font-13 text-white">Current Month </p>
                                            </div>
                                            <div class="fs-1 text-white"><i class='bx bxs-group'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card rounded-4 bg-gradient-smile">
                                    <div class="card-body" style="padding: 2% 10%;">

                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0 text-white">Total Collection</p>
                                                <h4 class="my-1 text-white">0</h4>
                                                <p class="mb-0 font-13 text-white">Current Month </p>

                                            </div>
                                            <div class="fs-1 text-white"><i class='bx bxs-wallet'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card rounded-4 bg-gradient-pinki">
                                    <div class="card-body" style="padding: 2% 10%;">

                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0 text-white">Product Stock </p>
                                                <h4 class="my-1 text-white">0 </h4>
                                                <p class="mb-0 font-13 text-white">Current Month </p>
                                            </div>
                                            <div class="fs-1 text-white"><i class='bx bxs-bar-chart-alt-2'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div>

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body" style="paddings:0 1%">
                <ul class="nav nav-tabs nav-primary" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome2" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon">
                                    <i class='bx bxs-hand-down  me-1'></i>
                                </div>
                                <div class="tab-title">MAHINDRA </div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile2" role="tab" aria-selected="false" tabindex="-1">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon">
                                    <i class='bx bxs-hand-down  me-1'></i>
                                </div>
                                <div class="tab-title">EICHER</div>
                            </div>
                        </a>
                    </li>

                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade active show" id="primaryhome2" role="tabpanel">
                        <div class="row row-cols-1 row-cols-lg-5">
                            <div class="col">
                                <div class="card bg-gradient-esinto rounded-4">
                                    <div class="card-body" style="padding: 0% 10%;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="">
                                                <h4 class="mb-0 text-white"><?= $user_type_brand_wise_data[0]['MAHINDRA_USER'] ?></h4>
                                                <p class="mb-0 text-white">HOD</p>
                                            </div>
                                            <div class="fs-1 text-white">
                                                <i class='bx bx-slider'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-gradient-dunada rounded-4">
                                    <div class="card-body" style="padding: 0% 10%;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="">
                                                <h4 class="mb-0 text-white"><?= $user_type_brand_wise_data[1]['MAHINDRA_USER'] ?></h4>
                                                <p class="mb-0 text-white">COORDINATOR</p>
                                            </div>
                                            <div class="fs-1 text-white">
                                                <i class="bx bx-chat"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-gradient-linga rounded-4">
                                    <div class="card-body" style="padding: 0% 10%;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="">
                                                <h4 class="mb-0 text-white"><?= $user_type_brand_wise_data[2]['MAHINDRA_USER'] ?></h4>
                                                <p class="mb-0 text-white">SALE EXE.</p>
                                            </div>
                                            <div class="fs-1 text-white">
                                                <i class="bx bx-share-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-gradient-blkw rounded-4">
                                    <div class="card-body" style="padding: 0% 10%;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="">
                                                <h4 class="mb-0 text-white"><?= $user_type_brand_wise_data[3]['MAHINDRA_USER'] ?></h4>
                                                <p class="mb-0 text-white">PLAZA RETAILER</p>
                                            </div>
                                            <div class="fs-1 text-white">
                                                <i class="bx bx-bell"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-gradient-purple rounded-4">
                                    <div class="card-body" style="padding: 0% 10%;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="">
                                                <h4 class="mb-0 text-white"><?= $user_type_brand_wise_data[4]['MAHINDRA_USER'] ?></h4>
                                                <p class="mb-0 text-white">RETAILER</p>
                                            </div>
                                            <div class="fs-1 text-white">
                                                <i class='bx bxs-sort-alt'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="primaryprofile2" role="tabpanel">
                        <div class="row row-cols-1 row-cols-lg-5">
                            <div class="col">
                                <div class="card bg-gradient-esinto rounded-4">
                                    <div class="card-body" style="padding: 0% 10%;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="">
                                                <h4 class="mb-0 text-white"><?= $user_type_brand_wise_data[0]['EICHER_USER'] ?></h4>
                                                <p class="mb-0 text-white">HOD</p>
                                            </div>
                                            <div class="fs-1 text-white">
                                                <i class='bx bx-slider'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-gradient-dunada rounded-4">
                                    <div class="card-body" style="padding: 0% 10%;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="">
                                                <h4 class="mb-0 text-white"><?= $user_type_brand_wise_data[1]['EICHER_USER'] ?></h4>
                                                <p class="mb-0 text-white">COORDINATOR</p>
                                            </div>
                                            <div class="fs-1 text-white">
                                                <i class="bx bx-chat"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-gradient-linga rounded-4">
                                    <div class="card-body" style="padding: 0% 10%;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="">
                                                <h4 class="mb-0 text-white"><?= $user_type_brand_wise_data[2]['EICHER_USER'] ?></h4>
                                                <p class="mb-0 text-white">SALE EXE.</p>
                                            </div>
                                            <div class="fs-1 text-white">
                                                <i class="bx bx-share-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-gradient-blkw rounded-4">
                                    <div class="card-body" style="padding: 0% 10%;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="">
                                                <h4 class="mb-0 text-white"><?= $user_type_brand_wise_data[3]['EICHER_USER'] ?></h4>
                                                <p class="mb-0 text-white">PLAZA RETAILER</p>
                                            </div>
                                            <div class="fs-1 text-white">
                                                <i class="bx bx-bell"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-gradient-purple rounded-4">
                                    <div class="card-body" style="padding: 0% 10%;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="">
                                                <h4 class="mb-0 text-white"><?= $user_type_brand_wise_data[4]['EICHER_USER'] ?></h4>
                                                <p class="mb-0 text-white">RETAILER</p>
                                            </div>
                                            <div class="fs-1 text-white">
                                                <i class='bx bxs-sort-alt'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!--end row-->
        <div class="row">
            <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Sale Executive List </h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body" style="height:380px; overflow: auto;">
                        <div class="categories-list">
                            <?php
                            $cooquery = "SELECT B.USER_NAME,B.USER_MOBILE,B.IMAGE_LINK FROM USER_MANPOWER_SETUP A,USER_PROFILE B
                            WHERE A.USER_ID=B.ID
                            AND PARENT_USER_ID='$log_user_id' FETCH FIRST 8 ROWS ONLY";
                            $coordinatorSQL = oci_parse($objConnect, $cooquery);
                            @oci_execute($coordinatorSQL);
                            while ($coodinatorRow = oci_fetch_assoc($coordinatorSQL)) {
                            ?>
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div class="">
                                        <?php if ($coodinatorRow['IMAGE_LINK'] != null) {
                                            echo '<img src="' . $sfcmBasePath . '/' . $coodinatorRow["IMAGE_LINK"] . ' class="product-img-2" alt="no_image">';
                                        } else {
                                            echo '<img src="https://png.pngtree.com/png-clipart/20210915/ourmid/pngtree-user-avatar-login-interface-abstract-blue-icon-png-image_3917504.jpg"  alt="no_image" class="product-img-2">';
                                        } ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-2">
                                            <?php echo $coodinatorRow['USER_NAME'] ?>
                                            <br>
                                            <?php echo $coodinatorRow['USER_MOBILE'] ?>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0"> Plaza Retailer List</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body" style="height:380px; overflow: auto;">
                        <div class="categories-list">
                            <?php
                            $cooquery = "SELECT B.USER_NAME,B.USER_MOBILE,B.IMAGE_LINK
                                            FROM USER_MANPOWER_SETUP A,USER_PROFILE B
                                            WHERE A.USER_ID=B.ID
                                            AND PARENT_USER_ID IN
                                            (
                                            SELECT A.USER_ID
                                            FROM USER_MANPOWER_SETUP A,USER_PROFILE B
                                            WHERE A.USER_ID=B.ID
                                            AND PARENT_USER_ID = $log_user_id
                                            ) FETCH FIRST 8 ROWS ONLY";
                            $coordinatorSQL = oci_parse($objConnect, $cooquery);
                            @oci_execute($coordinatorSQL);
                            while ($coodinatorRow = oci_fetch_assoc($coordinatorSQL)) {
                            ?>
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div class="">
                                        <?php if ($coodinatorRow['IMAGE_LINK'] != null) {
                                            echo '<img src="' . $sfcmBasePath . '/' . $coodinatorRow["IMAGE_LINK"] . ' class="product-img-2" alt="no_image">';
                                        } else {
                                            echo '<img src="https://png.pngtree.com/png-clipart/20210915/ourmid/pngtree-user-avatar-login-interface-abstract-blue-icon-png-image_3917504.jpg"  alt="no_image" class="product-img-2">';
                                        } ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-2">
                                            <?php echo $coodinatorRow['USER_NAME'] ?>
                                            <br>
                                            <?php echo $coodinatorRow['USER_MOBILE'] ?>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0"> Retailer List</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body" style="height:380px; overflow: auto;">
                        <div class="categories-list">
                            <?php
                            $cooquery = "SELECT B.USER_NAME,B.USER_MOBILE,B.IMAGE_LINK
                            FROM USER_MANPOWER_SETUP A,USER_PROFILE B
                            WHERE A.USER_ID=B.ID
                            AND PARENT_USER_ID IN
                            (SELECT USER_ID
                            FROM USER_MANPOWER_SETUP A,USER_PROFILE B
                            WHERE A.USER_ID=B.ID
                            AND PARENT_USER_ID IN
                            (
                            SELECT A.USER_ID
                            FROM USER_MANPOWER_SETUP A,USER_PROFILE B
                            WHERE A.USER_ID=B.ID
                            AND PARENT_USER_ID= '$log_user_id'
                            )
                            ) FETCH FIRST 8 ROWS ONLY";
                            $coordinatorSQL = oci_parse($objConnect, $cooquery);
                            @oci_execute($coordinatorSQL);
                            while ($coodinatorRow = oci_fetch_assoc($coordinatorSQL)) {
                            ?>
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div class="">
                                        <?php if ($coodinatorRow['IMAGE_LINK'] != null) {
                                            echo '<img src="' . $sfcmBasePath . '/' . $coodinatorRow["IMAGE_LINK"] . ' class="product-img-2" alt="no_image">';
                                        } else {
                                            echo '<img src="https://png.pngtree.com/png-clipart/20210915/ourmid/pngtree-user-avatar-login-interface-abstract-blue-icon-png-image_3917504.jpg"  alt="no_image" class="product-img-2">';
                                        } ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-2">
                                            <?php echo $coodinatorRow['USER_NAME'] ?>
                                            <br>
                                            <?php echo $coodinatorRow['USER_MOBILE'] ?>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Monthly Orders [DEMO DATA]</h6>
                            </div>

                        </div>
                        <div id="chart2"></div>
                    </div>
                </div>
            </div> -->
        </div><!--end row-->


        <div class="row">

            <div class="col-12 col-lg-8 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-cente">
                            <div>
                                <h6 class="mb-0">Collection Overview [DEMO DATA]</h6>
                            </div>

                        </div>
                        <div id="chart1"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-body">
                        <ul class="nav nav-pills nav-fill mb-3">
                            <li class="nav-item">
                                <a class="nav-link rounded-5" data-bs-toggle="pill" href="#primary-pills-home">Monthly</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active rounded-5" data-bs-toggle="pill" href="#primary-pills-profile">Weekly</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link rounded-5" data-bs-toggle="pill" href="#primary-pills-contact">Daily</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade" id="primary-pills-home">
                                <div id="chart3"></div>
                                <hr>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <div>
                                        <h3 class="mb-0">$ 9845.43</h3>
                                        <p class="mb-0">+3% Since Last Week</p>
                                    </div>
                                    <div class="fs-1">
                                        <i class="lni lni-arrow-up"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="primary-pills-profile">
                                <div id="chart4"></div>
                                <hr>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <div>
                                        <h3 class="mb-0">$ 45,245.37</h3>
                                        <p class="mb-0">+4% Since Last Month</p>
                                    </div>
                                    <div class="fs-1">
                                        <i class="lni lni-arrow-up"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="primary-pills-contact">
                                <div id="chart5"></div>
                                <hr>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <div>
                                        <h3 class="mb-0">$ 7395.23</h3>
                                        <p class="mb-0">+4% Since Tomorrow</p>
                                    </div>
                                    <div class="fs-1">
                                        <i class="lni lni-arrow-up"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->

        <!-- <div class="row">
            <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Browser Statistics [DEMO DATA]</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart6"></div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">Chrome <span class="badge bg-danger rounded-pill">10</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Opera <span class="badge bg-primary rounded-pill">65</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Firefox <span class="badge bg-warning text-dark rounded-pill">14</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-lg-8 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Retailer Location [DEMO DATA]</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div id="geographic-map-2" style="height: 280px;"></div>
                    </div>
                    <table class="table table-borderless align-items-center">
                        <tbody>
                            <tr>
                                <td><i class="bx bxs-circle me-2" style="color: #5a52db;"></i> Russia</td>
                                <td>18 %</td>
                                <td><i class="bx bxs-circle me-2" style="color: #f09c15;"></i> Australia</td>
                                <td>14.2 %</td>
                            </tr>
                            <tr>
                                <td><i class="bx bxs-circle me-2" style="color: #b659ff;"></i> India</td>
                                <td>15 %</td>
                                <td><i class="bx bxs-circle me-2" style="color: #2ccc72;"></i> United States</td>
                                <td>11.6 %</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div> -->
        <!--end row-->

        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Recent Orders [DEMO DATA]</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Photo</th>
                                        <th>Product ID</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Shipping</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Iphone 5</td>
                                        <td><img src="assets/images/products/01.png" class="product-img-2" alt="product img"></td>
                                        <td>#9405822</td>
                                        <td><span class="btn btn-outline-success btn-sm px-4 rounded-5 w-100">Completed</span></td>
                                        <td>$1250.00</td>
                                        <td>03 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 100%"></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Earphone GL</td>
                                        <td><img src="assets/images/products/02.png" class="product-img-2" alt="product img"></td>
                                        <td>#8304620</td>
                                        <td><span class="btn btn-outline-warning btn-sm px-4 rounded-5 w-100">Pending</span></td>
                                        <td>$1500.00</td>
                                        <td>05 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-gradient-blooker" role="progressbar" style="width: 60%"></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>HD Hand Camera</td>
                                        <td><img src="assets/images/products/03.png" class="product-img-2" alt="product img"></td>
                                        <td>#4736890</td>
                                        <td><span class="btn btn-outline-danger btn-sm px-4 rounded-5 w-100">Failed</span></td>
                                        <td>$1400.00</td>
                                        <td>06 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-gradient-bloody" role="progressbar" style="width: 70%"></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Clasic Shoes</td>
                                        <td><img src="assets/images/products/04.png" class="product-img-2" alt="product img"></td>
                                        <td>#8543765</td>
                                        <td><span class="btn btn-outline-success btn-sm px-4 rounded-5 w-100">Paid</span></td>
                                        <td>$10.00</td>
                                        <td>14 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 100%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sitting Chair</td>
                                        <td><img src="assets/images/products/06.png" class="product-img-2" alt="product img"></td>
                                        <td>#9629240</td>
                                        <td><span class="btn btn-outline-warning btn-sm px-4 rounded-5 w-100">Pending</span></td>
                                        <td>$1500.00</td>
                                        <td>18 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-gradient-blooker" role="progressbar" style="width: 60%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hand Watch</td>
                                        <td><img src="assets/images/products/05.png" class="product-img-2" alt="product img"></td>
                                        <td>#8506790</td>
                                        <td><span class="btn btn-outline-danger btn-sm px-4 rounded-5 w-100">Failed</span></td>
                                        <td>$1800.00</td>
                                        <td>21 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-gradient-bloody" role="progressbar" style="width: 40%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->

    </div>
</div>