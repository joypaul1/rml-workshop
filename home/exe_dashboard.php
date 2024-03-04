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

    .progress {
        --bs-progress-bg: #ffffff;
    }
</style>

<?php
$v_start_date = date("01/m/Y");
$v_end_date = date("t/m/Y");


// VISIT PLAN QUERY START
$totalvisitQuery = "SELECT (SELECT COUNT (ID)
FROM VISIT_ASSIGN
WHERE USER_ID = '$log_user_id'
    AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date','DD/MM/YYYY')
    AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
    AND PRODUCT_BRAND_ID = 1)
AS TOTAL_VISIT_OF_MAHINDRA,
/*  TOTAL_COMPLETE_VISIT */
(SELECT COUNT (ID)
FROM VISIT_ASSIGN
WHERE USER_ID = '$log_user_id'
    AND VISIT_STATUS = 1
    AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date',  'DD/MM/YYYY')
    AND TO_DATE ('29/02/2024','DD/MM/YYYY')
    AND PRODUCT_BRAND_ID = 1)
AS TOTAL_COMPLETE_VISIT_OF_MAHINDRA,
/*  TOTAL_VISIT */
(SELECT COUNT (ID)
FROM VISIT_ASSIGN
WHERE USER_ID = '$log_user_id'
    AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date','DD/MM/YYYY')
    AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
    AND PRODUCT_BRAND_ID = 2)
AS TOTAL_VISIT_OF_EICHER,
/*  COMPLETE_VISIT */
(SELECT COUNT (ID)
FROM VISIT_ASSIGN
WHERE USER_ID = '$log_user_id'
    AND VISIT_STATUS = 1
    AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date', 'DD/MM/YYYY')
    AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
    AND PRODUCT_BRAND_ID = 2)
AS TOTAL_COMPLETE_VISIT_OF_EICHER,

/*  COLLECTION_AMOUNT_COLLECTED */
(SELECT SUM(COLLECTION_AMOUNT_COLLECTED)
        FROM VISIT_ASSIGN
        WHERE USER_ID = '$log_user_id'
        AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date', 'DD/MM/YYYY')
        AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
        AND PRODUCT_BRAND_ID = 1)
        AS TOTAL_COLLECTION_OF_MAHINDRA,
(SELECT SUM(COLLECTION_AMOUNT_COLLECTED)
        FROM VISIT_ASSIGN
        WHERE USER_ID = '$log_user_id'
        AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date', 'DD/MM/YYYY')
        AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
        AND PRODUCT_BRAND_ID = 2)
        AS TOTAL_COLLECTION_OF_EICHER,
          /*  SALES_AMOUNT_COLLECTED */
(SELECT SUM(SALES_AMOUNT_COLLECTED)
        FROM VISIT_ASSIGN
        WHERE USER_ID = '$log_user_id'
        AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date', 'DD/MM/YYYY')
        AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
        AND PRODUCT_BRAND_ID = 1)
        AS TOTAL_SALES_OF_MAHINDRA,
(SELECT SUM(SALES_AMOUNT_COLLECTED)
        FROM VISIT_ASSIGN
        WHERE USER_ID = '$log_user_id'
        AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date', 'DD/MM/YYYY')
        AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
        AND PRODUCT_BRAND_ID = 2)
        AS TOTAL_SALES_OF_EICHER
FROM DUAL";

// echo $totalvisitQuery;
$totalvisitSQL = @oci_parse($objConnect, $totalvisitQuery);
@oci_execute($totalvisitSQL);
$visit_plan_month_wise_data = array(); // Initialize the array
while ($totalvisitRow = @oci_fetch_assoc($totalvisitSQL)) {
    array_push($visit_plan_month_wise_data, $totalvisitRow);
}
// VISIT PLAN QUERY END

?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
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
                                                <p class="mb-0 text-white">Total Visit Plan</p>
                                                <h4 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_VISIT_OF_MAHINDRA']) ? $visit_plan_month_wise_data[0]['TOTAL_VISIT_OF_MAHINDRA'] : 0 ?>
                                                </h4>
                                                <p class="mb-0 font-10 text-white"> As of <?php echo date('F') ?> <?php echo date('Y') ?> </p>
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
                                                <p class="mb-0 text-white">Visit Complete</p>
                                                <h4 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_COMPLETE_VISIT_OF_MAHINDRA']) ? $visit_plan_month_wise_data[0]['TOTAL_COMPLETE_VISIT_OF_MAHINDRA'] : 0 ?>
                                                </h4>
                                                <p class="mb-0 font-10 text-white"> As of <?php echo date('F') ?> <?php echo date('Y') ?> </p>
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
                                                <h4 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_COLLECTION_OF_MAHINDRA']) ? $visit_plan_month_wise_data[0]['TOTAL_COLLECTION_OF_MAHINDRA'] : 0 ?>
                                                </h4>
                                                <p class="mb-0 font-10 text-white"> As of <?php echo date('F') ?> <?php echo date('Y') ?> </p>

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
                                                <p class="mb-0 text-white">Total Sale </p>
                                                <h4 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_SALES_OF_MAHINDRA']) ? $visit_plan_month_wise_data[0]['TOTAL_SALES_OF_MAHINDRA'] : 0 ?>
                                                </h4>
                                                <p class="mb-0 font-10 text-white"> As of <?php echo date('F') ?> <?php echo date('Y') ?> </p>
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
                                                <p class="mb-0 text-white">Total Visit Plan</p>
                                                <h4 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_VISIT_OF_EICHER']) ? $visit_plan_month_wise_data[0]['TOTAL_VISIT_OF_EICHER'] : 0 ?>
                                                </h4>
                                                <p class="mb-0 font-10 text-white"> As of <?php echo date('F') ?> <?php echo date('Y') ?> </p>
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
                                                <p class="mb-0 text-white">Visit Complete</p>
                                                <h4 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_COMPLETE_VISIT_OF_EICHER']) ?
                                                        $visit_plan_month_wise_data[0]['TOTAL_COMPLETE_VISIT_OF_EICHER'] : 0 ?>
                                                </h4>
                                                <p class="mb-0 font-10 text-white"> As of <?php echo date('F') ?> <?php echo date('Y') ?> </p>
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
                                                <h4 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_COLLECTION_OF_EICHER']) ? $visit_plan_month_wise_data[0]['TOTAL_COLLECTION_OF_EICHER'] : 0 ?>
                                                </h4>
                                                <p class="mb-0 font-10 text-white"> As of <?php echo date('F') ?> <?php echo date('Y') ?> </p>

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
                                                <p class="mb-0 text-white">Total Sale </p>
                                                <h4 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_SALES_OF_EICHER']) ? $visit_plan_month_wise_data[0]['TOTAL_SALES_OF_EICHER'] : 0 ?>
                                                </h4>
                                                <p class="mb-0 font-10 text-white"> As of <?php echo date('F') ?> <?php echo date('Y') ?> </p>
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
            <div class="card-body">
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
                                                <p class="mb-0 text-white">RETAILER</p>
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
                                                <p class="mb-0 text-white">MECHANICS</p>
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
                                                <p class="mb-0 text-white">RETAILER</p>
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
                                                <p class="mb-0 text-white">MECHANICS</p>
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
        <!--<div class="row">
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
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Monthly Orders [DEMO DATA]</h6>
                            </div>

                        </div>
                        <div id="chart2"></div>
                    </div>
                </div>
            </div>
        </div>end row-->


        <!-- <div class="row">
            <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Top Retailer [DEMO DATA]</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="categories-list">
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/01.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-cosmic" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/02.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-ibiza" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/03.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/04.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-kyoto" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/05.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-blues" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Top Sale Executive [DEMO DATA]</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="categories-list">
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/01.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-cosmic" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/02.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-ibiza" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/03.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/04.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-kyoto" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/05.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-blues" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
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
        </div>end row-->

        <!--<div class="row">
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

        </div>end row-->

        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 border-success">
                                    <strong class="text-success">
                                        <i class="bx bx-flag text-info"></i>
                                        TARGET VS ACHIVEMENT
                                        <span class="badge bg-primary"> <?= date('F - Y') ?> </span>
                                    </strong>
                                </h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0  table-hover">
                                <thead class="bg-gradient-info text-center text-white fw-bold">
                                    <tr>
                                        <th>SL.</th>
                                        <th>RETAILER NAME </th>
                                        <th>DATE </th>
                                        <th>SALES AMOUNT</th>
                                        <th>COLLECTION AMOUNT</th>
                                        <th>TARGET AMOUNT</th>
                                        <th>RATE (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sucessQuery = "SELECT  VA.ID, VA.VISIT_DATE,
                                        VA.USER_REMARKS, VA.VISIT_STATUS, VA.ENTRY_DATE,
                                        VA.ENTRY_BY_ID,VA.SALES_AMOUNT_COLLECTED,VA.COLLECTION_AMOUNT_COLLECTED,
                                        NVL(CA.TARGET_AMOUNT, 0) AS TARGET_AMOUNT,
                                        (SELECT VT.TITLE FROM VISIT_TYPE VT WHERE VT.ID = VA.VISIT_TYPE_ID) AS VISIT_TYPE,
                                        (SELECT UP.USER_NAME FROM USER_PROFILE UP WHERE UP.ID = VA.RETAILER_ID) AS RETAILER_NAME,
                                        (SELECT TITLE FROM PRODUCT_BRAND WHERE ID=VA.PRODUCT_BRAND_ID) AS RETAILER_BRAND
                                        FROM VISIT_ASSIGN VA , COLLECTION_ASSIGN CA
                                        WHERE VA.RETAILER_ID = CA.USER_ID AND VA.USER_ID = '$log_user_id'
                                        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')
                                        AND TRUNC (CA.START_DATE) >= TO_DATE ('$v_start_date', 'DD/MM/YYYY') AND TRUNC (CA.END_DATE) <= TO_DATE ('$v_end_date', 'DD/MM/YYYY')";
                                    // echo $sucessQuery;
                                    $strSQL = @oci_parse($objConnect, $sucessQuery);

                                    @oci_execute($strSQL);
                                    $number = 0;
                                    while ($sucessRow = @oci_fetch_assoc($strSQL)) {
                                        $number++;
                                    ?>
                                        <tr class="table-info">
                                            <td><?= $number ?></td>
                                            <td><?= $sucessRow['RETAILER_NAME'] ?></td>
                                            <td><?= $sucessRow['VISIT_DATE'] ?></td>
                                            <td><?= number_format($sucessRow['SALES_AMOUNT_COLLECTED'], 2) ?></td>
                                            <td><?= number_format($sucessRow['COLLECTION_AMOUNT_COLLECTED'], 2) ?></td>
                                            <td><?= number_format($sucessRow['TARGET_AMOUNT'], 2) ?></td>
                                            <?php
                                            $percentageRate = 0;
                                            if (
                                                isset($sucessRow['TARGET_AMOUNT'], $sucessRow['COLLECTION_AMOUNT_COLLECTED']) &&
                                                !empty($sucessRow['TARGET_AMOUNT']) && !empty($sucessRow['COLLECTION_AMOUNT_COLLECTED'])
                                            ) {
                                                $percentageRate = round(($sucessRow['COLLECTION_AMOUNT_COLLECTED'] / $sucessRow['TARGET_AMOUNT']) * 100);
                                            }

                                            ?>
                                            <td>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-gradient-ibiza" role="progressbar" style="<?= 'width:' . $percentageRate . '%'  ?>"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row-->
        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 border-success">
                                    <strong class="text-success">
                                        <i class="bx bx-flag text-info"></i>
                                        Visit Schedule List of
                                        <span class="badge bg-primary"> <?= date('F - Y') ?> </span>
                                    </strong>
                                </h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0  table-hover">
                                <thead class="bg-gradient-info text-center text-white fw-bold">
                                    <tr>
                                        <th>SL.</th>
                                        <th>RETAILER NAME </th>
                                        <th>DATE </th>
                                        <th>ENTRY REMARKS</th>
                                        <th>SALES AMOUNT	</th>
                                        <th>COLLECTION AMOUNT</th>
                                        <th>VISITED REMARKS</th>
                                        <!-- <th>RATE (%)</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sucessQuery = "SELECT  VA.ID, VA.VISIT_DATE,VA.AFTER_VISIT_REMARKS,
                                        VA.USER_REMARKS, VA.VISIT_STATUS, VA.ENTRY_DATE,
                                        VA.ENTRY_BY_ID,VA.SALES_AMOUNT_COLLECTED,VA.COLLECTION_AMOUNT_COLLECTED,
                                        NVL(CA.TARGET_AMOUNT, 0) AS TARGET_AMOUNT,
                                        (SELECT VT.TITLE FROM VISIT_TYPE VT WHERE VT.ID = VA.VISIT_TYPE_ID) AS VISIT_TYPE,
                                        (SELECT UP.USER_NAME FROM USER_PROFILE UP WHERE UP.ID = VA.RETAILER_ID) AS RETAILER_NAME,
                                        (SELECT TITLE FROM PRODUCT_BRAND WHERE ID=VA.PRODUCT_BRAND_ID) AS RETAILER_BRAND
                                        FROM VISIT_ASSIGN VA , COLLECTION_ASSIGN CA
                                        WHERE VA.RETAILER_ID = CA.USER_ID AND VA.USER_ID = '$log_user_id'
                                        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')
                                        AND TRUNC (CA.START_DATE) >= TO_DATE ('$v_start_date', 'DD/MM/YYYY') AND TRUNC (CA.END_DATE) <= TO_DATE ('$v_end_date', 'DD/MM/YYYY')";
                                    // echo $sucessQuery;
                                    $strSQL = @oci_parse($objConnect, $sucessQuery);

                                    @oci_execute($strSQL);
                                    $number = 0;
                                    while ($sucessRow = @oci_fetch_assoc($strSQL)) {
                                        $number++;
                                    ?>
                                        <tr class="table-info">
                                            <td><?= $number ?></td>
                                            <td><?= $sucessRow['RETAILER_NAME'] ?></td>
                                            <td><?= $sucessRow['VISIT_DATE'] ?></td>
                                            <td><?= $sucessRow['USER_REMARKS'] ?></td>

                                            <td><?= number_format($sucessRow['SALES_AMOUNT_COLLECTED'], 2) ?></td>
                                            <td><?= number_format($sucessRow['COLLECTION_AMOUNT_COLLECTED'], 2) ?></td>
                                            <td><?= $sucessRow['AFTER_VISIT_REMARKS'] ?></td>

                                            <!-- <td><?= number_format($sucessRow['TARGET_AMOUNT'], 2) ?></td> -->
                                            <?php
                                            // $percentageRate = 0;
                                            // if (
                                            //     isset($sucessRow['TARGET_AMOUNT'], $sucessRow['COLLECTION_AMOUNT_COLLECTED']) &&
                                            //     !empty($sucessRow['TARGET_AMOUNT']) && !empty($sucessRow['COLLECTION_AMOUNT_COLLECTED'])
                                            // ) {
                                            //     $percentageRate = round(($sucessRow['COLLECTION_AMOUNT_COLLECTED'] / $sucessRow['TARGET_AMOUNT']) * 100);
                                            // }

                                            ?>
                                            <!-- <td>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-gradient-ibiza" role="progressbar" style="<?= 'width:' . $percentageRate . '%'  ?>"></div>
                                                </div>
                                            </td> -->
                                        </tr>
                                    <?php } ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row-->

    </div>
</div>