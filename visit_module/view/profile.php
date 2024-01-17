<?php
$dynamic_link_js[]  = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js';
$dynamic_link_css[] = 'https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css';
include_once('../../_helper/2step_com_conn.php');
$data = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && trim($_GET["actionType"]) == 'profileEdit') {
    $edit_id = trim($_GET["id"]);
    $query   = "SELECT UP.ID,
    UP.USER_NAME,
    UP.USER_MOBILE,
    UP.RML_ID,
    UP.PENDRIVE_ID,
    UP.IMAGE_LINK,
    (SELECT TITLE
    FROM USER_BRAND
    WHERE ID = UP.USER_BRAND_ID)
    AS USER_BRAND, 
    ( SELECT TITLE FROM     USER_TYPE WHERE ID = UP.USER_TYPE_ID) AS USER_TYPE
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
                    $headerType   = 'Edit';
                    $leftSideName = 'User Profile';
                    include('../../_includes/com_header.php');

                    ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <img src="<?php echo $_SESSION['USER_INFO']['IMAGE_LINK'] != null ? ($basePath . '/' . $_SESSION['USER_INFO']['IMAGE_LINK']) : $basePath . '/' . "assets/images/avatars/default_user.png"; ?>"
                                                alt="user_image" class="rounded-circle p-1 bg-primary" width="110">
                                            <div class="mt-3">
                                                <h4>
                                                    <?php echo $data['USER_NAME'] ?>
                                                </h4>
                                                <p class="text-secondary mb-1 text-start">
                                                    <strong><i class='bx bxs-mobile-vibration'></i> MOBILE :
                                                        <span class="text-primary">
                                                            <?php echo $data['USER_MOBILE'] ?>
                                                        </span>
                                                    </strong>
                                                </p>
                                                <p class="text-secondary mb-1 text-start">
                                                    <strong><i class='bx bx-bookmark'></i> RML-ID :
                                                        <span class="text-primary">
                                                            <?php echo $data['RML_ID'] ?>
                                                        </span>
                                                    </strong>
                                                </p>
                                                <p class="text-secondary mb-1 text-start">
                                                    <strong><i class='bx bx-git-branch'></i> BRAND :
                                                        <span class="text-primary">
                                                            <?php echo $data['USER_BRAND'] ?>
                                                        </span>
                                                    </strong>
                                                </p>
                                                <p class="text-secondary mb-1 text-start">
                                                    <strong><i class='bx bxl-jquery'></i> TYPE :
                                                        <span class="text-primary">
                                                            <?php echo $data['USER_TYPE'] ?>
                                                        </span>
                                                    </strong>

                                                </p>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST"
                                        action=" <?php echo ($basePath . '/visit_module/action/self_panel.php') ?>"

                                            class="row g-3" enctype="multipart/form-data" >
                                            <input type="hidden" name="actionType" value="profileUpdate">
                                            <input type="hidden" name="editId" value="<?php echo trim($_GET["id"]) ?>">
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Your Name <span class="text-danger">*</span></h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input type="text" name="user_name" class="form-control" value="<?php echo $data['USER_NAME'] ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Your Password</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <div class="input-group mb-3">
                                                        <input type="password" name="user_password" class="form-control" id="password"
                                                            placeholder="*****" aria-label="*****" aria-describedby="basic-addon2">
                                                        <span style="cursor: pointer;color:darkred" class="input-group-text typeChange"
                                                            id="basic-addon2 "><i class='bx bxs-low-vision'></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Your Image </h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input type="file" name="user_image"
                                                        data-default-file="<?php echo $basePath . '/' . $data['IMAGE_LINK'] ?>" class="dropify" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="text-end text-secondary">
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class='bx bxs-save'></i> Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
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
    (function () {
        'use strict'

        $('.dropify').dropify({
            messages: {
                'default': 'Profile Picture',
                'replace': 'Replace Profile Picture',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });

        $('.typeChange').on('click', function () {

            // Your code to toggle password visibility goes here
            var passwordInput = $('#password');
            var icon = $(this).find('i');
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('bxs-low-vision').addClass('bxs-show');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('bxs-show').addClass('bxs-low-vision');
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
    })()
</script>