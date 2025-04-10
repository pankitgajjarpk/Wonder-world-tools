<?php
include_once("connection.php");
include_once("functions.php");

if ($_SESSION["logged_user_id"] == "") {
    myFormErr(SITE_URL . "index.php", "expired", "");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="<?php echo SITE_URL; ?>assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?php echo $site_name; ?></title>

    <link rel="shortcut icon"
        href="<?php if ($site_logo != "") {
            echo SITE_URL . 'images/' . $site_logo;
        } else {
            echo SITE_URL; ?>images/default/favicon.png<?php } ?>">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <!-- <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>app-assets/vendors/css/vendors.min.css"> -->

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/fonts/flag-icons.css" />

    <link rel="stylesheet" href="<?php echo SITE_URL; ?>dist/jquery-ui.css" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>dist/bootstrap-tagsinput.css" />

    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/css/rtl/core.css"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/css/rtl/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/demo.css" />

    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <?php if ($cur_page == "new-assign.php" || $cur_page == "target-order-details.php" || $cur_page == "target-collection-details.php" || $cur_page == "order-list.php" || $cur_page == "quotation-list.php" || $cur_page == "follow-up-history.php" || $cur_page == "target-list.php" || $cur_page == "status-list.php" || $cur_page == "source-list.php" || $cur_page == "user-control-list.php" || $cur_page == "lead-search.php" || $cur_page == "notification-list.php" || $cur_page == "new-leads-list.php" || $cur_page == "type-list.php" || $cur_page == "not-interested-list.php" || $cur_page == "user-log-details.php" || $cur_page == "user-log-list.php" || $cur_page == "expired-follow-up-list.php" || $cur_page == "follow-up-list.php" || $cur_page == "item-list.php" || $cur_page == "dashboard.php" || $cur_page == "user-list.php" || $cur_page == "leads-list.php" || $cur_page == "test-leads-list.php") { ?>
        <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/node-waves/node-waves.css" />
        <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/typeahead-js/typeahead.css" />
        <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <?php } ?>

    <link rel="stylesheet"
        href="<?php echo SITE_URL; ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />

    <?php if ($cur_page == "new-leads.php" || $cur_page == "leads.php") { ?>
        <script src="<?php echo SITE_URL; ?>app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
        <script src="<?php echo SITE_URL; ?>app-assets/js/scripts/forms/form-repeater.js"></script>
    <?php } ?>

    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/tagify/tagify.css" />

    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet"
        href="<?php echo SITE_URL; ?>assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet"
        href="<?php echo SITE_URL; ?>assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/pickr/pickr-themes.css" />

    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/select2/select2.css" />

    <?php if ($cur_page == "smtp.php" || $cur_page == "setting.php") { ?>
        <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/quill/typography.css" />
        <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/quill/katex.css" />
        <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/vendor/libs/quill/editor.css" />
    <?php } ?>

    <script src="<?php echo SITE_URL; ?>assets/vendor/js/helpers.js"></script>

    <script src="<?php echo SITE_URL; ?>assets/js/config.js"></script>

    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/custom.css" />

    <?php /*if($cur_page == "dashboard.php" || $cur_page == "quotation-list.php" || $cur_page == "order-list.php") { ?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <?php }*/ ?>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">