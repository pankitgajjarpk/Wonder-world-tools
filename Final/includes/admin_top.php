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