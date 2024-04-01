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
$dynamic_link_js[]  = '../assets/js/executive.js';
$v_start_date   = date("01/m/Y");
$v_end_date     = date("t/m/Y");


// VISIT PLAN QUERY START
$totalvisitQuery = "SELECT (SELECT COUNT (ID)
FROM VISIT_ASSIGN
WHERE USER_ID = '$USER_LOGIN_ID'
    AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date','DD/MM/YYYY')
    AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
    AND PRODUCT_BRAND_ID = 1)
AS TOTAL_VISIT_OF_MAHINDRA,
/*  TOTAL_COMPLETE_VISIT */
(SELECT COUNT (ID)
FROM VISIT_ASSIGN
WHERE USER_ID = '$USER_LOGIN_ID'
    AND VISIT_STATUS = 1
    AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date',  'DD/MM/YYYY')
    AND TO_DATE ('$v_end_date','DD/MM/YYYY')
    AND PRODUCT_BRAND_ID = 1)
AS TOTAL_COMPLETE_VISIT_OF_MAHINDRA,
/*  TOTAL_VISIT */
(SELECT COUNT (ID)
FROM VISIT_ASSIGN
WHERE USER_ID = '$USER_LOGIN_ID'
    AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date','DD/MM/YYYY')
    AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
    AND PRODUCT_BRAND_ID = 2)
AS TOTAL_VISIT_OF_EICHER,
/*  COMPLETE_VISIT */
(SELECT COUNT (ID)
FROM VISIT_ASSIGN
WHERE USER_ID = '$USER_LOGIN_ID'
    AND VISIT_STATUS = 1
    AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date', 'DD/MM/YYYY')
    AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
    AND PRODUCT_BRAND_ID = 2)
AS TOTAL_COMPLETE_VISIT_OF_EICHER,

/*  COLLECTION_AMOUNT_COLLECTED */
(SELECT SUM(COLLECTION_AMOUNT_COLLECTED)
        FROM VISIT_ASSIGN
        WHERE USER_ID = '$USER_LOGIN_ID'
        AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date', 'DD/MM/YYYY')
        AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
        AND PRODUCT_BRAND_ID = 1)
        AS TOTAL_COLLECTION_OF_MAHINDRA,
        /* TOTAL_COLLECTION_TARGET_OF_MAHINDRA */
(SELECT SUM(COLLECTON_TARGET_AMOUNT)
    FROM COLLECTION_ASSIGN CA WHERE  TRUNC (CA.START_DATE) >= TO_DATE ('$v_start_date', 'DD/MM/YYYY')
    AND TRUNC (CA.END_DATE) <= TO_DATE ('$v_end_date', 'DD/MM/YYYY') AND CA.BRAND_ID = 1
    AND  CA.USER_ID IN    (SELECT USER_ID
          FROM USER_MANPOWER_SETUP
         WHERE PARENT_USER_ID = '$USER_LOGIN_ID'
        UNION ALL
        SELECT USER_ID
          FROM USER_MANPOWER_SETUP
         WHERE PARENT_USER_ID IN (SELECT USER_ID
                                    FROM USER_MANPOWER_SETUP
                                   WHERE PARENT_USER_ID = '$USER_LOGIN_ID')))
    AS TOTAL_COLLECTION_TARGET_OF_MAHINDRA,
        /* TOTAL_COLLECTION_TARGET_OF_MAHINDRA */
        /* TOTAL_COLLECTION_OF_EICHER */
(SELECT SUM(COLLECTION_AMOUNT_COLLECTED)
        FROM VISIT_ASSIGN
        WHERE USER_ID = '$USER_LOGIN_ID'
        AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date', 'DD/MM/YYYY')
        AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
        AND PRODUCT_BRAND_ID = 2)
        AS TOTAL_COLLECTION_OF_EICHER,
        /* TOTAL_COLLECTION_OF_EICHER */
        /* TOTAL_COLLECTION_TARGET_OF_EICHER */
(SELECT SUM(COLLECTON_TARGET_AMOUNT)
        FROM COLLECTION_ASSIGN CA WHERE  TRUNC (CA.START_DATE) >= TO_DATE ('$v_start_date', 'DD/MM/YYYY')
        AND TRUNC (CA.END_DATE) <= TO_DATE ('$v_end_date', 'DD/MM/YYYY') AND CA.BRAND_ID = 2
        AND  CA.USER_ID IN    (SELECT USER_ID
        FROM USER_MANPOWER_SETUP
        WHERE PARENT_USER_ID = '$USER_LOGIN_ID'
        UNION ALL
        SELECT USER_ID
        FROM USER_MANPOWER_SETUP
        WHERE PARENT_USER_ID IN (SELECT USER_ID
        FROM USER_MANPOWER_SETUP
        WHERE PARENT_USER_ID = '$USER_LOGIN_ID')))
        AS TOTAL_COLLECTION_TARGET_OF_EICHER,
        /* TOTAL_COLLECTION_TARGET_OF_EICHER */
        /* TOTAL_SALES_OF_MAHINDRA */
(SELECT SUM(SALES_AMOUNT_COLLECTED)
        FROM VISIT_ASSIGN
        WHERE USER_ID = '$USER_LOGIN_ID'
        AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date', 'DD/MM/YYYY')
        AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
        AND PRODUCT_BRAND_ID = 1)
        AS TOTAL_SALES_OF_MAHINDRA,
        /* TOTAL_SALES_OF_MAHINDRA */
        /* TOTAL_SALES_TARGET_OF_MAHINDRA */
(SELECT SUM(SALES_TARGET_AMOUNT)
    FROM COLLECTION_ASSIGN CA WHERE  TRUNC (CA.START_DATE) >= TO_DATE ('$v_start_date', 'DD/MM/YYYY')
    AND TRUNC (CA.END_DATE) <= TO_DATE ('$v_end_date', 'DD/MM/YYYY') AND CA.BRAND_ID = 1
    AND  CA.USER_ID IN    (SELECT USER_ID
          FROM USER_MANPOWER_SETUP
         WHERE PARENT_USER_ID = '$USER_LOGIN_ID'
        UNION ALL
        SELECT USER_ID
          FROM USER_MANPOWER_SETUP
         WHERE PARENT_USER_ID IN (SELECT USER_ID
                                    FROM USER_MANPOWER_SETUP
                                   WHERE PARENT_USER_ID = '$USER_LOGIN_ID')))
    AS TOTAL_SALES_TARGET_OF_MAHINDRA,
        /* TOTAL_SALES_TARGET_OF_MAHINDRA */
        /* TOTAL_SALES_OF_EICHER */
(SELECT SUM(SALES_AMOUNT_COLLECTED)
        FROM VISIT_ASSIGN
        WHERE USER_ID = '$USER_LOGIN_ID'
        AND TRUNC (VISIT_DATE) BETWEEN TO_DATE ('$v_start_date', 'DD/MM/YYYY')
        AND TO_DATE ('$v_end_date', 'DD/MM/YYYY')
        AND PRODUCT_BRAND_ID = 2)
        AS TOTAL_SALES_OF_EICHER,
        /* TOTAL_SALES_OF_EICHER */
        /* TOTAL_SALES_TARGET_OF_EICHER */
(SELECT SUM(SALES_TARGET_AMOUNT)
        FROM COLLECTION_ASSIGN CA WHERE  TRUNC (CA.START_DATE) >= TO_DATE ('$v_start_date', 'DD/MM/YYYY')
        AND TRUNC (CA.END_DATE) <= TO_DATE ('$v_end_date', 'DD/MM/YYYY') AND CA.BRAND_ID = 2
        AND  CA.USER_ID IN    (SELECT USER_ID
          FROM USER_MANPOWER_SETUP
         WHERE PARENT_USER_ID = '$USER_LOGIN_ID'
        UNION ALL
        SELECT USER_ID
        FROM USER_MANPOWER_SETUP
         WHERE PARENT_USER_ID IN (SELECT USER_ID FROM USER_MANPOWER_SETUP
            WHERE PARENT_USER_ID = '$USER_LOGIN_ID')))
        AS TOTAL_SALES_TARGET_OF_EICHER
        /* TOTAL_SALES_TARGET_OF_EICHER */
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
                    <?php if (in_array(1, explode(',', $USER_BRANDS))) { ?>
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
                    <?PHP } ?>
                    <?php if (in_array(2, explode(',', $USER_BRANDS))) { ?>
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
                    <?PHP } ?>

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
                                                <p class="mb-0 font-10 text-white text"> As of <?php echo date('F') ?> <?php echo date('Y') ?> </p>
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
                                                <p class="mb-0 text-white">Collection</p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_COLLECTION_OF_MAHINDRA']) ? number_format($visit_plan_month_wise_data[0]['TOTAL_COLLECTION_OF_MAHINDRA']) : 0 ?>
                                                </h6>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-white">Target</p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_COLLECTION_TARGET_OF_MAHINDRA']) ? number_format($visit_plan_month_wise_data[0]['TOTAL_COLLECTION_TARGET_OF_MAHINDRA']) : 0 ?>
                                                </h6>
                                            </div>
                                        </div>
                                        <p class="mb-0 font-10 text-white text-center d-flex justify-content-between">
                                            <i class='bx bx-collection' style="font-size:18px"></i>
                                            <span>As of <?php echo date('F') ?> <?php echo date('Y') ?></span>
                                            <i class='bx bx-bar-chart-alt' style="font-size:18px"></i>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card rounded-4 bg-gradient-pinki">
                                    <div class="card-body" style="padding: 2% 10%;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0 text-white"> Sale </p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_SALES_OF_MAHINDRA']) ? $visit_plan_month_wise_data[0]['TOTAL_SALES_OF_MAHINDRA'] : 0 ?>
                                                </h6>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-white">Target </p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_SALES_TARGET_OF_MAHINDRA']) ? number_format($visit_plan_month_wise_data[0]['TOTAL_SALES_TARGET_OF_MAHINDRA']) : 0 ?>
                                                </h6>
                                            </div>
                                        </div>
                                        <p class="mb-0 font-10 text-white text-center d-flex justify-content-between">
                                            <i class='bx bxs-cart-add' style="font-size:18px"></i>
                                            <span>As of <?php echo date('F') ?> <?php echo date('Y') ?></span>
                                            <i class='bx bx-bar-chart-alt' style="font-size:18px"></i>
                                        </p>
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
                                                <p class="mb-0 text-white">Collection</p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_COLLECTION_OF_EICHER']) ? number_format($visit_plan_month_wise_data[0]['TOTAL_COLLECTION_OF_EICHER']) : 0 ?>
                                                </h6>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-white">Target</p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_COLLECTON_TARGET_OF_EICHER']) ? number_format($visit_plan_month_wise_data[0]['TOTAL_COLLECTON_TARGET_OF_EICHER']) : 0 ?>
                                                </h6>
                                            </div>
                                        </div>
                                        <p class="mb-0 font-10 text-white text-center d-flex justify-content-between">
                                            <i class='bx bx-collection' style="font-size:18px"></i>
                                            <span>As of <?php echo date('F') ?> <?php echo date('Y') ?></span>
                                            <i class='bx bx-bar-chart-alt' style="font-size:18px"></i>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card rounded-4 bg-gradient-pinki">
                                    <div class="card-body" style="padding: 2% 10%;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0 text-white"> Sale </p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_SALES_OF_EICHER']) ? $visit_plan_month_wise_data[0]['TOTAL_SALES_OF_EICHER'] : 0 ?>
                                                </h6>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-white"> Target </p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data[0]['TOTAL_SALES_TARGET_OF_EICHER']) ? $visit_plan_month_wise_data[0]['TOTAL_SALES_TARGET_OF_EICHER'] : 0 ?>
                                                </h6>
                                            </div>
                                        </div>
                                        <p class="mb-0 font-10 text-white text-center d-flex justify-content-between">
                                            <i class='bx bxs-cart-add' style="font-size:18px"></i>
                                            <span>As of <?php echo date('F') ?> <?php echo date('Y') ?></span>
                                            <i class='bx bx-bar-chart-alt' style="font-size:18px"></i>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div>

                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-body">
                        <ul class="nav nav-pills nav-fill mb-3">
                            <li class="nav-item">
                                <a class="nav-link active rounded-5" data-bs-toggle="pill" href="#primary-pills-profile"> COLLECTION ACHIVEMENT </a>
                            </li>

                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane fade show active" id="primary-pills-profile">
                                <div id="chart4"></div>
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
                                <a class="nav-link active rounded-5" data-bs-toggle="pill" href="#primary-pills-contact">SALES ACHIVEMENT</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="primary-pills-contact">
                                <div id="chart5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="card">
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
        </div> -->

        <!--end row-->

        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <div class="card-header" style="background: #3b005c;">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="mb-0 border-success">
                                <strong class="text-white">
                                    <i class="bx bx-flag "></i>
                                    TARGET VS ACHIVEMENT
                                    <span class="badge bg-primary"> <?= date('F - Y') ?> </span>
                                </strong>
                            </h6>
                            <!-- <span>
                                <input type="text" id="id" name="name" placeholder="placeholder" class="bg-danger" />
                            </span> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsiveS">
                            <table class="table table-sm table-bordered align-middle mb-0 table-hover">
                                <thead class="bg-gradient-info text-center text-white fw-bold">
                                    <tr>
                                        <th>SL.</th>
                                        <th>RETAILER NAME & TYPE</th>
                                        <th>SA. AMT. </th>
                                        <th>SA. TAR.</th>
                                        <th>RATE (%)</th>
                                        <th>COL. AMT.</th>
                                        <th>COL. TAR.</th>
                                        <th>RATE (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $TGVSAC_QUERY = "SELECT
                                                        A.ID,
                                                        A.USER_NAME,
                                                        (
                                                            SELECT TITLE
                                                            FROM USER_TYPE
                                                            WHERE ID = A.USER_TYPE_ID
                                                        ) AS USER_TYPE,
                                                        TOTAL_VISTITED_COLLECTION(
                                                            A.ID,
                                                            TO_DATE('$v_start_date', 'DD/MM/YYYY'),
                                                            TO_DATE('$v_end_date', 'DD/MM/YYYY'),
                                                            'SALES'
                                                        ) AS SALES_AMOUNT,
                                                        TOTAL_VISTITED_COLLECTION(
                                                            A.ID,
                                                            TO_DATE('$v_start_date', 'DD/MM/YYYY'),
                                                            TO_DATE('$v_end_date', 'DD/MM/YYYY'),
                                                            'COLLECTION'
                                                        ) AS COLLECTION_AMOUNT,
                                                        TOTAL_TARGET_ASSIGN(
                                                            A.ID,
                                                            TO_DATE('$v_start_date', 'DD/MM/YYYY'),
                                                            TO_DATE('$v_end_date', 'DD/MM/YYYY'),
                                                            'SALES'
                                                        ) AS SALES_TARGET,
                                                        TOTAL_TARGET_ASSIGN(
                                                            A.ID,
                                                            TO_DATE('$v_start_date', 'DD/MM/YYYY'),
                                                            TO_DATE('$v_end_date', 'DD/MM/YYYY'),
                                                            'COLLECTION'
                                                        ) AS COLLECTION_TARGET
                                                    FROM
                                                        USER_PROFILE A,
                                                        (
                                                            SELECT USER_ID
                                                            FROM USER_MANPOWER_SETUP
                                                            WHERE PARENT_USER_ID = '$USER_LOGIN_ID'
                                                            UNION ALL
                                                            SELECT USER_ID
                                                            FROM USER_MANPOWER_SETUP
                                                            WHERE PARENT_USER_ID IN (
                                                                SELECT USER_ID
                                                                FROM USER_MANPOWER_SETUP
                                                                WHERE PARENT_USER_ID = '$USER_LOGIN_ID'
                                                            )
                                                        ) B
                                                    WHERE
                                                        A.ID = B.USER_ID";
                                    $strSQL = @oci_parse($objConnect, $TGVSAC_QUERY);

                                    @oci_execute($strSQL);
                                    $number = 0;
                                    while ($sucessRow = @oci_fetch_assoc($strSQL)) {
                                        $number++;
                                    ?>
                                        <tr class="table-info">
                                            <td><?= $number ?></td>
                                            <td> <?= $sucessRow['USER_NAME'] ?>
                                                <br>
                                                <span class="badge bg-success"><i class='bx bx-log-in-circle'></i> <?= $sucessRow['USER_TYPE'] ?></span>
                                            </td>
                                            <td class="text-end"><?= number_format($sucessRow['SALES_AMOUNT']) ?></td>
                                            <td class="text-end"><?= number_format($sucessRow['SALES_TARGET']) ?></td>
                                            <?php
                                            $percentageRate = 0;
                                            if (
                                                isset($sucessRow['SALES_AMOUNT'], $sucessRow['SALES_AMOUNT']) &&
                                                !empty($sucessRow['SALES_AMOUNT']) && !empty($sucessRow['SALES_AMOUNT'])
                                            ) {
                                                $salesAmount = $sucessRow['SALES_AMOUNT'] ? $sucessRow['SALES_AMOUNT'] : 0;
                                                $salesTarget =  $sucessRow['SALES_TARGET'] ? $sucessRow['SALES_TARGET'] : 0;
                                                if ($salesTarget != 0) {
                                                    $percentageRate = round(($salesAmount / $salesTarget) * 100);
                                                } else {
                                                    $percentageRate = 0;
                                                }
                                            }

                                            ?>
                                            <td class="text-center">
                                                <?= $percentageRate ?>%
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-gradient-ibiza" role="progressbar" style="<?= 'width:' . $percentageRate . '%'  ?>"></div>
                                                </div>
                                            </td>
                                            <td class="text-end"><?= number_format($sucessRow['COLLECTION_AMOUNT']) ?></td>
                                            <td class="text-end"><?= number_format($sucessRow['COLLECTION_TARGET']) ?></td>
                                            <?php
                                            $percentageRate2 = 0;
                                            if (
                                                isset($sucessRow['COLLECTION_AMOUNT'], $sucessRow['COLLECTION_TARGET']) &&
                                                !empty($sucessRow['COLLECTION_AMOUNT']) && !empty($sucessRow['COLLECTION_TARGET'])
                                            ) {
                                                $collectionAmount = $sucessRow['COLLECTION_AMOUNT'] ? $sucessRow['COLLECTION_AMOUNT'] : 0;
                                                $collectionTarget =  $sucessRow['COLLECTION_TARGET'] ? $sucessRow['COLLECTION_TARGET'] : 0;
                                                if ($collectionAmount != 0) {
                                                    $percentageRate2 = round(($collectionAmount / $collectionTarget) * 100);
                                                } else {
                                                    $percentageRate2 = 0;
                                                }
                                            }

                                            ?>
                                            <td class="text-center">
                                                <?= $percentageRate2 ?>%
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-gradient-ibiza" role="progressbar" style="<?= 'width:' . $percentageRate2 . '%'  ?>"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="3">
                                            <?php
                                            $TOTAL_SALES_OF_MAHINDRA = isset($visit_plan_month_wise_data[0]['TOTAL_SALES_OF_MAHINDRA']) ? $visit_plan_month_wise_data[0]['TOTAL_SALES_OF_MAHINDRA'] : 0;
                                            $TOTAL_SALES_OF_EICHER = isset($visit_plan_month_wise_data[0]['TOTAL_SALES_OF_EICHER']) ? $visit_plan_month_wise_data[0]['TOTAL_SALES_OF_EICHER'] : 0;
                                            echo '<span style="text-decoration-line: underline;
                                            text-decoration-style: double;">' . number_format(($TOTAL_SALES_OF_MAHINDRA + $TOTAL_SALES_OF_EICHER)) . '</span>';
                                            ?>
                                        </td>
                                        <td class="text-end">
                                            <?php
                                            $TOTAL_SALES_TARGET_OF_MAHINDRA = isset($visit_plan_month_wise_data[0]['TOTAL_SALES_TARGET_OF_MAHINDRA']) ? $visit_plan_month_wise_data[0]['TOTAL_SALES_TARGET_OF_MAHINDRA'] : 0;
                                            $TOTAL_SALES_TARGET_OF_EICHER = isset($visit_plan_month_wise_data[0]['TOTAL_SALES_TARGET_OF_EICHER']) ? $visit_plan_month_wise_data[0]['TOTAL_SALES_TARGET_OF_EICHER'] : 0;
                                            echo '<span style="text-decoration-line: underline;
                                            text-decoration-style: double;">' . number_format(($TOTAL_SALES_TARGET_OF_MAHINDRA + $TOTAL_SALES_TARGET_OF_EICHER)) . '</span>';
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $totalSales = $TOTAL_SALES_OF_MAHINDRA + $TOTAL_SALES_OF_EICHER;
                                            $totalSaleTarget = $TOTAL_SALES_TARGET_OF_MAHINDRA + $TOTAL_SALES_TARGET_OF_EICHER;

                                            if ($totalSaleTarget != 0) {
                                                $percentage = round(($totalSales / $totalSaleTarget) * 100);
                                                echo '<span style="text-decoration-line: underline; text-decoration-style: double;">' . $percentage . '%</span>';
                                            } else {
                                                echo '<span style="text-decoration-line: underline; text-decoration-style: double;">0%</span>';
                                            }

                                            ?>
                                        </td>

                                        <td class="text-end">
                                            <?php
                                            $TOTAL_COLLECTION_OF_MAHINDRA = isset($visit_plan_month_wise_data[0]['TOTAL_COLLECTION_OF_MAHINDRA']) ? $visit_plan_month_wise_data[0]['TOTAL_COLLECTION_OF_MAHINDRA'] : 0;
                                            $TOTAL_COLLECTION_OF_EICHER = isset($visit_plan_month_wise_data[0]['TOTAL_COLLECTION_OF_EICHER']) ? $visit_plan_month_wise_data[0]['TOTAL_COLLECTION_OF_EICHER'] : 0;
                                            if ($TOTAL_COLLECTION_OF_MAHINDRA > 0 || $TOTAL_COLLECTION_OF_EICHER > 0) {
                                                echo '<span style="text-decoration-line: underline;
                                                text-decoration-style: double;">' . number_format(($TOTAL_COLLECTION_OF_MAHINDRA + $TOTAL_COLLECTION_OF_EICHER)) . '</span>';
                                            } else {
                                                echo '<span style="text-decoration-line: underline;
                                                text-decoration-style: double;"> 0 </span>';
                                            }
                                            ?>
                                        </td>
                                        <td class="text-end">
                                            <?php
                                            $TOTAL_COLLECTION_TARGET_OF_MAHINDRA = isset($visit_plan_month_wise_data[0]['TOTAL_COLLECTION_TARGET_OF_MAHINDRA']) ? $visit_plan_month_wise_data[0]['TOTAL_COLLECTION_TARGET_OF_MAHINDRA'] : 0;
                                            $TOTAL_COLLECTION_TARGET_OF_EICHER = isset($visit_plan_month_wise_data[0]['TOTAL_COLLECTION_TARGET_OF_EICHER']) ? $visit_plan_month_wise_data[0]['TOTAL_COLLECTION_TARGET_OF_EICHER'] : 0;
                                            if ($TOTAL_COLLECTION_TARGET_OF_MAHINDRA > 0 || $TOTAL_COLLECTION_TARGET_OF_EICHER > 0) {
                                                echo '<span style="text-decoration-line: underline;
                                            text-decoration-style: double;">' . number_format(($TOTAL_COLLECTION_TARGET_OF_MAHINDRA + $TOTAL_COLLECTION_TARGET_OF_EICHER)) . '</span>';
                                            } else {
                                                echo '<span style="text-decoration-line: underline;
                                                text-decoration-style: double;"> 0 </span>';
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $totalCollection = $TOTAL_COLLECTION_OF_MAHINDRA + $TOTAL_COLLECTION_OF_EICHER;
                                            $totalCollectionTarget = $TOTAL_COLLECTION_TARGET_OF_MAHINDRA + $TOTAL_COLLECTION_TARGET_OF_EICHER;

                                            if ($totalCollectionTarget != 0) {
                                                $percentage = round(($totalCollection / $totalCollectionTarget) * 100);
                                                echo '<span style="text-decoration-line: underline; text-decoration-style: double;">' . $percentage . '%</span>';
                                            } else {
                                                echo '<span style="text-decoration-line: underline; text-decoration-style: double;">0%</span>';
                                            }

                                            ?>
                                        </td>
                                    </tr>
                                </tfoot>
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
                    <div class="card-header" style="background: #3b005c;">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 border-success">
                                <strong class="text-white">
                                    <i class="bx bx-flag "></i>
                                    Visit Schedule List of
                                    <span class="badge bg-primary"> <?= date('F - Y') ?> </span>
                                </strong>
                            </h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0  table-hover">
                                <thead class="bg-gradient-info text-center text-white fw-bold">
                                    <tr>
                                        <th>SL.</th>
                                        <th>RETAILER NAME & COST CENTER </th>
                                        <th>DATE </th>
                                        <th>ENTRY REMARKS</th>
                                        <th>S. AMT. </th>
                                        <th>COL. AMT.</th>
                                        <th>VISITED REMARKS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sucessQuery = "SELECT  VA.ID, VA.VISIT_DATE,VA.AFTER_VISIT_REMARKS,
                                        VA.USER_REMARKS, VA.VISIT_STATUS, VA.ENTRY_DATE,
                                        VA.ENTRY_BY_ID,VA.SALES_AMOUNT_COLLECTED,VA.COLLECTION_AMOUNT_COLLECTED,
                                        (SELECT VT.TITLE FROM VISIT_TYPE VT WHERE VT.ID = VA.VISIT_TYPE_ID) AS VISIT_TYPE,
                                        (SELECT UP.USER_NAME FROM USER_PROFILE UP WHERE UP.ID = VA.RETAILER_ID) AS RETAILER_NAME,
                                        (SELECT TITLE FROM PRODUCT_BRAND WHERE ID=VA.PRODUCT_BRAND_ID) AS RETAILER_BRAND
                                        FROM VISIT_ASSIGN VA
                                        WHERE  VA.USER_ID = '$USER_LOGIN_ID'
                                        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')";
                                    $strSQL = @oci_parse($objConnect, $sucessQuery);

                                    @oci_execute($strSQL);
                                    $number = 0;
                                    while ($sucessRow = @oci_fetch_assoc($strSQL)) {
                                        $number++;
                                    ?>
                                        <tr class="table-info">
                                            <td><?= $number ?></td>
                                            <td><?= $sucessRow['RETAILER_NAME'] ?>
                                                </br>
                                                <span class="badge bg-success">
                                                    <i class='bx bx-map-pin'></i>
                                                    <?= $sucessRow['RETAILER_BRAND'] ?>
                                                </span>
                                            </td>
                                            <td><?= $sucessRow['VISIT_DATE'] ?></td>
                                            <td>
                                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $sucessRow['USER_REMARKS']; ?>">
                                                    <?php echo mb_strlen($sucessRow['USER_REMARKS'], 'UTF-8') > 20 ? mb_substr($sucessRow['USER_REMARKS'], 0, 20, 'UTF-8') . '...' : $sucessRow['USER_REMARKS']; ?>
                                                </span>
                                            </td>

                                            <td class="text-end"><?= number_format($sucessRow['SALES_AMOUNT_COLLECTED']) ?></td>
                                            <td class="text-end"><?= number_format($sucessRow['COLLECTION_AMOUNT_COLLECTED']) ?></td>
                                            <td>
                                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $sucessRow['AFTER_VISIT_REMARKS']; ?>">
                                                    <?php echo mb_strlen($sucessRow['AFTER_VISIT_REMARKS'], 'UTF-8') > 20 ? mb_substr($sucessRow['AFTER_VISIT_REMARKS'], 0, 20, 'UTF-8') . '...' : $sucessRow['AFTER_VISIT_REMARKS']; ?>
                                                </span>
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

    </div>
</div>