<?php
include_once("connection.php");
include_once("functions.php");

if ($_SESSION["logged_user_id"] == "") {
    myFormErr("index.php", "expired", "");
    exit;
}
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">
<head>
    <meta charset="utf-8" />
    
    <title><?php echo $site_name; ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?php echo $site_name; ?>" name="description" />
    <meta content="Themesbrand" name="<?php echo $site_name; ?>" />

    <link rel="shortcut icon" href="<?php echo $site_url; ?>assets/images/favicon.ico">

    <script src="<?php echo $site_url; ?>assets/js/layout.js"></script>
    
    <link href="<?php echo $site_url; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo $site_url; ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $site_url; ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $site_url; ?>assets/css/custom.min.css" rel="stylesheet" type="text/css" />    
</head>

<body>
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <b>Welcome to <?php echo $site_name; ?></b>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" src="<?php echo $site_url; ?>assets/images/users/user-dummy-img.jpg" alt="Header Avatar">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo $_SESSION["logged_user_name"]; ?></span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="logout.php"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>