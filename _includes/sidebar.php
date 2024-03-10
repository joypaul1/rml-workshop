<body>

    <?php
    // $v_active      = 'mm-active';
    // $v_active_open = 'mm-active';
    $currentUrl    = $_SERVER['REQUEST_URI'];
  
    function isActive($url)
    {
        // $url = parse_url($url);
        // echo $url;
        global $currentUrl;
        return strpos($currentUrl, $url) !== false ? 'mm-active' : '';
    }
    // echo isActive('collection_module/view/create.php');
    // die();
    ?>
    <!--wrapper-->
    <div class="wrapper">

        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <!-- <div>
                    <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
                </div> -->
                <div>
                    <h4 class="logo-text">SFCM - SYSTEM</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li class="<?php echo isActive('/home/dashboard.php'); ?>">
                    <a href="<?php echo $sfcmBasePath ?>/home/dashboard.php">
                        <div class="parent-icon"><i class="bx bx-home-circle"></i>
                        </div>
                        <div class="menu-title">Dashboard </div>
                    </a>
                </li>


                <li class="<?php echo isActive('/collection_module/view/create.php'); ?>
                <?php echo isActive('/collection_module/view/edit.php'); ?>">
                    <a href="javascript:;" class="has-arrow">

                        <div class="parent-icon"><i class='bx bx-money'></i>
                        </div>
                        <div class="menu-title">Collection Module</div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo $sfcmBasePath ?>/collection_module/view/create.php"><i class='bx bxs-arrow-to-right'></i> Assign Collection </a>
                        </li>

                        <li> <a href="<?php echo $sfcmBasePath ?>/collection_module/view/index.php"><i class='bx bxs-arrow-to-right'></i> List Of Assign </a>

                        </li>
                        <li> <a href="<?php echo $sfcmBasePath ?>/collection_module/view/excel_upload.php"><i class='bx bxs-arrow-to-right'></i> Excel Upload </a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo isActive('/visit_module/view/edit.php'); ?>">
                    <a href="javascript:;" class="has-arrow">

                        <div class="parent-icon"><i class='bx bx-group'></i>
                        </div>
                        <div class="menu-title">Visit Plan Module</div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo $sfcmBasePath ?>/visit_module/view/index.php"><i class='bx bxs-arrow-to-right'></i> List Of Schedule </a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo isActive('/user_module/view/edit.php'); ?>">
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-group'></i>
                        </div>
                        <div class="menu-title">User Module</div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo $sfcmBasePath ?>/user_module/view/index.php"><i class='bx bxs-arrow-to-right'></i> List Of User</a>
                        </li>
                        <li> <a href="<?php echo $sfcmBasePath ?>/user_module/view/brandAssign.php"><i class='bx bxs-arrow-to-right'></i> Cost Center Assign</a>
                        </li>
                        <li> <a href="<?php echo $sfcmBasePath ?>/user_module/view/resource_allocation.php"><i class='bx bxs-arrow-to-right'></i> Resource Allocation </a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo isActive('/admin_module/view/ut_edit.php'); ?> <?php echo isActive('/admin_module/view/vt_edit.php'); ?> <?php echo isActive('/admin_module/view/dis_create.php'); ?>
                <?php echo isActive('/admin_module/view/dis_edit.php'); ?>">
                    <a href="javascript:;" class="has-arrow">

                        <div class="parent-icon"><i class='bx bx-cog'></i>
                        </div>
                        <div class="menu-title">Admin Module</div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo $sfcmBasePath ?>/admin_module/view/user_type.php"><i class='bx bxs-arrow-to-right'></i> User Type Config.</a>
                        </li>
                        <li> <a href="<?php echo $sfcmBasePath ?>/admin_module/view/visit_type.php"><i class='bx bxs-arrow-to-right'></i> Visit Type Config.</a>
                        </li>
                        <li> <a href="<?php echo $sfcmBasePath ?>/admin_module/view/plaza_retailer_type.php"><i class='bx bxs-arrow-to-right'></i> Plaza Retailer Type </a>
                        </li>
                        <li> <a href="<?php echo $sfcmBasePath ?>/admin_module/view/district.php"><i class='bx bxs-arrow-to-right'></i> Districts Name Config.</a>
                        </li>
                    </ul>
                </li>

            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->