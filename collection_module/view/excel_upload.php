<?php
$dynamic_link_css[] = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css';
$dynamic_link_js[]  = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js';
$dynamic_link_js[]  = 'https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js';
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
                                    <input type="file" id="excel_file" name="excel_file" class="form-control dropify" required="" data-allowed-file-extensions="xlsx xlsm xlsb xltx xltm xls xlt" />

                                </div>
                            </form>
                        </div>
                        <div id="excel_data" class="mt-5"></div>
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

    // excel  file upload function
    const excel_file = document.getElementById('excel_file');

    excel_file.addEventListener('change', (event) => {
        event.preventDefault(); // Prevent default form submission

        if (!['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'].includes(excel_file.files[0].type)) {
            document.getElementById('excel_data').innerHTML = '<div class="alert alert-danger">Only .xlsx or .xls file format are allowed</div>';

            excel_file.value = '';

            return false;
        }

        var reader = new FileReader();

        reader.readAsArrayBuffer(excel_file.files[0]);

        reader.onload = function(event) {

            var data = new Uint8Array(reader.result);

            var work_book = XLSX.read(data, {
                type: 'array'
            });

            var sheet_name = work_book.SheetNames;

            var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {
                header: 1
            });

            if (sheet_data.length > 0) {
                var table_output = '<table class="table table-striped table-bordered">';

                for (var row = 0; row < sheet_data.length; row++) {

                    table_output += '<tr>';

                    for (var cell = 0; cell < sheet_data[row].length; cell++) {

                        if (row == 0) {
                            // Header row
                            table_output += '<th>' + sheet_data[row][cell] + '</th>';
                        } else {
                            // Data row
                            table_output += '<td>' + sheet_data[row][cell] + '</td>';
                        }
                    }



                    table_output += '</tr>';

                }
                table_output += '<tr class="text-center"> <td colspan="9"><button class="btn btn-gradient-info" onclick="processData()">Process Excel Data <i class="bx bxs-arrow-from-bottom"></i> </button></td></tr>';
                table_output += '</table>';

                document.getElementById('excel_data').innerHTML = table_output;
            }

            excel_file.value = '';

        }
    });

    function processData() {
        var table = document.getElementById('excel_data').getElementsByTagName('table')[0];
        var allData = [];

        // Iterate over each row in the table except the first one (header row)
        for (var row = 1; row < table.rows.length; row++) {
            var rowData = [];

            // Iterate over each cell in the row
            for (var cell = 0; cell < table.rows[row].cells.length - 1; cell++) {
                rowData.push(table.rows[row].cells[cell].innerHTML);
            }

            // Push the row data to the allData array
            allData.push(rowData);
        }

        console.log(allData);
        // Prepare data to be sent
        var requestData = {
            data: allData
        };
        let URL = "<?php echo ($cspdBasePath . '/collection_module/action/uploadExcel.php') ?>";
        // Send data using AJAX
        fetch(URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                if (response.ok) {
                    // Successful response
                    console.log('Data sent successfully');
                } else {
                    // Handle errors
                    console.error('Error while sending data');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>