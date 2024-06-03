<?php
session_start();
require_once ('../../_config/connoracle.php');

$fileName      = $_GET['brand_name'] . "_" . date("Y-m-d") . '.xlsx'; // Set the desired file name
$brand_ID      = $_GET['brand_type'];
$USER_LOGIN_ID = $_SESSION['USER_CSPD_INFO']['ID'];
$v_start_date  = date("01/m/Y");
$v_end_date    = date("t/m/Y");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
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
                <th>TARGET_AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($_SESSION['USER_CSPD_INFO']['USER_TYPE'] == 'HOD') {
                $QUERY  = "SELECT A.ID, A.USER_NAME,
                                (SELECT TITLE FROM USER_TYPE WHERE ID = A.USER_TYPE_ID) AS USER_TYPE
                                FROM USER_PROFILE A
                            WHERE  A.USER_TYPE_ID IN (4,5)";
                $strSQL = oci_parse($objConnect, $QUERY);
                oci_execute($strSQL);
                $number = 0;
                while ($sucessRow = oci_fetch_assoc($strSQL)) {
                    $number++;
                    ?>
                    <tr>
                        <td><?= $sucessRow['ID'] ?></td>
                        <td><?= $brand_ID ?></td>
                        <td><?= $sucessRow['USER_NAME'] ?> <br> <?= $sucessRow['USER_TYPE'] ?> <br> </td>
                        <td><?= $v_start_date ?></td>
                        <td><?= $v_end_date ?></td>
                        <td></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
    <div class="text-end">
        <button id="downloadBtn" class="btn btn-sm btn-primary">Download as Excel</button>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        document.getElementById('downloadBtn').addEventListener('click', function () {
            // Select the table
            var table = document.querySelector('table');
            // Convert table to worksheet
            var workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
            // Generate Excel file
            XLSX.writeFile(workbook, '<?= $fileName; ?>');
        });
    </script>
</body>

</html>