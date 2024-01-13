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
$basePath    = $_SESSION['basePath'];
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
        var selfData = <?php echo json_encode($selfData); ?>;
        var coodinoatorData = <?php echo json_encode($coodinoatorData); ?>;

        var buildHierarchy = function(data) {
            var hierarchy = {
                name: selfData.USER_NAME,
                title: "HOD",
                children: []
            };

            for (var i = 0; i < data.length; i++) {
                (function(userData) {
                    var parentChild = {
                        name: userData.USER_NAME,
                        title: "Coordinator",
                        className: "middle-level",
                        children: []
                    };
                    hierarchy.children.push(parentChild);

                    $.ajax({
                        type: "GET",
                        url: "<?php echo ($basePath . '/user_module/action/getSaleExecutive.php') ?>",
                        data: {
                            coordinator: userData.ID
                        },
                        dataType: "JSON",
                        success: function(res) {
                            for (var j = 0; j < res.data.length; j++) {
                                var child = {
                                    name: res.data[j].USER_NAME,
                                    title: "Sale Executive",
                                    className: "product-dept",
                                    children: []
                                };
                                parentChild.children.push(child);

                                $.ajax({
                                    type: "GET",
                                    url: "<?php echo ($basePath . '/user_module/action/getSaleExecutive.php') ?>",
                                    data: {
                                        sale_executive: res.data[j].ID
                                    },
                                    dataType: "JSON",
                                    success: function(res) {
                                        for (var k = 0; k < res.data.length; k++) {
                                            var subChild = {
                                                name: res.data[k].USER_NAME,
                                                title: "Retailer",
                                                className: "frontend1",
                                                children: []
                                            };
                                            child.children.push(subChild);

                                            $.ajax({
                                                type: "GET",
                                                url: "<?php echo ($basePath . '/user_module/action/getSaleExecutive.php') ?>",
                                                data: {
                                                    retailer: res.data[k].ID
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
                                                    // Re-render org chart after adding all children
                                                    $("#chart-container").empty().orgchart({
                                                        data: hierarchy,
                                                        nodeContent: "title"
                                                    });
                                                }

                                            });


                                        }
                                        // Re-render org chart after adding all children
                                        $("#chart-container").empty().orgchart({
                                            data: hierarchy,
                                            nodeContent: "title"
                                        });
                                    }
                                });
                            }
                            // Re-render org chart after adding all children
                            $("#chart-container").empty().orgchart({
                                data: hierarchy,
                                nodeContent: "title"
                            });
                        }
                    });
                })(data[i]);
            }

            return hierarchy;
        };

        $(function() {
            var chartData = buildHierarchy(coodinoatorData);
        });
    </script>


</body>

</html>