<body>

    <?php
    $v_active      = 'mm-active';
    $v_active_open = 'mm-active';
    $currentUrl    = $_SERVER['REQUEST_URI'];
    function isActive($url)
    {
        global $currentUrl;
        return strpos($currentUrl, $url) !== false ? 'mm-active' : '';
    }
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
                    <h4 class="logo-text">COLLECTION APPS</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li class="<?php echo isActive('/home/dashboard_zh.php'); ?>">
                    <a href="<?php echo $basePath ?>/home/dashboard_zh.php">
                        <div class="parent-icon"><i class="bx bx-home-circle"></i>
                        </div>
                        <div class="menu-title">ZH Dashboard</div>
                    </a>
                </li>

                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-cart'></i>
                        </div>
                        <div class="menu-title">Product Panel </div>
                    </a>
                    <ul>
                        <li> <a href="#"><i class='bx bxs-arrow-to-right'></i></i>Products</a>
                        </li>
                        <!-- <li> <a href="#"><i class='bx bxs-arrow-to-right'></i></i>Product Details</a>
                        </li>
                        <li> <a href="#"><i class='bx bxs-arrow-to-right'></i></i>Add New Products</a>
                        </li>
                        <li> <a href="#"><i class='bx bxs-arrow-to-right'></i></i>Orders</a>
                        </li> -->
                    </ul>
                </li>
                <li class="<?php echo isActive('/user_module/view/edit.php'); ?>">
                    <a href="javascript:;" class="has-arrow">

                        <div class="parent-icon"><i class='bx bx-group'></i>
                        </div>
                        <div class="menu-title">User Panel</div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo $basePath ?>/user_module/view/create.php"><i class='bx bxs-arrow-to-right'></i></i>Create User</a>
                        </li>
                        <li> <a href="<?php echo $basePath ?>/user_module/view/index.php"><i class='bx bxs-arrow-to-right'></i></i>List Of User</a>
                        </li>
                    </ul>
                </li>

            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->