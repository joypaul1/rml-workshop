<?php
include_once('../../_helper/2step_com_conn.php');


$v_rml_id = $_REQUEST['login_id'];
$v_login_id = 0;


$v_start_date = $_REQUEST['start_date'];
$v_end_date   = $_REQUEST['end_date'];
$v_what_want  = $_REQUEST['want'];
$len          = strlen($_REQUEST['login_id']);

if ($len == 1) {
    $v_login_id = '00000' . $v_rml_id;
} else if ($len == 2) {
    $v_login_id = '0000' . $v_rml_id;
} else if ($len == 3) {
    $v_login_id = '000' . $v_rml_id;
} else if ($len == 4) {
    $v_login_id = '00' . $v_rml_id;
} else if ($len == 5) {
    $v_login_id = '0' . $v_rml_id;
}

?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">


        <div class="row">


            <div class="card rounded-4">
                <div class="card-header p-3 rounded-4 bg-gradient-info text-white fw-bold text-center">

                    <?php
                    if ($v_what_want == 'total_code') {
                        $summaryTitle = 'ERP Code Assign Summary';
                    } else if ($v_what_want == 'total_assign') {
                        $summaryTitle = 'Code Assign Summary On Apps';
                    }
                    $arrowIcon = "<i class='bx bxs-arrow-from-left'></i>";

                    echo '<div class="summary">';
                    echo '<strong>' . $summaryTitle . '</strong>';
                    echo '<br>';
                    echo $arrowIcon . 'Start Date: ' . $v_start_date;
                    echo '<br>';
                    echo $arrowIcon . 'End Date: ' . $v_end_date;
                    echo '<br>';
                    echo $arrowIcon . 'Concern ID: ' . $v_rml_id;
                    echo '</div>';
                    ?>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle mb-0 ">
                            <thead class="table-cust text-uppercase text-center ">
                                <tr>
                                    <th>SL.</th>
                                    <th>Code Information </th>
                                    <th>Payment Information</th>
                                    <th>Visited Information</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                               
                                //query statement 
                                if ($v_what_want == 'total_code') {
                                    $query  = "SELECT 
                                            A.REF_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
                                            (SELECT count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
                                                WHERE B.VISIT_STATUS=1
                                                AND B.REF_ID=A.REF_CODE
                                                AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY'))
                                            TOTAL_VISITED,
                                            (SELECT count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
                                                WHERE B.REF_ID=A.REF_CODE
                                                AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY'))
                                            TOTAL_VISIT_ASSIGN
                                        FROM LEASE_ALL_INFO_ERP A
                                            WHERE A.COLL_CONCERN_ID ='$v_login_id'
                                            AND A.STATUS='N'
                                            AND A.PAMTMODE='CRT'
                                            ORDER BY A.NUMBER_OF_DUE DESC";
                                } else if ($v_what_want == 'total_assign') {
                                    $query  = "SELECT 
                                            A.REF_ID REF_CODE,
                                            A.CUSTOMER_NAME,
                                            (SELECT B.PARTY_ADDRESS FROM LEASE_ALL_INFO_ERP B where B.REF_CODE=A.REF_ID)PARTY_ADDRESS,
                                            (SELECT B.LAST_PAYMENT_AMOUNT FROM LEASE_ALL_INFO_ERP B where B.REF_CODE=A.REF_ID)LAST_PAYMENT_AMOUNT,
                                            (SELECT B.LAST_PAYMENT_DATE FROM LEASE_ALL_INFO_ERP B where B.REF_CODE=A.REF_ID)LAST_PAYMENT_DATE,
                                            (SELECT B.NUMBER_OF_DUE FROM LEASE_ALL_INFO_ERP B where B.REF_CODE=A.REF_ID)NUMBER_OF_DUE,
                                            (SELECT B.COLL_CONCERN_ID FROM LEASE_ALL_INFO_ERP B where B.REF_CODE=A.REF_ID)COLL_CONCERN_ID,
                                            (SELECT count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
                                                            WHERE B.VISIT_STATUS=1
                                                            AND B.REF_ID=A.REF_ID
                                                            AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY'))
                                                        TOTAL_VISITED,
                                            (SELECT count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
                                                WHERE B.REF_ID=A.REF_ID
                                                AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY'))
                                            TOTAL_VISIT_ASSIGN			
                                                 from RML_COLL_VISIT_ASSIGN A
                                                 where CREATED_BY='$v_rml_id'
                                                 and trunc(ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
                                                 ORDER BY A.REF_ID";
                                } else if ($v_what_want == 'Not_Touching_Code') {
                                    $query = "SELECT REF_CODE,
                                             CUSTOMER_NAME,PARTY_ADDRESS,
                                                       CUSTOMER_MOBILE_NO,LAST_PAYMENT_AMOUNT,
                                                       NUMBER_OF_DUE,LAST_PAYMENT_DATE
                                                       from LEASE_ALL_INFO_ERP
                                                where COLL_CONCERN_ID='$v_login_id'
                                                and STATUS='N'
                                                and PAMTMODE='CRT'
                                                order by NUMBER_OF_DUE DESC";
                                }
                                $strSQL = oci_parse($objConnect, $query);

                                oci_execute($strSQL);
                                $number = 0;
                                while ($row = oci_fetch_assoc($strSQL)) {

                                    $number++;
                                ?>
                                    <tr>
                                        <td class="text-center">
                                            <strong>
                                                <?php echo $number; ?>
                                            </strong>
                                        </td>

                                        <td class="customer-info">
                                            <?php
                                            echo 'Code: ' . $row['REF_CODE'];
                                            echo '<br>';
                                            echo 'Customer Name: ' . $row['CUSTOMER_NAME'];
                                            echo '<br>';
                                            echo 'Address: <i class="fw-bold" style="color:red;">' . $row['PARTY_ADDRESS'] . '</i>';
                                            echo '<br>';
                                            echo 'RML ID: <i>' . $row['COLL_CONCERN_ID'] . '</i>';

                                            ?>
                                        </td>
                                        <td class="concern-info">
                                            <?php
                                           
                                           echo 'Last Payment: <span class="fw-bold text-success">' . number_format($row['LAST_PAYMENT_AMOUNT'], 2) . ' TK</span>';
 
                                            echo '<br>';
                                            echo 'Last Payment Date: ' . $row['LAST_PAYMENT_DATE'];
                                            echo '<br>';
                                            echo '<u>Number of Due: <b style="color:red;">' . $row['NUMBER_OF_DUE'] . '</b></u>';
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo 'Total Visit: ' . $row['TOTAL_VISITED'];
                                            echo '<br>';
                                            echo 'Total Visit Assign: ' . $row['TOTAL_VISIT_ASSIGN'];
                                            ?>
                                        </td>

                                    </tr>


                                <?php } ?>

                            </tbody>

                        </table>
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