                </div>
            </div>

            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © <span class="dynamic-year"><?php echo date('Y'); ?></span> <a href="<?php echo $site_url; ?>"><?php echo $site_name; ?></a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Developed by The Crazy Coders</p>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo $site_url; ?>src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $site_url; ?>src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo $site_url; ?>src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="<?php echo $site_url; ?>src/plugins/src/waves/waves.min.js"></script>
    <script src="<?php echo $site_url; ?>layouts/vertical-light-menu/app.js"></script>
    
    <?php if ($cur_page == "dashboard.php") { ?>
    <script src="<?php echo $site_url; ?>src/plugins/src/apex/apexcharts.min.js"></script>
    <script src="<?php echo $site_url; ?>src/assets/js/dashboard/dash_2.js"></script>
    <?php } ?>

    <script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
</body>
</html>