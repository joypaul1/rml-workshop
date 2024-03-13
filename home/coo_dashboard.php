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
$dynamic_link_js[]  = '../assets/js/hod.js';
$v_start_date = date("01/m/Y");
$v_end_date = date("t/m/Y");
$sale_executive_all_retailer_ids = [];
$sale_executive_all_retailer_ids_str  = '0';
// sale_executive_all_retailer_query
$sale_executive_all_retailer_query = "SELECT A.USER_ID
FROM USER_MANPOWER_SETUP A,
USER_PROFILE B
WHERE A.USER_ID = B.ID AND PARENT_USER_ID IN
    (SELECT A.USER_ID FROM USER_MANPOWER_SETUP A, USER_PROFILE B
    WHERE A.USER_ID = B.ID AND PARENT_USER_ID = $USER_LOGIN_ID)
UNION
SELECT B.ID
FROM USER_MANPOWER_SETUP A, USER_PROFILE B
WHERE A.USER_ID = B.ID
    AND PARENT_USER_ID IN
        (SELECT USER_ID FROM USER_MANPOWER_SETUP A, USER_PROFILE B
        WHERE A.USER_ID = B.ID AND PARENT_USER_ID IN
            (SELECT A.USER_ID FROM USER_MANPOWER_SETUP A, USER_PROFILE B
            WHERE A.USER_ID = B.ID AND PARENT_USER_ID = $USER_LOGIN_ID))";
$strSQL3 = @oci_parse($objConnect, $sale_executive_all_retailer_query);
@oci_execute($strSQL3);

while ($row = oci_fetch_assoc($strSQL3)) {
    $sale_executive_all_retailer_ids[] = $row['USER_ID'];
}
if (count($sale_executive_all_retailer_ids) > 0) {
    $sale_executive_all_retailer_ids_str = implode(',', $sale_executive_all_retailer_ids);
}
// sale_executive_all_retailer_query
//Start total visit row
$totalvisitQuery = "SELECT
/* Start TOTAL_VISIT_OF_MAHINDRA */
(
    SELECT
        NVL(COUNT(VA.ID), 0)
    FROM
        VISIT_ASSIGN VA
    WHERE
        VA.PRODUCT_BRAND_ID = 1
        AND VA.USER_ID IN (
            SELECT
                B.ID
            FROM
                USER_MANPOWER_SETUP A,
                USER_PROFILE B
            WHERE
                A.USER_ID = B.ID
                AND PARENT_USER_ID = '$USER_LOGIN_ID'
        )
        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date', 'DD/MM/YYYY') AND TO_DATE('$v_end_date', 'DD/MM/YYYY')
) AS TOTAL_VISIT_OF_MAHINDRA,
/* End TOTAL_VISIT_OF_MAHINDRA */

/* Start TOTAL_COMPLETE_VISIT_OF_MAHINDRA */
(
    SELECT
        NVL(COUNT(VA.ID), 0)
    FROM
        VISIT_ASSIGN VA
    WHERE
        VA.VISIT_STATUS = 1
        AND VA.PRODUCT_BRAND_ID = 1
        AND VA.USER_ID IN (
            SELECT
                B.ID
            FROM
                USER_MANPOWER_SETUP A,
                USER_PROFILE B
            WHERE
                A.USER_ID = B.ID
                AND PARENT_USER_ID = '$USER_LOGIN_ID'
        )
        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date', 'DD/MM/YYYY') AND TO_DATE('$v_end_date', 'DD/MM/YYYY')
) AS TOTAL_COMPLETE_VISIT_OF_MAHINDRA,
/* End TOTAL_COMPLETE_VISIT_OF_MAHINDRA */

/* Start TOTAL_COLLECTION_OF_MAHINDRA */
(
    SELECT NVL(SUM(VA.COLLECTION_AMOUNT_COLLECTED), 0)
    FROM
        VISIT_ASSIGN VA
    WHERE
        VA.VISIT_STATUS = 1
        AND VA.PRODUCT_BRAND_ID = 1
        AND VA.USER_ID IN (
            SELECT
                B.ID
            FROM
                USER_MANPOWER_SETUP A,
                USER_PROFILE B
            WHERE
                A.USER_ID = B.ID
                AND PARENT_USER_ID = '$USER_LOGIN_ID'
        )
        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date', 'DD/MM/YYYY') AND TO_DATE('$v_end_date', 'DD/MM/YYYY')
) AS TOTAL_COLLECTION_OF_MAHINDRA,
/* End TOTAL_COLLECTION_OF_MAHINDRA */

/* Start TOTAL_COLLECTION_TARGET_OF_MAHINDRA */
(
    SELECT NVL(SUM(CA.COLLECTON_TARGET_AMOUNT), 0)
    FROM
    COLLECTION_ASSIGN CA
    WHERE TRUNC (CA.START_DATE) >= TO_DATE ('$v_start_date', 'DD/MM/YYYY')
    AND TRUNC (CA.END_DATE) <= TO_DATE ('$v_end_date', 'DD/MM/YYYY')
    AND CA.BRAND_ID = 1
    AND CA.USER_ID IN  ($sale_executive_all_retailer_ids_str)
) AS TOTAL_COLLECTION_TARGET_OF_MAHINDRA,
/* End TOTAL_COLLECTION_TARGET_OF_MAHINDRA */

/* Start TOTAL_SALES_TARGET_OF_MAHINDRA */
(
    SELECT NVL(SUM(CA.SALES_TARGET_AMOUNT), 0)
    FROM
    COLLECTION_ASSIGN CA
    WHERE TRUNC (CA.START_DATE) >= TO_DATE ('$v_start_date', 'DD/MM/YYYY')
    AND TRUNC (CA.END_DATE) <= TO_DATE ('$v_end_date', 'DD/MM/YYYY')
    AND CA.BRAND_ID = 1
    AND CA.USER_ID IN  ($sale_executive_all_retailer_ids_str)
) AS TOTAL_SALES_TARGET_OF_MAHINDRA,
/* End TOTAL_SALES_TARGET_OF_MAHINDRA */



/* Start TOTAL_SALES_OF_MAHINDRA */
(
    SELECT NVL(SUM(VA.SALES_AMOUNT_COLLECTED), 0)
    FROM
        VISIT_ASSIGN VA
    WHERE
        VA.VISIT_STATUS = 1
        AND VA.PRODUCT_BRAND_ID = 1
        AND VA.USER_ID IN (
            SELECT
                B.ID
            FROM
                USER_MANPOWER_SETUP A,
                USER_PROFILE B
            WHERE
                A.USER_ID = B.ID
                AND PARENT_USER_ID = '$USER_LOGIN_ID'
        )
        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date', 'DD/MM/YYYY') AND TO_DATE('$v_end_date', 'DD/MM/YYYY')
) AS TOTAL_SALES_OF_MAHINDRA,
/* End TOTAL_SALES_OF_MAHINDRA */

/* Start TOTAL_VISIT_OF_EICHER */
(
    SELECT
        NVL(COUNT(VA.ID), 0)
    FROM
        VISIT_ASSIGN VA
    WHERE
        VA.PRODUCT_BRAND_ID = 2
        AND VA.USER_ID IN (
            SELECT
                B.ID
            FROM
                USER_MANPOWER_SETUP A,
                USER_PROFILE B
            WHERE
                A.USER_ID = B.ID
                AND PARENT_USER_ID = '$USER_LOGIN_ID'
        )
        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date', 'DD/MM/YYYY') AND TO_DATE('$v_end_date', 'DD/MM/YYYY')
) AS TOTAL_VISIT_OF_EICHER,
/* End TOTAL_VISIT_OF_EICHER */

/* Start TOTAL_COMPLETE_VISIT_OF_EICHER */
(
    SELECT
        NVL(COUNT(VA.ID), 0)
    FROM
        VISIT_ASSIGN VA
    WHERE
        VA.VISIT_STATUS = 1
        AND VA.PRODUCT_BRAND_ID = 2
        AND VA.USER_ID IN (
            SELECT
                B.ID
            FROM
                USER_MANPOWER_SETUP A,
                USER_PROFILE B
            WHERE
                A.USER_ID = B.ID
                AND PARENT_USER_ID = '$USER_LOGIN_ID'
        )
        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date', 'DD/MM/YYYY') AND TO_DATE('$v_end_date', 'DD/MM/YYYY')
) AS TOTAL_COMPLETE_VISIT_OF_EICHER,
/* End TOTAL_COMPLETE_VISIT_OF_EICHER */

/* Start TOTAL_SALES_OF_EICHER */
(
    SELECT NVL(SUM(VA.SALES_AMOUNT_COLLECTED), 0)
    FROM
        VISIT_ASSIGN VA
    WHERE
        VA.VISIT_STATUS = 1
        AND VA.PRODUCT_BRAND_ID = 2
        AND VA.USER_ID IN (
            SELECT
                B.ID
            FROM
                USER_MANPOWER_SETUP A,
                USER_PROFILE B
            WHERE
                A.USER_ID = B.ID
                AND PARENT_USER_ID = '$USER_LOGIN_ID'
        )
        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date', 'DD/MM/YYYY') AND TO_DATE('$v_end_date', 'DD/MM/YYYY')
) AS TOTAL_SALES_OF_EICHER,
/* End TOTAL_SALES_OF_EICHER */

/* Start TOTAL_COLLECTION_OF_EICHER */
(
    SELECT NVL(SUM(VA.COLLECTION_AMOUNT_COLLECTED), 0)
    FROM
        VISIT_ASSIGN VA
    WHERE
        VA.VISIT_STATUS = 1
        AND VA.PRODUCT_BRAND_ID = 2
        AND VA.USER_ID IN (
            SELECT
                B.ID
            FROM
                USER_MANPOWER_SETUP A,
                USER_PROFILE B
            WHERE
                A.USER_ID = B.ID
                AND PARENT_USER_ID = '$USER_LOGIN_ID'
        )
        AND TRUNC(VA.VISIT_DATE) BETWEEN TO_DATE('$v_start_date', 'DD/MM/YYYY') AND TO_DATE('$v_end_date', 'DD/MM/YYYY')
) AS TOTAL_COLLECTION_OF_EICHER,
/* End TOTAL_COLLECTION_OF_EICHER */

/* Start TOTAL_COLLECTION_TARGET_OF_EICHER */
(
    SELECT NVL(SUM(CA.COLLECTON_TARGET_AMOUNT), 0)
    FROM
    COLLECTION_ASSIGN CA
    WHERE TRUNC (CA.START_DATE) >= TO_DATE ('$v_start_date', 'DD/MM/YYYY')
    AND TRUNC (CA.END_DATE) <= TO_DATE ('$v_end_date', 'DD/MM/YYYY')
    AND CA.BRAND_ID = 2
    AND CA.USER_ID IN  ($sale_executive_all_retailer_ids_str)
) AS TOTAL_COLLECTION_TARGET_OF_EICHER,
/* End TOTAL_COLLECTION_TARGET_OF_EICHER */

/* Start TOTAL_SALES_TARGET_OF_EICHER */
(
    SELECT NVL(SUM(CA.SALES_TARGET_AMOUNT), 0)
    FROM
    COLLECTION_ASSIGN CA
    WHERE TRUNC (CA.START_DATE) >= TO_DATE ('$v_start_date', 'DD/MM/YYYY')
    AND TRUNC (CA.END_DATE) <= TO_DATE ('$v_end_date', 'DD/MM/YYYY')
    AND CA.BRAND_ID = 2
    AND CA.USER_ID IN  ($sale_executive_all_retailer_ids_str)
) AS TOTAL_SALES_TARGET_OF_EICHER
/* End TOTAL_SALES_TARGET_OF_EICHER */

FROM DUAL";
// echo $totalvisitQuery;
$strSQL2 = @oci_parse($objConnect, $totalvisitQuery);
@oci_execute($strSQL2);
$visit_plan_month_wise_data = @oci_fetch_assoc($strSQL2);

//End visiT queries

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
                                                <p class="mb-0 text-white">Total Visit Plan</p>
                                                <h4 class="my-1 text-white">
                                                    <?php print_r($visit_plan_month_wise_data['TOTAL_VISIT_OF_MAHINDRA'] ? $visit_plan_month_wise_data['TOTAL_VISIT_OF_MAHINDRA'] : 0) ?>
                                                </h4>
                                                <p class="mb-0 font-10 text-white"> Current Month </p>
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
                                                    <?php print_r($visit_plan_month_wise_data['TOTAL_COMPLETE_VISIT_OF_MAHINDRA'] ? $visit_plan_month_wise_data['TOTAL_COMPLETE_VISIT_OF_MAHINDRA'] : 0) ?>
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
                                                <p class="mb-0 text-white">Collection</p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data['TOTAL_COLLECTION_OF_MAHINDRA']) ? number_format($visit_plan_month_wise_data['TOTAL_COLLECTION_OF_MAHINDRA']) : 0 ?>
                                                </h6>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-white">Target</p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data['TOTAL_COLLECTION_TARGET_OF_MAHINDRA']) ? number_format($visit_plan_month_wise_data['TOTAL_COLLECTION_TARGET_OF_MAHINDRA']) : 0 ?>
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
                                                    <?php echo isset($visit_plan_month_wise_data['TOTAL_SALES_OF_MAHINDRA']) ? $visit_plan_month_wise_data['TOTAL_SALES_OF_MAHINDRA'] : 0 ?>
                                                </h6>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-white">Target </p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data['TOTAL_SALES_TARGET_OF_MAHINDRA']) ? number_format($visit_plan_month_wise_data['TOTAL_SALES_TARGET_OF_MAHINDRA']) : 0 ?>
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
                                                    <?php print_r($visit_plan_month_wise_data['TOTAL_VISIT_OF_EICHER'] ? $visit_plan_month_wise_data['TOTAL_VISIT_OF_EICHER'] : 0) ?>
                                                </h4>
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
                                                <p class="mb-0 text-white"> Visit Complete</p>
                                                <h4 class="my-1 text-white">
                                                    <?php print_r($visit_plan_month_wise_data['TOTAL_COMPLETE_VISIT_OF_EICHER'] ? $visit_plan_month_wise_data['TOTAL_COMPLETE_VISIT_OF_EICHER'] : 0) ?>
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
                                                <p class="mb-0 text-white">Collection</p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data['TOTAL_COLLECTION_OF_EICHER']) ? number_format($visit_plan_month_wise_data['TOTAL_COLLECTION_OF_EICHER']) : 0 ?>
                                                </h6>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-white">Target</p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data['TOTAL_COLLECTON_TARGET_OF_EICHER']) ? number_format($visit_plan_month_wise_data['TOTAL_COLLECTON_TARGET_OF_EICHER']) : 0 ?>
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
                                                    <?php echo isset($visit_plan_month_wise_data['TOTAL_SALES_OF_EICHER']) ? $visit_plan_month_wise_data['TOTAL_SALES_OF_EICHER'] : 0 ?>
                                                </h6>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-white"> Target </p>
                                                <h6 class="my-1 text-white">
                                                    <?php echo isset($visit_plan_month_wise_data['TOTAL_SALES_TARGET_OF_EICHER']) ? $visit_plan_month_wise_data['TOTAL_SALES_TARGET_OF_EICHER'] : 0 ?>
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
                    <div class="card-header" style="background-color: #3b005c;">
                        <div class="text-center ">
                            <h6 class="mb-0 fw-bold text-white">Sale Executive List </h6>
                        </div>
                    </div>
                    <div class="card-body" style="height:380px; overflow: auto;">
                        <div class="categories-list">
                            <?php
                            $cooquery = "SELECT B.USER_NAME,B.USER_MOBILE,B.IMAGE_LINK FROM USER_MANPOWER_SETUP A,USER_PROFILE B
                            WHERE A.USER_ID=B.ID
                            AND PARENT_USER_ID='$USER_LOGIN_ID' FETCH FIRST 8 ROWS ONLY";
                            $coordinatorSQL = oci_parse($objConnect, $cooquery);
                            @oci_execute($coordinatorSQL);
                            while ($coodinatorRow = oci_fetch_assoc($coordinatorSQL)) {
                            ?>
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div class="">
                                        <?php if ($coodinatorRow['IMAGE_LINK'] != null) {
                                            echo '<img src="' . $sfcmBasePath . '/' . $coodinatorRow["IMAGE_LINK"] . '" class="product-img-2" alt="user_image">';
                                        } else {
                                            echo '<img src="https://png.pngtree.com/png-clipart/20210915/ourmid/pngtree-user-avatar-login-interface-abstract-blue-icon-png-image_3917504.jpg"  alt="user_image" class="product-img-2">';
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
                    <div class="card-header" style="background-color: #3b005c;">
                        <div class="text-center ">
                            <h6 class="mb-0 fw-bold text-white">Plaza Retailer List </h6>
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
                                            AND PARENT_USER_ID = $USER_LOGIN_ID
                                            ) FETCH FIRST 8 ROWS ONLY";
                            $coordinatorSQL = oci_parse($objConnect, $cooquery);
                            @oci_execute($coordinatorSQL);
                            while ($coodinatorRow = oci_fetch_assoc($coordinatorSQL)) {
                            ?>
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div class="">
                                        <?php if ($coodinatorRow['IMAGE_LINK'] != null) {
                                            echo '<img src="' . $sfcmBasePath . '/' . $coodinatorRow["IMAGE_LINK"] . '" class="product-img-2" alt="user_image">';
                                        } else {
                                            echo '<img src="https://png.pngtree.com/png-clipart/20210915/ourmid/pngtree-user-avatar-login-interface-abstract-blue-icon-png-image_3917504.jpg"  alt="user_image" class="product-img-2">';
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
                    <div class="card-header" style="background-color: #3b005c;">
                        <div class="text-center ">
                            <h6 class="mb-0 fw-bold text-white"> Retailer List </h6>
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
                            AND PARENT_USER_ID= '$USER_LOGIN_ID'
                            )
                            ) FETCH FIRST 8 ROWS ONLY";
                            $coordinatorSQL = oci_parse($objConnect, $cooquery);
                            @oci_execute($coordinatorSQL);
                            while ($coodinatorRow = oci_fetch_assoc($coordinatorSQL)) {
                            ?>
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div class="">
                                        <?php if ($coodinatorRow['IMAGE_LINK'] != null) {
                                            echo '<img src="' . $sfcmBasePath . '/' . $coodinatorRow["IMAGE_LINK"] . '" class="product-img-2" alt="user_image">';
                                        } else {
                                            echo '<img src="https://png.pngtree.com/png-clipart/20210915/ourmid/pngtree-user-avatar-login-interface-abstract-blue-icon-png-image_3917504.jpg"  alt="user_image" class="product-img-2">';
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
            <div class="col-12">
                <div class="card rounded-4">
                    <div class="card-header" style="background: #3b005c;">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 border-success">
                                <strong class="text-white">
                                    <i class="bx bx-flag "></i>
                                    TARGET VS ACHIVEMENT
                                    <span class="badge bg-primary"> <?= date('F - Y') ?> </span>
                                </strong>
                            </h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsiveS">
                            <table class="table table-sm table-bordered align-middle mb-0 table-hover">
                                <thead class="bg-gradient-info text-center text-white fw-bold">
                                    <tr>
                                        <th>SL.</th>
                                        <th>RETAILER NAME & TYPE </th>
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
                                    $TGVSAC_QUERY = "SELECT A.ID,
                                                    A.USER_NAME,
                                                    (SELECT TITLE
                                                    FROM USER_TYPE
                                                    WHERE ID = A.USER_TYPE_ID) AS USER_TYPE,
                                                    TOTAL_VISTITED_COLLECTION(A.ID,
                                                        TO_DATE('$v_start_date', 'DD/MM/YYYY'),
                                                        TO_DATE('$v_end_date', 'DD/MM/YYYY'),
                                                        'SALES') AS SALES_AMOUNT,
                                                    TOTAL_VISTITED_COLLECTION(A.ID,
                                                        TO_DATE('$v_start_date', 'DD/MM/YYYY'),
                                                        TO_DATE('$v_end_date', 'DD/MM/YYYY'),
                                                        'COLLECTION') AS COLLECTION_AMOUNT,
                                                    TOTAL_TARGET_ASSIGN(A.ID,
                                                        TO_DATE('$v_start_date', 'DD/MM/YYYY'),
                                                        TO_DATE('$v_end_date', 'DD/MM/YYYY'),
                                                        'SALES') AS SALES_TARGET,
                                                    TOTAL_TARGET_ASSIGN(A.ID,
                                                        TO_DATE('$v_start_date', 'DD/MM/YYYY'),
                                                        TO_DATE('$v_end_date', 'DD/MM/YYYY'),
                                                        'COLLECTION') AS COLLECTION_TARGET
                                                FROM USER_PROFILE A
                                                WHERE A.ID IN ($sale_executive_all_retailer_ids_str)";
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
                                                $percentageRate = round(($sucessRow['SALES_AMOUNT'] / $sucessRow['SALES_TARGET']) * 100);
                                            }
                                            ?>
                                            <td class="text-center">
                                                <?= $percentageRate ?>%
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-gradient-ibiza" role="progressbar" style="<?= 'width:' . $percentageRate . '%' ?>"></div>
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
                                                $percentageRate2 = round(($sucessRow['COLLECTION_AMOUNT'] / $sucessRow['COLLECTION_TARGET']) * 100);
                                            }
                                            ?>
                                            <td class="text-center">
                                                <?= $percentageRate2 ?>%
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-gradient-ibiza" role="progressbar" style="<?= 'width:' . $percentageRate2 . '%' ?>"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="3">
                                            <?php
                                            $TOTAL_SALES_OF_MAHINDRA = isset($visit_plan_month_wise_data['TOTAL_SALES_OF_MAHINDRA']) ? $visit_plan_month_wise_data['TOTAL_SALES_OF_MAHINDRA'] : 0;
                                            $TOTAL_SALES_OF_EICHER = isset($visit_plan_month_wise_data['TOTAL_SALES_OF_EICHER']) ? $visit_plan_month_wise_data['TOTAL_SALES_OF_EICHER'] : 0;
                                            echo '<span style="text-decoration-line: underline;
                                            text-decoration-style: double;">' . number_format(($TOTAL_SALES_OF_MAHINDRA + $TOTAL_SALES_OF_EICHER)) . '</span>';
                                            ?>
                                        </td>
                                        <td class="text-end">
                                            <?php
                                            $TOTAL_SALES_TARGET_OF_MAHINDRA = isset($visit_plan_month_wise_data['TOTAL_SALES_TARGET_OF_MAHINDRA']) ? $visit_plan_month_wise_data['TOTAL_SALES_TARGET_OF_MAHINDRA'] : 0;
                                            $TOTAL_SALES_TARGET_OF_EICHER = isset($visit_plan_month_wise_data['TOTAL_SALES_TARGET_OF_EICHER']) ? $visit_plan_month_wise_data['TOTAL_SALES_TARGET_OF_EICHER'] : 0;
                                            echo '<span style="text-decoration-line: underline;
                                            text-decoration-style: double;">' . number_format(($TOTAL_SALES_TARGET_OF_MAHINDRA + $TOTAL_SALES_TARGET_OF_EICHER)) . '</span>';
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $totalSales = ($TOTAL_SALES_OF_MAHINDRA + $TOTAL_SALES_OF_EICHER);
                                            $totalSaleTarget = ($TOTAL_SALES_TARGET_OF_MAHINDRA + $TOTAL_SALES_TARGET_OF_EICHER);
                                            if ($totalSales > 0 || $totalSaleTarget > 0) {
                                                echo '<span style="text-decoration-line: underline;
                                                text-decoration-style: double;">' . round(($totalSales / $totalSaleTarget) / 100) . '%' . '</span>';
                                            } else {
                                                echo '<span style="text-decoration-line: underline;
                                                text-decoration-style: double;"> 0% </span>';
                                            }
                                            ?>
                                        </td>

                                        <td class="text-end">
                                            <?php
                                            $TOTAL_COLLECTION_OF_MAHINDRA = isset($visit_plan_month_wise_data['TOTAL_COLLECTION_OF_MAHINDRA']) ? $visit_plan_month_wise_data['TOTAL_COLLECTION_OF_MAHINDRA'] : 0;
                                            $TOTAL_COLLECTION_OF_EICHER = isset($visit_plan_month_wise_data['TOTAL_COLLECTION_OF_EICHER']) ? $visit_plan_month_wise_data['TOTAL_COLLECTION_OF_EICHER'] : 0;
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
                                            $TOTAL_COLLECTION_TARGET_OF_MAHINDRA = isset($visit_plan_month_wise_data['TOTAL_COLLECTION_TARGET_OF_MAHINDRA']) ? $visit_plan_month_wise_data['TOTAL_COLLECTION_TARGET_OF_MAHINDRA'] : 0;
                                            $TOTAL_COLLECTION_TARGET_OF_EICHER = isset($visit_plan_month_wise_data['TOTAL_COLLECTION_TARGET_OF_EICHER']) ? $visit_plan_month_wise_data['TOTAL_COLLECTION_TARGET_OF_EICHER'] : 0;
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
                                            $totalCollection = ($TOTAL_COLLECTION_OF_MAHINDRA + $TOTAL_COLLECTION_OF_EICHER);
                                            $totalCollectionTarget = ($TOTAL_COLLECTION_TARGET_OF_MAHINDRA + $TOTAL_COLLECTION_TARGET_OF_EICHER);
                                            if ($totalCollection > 0 || $totalCollectionTarget > 0) {
                                                echo '<span style="text-decoration-line: underline;
                                                text-decoration-style: double;">' . round(($totalCollection / $totalCollectionTarget) / 100) . '%' . '</span>';
                                            } else {
                                                echo '<span style="text-decoration-line: underline;
                                                text-decoration-style: double;"> 0% </span>';
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
                                        WHERE   VA.RETAILER_ID IN ($sale_executive_all_retailer_ids_str)
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
                                            <td class="text-center"><?= $sucessRow['VISIT_DATE'] ?></td>
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
                                <thead class="text-white text-uppercase text-center" style="background-color: #3b005c !important">
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