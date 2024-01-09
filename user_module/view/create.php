<?php
$dynamic_link_js[]  = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js';
$dynamic_link_css[] = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css';
include_once('../../_helper/2step_com_conn.php');


?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <?php
                    $headerType    = 'Create';
                    $leftSideName  = 'User Create';
                    $rightSideName = 'User List';
                    $routePath     = 'user_module/view/index.php';
                    include('../../_includes/com_header.php');

                    ?>
                    <div class="card-body">
                        <div class="p-4 border rounded">
                            <form method="post" action="<?php echo ($basePath . '/user_module/action/self_panel.php') ?>"
                                class="row g-3 needs-validation" enctype="multipart/form-data" novalidate="">
                                <input type="hidden" name="actionType" value="create">
                                <div class="col-sm-12 col-md-4">
                                    <label for="validationCustom01" class="form-label">User Name <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" name="USER_NAME" class="form-control" id="validationCustom01" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom02" class="form-label">User Mobile (Login ID) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                        autocomplete="off" autocomplete="off" name="USER_MOBILE" id="validationCustom02" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom08" class="form-label">User Password <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="USER_PASSWORD" autocomplete="off" id="validationCustom08"
                                        required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom09" class="form-label">User RML ID </label>
                                    <input type="text" class="form-control" name="RML_ID" autocomplete="off" id="validationCustom09">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>


                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom06" class="form-label">User Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="validationCustom06" name="USER_TYPE_ID" required="">
                                        <option hidden value="<?php echo Null ?>"><- Select Type -></option>
                                        <?php
                                        $typeRow = [];
                                        $query   = "SELECT ID,TITLE FROM USER_TYPE WHERE STATUS ='1'";
                                        $strSQL  = @oci_parse($objConnect, $query);

                                        @oci_execute($strSQL);
                                        while ($typeRow = @oci_fetch_assoc($strSQL)) {
                                            ?>
                                            <option value="<?php echo $typeRow['ID'] ?>">
                                                <?php echo $typeRow['TITLE'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">Please select a User Type.</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom04" class="form-label">User Brand <span class="text-danger">*</span> </label>
                                    <select class="form-select" id="validationCustom04" name="USER_BRAND_ID" required="">
                                        <option hidden value="<?php echo Null ?>"><- Select Brand -></option>
                                        <?php
                                        $brandRow = [];
                                        $query    = "SELECT ID,TITLE FROM USER_BRAND WHERE STATUS ='1'";
                                        $strSQL   = @oci_parse($objConnect, $query);

                                        @oci_execute($strSQL);
                                        while ($brandRow = @oci_fetch_assoc($strSQL)) {
                                            ?>
                                            <option value="<?php echo $brandRow['ID'] ?>">
                                                <?php echo $brandRow['TITLE'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">Please select a User Brand.</div>
                                </div>
                                <div id="addResponsiableData"></div>

                                <div class="col-12">
                                    <label for="" class="form-label">User Profile Image</label>
                                    <input type="file" name="IMAGE_LINK" class="dropify" />
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
    const url = "<?php echo ($basePath . '/user_module/action/drop_down_panel.php') ?>";
    let $user_type_id = $('select[name="USER_TYPE_ID"]');
    let $user_brand_id = $('select[name="USER_BRAND_ID"]');
    $('select[name="USER_TYPE_ID"]').on('change', function () {
        $('#addResponsiableData').empty();
        if ($user_type_id.val() == 2) {
            get_hod();
        } else if ($user_type_id.val() == 3) {
            get_cod();
        } else if ($user_type_id.val() == 4) {
            get_selExc();
        } else if ($user_type_id.val() == 5) {
            get_mec();
        }
        console.log($user_type_id.val());
        console.log($user_brand_id.val());
    });
    function get_hod() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            data: {
                brand_ID: $user_brand_id.val(),
                type_ID: 1,
            },
            success: function (res) {
                console.log(res);
                let htmlTag = `<div class="col-sm-12 col-md-4">
                            <label for="validationCustom10" class="form-label">Responsible HOD <span class="text-danger">*</span></label>
                            <select class="form-select" id="validationCustom10" required>
                            <option  hidden value="<?php echo Null ?>"> <- Selecte HOD -></option>`;
                if (res.status) {
                    (res.data).forEach(element => {
                        console.log(element);
                        htmlTag += '<option value="' + element.ID + '"> ' + element.USER_NAME + ' </option>';
                    });

                }
                htmlTag += `</select></div>`;
                $('#addResponsiableData').append(htmlTag);
            }
        });

    }
    function get_cod() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "method",
            url: "url",
            dataType: "json",
            data: {
                brand_ID: $user_brand_id.val(),
                type_ID: 2,
            },
            success: function (res) {
                console.log(res);
                let htmlTag = `<div class="col-sm-12 col-md-4">
                            <label for="validationCustom10" class="form-label">Responsible COORDINATOR <span class="text-danger">*</span></label>
                            <select class="form-select" id="validationCustom10" required>
                            <option  hidden value="<?php echo Null ?>"> <- Selecte Coordinator -></option>`;
                if (res.status) {
                    (res.data).forEach(element => {
                        console.log(element);
                        htmlTag += '<option value="' + element.ID + '"> ' + element.USER_NAME + ' </option>';
                    });

                }
                htmlTag += `</select></div>`;
                $('#addResponsiableData').append(htmlTag);
            }
        });
        let htmlTag = `<div class="col-sm-12 col-md-4">
            <label for="validationCustom10" class="form-label">Responsible COORDINATOR <span class="text-danger">*</span></label>
            <select class="form-select" id="validationCustom10" required>
                <option  hidden value="<?php echo Null ?>"> <- Selecte Coordinator -></option>
                <option value="1">One</option>
            </select>
        </div>`;
        $('#addResponsiableData').append(htmlTag);

    }
    function get_mec() {
        let htmlTag = `<div class="col-sm-12 col-md-4">
            <label for="validationCustom10" class="form-label">Responsible RETAILER <span class="text-danger">*</span></label>
            <select class="form-select" id="validationCustom10" required>
                <option  hidden value="<?php echo Null ?>"> <- Selecte Retailer-></option>
                <option value="1">One</option>
            </select>
        </div>`;
        $('#addResponsiableData').append(htmlTag);

    }
    function get_selExc() {
        let htmlTag = `<div class="col-sm-12 col-md-4">
            <label for="validationCustom10" class="form-label">Responsible SALE EXECUTIVE <span class="text-danger">*</span></label>
            <select class="form-select" id="validationCustom10" required>
                <option  hidden value="<?php echo Null ?>"> <- Selecte Sale Excutive -></option>
                <option value="1">One</option>
            </select>
        </div>`;
        $('#addResponsiableData').append(htmlTag);

    }

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        $('.dropify').dropify({
            messages: {
                'default': 'Select User Profile Image',
                'replace': 'Replace User Profile Image',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })();


</script>