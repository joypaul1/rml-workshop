<?php
$dynamic_link_js[]  = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js';
$dynamic_link_css[] = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2.min.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2-bootstrap4.css';
$dynamic_link_js[]  = '../../assets/plugins/select2/js/select2.min.js';
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
                            <form method="post" action="<?php echo ($sfcmBasePath . '/user_module/action/self_panel.php') ?>" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate="">
                                <input type="hidden" name="actionType" value="create">
                                <div class="col-sm-12 col-md-4">
                                    <label for="validationCustom01" class="form-label">User Name <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" name="USER_NAME" class="form-control" id="validationCustom01" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom02" class="form-label">User Mobile (Login ID) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' autocomplete="off" autocomplete="off" name="USER_MOBILE" id="validationCustom02" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom08" class="form-label">User Password <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="USER_PASSWORD" autocomplete="off" id="validationCustom08" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom09" class="form-label">User RML/RMLW ID </label>
                                    <input type="text" class="form-control" name="RML_ID" autocomplete="off" id="validationCustom09">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>


                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom06" class="form-label">User Type <span class="text-danger">*</span></label>
                                    <select class="form-select " id="validationCustom06" name="USER_TYPE_ID" required="">
                                        <option hidden value="<?php echo Null ?>"><- Select Type -></option>
                                        <?php
                                        $typeRow = [];
                                        $currentUserTypeID = $_SESSION['USER_SFCM_INFO']['USER_TYPE_ID'];
                                        $query   = "SELECT ID,TITLE FROM USER_TYPE WHERE STATUS ='1'  
                                        AND ID > '$currentUserTypeID'  ORDER BY ID ASC ";
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


                                <div class="row mt-3" id="addResponsiableData"></div>

                                <div class="col-12">
                                    <label for="" class="form-label">User Profile Image</label>
                                    <input type="file" name="IMAGE_LINK" class="dropify" />
                                    <!-- <div class="valid-feedback">Looks good!</div> -->

                                </div>
                                <div class="col-12 text-center">
                                    <button class="btn btn-primary" type="submit">Create Data</button>
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
    const url = "<?php echo ($sfcmBasePath . '/user_module/action/drop_down_panel.php') ?>";
    const $user_type_id = $('select[name="USER_TYPE_ID"]');


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
                                <input type="text" name="LAT" autocomplete="off" class="form-control" id="validationCustom12" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div><div class="col-sm-12 col-md-4">
                                <label for="validationCustom13" class="form-label">Loc. LANG. <span class="text-danger">*</span></label>
                                <input type="text" name="LANG" autocomplete="off" class="form-control" id="validationCustom13" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label for="validationCustom14" class="form-label">Address Location <span class="text-danger">*</span></label>
                                <input type="text" name="LOCATION_REMARKS" autocomplete="off" class="form-control" id="validationCustom14" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>`;
            $.ajax({
                type: "GET",
                url: url,
                dataType: "JSON",
                data: {
                    district_data: true,
                },
                success: function(res) {
                    htmlTag += `<div class="col-sm-12 col-md-4 mt-3">
                        <label for="validationCustom10_hod"  class="form-label"> Retailer District <span class="text-danger">*</span></label>
                        <select class="form-select single-select" name="DISTRICT_ID" id="validationCustom10_hod" required>
                        <option  hidden value="<?php echo Null ?>"> <- Selecte District -></option>`;
                    if (res.status) {
                        (res.data).forEach(element => {
                            htmlTag += '<option value="' + element.ID + '"> ' + element.NAME + ' </option>';
                        });
                    }
                    htmlTag += `</select></div>`;
                    $('#addResponsiableData').append(htmlTag);
                    // Initialize Select2 for the appended dropdown element
                    $('#addResponsiableData').find('#validationCustom10_hod').select2({
                        theme: 'bootstrap4',
                        width: '100%', // Set the width as needed
                        placeholder: 'Select District', // Set the placeholder text
                        allowClear: true, // Enable clearing the selection
                    });
                }

            })
        }
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

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

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