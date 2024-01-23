<?php

include_once('../../_helper/2step_com_conn.php');
$data = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'edit') {
    $edit_id = trim($_GET["id"]);
    $query   = "SELECT *
    FROM VISIT_TYPE  WHERE ID = $edit_id";
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
                    $leftSideName  = 'Visit Type Edit';
                    include('../../_includes/com_header.php');

                    ?>
                    <div class="card-body">
                        <div class="p-4 border rounded">
                            <form 
                            action="<?php echo ($basePath . '/admin_module/action/self_panel.php') ?>" 
                            method="POST" class="row g-3 needs-validations">
                                <input type="hidden" name="actionType" value="vt_edit">
                                <input type="hidden" name="editId" value="<?php echo trim($_GET["id"]) ?>">
                                <div class="col-sm-12 col-md-4">
                                    <label for="validationCustom01" class="form-label">User Name <span class="text-danger">*</span></label>
                                    <input type="text" name="TITLE" autocomplete="off" class="form-control" id="validationCustom01" value="<?php echo $data['TITLE'] ?>" required>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <label for="validationCustom06" class="form-label">Satatus <span class="text-danger">*</span></label>
                                    <select class="form-select" id="validationCustom06" name="STATUS" required>
                                        <option value="1" <?= ($data['STATUS'] == 1) ? 'selected' : ''; ?>> Active </option>
                                        <option value="0" <?= ($data['STATUS'] == 0) ? 'selected' : ''; ?>> Deactive </option>
                                    </select>
                                    <div class="invalid-feedback">Please select a Satatus Type.</div>
                                </div>

                                <div class="col-12 text-center">
                                    <button  type="submit" class="btn btn-sm btn-primary">Update Data</button>
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
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict'

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