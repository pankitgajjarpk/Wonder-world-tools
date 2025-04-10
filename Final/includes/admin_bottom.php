                            <footer class="content-footer text-center footer bg-footer-theme">
                                <div class="container-xxl">
                                    <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-column">
                                        <div>
                                            Powered By <a target="_blank" href="https://adsweb.app/"><b>ADSWEB</b></a>
                                        </div>
                                    </div>
                                </div>
                            </footer>
                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>      
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>

    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/jquery/jquery.js"></script>
    <!-- <script src="<?php echo SITE_URL; ?>assets/vendor/libs/popper/poppper.js"></script> -->
    <script src="<?php echo SITE_URL; ?>assets/vendor/js/bootstrap.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/hammer/hammer.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/i18n/i18n.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="<?php echo SITE_URL; ?>assets/vendor/js/menu.js"></script>

    <?php if($cur_page != "dashboard.php") { ?>
    <script src="<?php echo SITE_URL; ?>dist/jquery-ui.js"></script>
    <script src="<?php echo SITE_URL; ?>dist/bootstrap-tagsinput.min.js"></script>
    <?php } ?>

    <?php if($cur_page == "new-assign.php" || $cur_page == "target-order-details.php" || $cur_page == "target-collection-details.php" || $cur_page == "follow-up-history.php" || $cur_page == "target-list.php" || $cur_page == "status-list.php" || $cur_page == "source-list.php" || $cur_page == "user-control-list.php" || $cur_page == "order-list.php" || $cur_page == "lead-search.php" || $cur_page == "notification-list.php" || $cur_page == "new-leads-list.php" || $cur_page == "type-list.php" || $cur_page == "not-interested-list.php" || $cur_page == "quotation-list.php" || $cur_page == "expired-follow-up-list.php" || $cur_page == "follow-up-list.php" || $cur_page == "item-list.php" || $cur_page == "dashboard.php" || $cur_page == "user-list.php" || $cur_page == "leads-list.php" || $cur_page == "test-leads-list.php") { ?>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <?php } ?>

    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/moment/moment.js"></script>

    <?php if($cur_page != "smtp.php" && $cur_page != "dashboard.php") { ?>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/pickr/pickr.js"></script>
    <?php } ?>

    <?php
    if($cur_page != "new-assign.php" && $cur_page != "target-order-details.php" && $cur_page != "target-collection-details.php" && $cur_page != "order-list.php" && $cur_page != "follow-up-history.php" && $cur_page != "target-list.php" && $cur_page != "status-list.php" && $cur_page != "source-list.php" && $cur_page != "user-control-list.php" && $cur_page != "lead-search.php" && $cur_page != "notification-list.php" && $cur_page != "new-leads-list.php" && $cur_page != "type-list.php" && $cur_page != "not-interested-list.php" && $cur_page != "quotation-list.php" && $cur_page != "expired-follow-up-list.php" && $cur_page != "follow-up-list.php" && $cur_page != "item-list.php" && $cur_page != "dashboard.php" && $cur_page != "user-list.php" && $cur_page != "leads-list.php" && $cur_page != "test-leads-list.php") {
    ?>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/moment/moment.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <?php } ?>

    <?php if($cur_page != "dashboard.php") { ?>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/tagify/tagify.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/bloodhound/bloodhound.js"></script>
    <?php } ?>

    <?php if($cur_page == "smtp.php" || $cur_page == "setting.php") { ?>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/quill/katex.js"></script>
    <script src="<?php echo SITE_URL; ?>assets/vendor/libs/quill/quill.js"></script>
    <?php } ?>

    <script src="<?php echo SITE_URL; ?>assets/js/main.js"></script>
    
    <?php if($cur_page == "smtp.php" || $cur_page == "setting.php") { ?>
    <script src="<?php echo SITE_URL; ?>assets/js/forms-editors.js"></script>
    <?php } ?>

    <?php if($cur_page != "new-assign.php") { ?>
    <script src="<?php echo SITE_URL; ?>assets/js/forms-pickers.js"></script>
    <?php } ?>

    <?php if($cur_page == "new-assign.php" || $cur_page == "target-order-details.php" || $cur_page == "target-collection-details.php" || $cur_page == "order-list.php" || $cur_page == "follow-up-history.php" || $cur_page == "target-list.php" || $cur_page == "status-list.php" || $cur_page == "source-list.php" || $cur_page == "user-control-list.php" || $cur_page == "lead-search.php" || $cur_page == "notification-list.php" || $cur_page == "new-leads-list.php" || $cur_page == "type-list.php" || $cur_page == "not-interested-list.php" || $cur_page == "quotation-list.php" || $cur_page == "expired-follow-up-list.php" || $cur_page == "follow-up-list.php" || $cur_page == "item-list.php" || $cur_page == "user-list.php" || $cur_page == "leads-list.php" || $cur_page == "test-leads-list.php") { ?>
    <script src="<?php echo SITE_URL; ?>assets/js/tables-datatables-advanced.js"></script>
    
    <?php if($cur_page == "not-interested-list.php") { ?>
        <script type="text/javascript">
        $('.datatables-ajax').dataTable( {
            pageLength: 50,
            //lengthMenu: [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
            lengthMenu: [[25, 50, 100], [25, 50, 100]],
            language: {
                search:'Search Lead Details'
            },
            "aaSorting": [],
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            }]
        });
        </script>
        <?php } else { ?>
        <script type="text/javascript">
        $('.datatables-ajax').dataTable( {
            pageLength: 50,
            //lengthMenu: [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
            lengthMenu: [[25, 50, 100], [25, 50, 100]],
            "aaSorting": [],
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            }]
        });
        </script>
        <?php } ?>
    <?php } ?>

    <?php if($cur_page == "setting.php") { ?>
    <script src="<?php echo SITE_URL; ?>assets/js/form-layouts.js"></script>
    <?php } ?>
    
    <?php if($cur_page == "dashboard.php") { ?>
    <script src="<?php echo SITE_URL; ?>assets/js/dashboards-crm.js"></script>
    <?php } ?>

    <?php if($cur_page == "international-order.php" || $cur_page == "international-order-edit.php" || $cur_page == "international-quotation.php" || $cur_page == "international-quotation-edit.php" || $cur_page == "order-edit.php" || $cur_page == "order.php" || $cur_page == "quotation-edit.php" || $cur_page == "quotation.php" || $cur_page == "new-leads.php" || $cur_page == "leads.php") { ?>
    <script src="<?php echo SITE_URL; ?>app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
    <script src="<?php echo SITE_URL; ?>app-assets/js/scripts/forms/form-repeater.js"></script>
    <script src="<?php echo SITE_URL; ?>app-assets/js/quotation.js"></script>
    <?php } ?>
    
    <script src="<?php echo SITE_URL; ?>assets/js/ui-popover.js"></script>
    
    <script type="text/javascript">
    function goBack() {
      window.history.back();
    }
    </script>

    <?php if($cur_page == "leads-list.php" || $cur_page == "test-leads-list.php" || $cur_page == "follow-up-list.php" || $cur_page == "expired-follow-up-list.php" || $cur_page == "not-interested-list.php" || $cur_page == "dashboard.php" || $cur_page == "quotation-list.php" || $cur_page == "order-list.php") { ?>
    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">PDF Viewer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div> -->
                <div class="modal-body">
                    <div id="pdfViewerContainer"></div>
                    <!-- <canvas id="pdfViewer" style="width: 100%;"></canvas> -->
                    <!-- <iframe id="pdfViewer" class="ytplayer" type="text/html" width="100%" height="360" frameborder="0"></iframe> -->
                    <!-- <embed id="pdfViewer" src="" type="application/pdf" width="100%" height="600px" /> -->
                    <!-- <object id="pdfViewer" type="application/pdf" width="100%" height="600px">
                        <p>Your web browser doesn't have a PDF plugin.</p>
                    </object> -->
                </div>
                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>-->
            </div>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    
    <script type="text/javascript">
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';
    $(document).ready(function() {
        $('#pdfModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var pdfUrl = button.data('pdf');
            
            $('#pdfViewerContainer').empty();

            var loadingTask = pdfjsLib.getDocument(pdfUrl);
            loadingTask.promise.then(function(pdf) {                
                var totalPages = pdf.numPages;                
                var pagesToRender = Math.min(3, totalPages);

                for (let i = 1; i <= pagesToRender; i++) {                    
                    var canvas = $('<canvas></canvas>').attr('id', 'pdfPage' + i).css('width', '100%');
                    $('#pdfViewerContainer').append(canvas);
                    
                    pdf.getPage(i).then(function(page) {
                        var scale = 1.5;  
                        var viewport = page.getViewport({ scale: scale });

                        var context = document.getElementById('pdfPage' + i).getContext('2d');
                        document.getElementById('pdfPage' + i).height = viewport.height;
                        document.getElementById('pdfPage' + i).width = viewport.width;

                        var renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };
                        page.render(renderContext);
                    });
                }
            }, function(error) {
                console.error('Error loading PDF: ', error);
            });
        });
    });
    </script>
    <?php } ?>

    <script type="text/javascript">
    function view_switch_user() {
        $.ajax({
            type: "POST",
            url: '<?php echo SITE_URL; ?>switch-user.php',
            data: "",
            async: false,
            cache: false,
            success: function (res) {
                $("#switchUserSide").empty().append(res), $('#switchUserSide').addClass('show');
                $('#switchUserbackdrop').addClass('offcanvas-backdrop fade show');
                $('body').css({
                    'overflow': 'hidden',
                    'padding-right': '15px'
                });
            }
        })
    }

    function close_switch_user_process(){
        $('body').removeAttr('style');
        $('#switchUserSide').removeClass('fade show');
        $('#switchUserbackdrop').removeClass('offcanvas-backdrop fade show');
    }
    </script>
    
    <style>
    .select2-dropdown.increasezindex { z-index:99999; }
    .offcanvas { width: 550px !important; }
    </style>
</body>
</html>