<?php
include_once('../_helper/com_conn.php');
$query = "SELECT COUNT(RML_ID) TOTAL_CONCERN,
'Total Concern' MIDDLE_TITLE, 
'As Of Admin Setup' FOOTER_TITLE 
FROM MONTLY_COLLECTION
WHERE IS_ACTIVE=1
AND ZONAL_HEAD='441'";
$strSQL = @oci_parse($objConnect, $query);
@oci_execute($strSQL);
$dataRow = @oci_fetch_assoc($strSQL);

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
                                <h4 class="my-1 text-white">8,643</h4>
                                <p class="mb-0 font-13 text-white">+2.5% from last week</p>
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
                                <p class="mb-0 text-white"><?php echo $dataRow['MIDDLE_TITLE'] ?></p>
                                <h4 class="my-1 text-white"><?php echo $dataRow['TOTAL_CONCERN'] ?></h4>
                                <p class="mb-0 font-13 text-white"><?php echo $dataRow['FOOTER_TITLE'] ?></p>
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
                                <p class="mb-0 text-white">Revenue</p>
                                <h4 class="my-1 text-white">$24.5K</h4>
                                <p class="mb-0 font-13 text-white">-4.5% from last week</p>
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
                                <p class="mb-0 text-white">Growth</p>
                                <h4 class="my-1 text-white">41.86%</h4>
                                <p class="mb-0 font-13 text-white">+8.4% from last week</p>
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
                                <h6 class="mb-0">Sales Overview</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                    </li>
                                </ul>
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
                                <h6 class="mb-0">Monthly Orders</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                    </li>
                                </ul>
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
                                <h6 class="mb-0">Top Categories</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                    </li>
                                </ul>
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
                                <h6 class="mb-0">New Users</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-users-list">
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/avatars/avatar-1.png" class="rounded-circle" width="45" height="45" alt="user img">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Benji Harper</h6>
                                    <p class="mb-0 extra-small-font">UI Designer</p>
                                </div>
                                <div class="">
                                    <button type="button" class="btn btn-gradient-primary btn-sm rounded-4 px-4">Add</button>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/avatars/avatar-2.png" class="rounded-circle" width="45" height="45" alt="user img">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">John Michael</h6>
                                    <p class="mb-0 extra-small-font">Project Manger</p>
                                </div>
                                <div class="">
                                    <button type="button" class="btn btn-gradient-primary btn-sm rounded-4 px-4">Add</button>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/avatars/avatar-3.png" class="rounded-circle" width="45" height="45" alt="user img">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Justine Myranda</h6>
                                    <p class="mb-0 extra-small-font">Php Developer</p>
                                </div>
                                <div class="">
                                    <button type="button" class="btn btn-gradient-primary btn-sm rounded-4 px-4">Add</button>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/avatars/avatar-4.png" class="rounded-circle" width="45" height="45" alt="user img">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Janet Lucas</h6>
                                    <p class="mb-0 extra-small-font">Team Leader</p>
                                </div>
                                <div class="">
                                    <button type="button" class="btn btn-gradient-primary btn-sm rounded-4 px-4">Add</button>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="">
                                    <img src="assets/images/avatars/avatar-5.png" class="rounded-circle" width="45" height="45" alt="user img">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Alex Smith</h6>
                                    <p class="mb-0 extra-small-font">Graphic Designer</p>
                                </div>
                                <div class="">
                                    <button type="button" class="btn btn-gradient-primary btn-sm rounded-4 px-4">Add</button>
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
                                <h6 class="mb-0">Browser Statistics</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                    </li>
                                </ul>
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
                                <h6 class="mb-0">Top Selling Countries</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                    </li>
                                </ul>
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
                    <div class="card-header border-success">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="">
                                <h6 class="mb-0 border-success">
                                    <strong class="">
                                        <i class="bx bx-flag text-danger"></i>
                                        Concern List Assign Summary of
                                        <span class="badge bg-success">
                                            <?php echo date('F') ?>
                                        </span>
                                        Month
                                    </strong>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <style>
                        .tbPink {
                            background-color: #d115db38 !important;
                            text-align: center;
                            font-weight: bold;
                        }

                        table.concerntList {
                            font-size: 10px;
                        }

                        .table-sm>:not(caption)>*>* {
                            padding: 0.1rem 0.1rem;
                        }
                    </style>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0 concerntList">
                                <thead class="bg-warning text-center">
                                    <tr >
                                        <th>SL</th>
                                        <!-- <th>Photo</th> -->
                                        <th>Concern Name</th>
                                        <th> </th>
                                        <th>Code Number</th>
                                        <th>Total Visit Assign</th>
                                        <th>Unique Visit Assign</th>
                                        <th>Not Touching</th>
                                        <th> </th>
                                        <th>Total Visited</th>
                                        <th>Unique Visited</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td rowspan="3">1</td>
                                        <!-- <td rowspan="3"><img src="<?php echo  $basePath . '/' . "assets/images/avatars/default_user.png"; ?>" class="product-img-2" alt="product img"></td> -->
                                        <td rowspan="3">Mr. X Paul
                                            <br>
                                            Zone: <strong class="text-danger">B2</strong>
                                        </td>
                                        <td class="bg-warning fw-bold text-end">
                                            On Road :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">20</td>
                                        <td class="tbPink">15</td>
                                        <td class="bg-warning fw-bold text-end">
                                            On Road :
                                        </td>
                                        <td class="tbPink">5</td>
                                        <td class="tbPink">5</td>
                                    </tr>
                                    <tr>

                                        <td class="bg-warning fw-bold text-end">
                                            Others :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">20</td>
                                        <td class="tbPink">15</td>
                                        <td class="bg-warning fw-bold text-end">
                                            Others :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 2px solid black">

                                        <td class="bg-warning fw-bold text-end">
                                            Total :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">20</td>
                                        <td class="tbPink">15</td>
                                        <td class="bg-warning fw-bold text-end">
                                            Total :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>

                                    </tr>
                                    <tr>
                                        <td rowspan="3">1</td>
                                        <!-- <td rowspan="3"><img src="<?php echo  $basePath . '/' . "assets/images/avatars/default_user.png"; ?>" class="product-img-2" alt="product img"></td> -->
                                        <td rowspan="3">Mr. X Paul
                                            <br>
                                            Zone: <strong class="text-danger">B2</strong>
                                        </td>
                                        <td class="bg-warning fw-bold text-end">
                                            On Road :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">20</td>
                                        <td class="tbPink">15</td>
                                        <td class="bg-warning fw-bold text-end">
                                            On Road :
                                        </td>
                                        <td class="tbPink">5</td>
                                        <td class="tbPink">5</td>
                                    </tr>
                                    <tr>

                                        <td class="bg-warning fw-bold text-end">
                                            Others :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">20</td>
                                        <td class="tbPink">15</td>
                                        <td class="bg-warning fw-bold text-end">
                                            Others :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 2px solid black">

                                        <td class="bg-warning fw-bold text-end">
                                            Total :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">20</td>
                                        <td class="tbPink">15</td>
                                        <td class="bg-warning fw-bold text-end">
                                            Total :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>

                                    </tr>
                                    <tr>
                                        <td rowspan="3">1</td>
                                        <!-- <td rowspan="3"><img src="<?php echo  $basePath . '/' . "assets/images/avatars/default_user.png"; ?>" class="product-img-2" alt="product img"></td> -->
                                        <td rowspan="3">Mr. X Paul
                                            <br>
                                            Zone: <strong class="text-danger">B2</strong>
                                        </td>
                                        <td class="bg-warning fw-bold text-end">
                                            On Road :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">20</td>
                                        <td class="tbPink">15</td>
                                        <td class="bg-warning fw-bold text-end">
                                            On Road :
                                        </td>
                                        <td class="tbPink">5</td>
                                        <td class="tbPink">5</td>
                                    </tr>
                                    <tr>

                                        <td class="bg-warning fw-bold text-end">
                                            Others :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">20</td>
                                        <td class="tbPink">15</td>
                                        <td class="bg-warning fw-bold text-end">
                                            Others :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 2px solid black">

                                        <td class="bg-warning fw-bold text-end">
                                            Total :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">20</td>
                                        <td class="tbPink">15</td>
                                        <td class="bg-warning fw-bold text-end">
                                            Total :
                                        </td>
                                        <td class="tbPink">
                                            10
                                        </td>
                                        <td class="tbPink">
                                            10
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