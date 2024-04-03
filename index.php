<?php
session_start();
session_regenerate_id(TRUE);
require_once('./_config/connoracle.php');
include_once('./config_file_path.php');

if (isset($_POST['login_submit'])) {

    if (!empty($_POST['user_mobile']) && !empty($_POST['password'])) {
        $v_usermobile = trim($_POST['user_mobile']);
        $v_password   = trim($_POST['password']);
        $md5Password  = md5($v_password);
        $query = "SELECT UP.ID, UP.USER_NAME, UP.USER_MOBILE, 
                    UP.RML_IDENTITY_ID, UP.USER_PASSWORD, UP.IMAGE_LINK,
                    UP.USER_TYPE_ID,
                    (SELECT TITLE FROM USER_TYPE WHERE ID = UP.USER_TYPE_ID) AS USER_TYPE,
                    LISTAGG(UBS.PRODUCT_BRAND_ID, ', ') WITHIN GROUP (ORDER BY UBS.PRODUCT_BRAND_ID) AS USER_BRANDS
                FROM USER_PROFILE UP
                LEFT JOIN USER_BRAND_SETUP UBS ON UP.ID = UBS.USER_PROFILE_ID
                WHERE   UBS.STATUS = 1 AND UP.USER_MOBILE ='$v_usermobile' AND UP.USER_PASSWORD = '$md5Password' AND UP.USER_STATUS = 1
                GROUP BY UP.ID, UP.USER_NAME, UP.USER_MOBILE, UP.RML_IDENTITY_ID, UP.USER_PASSWORD, UP.IMAGE_LINK, UP.USER_TYPE_ID";



        $strSQL = @oci_parse($objConnect, $query);
        @oci_execute($strSQL);
        $dataRow = @oci_fetch_assoc($strSQL);

        if ($dataRow) {
            unset($dataRow['USER_PASSWORD']);
            $_SESSION['USER_CSPD_INFO']     = $dataRow;
            $_SESSION['baseUrl']            = $baseUrl;
            $_SESSION['cspdBasePath']       = $cspdBasePath;
            $_SESSION['rs_img_path']        = $rs_img_path;
            header('location:home/dashboard.php');
            exit;
        } else {
            $errorMsg = "Wrong EMP-ID or password";
        }
    }
}

if (isset($_GET['logout_hr']) && $_GET['logout_hr'] == true) {
    $cspdBasePath    = $_SESSION['cspdBasePath'];
    $rs_img_path = $_SESSION['rs_img_path'];
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(), '', 0, '/');
    session_regenerate_id(true);
    header("location:" . $cspdBasePath . "/index.php");
    exit;
}

?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png">
    <!--plugins-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet">
    <script src="assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="../../../css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <title>CSPD-SYSTEM | RML</title>
</head>

<body class="bg-login">
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="card rounded-4">
                            <div class="card-body">
                                <div class="border p-4 rounded-4">
                                    <div class="text-center">
                                        <img src="assets/images/logo-img.png" width="200" alt="">
                                        <h5 class="mt-3 mb-0"><u> CSPD - SYSTEM </u></h5>
                                        <p class="mb-4">Please Login Before Enter The Dashboard.</p>
                                    </div>

                                    <div class="form-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="row g-3">
                                            <div class="col-12">
                                                <label for="inputEmailAddress" class="form-label">USER MOBILE NUMBER</label>
                                                <input type="text" name="user_mobile" class="form-control rounded-5" onkeypress='return event.charCode >= 48 && event.charCode <= 57' id="inputEmailAddress" autocomplete="off" required placeholder="">
                                            </div>
                                            <div class="col-12">
                                                <label for="inputChoosePassword" class="form-label">Password</label>

                                                <input type="password" name="password" class="form-control rounded-5" id="inputChoosePassword" required autocomplete="off" placeholder="">
                                            </div>


                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" name="login_submit" class="btn btn-gradient-info rounded-5">
                                                        <i class="bx bxs-lock-open"></i>Sign in
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center">
                                                <p class="mb-0">New on our platform? Contract With <strong><u>RML IT & ERP</u>.</strong></p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <!--Password show & hide js -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <!--app JS-->
    <script src="assets/js/app.js"></script>
</body>

</html>