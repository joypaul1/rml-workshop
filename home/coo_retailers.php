<?php
$sale_executive_all_retailer_ids     = [];
$sale_executive_all_retailer_ids_str = '0';
// sale_executive_all_retailer_query
$sale_executive_all_retailer_query = "WITH SALES_EXE_USERS AS (
    SELECT DISTINCT A.USER_ID AS USER_ID
    FROM USER_MANPOWER_SETUP A
    JOIN USER_PROFILE B ON A.USER_ID = B.ID
    JOIN USER_BRAND_SETUP C ON C.USER_PROFILE_ID = B.ID
    WHERE A.PARENT_USER_ID = '$USER_LOGIN_ID'
    AND C.PRODUCT_BRAND_ID IN ($USER_BRANDS)
),
PLAZA_USERS AS (
    SELECT DISTINCT A.USER_ID AS USER_ID
    FROM USER_MANPOWER_SETUP A
    JOIN USER_PROFILE B ON A.USER_ID = B.ID
    JOIN USER_BRAND_SETUP C ON C.USER_PROFILE_ID = B.ID
    WHERE A.PARENT_USER_ID IN (SELECT USER_ID FROM SALES_EXE_USERS)
    AND C.PRODUCT_BRAND_ID IN ($USER_BRANDS)
),
RETAILER_USERS AS (
    SELECT DISTINCT A.USER_ID AS USER_ID
    FROM USER_MANPOWER_SETUP A
    JOIN USER_PROFILE B ON A.USER_ID = B.ID
    JOIN USER_BRAND_SETUP C ON C.USER_PROFILE_ID = B.ID
    WHERE A.PARENT_USER_ID IN (SELECT USER_ID FROM PLAZA_USERS)
    AND C.PRODUCT_BRAND_ID IN ($USER_BRANDS)
)
-- Select USER_IDs from PLAZA_USERS and RETAILER_USERS
SELECT USER_ID FROM PLAZA_USERS
UNION
SELECT USER_ID FROM RETAILER_USERS";


$strSQL3 = @oci_parse($objConnect, $sale_executive_all_retailer_query);
@oci_execute($strSQL3);

while ($row = oci_fetch_assoc($strSQL3)) {
    $sale_executive_all_retailer_ids[] = $row['USER_ID'];
}

if (count($sale_executive_all_retailer_ids) > 0) {
    $sale_executive_all_retailer_ids_str = implode(',', $sale_executive_all_retailer_ids);
}
// sale_executive_all_retailer_query
?>