<?php
$dynamic_link_js[]  = '../assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js';
$dynamic_link_js[]  = '../assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js';
$dynamic_link_js[]  = '../assets/plugins/apexcharts-bundle/js/apexcharts.min.js';
$dynamic_link_js[]  = '../assets/plugins/chartjs/js/Chart.min.js';
// $dynamic_link_js[]  = '../assets/plugins/chartjs/js/Chart.extension.js';
$dynamic_link_js[]  = '../assets/js/index2.js';

include_once('../_helper/com_conn.php');
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <div class="card rounded-4 bg-gradient-worldcup">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-0 text-white">Total Orders</p>
                                <h4 class="my-1 text-white">200</h4>
                                <p class="mb-0 font-13 text-white">Current Month Summary </p>
                            </div>
                            <div class="fs-1 text-white"><i class='bx bxs-cart'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded-4 bg-gradient-rainbow">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-0 text-white">Total Visit</p>
                                <h4 class="my-1 text-white">50 </h4>
                                <p class="mb-0 font-13 text-white">Current Month Summary </p>
                            </div>
                            <div class="fs-1 text-white"><i class='bx bxs-group'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded-4 bg-gradient-smile">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-0 text-white">Total Collection</p>
                                <h4 class="my-1 text-white">2,00,00.00</h4>
                                <p class="mb-0 font-13 text-white">Current Month Summary </p>

                            </div>
                            <div class="fs-1 text-white"><i class='bx bxs-wallet'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded-4 bg-gradient-pinki">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-0 text-white">Product Stock </p>
                                <h4 class="my-1 text-white">0 </h4>
                                <p class="mb-0 font-13 text-white">Current Month Summary </p>
                            </div>
                            <div class="fs-1 text-white"><i class='bx bxs-bar-chart-alt-2'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->

        <div class="row">
            <div class="col-12 col-lg-8 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-cente">
                            <div>
                                <h6 class="mb-0">Collection Overview [DEMO DATA]</h6>
                            </div>

                        </div>
                        <div id="chart1"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Monthly Orders [DEMO DATA]</h6>
                            </div>

                        </div>
                        <div id="chart2"></div>
                    </div>
                </div>
            </div>
        </div><!--end row-->


        <div class="row">
            <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Top Retailer [DEMO DATA]</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="categories-list">
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/01.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-cosmic" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/02.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-ibiza" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/03.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/04.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-kyoto" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/05.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-blues" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Top Sale Executive [DEMO DATA]</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="categories-list">
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/01.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-cosmic" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/02.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-ibiza" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/03.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/04.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-kyoto" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/products/05.png" class="product-img-2" alt="product img">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-2">Mobiles <span class="float-end">75%</span></p>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-gradient-blues" role="progressbar" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-body">
                        <ul class="nav nav-pills nav-fill mb-3">
                            <li class="nav-item">
                                <a class="nav-link rounded-5" data-bs-toggle="pill" href="#primary-pills-home">Monthly</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active rounded-5" data-bs-toggle="pill" href="#primary-pills-profile">Weekly</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link rounded-5" data-bs-toggle="pill" href="#primary-pills-contact">Daily</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade" id="primary-pills-home">
                                <div id="chart3"></div>
                                <hr>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <div>
                                        <h3 class="mb-0">$ 9845.43</h3>
                                        <p class="mb-0">+3% Since Last Week</p>
                                    </div>
                                    <div class="fs-1">
                                        <i class="lni lni-arrow-up"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="primary-pills-profile">
                                <div id="chart4"></div>
                                <hr>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <div>
                                        <h3 class="mb-0">$ 45,245.37</h3>
                                        <p class="mb-0">+4% Since Last Month</p>
                                    </div>
                                    <div class="fs-1">
                                        <i class="lni lni-arrow-up"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="primary-pills-contact">
                                <div id="chart5"></div>
                                <hr>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <div>
                                        <h3 class="mb-0">$ 7395.23</h3>
                                        <p class="mb-0">+4% Since Tomorrow</p>
                                    </div>
                                    <div class="fs-1">
                                        <i class="lni lni-arrow-up"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->

        <div class="row">
            <div class="col-12 col-lg-4 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Browser Statistics [DEMO DATA]</h6>
                            </div>
                          
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart6"></div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">Chrome <span class="badge bg-danger rounded-pill">10</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Opera <span class="badge bg-primary rounded-pill">65</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Firefox <span class="badge bg-warning text-dark rounded-pill">14</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-lg-8 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Retailer Location [DEMO DATA]</h6>
                            </div>
                           
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="geographic-map-2" style="height: 280px;"></div>
                    </div>
                    <table class="table table-borderless align-items-center">
                        <tbody>
                            <tr>
                                <td><i class="bx bxs-circle me-2" style="color: #5a52db;"></i> Russia</td>
                                <td>18 %</td>
                                <td><i class="bx bxs-circle me-2" style="color: #f09c15;"></i> Australia</td>
                                <td>14.2 %</td>
                            </tr>
                            <tr>
                                <td><i class="bx bxs-circle me-2" style="color: #b659ff;"></i> India</td>
                                <td>15 %</td>
                                <td><i class="bx bxs-circle me-2" style="color: #2ccc72;"></i> United States</td>
                                <td>11.6 %</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!--end row-->

        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Recent Orders [DEMO DATA]</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Photo</th>
                                        <th>Product ID</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Shipping</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Iphone 5</td>
                                        <td><img src="assets/images/products/01.png" class="product-img-2" alt="product img"></td>
                                        <td>#9405822</td>
                                        <td><span class="btn btn-outline-success btn-sm px-4 rounded-5 w-100">Completed</span></td>
                                        <td>$1250.00</td>
                                        <td>03 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 100%"></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Earphone GL</td>
                                        <td><img src="assets/images/products/02.png" class="product-img-2" alt="product img"></td>
                                        <td>#8304620</td>
                                        <td><span class="btn btn-outline-warning btn-sm px-4 rounded-5 w-100">Pending</span></td>
                                        <td>$1500.00</td>
                                        <td>05 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-gradient-blooker" role="progressbar" style="width: 60%"></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>HD Hand Camera</td>
                                        <td><img src="assets/images/products/03.png" class="product-img-2" alt="product img"></td>
                                        <td>#4736890</td>
                                        <td><span class="btn btn-outline-danger btn-sm px-4 rounded-5 w-100">Failed</span></td>
                                        <td>$1400.00</td>
                                        <td>06 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-gradient-bloody" role="progressbar" style="width: 70%"></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Clasic Shoes</td>
                                        <td><img src="assets/images/products/04.png" class="product-img-2" alt="product img"></td>
                                        <td>#8543765</td>
                                        <td><span class="btn btn-outline-success btn-sm px-4 rounded-5 w-100">Paid</span></td>
                                        <td>$1200.00</td>
                                        <td>14 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 100%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sitting Chair</td>
                                        <td><img src="assets/images/products/06.png" class="product-img-2" alt="product img"></td>
                                        <td>#9629240</td>
                                        <td><span class="btn btn-outline-warning btn-sm px-4 rounded-5 w-100">Pending</span></td>
                                        <td>$1500.00</td>
                                        <td>18 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-gradient-blooker" role="progressbar" style="width: 60%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hand Watch</td>
                                        <td><img src="assets/images/products/05.png" class="product-img-2" alt="product img"></td>
                                        <td>#8506790</td>
                                        <td><span class="btn btn-outline-danger btn-sm px-4 rounded-5 w-100">Failed</span></td>
                                        <td>$1800.00</td>
                                        <td>21 Feb 2020</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-gradient-bloody" role="progressbar" style="width: 40%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->

    </div>
</div>
<!--end page wrapper -->
<?php
include_once('../_includes/footer_info.php');
include_once('../_includes/footer.php');
?>