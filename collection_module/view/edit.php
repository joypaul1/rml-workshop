<?php
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2.min.css';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.css';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.date.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2-bootstrap4.css';
$dynamic_link_js[]  = '../../assets/plugins/select2/js/select2.min.js';
$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.js';
$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.date.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js';

include_once('../../_helper/2step_com_conn.php');
$data = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'edit') {
    $edit_id = trim($_GET["id"]);
    $query   = "SELECT CA.ID, CA.START_DATE, CA.END_DATE,CA.TARGET_AMOUNT,
    CA.STATUS,CA.REMARKS, (SELECT USER_NAME FROM USER_PROFILE UP WHERE CA.USER_ID = UP.ID) AS USER_NAME,(SELECT TITLE FROM PRODUCT_BRAND PB WHERE PB.ID = CA.BRAND_ID) AS BRAND_NAME FROM COLLECTION_ASSIGN CA
    WHERE ID = $edit_id";
    $strSQL  = @oci_parse($objConnect, $query);
    @oci_execute($strSQL);
    $data = @oci_fetch_assoc($strSQL);
}

?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="">
                <div class="card rounded-4">
                    <?php
                    // print_r($data);
                    $headerType    = 'Edit';
                    $leftSideName  = 'Collection Edit';
                    $rightSideName = 'Collection List';
                    $routePath     = 'collection_module/view/index.php';
                    include('../../_includes/com_header.php');

                    ?>
                    <div class="card-body">
                        <div class="p-4 border rounded">
                            <form action="<?php echo ($sfcmBasePath . '/collection_module/action/self_panel.php') ?>" method="POST" class="row g-3 needs-validations justify-content-center">
                                <input type="hidden" name="actionType" value="edit">
                                <input type="hidden" name="editId" value="<?php echo trim($_GET["id"]) ?>">


                                <div class="col-4 text-center form-group mb-3">
                                    <label class="form-label"> Collection Start Date: <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input required="" class="form-control text-center datepicker start_date" name="start_date" type="text" value='<?php echo $data['START_DATE']; ?>' />
                                    </div>
                                </div>

                                <div class="col-4 text-center form-group mb-3">
                                    <label class="form-label">Collection End Date: <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input required="" class="form-control text-center datepicker end_date" name="end_date" type="text" value='<?php echo $data['END_DATE']; ?>' />
                                    </div>
                                </div>
                                <div class="col-4 text-center form-group mb-3">
                                    <label for="validationCustom01" class="form-label">Target Amount <span class="text-danger">*</span></label>
                                    <input type="text" name="target_amount" autocomplete="off" class="form-control" id="validationCustom01" value="<?php echo $data['TARGET_AMOUNT'] ?>" required>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-6 text-center form-group mb-3">
                                    <label for="validationCustom01" class="form-label">Any Remarks or Note ?</label>
                                    <input type="text" name="remarks" autocomplete="off" class="form-control" id="validationCustom01" value="<?php echo $data['REMARKS'] ?>">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-sm btn-primary">Update Data</button>
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
    (function() {
        'use strict'
        // Get the current date
        var today = new Date();
        var formattedToday = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();

        // Initialize Pickadate with the min option set to today
        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: true,
            format: 'dd-mm-yyyy',  // Specify your desired date format
            min: new Date(today.getFullYear(), today.getMonth(), 1), // Set min date to the first day of the current month
            onClose: function() {
                // Trigger close event if needed
            }
        });

        // Example starter JavaScript for disabling form submissions if there are invalid fields
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