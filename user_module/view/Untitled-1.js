<?php
$dynamic_link_js[]  = 'https://cdnjs.cloudflare.com/ajax/libs/orgchart/2.1.3/js/jquery.orgchart.min.js';
$dynamic_link_css[] = 'https://cdnjs.cloudflare.com/ajax/libs/orgchart/2.1.3/css/jquery.orgchart.min.css';
$dynamic_link_css[] = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css';
include_once('../../_helper/2step_com_conn_without_sidebar.php');
?>

<!--start page wrapper -->
<div class="page-wrappers">
    <div class="page-content">


        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <?php
                    $headerType    = 'List';
                    $leftSideName  = 'User Tree List ';
                    include('../../_includes/com_header.php');

                    ?>
                    <div class="card-body">
                        <div id="chart-container"></div>
                        <a id="github-link" href="https://github.com/dabeng/OrgChart" target="_blank"><i class="fa fa-github-square"></i></a>
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