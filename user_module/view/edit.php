<?php
$dynamic_link_js[]  = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js';
$dynamic_link_css[] = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2.min.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2-bootstrap4.css';
$dynamic_link_js[]  = '../../assets/plugins/select2/js/select2.min.js';
include_once('../../_helper/2step_com_conn.php');
$data = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'edit') {
    $edit_id = trim($_GET["id"]);
    // ECHO  $edit_id ;
    $query   = "SELECT UP.ID,
    UP.USER_NAME,
    UP.USER_MOBILE,
    UP.RML_IDENTITY_ID as RML_ID,
    UP.PENDRIVE_ID,
    UP.USER_TYPE_ID,
    UP.IMAGE_LINK,
    UP.LAT,
    UP.LANG,
    UP.LOCATION_REMARKS
    FROM USER_PROFILE UP WHERE ID = $edit_id";
    $strSQL  = @oci_parse($objConnect, $query);

    @oci_execute($strSQL);
    $data = @oci_fetch_assoc($strSQL);
}

?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <?php

                    $headerType    = 'Edit';
                    $leftSideName  = 'User Edit';
                    $rightSideName = 'User List';
                    $routePath     = 'user_module/view/index.php';
                    include('../../_includes/com_header.php');

                    ?>
                    <div class="card-body">
                        <div class="p-4 border rounded">
                            <form method="post" action="<?php echo ($basePath . '/user_module/action/self_panel.php') ?>" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate="">
                                <input type="hidden" name="actionType" value="edit">
                                <input type="hidden" name="editId" value="<?php echo trim($_GET["id"]) ?>">
                                <div class="col-sm-12 col-md-4">
                                    <label for="validationCustom01" class="form-label">User Name <span class="text-danger">*</span></label>
                                    <input type="text" name="USER_NAME" autocomplete="off" class="form-control" id="validationCustom01" value="<?php echo $data['USER_NAME'] ?>" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom02" class="form-label">User Mobile (Login ID) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" autocomplete="off" name="USER_MOBILE" onkeypress='return event.charCode >= 48 && event.charCode <= 57' id="validationCustom02" value="<?php echo $data['USER_MOBILE'] ?>" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom08" class="form-label">User Password </label>
                                    <input type="text" class="form-control" name="USER_PASSWORD" autocomplete="off" value="<?php echo $data['PENDRIVE_ID'] ?>" id="validationCustom08" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom09" class="form-label">User RML ID </label>
                                    <input type="text" class="form-control" autocomplete="off" name="RML_ID" value="<?php echo $data['RML_ID'] ?>" id="validationCustom09">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="validationCustom06" class="form-label">User Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="validationCustom06" name="USER_TYPE_ID" required>
                                        <option hidden value="">- Select Type -</option>

                                        <?php
                                        $currentUserTypeID = $_SESSION['USER_SFCM_INFO']['USER_TYPE_ID'];
                                        $query = "SELECT ID, TITLE FROM USER_TYPE WHERE STATUS ='1' AND ID > :currentUserTypeID ORDER BY ID ASC";
                                        $strSQL = oci_parse($objConnect, $query);

                                        oci_bind_by_name($strSQL, ":currentUserTypeID", $currentUserTypeID);

                                        oci_execute($strSQL);

                                        while ($typeRow = oci_fetch_assoc($strSQL)) {
                                            $selected = ($typeRow['ID'] == $data['USER_TYPE_ID']) ? 'selected' : '';
                                        ?>
                                            <option value="<?= $typeRow['ID'] ?>" <?= $selected ?>>
                                                <?= $typeRow['TITLE'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">Please select a User Type.</div>
                                </div>



                                <!-- <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom04" class="form-label">User Brand <span class="text-danger">*</span> </label>
                                    <select class="form-select" id="validationCustom04" name="USER_BRAND_ID" required="">
                                        <option hidden value="<?php echo Null ?>"><- Select Brand -></option>
                                        <?php
                                        $brandRow = [];
                                        $currentUserBrandID = $_SESSION['USER_SFCM_INFO']['USER_BRAND_ID'];
                                        $query    = "SELECT ID,TITLE FROM USER_BRAND WHERE STATUS ='1' AND ID = $currentUserBrandID";
                                        $strSQL   = @oci_parse($objConnect, $query);

                                        @oci_execute($strSQL);
                                        while ($brandRow = @oci_fetch_assoc($strSQL)) {
                                        ?>
                                            <option value="<?php echo $brandRow['ID'] ?>" <?php echo $brandRow['ID'] == $data['USER_BRAND_ID'] ? 'Selected' : '' ?>>
                                                <?php echo $brandRow['TITLE'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">Please select a User Brand.</div>
                                </div> -->
                                <div class="row mt-3" id="addResponsiableData"></div>
                                <div class="col-12">
                                    <label for="" class="form-label">User Profile Image</label>
                                    <input type="file" name="IMAGE_LINK" class="dropify" data-default-file="<?php echo $basePath . '/' . $data['IMAGE_LINK'] ?>" />
                                    <!-- <div class="valid-feedback">Looks good!</div> -->

                                </div>
                                <div class="col-12 text-center">
                                    <button class="btn btn-primary" type="submit">Submit form</button>
                                </div>
                            </form>
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
    const $LAT = "<?php echo $data['LAT'] ?>";
    const $LANG = "<?php echo $data['LANG'] ?>";
    const $LOCATION_REMARKS = "<?php echo $data['LOCATION_REMARKS'] ?>";

    let url = "<?php echo ($basePath . '/user_module/action/drop_down_panel.php') ?>";
    const $user_type_id = $('select[name="USER_TYPE_ID"]');
    const $user_brand_id = $('select[name="USER_BRAND_ID"]');

    $('select[name="USER_TYPE_ID"]').on('change', function() {
        getVerifyData();
    });

    function getVerifyData() {
        const userTypeId = $user_type_id.val();
   
        $('#addResponsiableData').empty();
        if (parseInt(userTypeId) == 4) {
            let htmlTag = ''; // Initialize htmlTag
            htmlTag += `<div class="col-sm-12 col-md-4">
                                    <label for="validationCustom12" class="form-label">Loc. LAT. <span class="text-danger">*</span></label>
                                    <input type="text" name="LAT" value="${$LAT}"  autocomplete="off" class="form-control" id="validationCustom12" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div><div class="col-sm-12 col-md-4">
                                    <label for="validationCustom13" class="form-label">Loc. LANG. <span class="text-danger">*</span></label>
                                    <input type="text" name="LANG" value="${$LANG}" autocomplete="off" class="form-control" id="validationCustom13" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="validationCustom14" class="form-label">Address Location <span class="text-danger">*</span></label>
                                    <input type="text" name="LOCATION_REMARKS" autocomplete="off" class="form-control" id="validationCustom14" value="${$LOCATION_REMARKS}" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>`;
            $('#addResponsiableData').append(htmlTag);
        }
    }



    function get_selExc() {
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            data: {
                brand_ID: $user_brand_id.val(),
                type_ID: 3,
            },
            success: function(res) {
                let htmlTag = `<div class="col-sm-12 col-md-4">
                            <label for="validationCustom10_sale" class="form-label">Responsible SALE EXECUTIVE <span class="text-danger">*</span></label>
                            <select class="form-select single-select"  name="RESPONSIBLE_ID" id="validationCustom10_sale" required>
                            <option  hidden value="<?php echo Null ?>"> <- Selecte Sale Excutive -></option>`;
                if (res.status) {
                    (res.data).forEach(element => {
                        htmlTag += '<option value="' + element.ID + '" ' + ($RESPONSIBLE_ID == element.ID ? 'selected' : '') + '> ' + element.USER_NAME + ' </option>';
                    });
                }
                htmlTag += `</select></div>`;

                // Initialize Select2 for the appended dropdown element
                $('#addResponsiableData').find('#validationCustom10_sale').select2({
                    theme: 'bootstrap4',
                    width: '100%', // Set the width as needed
                    placeholder: 'Select Sale Excutive', // Set the placeholder text
                    allowClear: true, // Enable clearing the selection
                });
            }
        });

    }

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict'
        $('.dropify').dropify({
            messages: {
                'default': 'Select User Profile Image',
                'replace': 'Replace User Profile Image',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });
        getVerifyData();
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validations')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            });
    })();
</script>