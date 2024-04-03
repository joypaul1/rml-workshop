<?php
session_start();
require_once('../../_config/connoracle.php');

$fileName = $_GET['brand_name'] . "_" . date("Y-m-d") . '.xlsx'; // Set the desired file name
$brand_ID = $_GET['brand_type'];
$USER_LOGIN_ID  = $_SESSION['USER_CSPD_INFO']['ID'];
// print_r($_SESSION['USER_CSPD_INFO']);
$sale_executive_all_retailer_ids = [];
if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == 'HOD') {
    $sale_executive_all_retailer_ids_str  = '0';
    // sale_executive_all_retailer_query
    $sale_executive_all_retailer_query = "SELECT A.USER_ID
    FROM USER_MANPOWER_SETUP A, USER_PROFILE B
    WHERE A.USER_ID = B.ID AND PARENT_USER_ID IN
        (SELECT A.USER_ID FROM USER_MANPOWER_SETUP A, USER_PROFILE B
        WHERE A.USER_ID = B.ID AND PARENT_USER_ID = $USER_LOGIN_ID)";

    $sale_executive_all_retailer_query .= " UNION ALL ";

    $sale_executive_all_retailer_query .= "SELECT B.ID
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
    // print_r($sale_executive_all_retailer_ids);
    if (count($sale_executive_all_retailer_ids) > 0) {
        $sale_executive_all_retailer_ids_str = implode(',', $sale_executive_all_retailer_ids);
    }
} else if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == 'COORDINATOR') {
    $query = "SELECT UP.ID, UP.USER_NAME, UP.USER_MOBILE
    FROM
        USER_PROFILE UP
    LEFT JOIN
        USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
    WHERE
        UBS.PRODUCT_BRAND_ID IN ($brand_ID)
        AND UBS.STATUS = 1
        AND UP.USER_TYPE_ID = 3";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Document</title>
</head>

<body>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>USER_ID</th>
                <th>BRAND_ID</th>
                <th>USER_INFO</th>
                <th>START_DATE</th>
                <th>END_DATE</th>
                <th>SALES_TARGET_AMOUNT</th>
                <th>COLLECTON_TARGET_AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == 'HOD') {
                $TGVSAC_QUERY = "SELECT A.ID,
                                A.USER_NAME,
                                (SELECT TITLE
                                    FROM USER_TYPE
                                    WHERE ID = A.USER_TYPE_ID) AS USER_TYPE
                            FROM USER_PROFILE A,
                                (SELECT USER_ID
                                    FROM USER_MANPOWER_SETUP
                                    WHERE PARENT_USER_ID = $USER_LOGIN_ID
                                UNION ALL
                                SELECT USER_ID
                                    FROM USER_MANPOWER_SETUP
                                    WHERE PARENT_USER_ID IN ($sale_executive_all_retailer_ids_str)) B
                            WHERE A.ID = B.USER_ID AND A.USER_TYPE_ID IN (4,5)";
                $strSQL = oci_parse($objConnect, $TGVSAC_QUERY); // Assuming $objConnect is your Oracle connection object
                oci_execute($strSQL); // Execute the SQL query
                $number = 0;
                while ($sucessRow = oci_fetch_assoc($strSQL)) {
                    $number++;
            ?>
                    <tr>
                        <td><?= $sucessRow['ID'] ?></td>
                        <td><?= $brand_ID ?></td>
                        <td><?= $sucessRow['USER_NAME'] ?> <br> <?= $sucessRow['USER_TYPE'] ?> <br> </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>

    </table>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>




<script>
    console.log(3333);
</script>