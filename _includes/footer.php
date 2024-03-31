<!--start switcher-->
<div class="switcher-wrapper">
    <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
    </div>
    <div class="switcher-body">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
            <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
        </div>
        <hr>
        <h6 class="mb-0">Theme Styles</h6>
        <hr>
        <div class="d-flex align-items-center justify-content-between">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode">
                <label class="form-check-label" for="lightmode">Light</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
                <label class="form-check-label" for="darkmode">Dark</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark" checked="">
                <label class="form-check-label" for="semidark">Semi Dark</label>
            </div>
        </div>
        <hr>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
            <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
        </div>
        <hr>
        <h6 class="mb-0">Header Colors</h6>
        <hr>
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col">
                    <div class="indigator headercolor1" id="headercolor1"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor2" id="headercolor2"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor3" id="headercolor3"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor4" id="headercolor4"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor5" id="headercolor5"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor6" id="headercolor6"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor7" id="headercolor7"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor8" id="headercolor8"></div>
                </div>
            </div>
        </div>
        <hr>
        <h6 class="mb-0">Sidebar Colors</h6>
        <hr>
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col">
                    <div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end switcher-->
<!-- Bootstrap JS -->
<script src="<?php echo $sfcmBasePath ?>/assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="<?php echo $sfcmBasePath ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo $sfcmBasePath ?>/assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="<?php echo $sfcmBasePath ?>/assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="<?php echo $sfcmBasePath ?>/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.js" integrity="sha512-7x7HoEikRZhV0FAORWP+hrUzl75JW/uLHBbg2kHnPdFmScpIeHY0ieUVSacjusrKrlA/RsA2tDOBvisFmKc3xw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!--app JS-->
<script src="<?php echo $sfcmBasePath ?>/assets/js/app.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {
        $('[data-bs-toggle="popover"]').popover();
        $('[data-bs-toggle="tooltip"]').tooltip();
    })

    function showTime() {
        // to get current time/ date.
        var date = new Date();
        // to get the current hour
        var h = date.getHours();
        // to get the current minutes
        var m = date.getMinutes();
        //to get the current second
        var s = date.getSeconds();
        // AM, PM setting
        var session = "AM";

        //conditions for times behavior
        if (h == 0) {
            h = 12;
        }
        if (h >= 12) {
            session = "PM";
        }

        if (h > 12) {
            h = h - 12;
        }
        m = m < 10 ? (m = "0" + m) : m;
        s = s < 10 ? (s = "0" + s) : s;

        //putting time in one variable
        var time = h + ":" + m + ":" + s + " " + session;
        //putting time in our div
        $("#clock").html(time);
        //to change time in every seconds
        setTimeout(showTime, 1000);
    }
    showTime();
</script>

<?php if (isset($dynamic_link_js) && count($dynamic_link_js) > 0) {
    foreach ($dynamic_link_js as $key => $linkJs) {
        echo "<script src='$linkJs'></script>";
    }
} ?>

<?php
if (!empty($_SESSION['noti_message'])) {
    if ($_SESSION['noti_message']['status'] == 'false') {
        echo "<script>toastr.warning('{$_SESSION['noti_message']['text']}');</script>";
    }
    if ($_SESSION['noti_message']['status'] == 'true') {
        echo "<script>toastr.success('{$_SESSION['noti_message']['text']}');</script>";
    }
    unset($_SESSION['noti_message']);
}
?>

</body>

</html>