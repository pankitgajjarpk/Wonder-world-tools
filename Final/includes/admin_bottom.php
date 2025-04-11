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

    <?php if ($cur_page == "user-list.php") { ?>
    <script src="<?php echo $site_url; ?>src/plugins/src/global/vendors.min.js"></script>
    <?php } ?>
    
    <script src="<?php echo $site_url; ?>src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $site_url; ?>src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo $site_url; ?>src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="<?php echo $site_url; ?>src/plugins/src/waves/waves.min.js"></script>
    <script src="<?php echo $site_url; ?>layouts/vertical-light-menu/app.js"></script>
    
    <?php if ($cur_page == "dashboard.php") { ?>
    <script src="<?php echo $site_url; ?>src/plugins/src/apex/apexcharts.min.js"></script>
    <script src="<?php echo $site_url; ?>src/assets/js/dashboard/dash_2.js"></script>
    <?php } ?>

    <?php if ($cur_page == "setting.php") { ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <?php } ?>

    <?php if ($cur_page == "user-list.php") { ?>
    <script src="<?php echo $site_url; ?>src/assets/js/custom.js"></script>
    <script src="<?php echo $site_url; ?>src/plugins/src/table/datatable/datatables.js"></script>
    <script>
        $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10 
        });
    </script>
    <?php } ?>
</body>
</html>