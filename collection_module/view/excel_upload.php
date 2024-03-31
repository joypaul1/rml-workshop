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
                    $leftSideName  = 'Collection Data Excel Upload';
                    include('../../_includes/com_header.php');

                    ?>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body border rounded " style="background: #8fbc8f6b;">
                                <div class="text-center">
                                    <strong class="text-danger"><u>**** Note ****</u></strong>
                                </div>
                                <span class="d-flex flex-column gap-1 text-danger fw-bold">
                                    <span><i class="bx bxs-chevrons-right font-18 align-middle me-1"></i> Do Not Change/Modify USER_ID & BRAND_ID Column data.</span>
                                    <span><i class="bx bxs-chevrons-right font-18 align-middle me-1"></i> Do Not Change Start Date & End Date format.</span>
                                    <span><i class="bx bxs-chevrons-right font-18 align-middle me-1"></i> If any single User don't need?You can Delete that User Row.</span>
                                </span>
                            </div>
                        </div>
                        <div class="p-4 border rounded">
                            <div class="col-12 text-center">
                                <a href="excel_download.php?brand_type=1&brand_name=Mahindra" class="btn btn-gradient-primary"> Mahindra Excel File Download <i class='bx bxs-download'></i> </a>
                                <a href="excel_download.php?brand_type=2&brand_name=Eicher" class="btn btn-gradient-success"> Eicher Excel File Download <i class='bx bxs-download'></i> </a>

                            </div>

                            <form method="POST" action="<?php echo ($cspdBasePath . '/collection_module/action/uploadExcel.php') ?>" class="row g-3 needs-validation mt-2" enctype="multipart/form-data" novalidate="">
                                <input type="hidden" name="importSubmit" value="importSubmit">

                                <div class="col-12">
                                    <!-- <label for="" class="form-label">Select Collection Target Excel File</label> -->
                                    <input type="file" name="file" class="form-control dropify" required="" data-allowed-file-extensions="xlsx xlsm xlsb xltx xltm xls xlt" />

                                </div>

                                <div class="col-12 text-center">
                                    <button class="btn btn-primary" type="submit"> Upload Data <i class='bx bxs-arrow-from-bottom'></i> </button>
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
        $('.dropify').dropify({
            messages: {
                'default': 'Collection Target Excel File',
                'replace': 'Replace Excel File',
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