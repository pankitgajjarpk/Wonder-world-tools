<?php
include_once("connection.php");
include_once("functions.php");

if ($_SESSION["logged_user_id"] == "") {
    myFormErr("index.php", "expired", "");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    
    <title><?php echo $site_name; ?></title>

    <?php if($site_logo != "") { ?>
    <link href="<?php echo $site_url.'images/'.$site_logo; ?>"/>
    <?php } else { ?>
    <link rel="icon" type="image/x-icon" href="<?php echo $site_url; ?>src/assets/img/favicon.ico"/>
    <?php } ?>

    <link href="<?php echo $site_url; ?>layouts/vertical-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    
    <script src="<?php echo $site_url; ?>layouts/vertical-light-menu/loader.js"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    
    <link href="<?php echo $site_url; ?>src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $site_url; ?>layouts/vertical-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo $site_url; ?>src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $site_url; ?>src/assets/css/light/components/list-group.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $site_url; ?>src/assets/css/light/dashboard/dash_2.css" rel="stylesheet" type="text/css" />

    <?php if ($cur_page == "user-list.php") { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>src/plugins/src/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>src/plugins/css/light/table/datatable/dt-global_style.css">
    <?php } ?>
</head>

<body class=" layout-boxed">
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>

    <div class="header-container container-xxl">
        <header class="header navbar navbar-expand-sm expand-header">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-text">
                    <a href="<?php echo $site_url; ?>" class="nav-link"><?php echo $site_name; ?> </a>
                </li>
            </ul>
            <ul class="navbar-item flex-row ms-lg-auto ms-0 action-area">
                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-container">
                            <div class="avatar avatar-sm avatar-indicators avatar-online">
                                <img alt="avatar" src="<?php echo $site_url; ?>src/assets/img/user-dummy-img.jpg" class="rounded-circle">
                            </div>
                        </div>
                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <div class="emoji me-2">
                                    &#x1F44B;
                                </div>
                                <div class="media-body">
                                    <h5><?php echo $_SESSION["logged_user_name"]; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="logout.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>

    <div class="main-container" id="container">