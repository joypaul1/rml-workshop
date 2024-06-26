<?php
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2.min.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2-bootstrap4.css';
$dynamic_link_js[]  = '../../assets/plugins/select2/js/select2.min.js';
include_once('../../_helper/2step_com_conn.php');
$number = 0;
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <div class="row">
            <div class="card rounded-4">
                <div class="card-body">
                    <button class="accordion-button" style="color:#0dcaf0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <strong><i class='bx bx-filter-alt'></i> Filter Data</strong>
                    </button>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">

                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-sm-12  col-md-4">
                                                <label for="validationCustom06" class="form-label">User Type </label>
                                                <select class="form-select " id="validationCustom06" name="USER_TYPE_ID">
                                                    <option value=""><- Select Type -></option>
                                                    <?php
                                                    $typeRow = [];
                                                    $currentUserTypeID = $_SESSION['USER_CSPD_INFO']['USER_TYPE_ID'];
                                                    $USER_TYPE_ID = $_POST['USER_TYPE_ID'] ? $_POST['USER_TYPE_ID'] : '';
                                                    $query   = "SELECT ID,TITLE FROM USER_TYPE WHERE STATUS ='1'  
                                        AND ID > '$currentUserTypeID'  ORDER BY ID ASC ";
                                                    $strSQL  = @oci_parse($objConnect, $query);

                                                    @oci_execute($strSQL);
                                                    while ($typeRow = @oci_fetch_assoc($strSQL)) {
                                                    ?>
                                                        <option value="<?php echo $typeRow['ID'] ?>" <?php echo $USER_TYPE_ID == $typeRow['ID'] ? 'Selected' : ' ' ?>>
                                                            <?php echo $typeRow['TITLE'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <div class="invalid-feedback">Please select a User Type.</div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>MOBILE : </label>
                                                <input class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="USER_MOBILE" type="text" value='<?php echo isset($_POST['USER_MOBILE']) ? $_POST['USER_MOBILE'] : ''; ?>' />
                                            </div>
                                            <div class="col-sm-4 d-flex gap-2">
                                                <button type="submit" class="form-control btn btn-sm btn-gradient-primary mt-4">Search Data<i class='bx bx-file-find'></i></button>
                                                <a href="<?php echo $cspdBasePath  ?>/user_module/view/resource_allocation.php" class="form-control btn btn-sm btn-gradient-info mt-4">Reset Data<i class='bx bx-file'></i></a>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="">
                <span class="d-block text-center text-danger fw-bold">[*** Only Cost Center Assign User List Here ***]</span>
                <div class="card rounded-4">
                    <?php
                    $headerType    = 'List';
                    $leftSideName  = 'Resource Allocation List';
                    include('../../_includes/com_header.php');
                    ?>
                    <div class="card-body">

                        <div class="table-responsives">
                            <table class="table table-sm table-bordered align-middle mb-0">
                                <thead class="text-white text-uppercase text-center" style="background-color: #3b005c !important">
                                    <tr>
                                        <th>SL.</th>
                                        <th>User info</th>
                                        <th colspan="2">Assign Responsible ID</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th>MAHINDRA</th>
                                        <th>EICHER</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $query = "SELECT UP.ID,
                                                        UP.USER_NAME,
                                                        UP.USER_MOBILE,
                                                        UP.USER_TYPE_ID,
                                                        UP.RML_IDENTITY_ID AS RML_ID,
                                                        (SELECT TITLE
                                                        FROM USER_TYPE
                                                        WHERE ID = UP.USER_TYPE_ID)
                                                        AS USER_TYPE,
                                                        (SELECT TITLE FROM USER_TYPE WHERE ID = (UP.USER_TYPE_ID - 1) ) AS RES_USER_TYPE,
                                                        LISTAGG (UBS.PRODUCT_BRAND_ID, ',')
                                                        WITHIN GROUP (ORDER BY UBS.PRODUCT_BRAND_ID)
                                                        AS USER_BRANDS
                                                FROM USER_PROFILE UP
                                                        LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
                                                WHERE UBS.STATUS = 1 AND UP.USER_STATUS = 1 AND UP.USER_TYPE_ID != '1'";



                                    if (isset($_POST['USER_TYPE_ID']) && !empty($_POST['USER_TYPE_ID'])) {
                                        $USER_TYPE_ID   = $_POST['USER_TYPE_ID'];
                                        $query .= " AND UP.USER_TYPE_ID = $USER_TYPE_ID";
                                    }

                                    if (isset($_POST['USER_MOBILE']) && !empty($_POST['USER_MOBILE'])) {
                                        $USER_MOBILE = $_POST['USER_MOBILE'];
                                        $query .= " AND UP.USER_MOBILE LIKE '%" . $USER_MOBILE . "%'";
                                    }

                                    $query .= " GROUP BY UP.ID,
                                                UP.USER_NAME,
                                                UP.USER_MOBILE,
                                                UP.RML_IDENTITY_ID,
                                                UP.USER_TYPE_ID
                                                ORDER BY UP.USER_TYPE_ID";

                                    $strSQL = @oci_parse($objConnect, $query);

                                    @oci_execute($strSQL);

                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                        $number++;
                                    ?>
                                        <tr>
                                            <td class="text-center">
                                                <strong>
                                                    <?php echo $number; ?>
                                                </strong>
                                            </td>

                                            <td>
                                                <?php echo $row['USER_NAME']; ?>
                                                <br>
                                                Mobile : <?php echo $row['USER_MOBILE']; ?>
                                                <br>
                                                Type : <?php echo $row['USER_TYPE']; ?>
                                                <br>
                                                ID : <?php echo $row['RML_ID']; ?>
                                                <br>
                                                Brand :
                                                <?php
                                                $userBrandID = null;
                                                $userBrandID = $row['USER_BRANDS'];
                                                $brandQuery  = "SELECT PB.TITLE FROM PRODUCT_BRAND PB WHERE  PB.ID IN
                                                ($userBrandID) AND PB.STATUS = 1";

                                                $brandstrSQL  = @oci_parse($objConnect, $brandQuery);
                                                @oci_execute($brandstrSQL);

                                                while ($brandData = @oci_fetch_assoc($brandstrSQL)) {
                                                    echo '<span class="badge rounded-pill bg-gradient-success">' . $brandData['TITLE'] . '</span> ';
                                                }
                                                ?>

                                            </td>
                                            <td>
                                                <?php
                                                $userBrandID =  explode(',', $userBrandID);
                                                if (in_array(1, $userBrandID)) {
                                                ?>
                                                    <form action="<?php echo ($cspdBasePath . '/user_module/action/self_panel.php') ?>" method="post" class="d-flex gap-3">
                                                        <input type="hidden" name="actionType" value="resource_allocation">
                                                        <input type="hidden" name="USER_ID" value="<?php echo $row['ID'] ?>">
                                                        <input type="hidden" name="BRAND_ID" value="1">
                                                        <select class="form-select text-center RESPONSIBLE_IDs" id="" name="PARENT_USER_ID">
                                                            <option><-- Select <?php echo ucwords(strtolower($row['RES_USER_TYPE'])) ?> --></option>
                                                            <?php
                                                            $resRow = [];
                                                            $USER_ID = $row['ID'];
                                                            $currentUserBrandID = $row['USER_BRANDS'];
                                                            $currentUserTypeID = $row['USER_TYPE_ID'];
                                                            $USER_TYPE_ID = $row['USER_TYPE_ID'] ? $row['USER_TYPE_ID']  - 1 : '';
                                                            $query = "SELECT
                                                                    DISTINCT
                                                                    UP.USER_NAME,
                                                                    UP.USER_MOBILE,
                                                                    UP.ID
                                                                    FROM USER_PROFILE UP
                                                                    LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
                                                                    WHERE UP.USER_STATUS = 1
                                                                    AND  UBS.PRODUCT_BRAND_ID IN (1)
                                                                    AND UBS.STATUS = 1
                                                                    AND UP.USER_TYPE_ID = '$USER_TYPE_ID'
                                                                    ORDER BY UP.ID ASC";
                                                            $query3 = "SELECT  PARENT_USER_ID FROM USER_MANPOWER_SETUP WHERE USER_ID = $USER_ID AND STATUS = 1  AND BRAND_ID = 1";
                                                            echo $query3;
                                                            $strSQL2  = @oci_parse($objConnect, $query);
                                                            $strSQL3  = @oci_parse($objConnect, $query3);
                                                            @oci_execute($strSQL2);
                                                            @oci_execute($strSQL3);
                                                            $userResponsibleRow = @oci_fetch_assoc($strSQL3);
                                                            $PARENT_USER_ID = $userResponsibleRow['PARENT_USER_ID'] ? $userResponsibleRow['PARENT_USER_ID'] : null;

                                                            while ($resRow = @oci_fetch_assoc($strSQL2)) {
                                                            ?>
                                                                <option value="<?php echo $resRow['ID'] ?>" <?php echo $PARENT_USER_ID == $resRow['ID'] ? 'Selected' : ' ' ?>>
                                                                    <?php echo $resRow['USER_NAME'] ?>
                                                                    - <?php echo $resRow['USER_MOBILE'] ?>
                                                                </option>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                        <?php if ($PARENT_USER_ID) {
                                                            echo '<button type="submit" class="btn btn-sm btn-gradient-success"> <i class="bx bx-check-double"></i></button>';
                                                        } else {
                                                            echo '<button type="submit" class="btn btn-sm btn-gradient-warning text-white"> <i class="bx bx-check-double"></i>
                                                            </button>';
                                                        } ?>

                                                    </form>
                                                <?php }
                                                ?>

                                            </td>
                                            <td>
                                                <?php
                                                if (in_array(2, $userBrandID)) {
                                                ?>
                                                    <form action="<?php echo ($cspdBasePath . '/user_module/action/self_panel.php') ?>" method="post" class="d-flex gap-3">
                                                        <input type="hidden" name="actionType" value="resource_allocation">
                                                        <input type="hidden" name="USER_ID" value="<?php echo $row['ID'] ?>">
                                                        <input type="hidden" name="BRAND_ID" value="2">
                                                        <select class="form-select text-center RESPONSIBLE_IDs" id="" name="PARENT_USER_ID">
                                                            <option><-- Select <?php echo ucwords(strtolower($row['RES_USER_TYPE'])) ?> --></option>
                                                            <?php
                                                            $resRow = [];
                                                            $USER_ID = $row['ID'];
                                                            $currentUserBrandID = $row['USER_BRANDS'];
                                                            $currentUserTypeID = $row['USER_TYPE_ID'];
                                                            $USER_TYPE_ID = $row['USER_TYPE_ID'] ? $row['USER_TYPE_ID']  - 1 : '';
                                                            $query = "SELECT
                                                                    DISTINCT
                                                                    UP.USER_NAME,
                                                                    UP.USER_MOBILE,
                                                                    UP.ID
                                                                    FROM USER_PROFILE UP
                                                                    LEFT JOIN USER_BRAND_SETUP UBS ON UBS.USER_PROFILE_ID = UP.ID
                                                                    WHERE UP.USER_STATUS = 1
                                                                    AND  UBS.PRODUCT_BRAND_ID IN (2)
                                                                    AND UBS.STATUS = 1
                                                                    AND UP.USER_TYPE_ID = '$USER_TYPE_ID'
                                                                    ORDER BY UP.ID ASC";
                                                            $query3 = "SELECT  PARENT_USER_ID FROM USER_MANPOWER_SETUP WHERE USER_ID = $USER_ID AND STATUS = 1 AND BRAND_ID = 2";
                                                            $strSQL2  = @oci_parse($objConnect, $query);
                                                            $strSQL3  = @oci_parse($objConnect, $query3);
                                                            @oci_execute($strSQL2);
                                                            @oci_execute($strSQL3);
                                                            $userResponsibleRow = @oci_fetch_assoc($strSQL3);
                                                            $PARENT_USER_ID = $userResponsibleRow['PARENT_USER_ID'] ? $userResponsibleRow['PARENT_USER_ID'] : null;

                                                            while ($resRow = @oci_fetch_assoc($strSQL2)) {
                                                            ?>
                                                                <option value="<?php echo $resRow['ID'] ?>" <?php echo $PARENT_USER_ID == $resRow['ID'] ? 'Selected' : ' ' ?>>
                                                                    <?php echo $resRow['USER_NAME'] ?>
                                                                    - <?php echo $resRow['USER_MOBILE'] ?>
                                                                </option>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                        <?php if ($PARENT_USER_ID) {
                                                            echo '<button type="submit" class="btn btn-sm btn-gradient-success"> <i class="bx bx-check-double"></i></button>';
                                                        } else {
                                                            echo '<button type="submit" class="btn btn-sm btn-gradient-warning text-white"> <i class="bx bx-check-double"></i>
                                                            </button>';
                                                        } ?>

                                                    </form>
                                                <?php }
                                                ?>

                                            </td>

                                        </tr>

                                    <?php
                                    }
                                    if ($number == 0) {
                                        echo '<tr><td colspan="9" class="text-center text-danger fw-bold"> !</td></tr>';
                                    } ?>
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
    $('.RESPONSIBLE_ID').each(function() {
        console.log($(this));
        $(this).select2({
            theme: 'bootstrap4',
            width: '100%', // Set the width as needed
            // Set the width as needed
            // placeholder: 'Select Resposible ID', // Set the placeholder text
            allowClear: true, // Enable clearing the selection
        }).addClass("text-center");
    });
</script>