<?php
session_start();
include_once('../../_config/connoracle.php');
include_once('../../config_file_path.php');

$coodinoatorData = array();
$selfData = array();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userID = $_GET['id'];
    //Self Data 
    $query    = "SELECT ID, USER_NAME FROM USER_PROFILE WHERE  ID = $userID";
    $strSQL = @oci_parse($objConnect, $query);
    if (@oci_execute($strSQL)) {
        $selfData = @oci_fetch_assoc($strSQL);
    }
    //END Self Data 
    // coodinoatorData
    $query2    = "SELECT ID, USER_NAME FROM USER_PROFILE WHERE USER_TYPE_ID = 2 AND RESPONSIBLE_ID = $userID";
    $strSQL = @oci_parse($objConnect, $query2);
    if (@oci_execute($strSQL)) {
        while ($row = @oci_fetch_assoc($strSQL)) {
            $coodinoatorData[] = $row; // Append each row to the $data array
        }
    }
    //end coodinoatorData
}
$cspdBasePath    = $_SESSION['cspdBasePath'];
?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <title>CSPD-SYSTEM | RML</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <!--favicon-->
    <link rel="icon" href="<?php echo $cspdBasePath ?>assets/images/favicon-32x32.png" type="image/png">
    <!--plugins-->
    <!-- Bootstrap CSS -->
    <link href="<?php echo $cspdBasePath ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $cspdBasePath ?>/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="../../../css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?php echo $cspdBasePath ?>/assets/css/app.css" rel="stylesheet">
    <link href="<?php echo $cspdBasePath ?>/assets/css/icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/orgchart/2.1.3/css/jquery.orgchart.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<style>
    #chart-container {
        font-family: Arial;
        height: 450px;
        border: 2px dashed #0ce983;
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

    .orgchart .first-level .title {
        background-color: red;
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

<body class="bg-tree ">

    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col mx-auto">
                        <div class="card bg-gradient-moonlit shadow rounded-4 overflow-hidden">
                            <div class="card-body text-center">
                                <h5 class="card-title text-white">
                                    User Member Tree for <?php echo $_SESSION['USER_CSPD_INFO']['USER_NAME'] ?>
                                    <span><i class="fa fa-sort-amount-asc text-info" aria-hidden="true"></i></span>

                                </h5>

                            </div>
                        </div>
                        <div class="card rounded-4">
                            <div class="card-bodys">
                                <div class="borders p-3 rounded-4">
                                    <div id="chart-container"></div>

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
    <script src="<?php echo $cspdBasePath ?>/assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="<?php echo $cspdBasePath ?>/assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/orgchart/2.1.3/js/jquery.orgchart.min.js"></script>
    <!--Password show & hide js -->

    <!--app JS-->
    <script src="assets/js/app.js"></script>
    <script>
        var selfData = <?php echo json_encode($selfData); ?>;
        var coodinoatorData = <?php echo json_encode($coodinoatorData); ?>;

        var buildHierarchy = function(data) {
            var hierarchy = {
                name: selfData.USER_NAME,
                title: "HOD",
                className: "first-level",
                children: [],
            };

            var coordinatorPromises = [];

            for (var i = 0; i < data.length; i++) {
                (function(userData) {
                    var parentChild = {
                        name: userData.USER_NAME,
                        title: "Coordinator",
                        className: "middle-level",
                        children: []
                    };
                    hierarchy.children.push(parentChild);

                    var coordinatorPromise = new Promise(function(resolve, reject) {
                        $.ajax({
                            type: "GET",
                            url: "<?php echo ($cspdBasePath . '/user_module/action/getSaleExecutive.php') ?>",
                            data: {
                                coordinator: userData.ID
                            },
                            dataType: "JSON",
                            success: function(res) {
                                var executivePromises = [];

                                for (var j = 0; j < res.data.length; j++) {
                                    (function(executiveData) {
                                        var child = {
                                            name: executiveData.USER_NAME,
                                            title: "Sale Executive",
                                            className: "product-dept",
                                            children: []
                                        };
                                        parentChild.children.push(child);

                                        var executivePromise = new Promise(function(resolve, reject) {
                                            $.ajax({
                                                type: "GET",
                                                url: "<?php echo ($cspdBasePath . '/user_module/action/getSaleExecutive.php') ?>",
                                                data: {
                                                    sale_executive: executiveData.ID
                                                },
                                                dataType: "JSON",
                                                success: function(res) {
                                                    var retailerPromises = [];

                                                    for (var k = 0; k < res.data.length; k++) {
                                                        (function(retailerData) {
                                                            var subChild = {
                                                                name: retailerData.USER_NAME,
                                                                title: "Retailer",
                                                                className: "frontend1",
                                                                children: []
                                                            };
                                                            child.children.push(subChild);

                                                            var retailerPromise = new Promise(function(resolve, reject) {
                                                                // Add AJAX call to get Mechanics data
                                                                $.ajax({
                                                                    type: "GET",
                                                                    url: "<?php echo ($cspdBasePath . '/user_module/action/getSaleExecutive.php') ?>",
                                                                    data: {
                                                                        retailer: retailerData.ID
                                                                    },
                                                                    dataType: "JSON",
                                                                    success: function(res) {
                                                                        for (var jk = 0; jk < res.data.length; jk++) {
                                                                            var subsubChild = {
                                                                                name: res.data[jk].USER_NAME,
                                                                                title: "Mechanics",
                                                                                className: "pipeline1",
                                                                                children: []
                                                                            };
                                                                            subChild.children.push(subsubChild);
                                                                        }
                                                                        resolve(); // Resolve the retailerPromise after adding all Mechanics
                                                                    }
                                                                });
                                                            });

                                                            retailerPromises.push(retailerPromise);
                                                        })(res.data[k]);
                                                    }

                                                    Promise.all(retailerPromises).then(function() {
                                                        resolve(); // Resolve the executivePromise after all retailerPromises are resolved
                                                    });
                                                }
                                            });
                                        });

                                        executivePromises.push(executivePromise);
                                    })(res.data[j]);
                                }

                                Promise.all(executivePromises).then(function() {
                                    resolve(); // Resolve the coordinatorPromise after all executivePromises are resolved
                                });
                            }
                        });
                    });

                    coordinatorPromises.push(coordinatorPromise);
                })(data[i]);
            }

            Promise.all(coordinatorPromises).then(function() {
                // Re-render org chart after adding all children
                $("#chart-container").empty().orgchart({
                    data: hierarchy,
                    nodeContent: "title"
                });
            });

            return hierarchy;
        };

        // ... (remaining code)



        $(function() {
            var chartData = buildHierarchy(coodinoatorData);
        });
    </script>


</body>

</html>