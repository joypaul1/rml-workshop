<?php
session_start();
session_regenerate_id(TRUE);
include_once('../../_config/connoracle.php');
include_once('../../config_file_path.php');

if (isset($_POST['login_submit'])) {

    if (!empty($_POST['user_mobile']) && !empty($_POST['password'])) {
        $v_usermobile = trim($_POST['user_mobile']);
        $v_password   = trim($_POST['password']);
        $md5Password  = md5($v_password);

        $sql    = "SELECT 
                ID, USER_NAME, USER_MOBILE, 
                RML_ID, USER_PASSWORD, USER_BRAND_ID, IMAGE_LINK,
                USER_TYPE_ID, USER_STATUS FROM USER_PROFILE WHERE USER_MOBILE ='$v_usermobile' and USER_PASSWORD = '$v_password'";
        $strSQL = @oci_parse($objConnect, $sql);
        @oci_execute($strSQL);
        $dataRow = @oci_fetch_assoc($strSQL);
        if ($dataRow) {
            unset($dataRow['USER_PASSWORD']);

            $_SESSION['USER_INFO']   = $dataRow;
            $_SESSION['baseUrl']     = $baseUrl;
            $_SESSION['basePath']    = $basePath;
            $_SESSION['rs_img_path'] = $rs_img_path;
            header('location:home/dashboard.php');
            exit;
        } else {
            $errorMsg = "Wrong EMP-ID or password";
        }
    }
}

if (isset($_GET['logout_hr']) && $_GET['logout_hr'] == true) {
    $basePath    = $_SESSION['basePath'];
    $rs_img_path = $_SESSION['rs_img_path'];
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(), '', 0, '/');
    session_regenerate_id(true);
    header("location:" . $basePath . "/index.php");
    exit;
}

?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <title>SFCM-SYSTEM | RML</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <!--favicon-->
    <link rel="icon" href="<?php echo $basePath ?>assets/images/favicon-32x32.png" type="image/png">
    <!--plugins-->
    <!-- Bootstrap CSS -->
    <link href="<?php echo $basePath ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $basePath ?>/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="../../../css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?php echo $basePath ?>/assets/css/app.css" rel="stylesheet">
    <link href="<?php echo $basePath ?>/assets/css/icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/orgchart/2.1.3/css/jquery.orgchart.min.css" rel="stylesheet">
</head>
<style>
    #chart-container {
        font-family: Arial;
        height: 420px;
        border: 2px dashed #aaa;
        border-radius: 5px;
        overflow: auto;
        text-align: center;
    }

    .orgchart {
        background: #fff;
    }

    .orgchart td.left,
    .orgchart td.right,
    .orgchart td.top {
        border-color: #aaa;
    }

    .orgchart td>.down {
        background-color: #aaa;
    }

    .orgchart .middle-level .title {
        background-color: #006699;
    }

    .orgchart .middle-level .content {
        border-color: #006699;
    }

    .orgchart .product-dept .title {
        background-color: #009933;
    }

    .orgchart .product-dept .content {
        border-color: #009933;
    }

    .orgchart .rd-dept .title {
        background-color: #993366;
    }

    .orgchart .rd-dept .content {
        border-color: #993366;
    }

    .orgchart .pipeline1 .title {
        background-color: #996633;
    }

    .orgchart .pipeline1 .content {
        border-color: #996633;
    }

    .orgchart .frontend1 .title {
        background-color: #cc0066;
    }

    .orgchart .frontend1 .content {
        border-color: #cc0066;
    }

    #github-link {
        position: fixed;
        top: 0px;
        right: 10px;
        font-size: 3em;
    }
</style>

<body class="bg-tree">
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col mx-auto">
                        <div class="card rounded-4">
                            <div class="card-bodys">
                                <div class="borders p-4 rounded-4">
                                    <div id="chart-container"></div>
                                    <a id="github-link" href="https://github.com/dabeng/OrgChart" target="_blank"><i class="fa fa-github-square"></i></a>
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
    <script src="<?php echo $basePath ?>/assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="<?php echo $basePath ?>/assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/orgchart/2.1.3/js/jquery.orgchart.min.js"></script>
    <!--Password show & hide js -->

    <!--app JS-->
    <script src="assets/js/app.js"></script>
    <script>
        "use strict";

        (function($) {
            $(function() {
                var datascource = {
                    name: "MR. Joy",
                    title: "HOD",
                    children: [{
                            name: "Bo Miao",
                            title: "Coordinoator",
                            className: "middle-level",
                            children: [{
                                    name: "Li Jing",
                                    title: "Sale Executive",
                                    className: "product-dept",
                                },
                                {
                                    name: "Li Xin",
                                    title: "Sale Executive",
                                    className: "product-dept",
                                    children: [{
                                            name: "To To",
                                            title: "Retailer",
                                            className: "frontend1"
                                        },
                                        {
                                            name: "Fei Fei",
                                            title: "Retailer",
                                            className: "frontend1",
                                            children: [{
                                                    name: "To To",
                                                    title: "Mechanics",
                                                    className: "rd-dept",
                                                },
                                                {
                                                    name: "Fei Fei",
                                                    title: "Mechanics",
                                                    className: "rd-dept",
                                                }
                                            ],
                                        },
                                        {
                                            name: "Xuan Xuan",
                                            title: "Retailer",
                                            className: "rd-dept",
                                        },
                                    ],
                                },
                            ],
                        },
                        {
                            name: "Su Miao",
                            title: "Coordinoator",
                            className: "middle-level",
                            children: [{
                                    name: "Pang Pang",
                                    title: "Sale Executive",
                                    className: "rd-dept",
                                },
                                {
                                    name: "Hei Hei",
                                    title: "Sale Executive",
                                    className: "rd-dept",
                                    children: [{
                                            name: "Xiang Xiang",
                                            title: "UE Retailer",
                                            className: "frontend1",
                                        },
                                        {
                                            name: "Dan Dan",
                                            title: "Retailer",
                                            className: "frontend1"
                                        },
                                        {
                                            name: "Zai Zai",
                                            title: "Retailer",
                                            className: "frontend1",
                                            children: [{
                                                    name: "To To",
                                                    title: "Mechanics",
                                                    className: "pipeline1",
                                                },
                                                {
                                                    name: "Fei Fei",
                                                    title: "Mechanics",
                                                    className: "pipeline1",
                                                }
                                            ],
                                        },
                                    ],
                                },
                            ],
                        },
                    ],
                };

                var oc = $("#chart-container").orgchart({
                    data: datascource,
                    nodeContent: "title",
                });
            });
        })(jQuery);
    </script>
</body>

</html>