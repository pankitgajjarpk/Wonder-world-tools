                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © <?php echo $site_name; ?>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by The Crazy Coders
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>

        <div id="preloader">
            <div id="status">
                <div class="spinner-border text-primary avatar-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

    <script src="<?php echo $site_url; ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $site_url; ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo $site_url; ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo $site_url; ?>assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?php echo $site_url; ?>assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="<?php echo $site_url; ?>assets/js/plugins.js"></script>

    <?php if ($cur_page == "dashboard.php") { ?>
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/pages/dashboard-crm.init.js"></script>
    <?php } ?>

    <script src="assets/js/app.js"></script>
</body>
</html>