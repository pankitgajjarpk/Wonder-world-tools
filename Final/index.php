<?php
include_once("includes/connection.php");
include_once("includes/functions.php");

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

$action = isset($_REQUEST["err"]) ? strtolower(trim($_REQUEST["err"])) : "";
$mymsg = isset($_REQUEST["errmsg"]) ? $_REQUEST["errmsg"] : "";
$err = isset($_REQUEST["err"]) ? strtolower(trim($_REQUEST["err"])) : "";
$msg = isset($_REQUEST["msg"]) ? strtolower(trim($_REQUEST["msg"])) : "";

if($_SESSION["logged_user_id"] != "") {
    header ("Location:".SITE_URL."dashboard");
    exit;
}

if(strlen($err) > 0) {
    if ($err == "incorrect"){
        $mymsg = '<div class="alert alert-danger" role="alert"><div class="alert-body">Incorrect username or password.</div></div>';
    } elseif ($err == "blank"){
        $mymsg = '<div class="alert alert-danger" role="alert"><div class="alert-body">Please fill out all required fields.</div></div>';
    } elseif ($err == "invalidemail"){
        $mymsg = '<div class="alert alert-danger" role="alert"><div class="alert-body">Please enter valid email address.</div></div>';
    } elseif ($err == "notallow"){
        $mymsg = '<div class="alert alert-danger" role="alert"><div class="alert-body">You are not allowed to login.</div></div>';
    } else {
    }
}

if(strlen($msg) > 0) {
    if($msg == "logout"){
        $mymsg = '<div class="alert alert-success" role="alert"><div class="alert-body">You have been logged out successfully.</div></div>';
    } elseif ($msg == "edit"){
        $mymsg = '<div class="alert alert-success" role="alert"><div class="alert-body">Password has been changed successfully.</div></div>';
    } else {
    }
}
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?php echo $site_name; ?></title>

    <link rel="shortcut icon" href="<?php echo $site_url; ?>assets/images/favicon.ico">

    <script src="<?php echo $site_url; ?>assets/js/layout.js"></script>
    
    <link href="<?php echo $site_url; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $site_url; ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $site_url; ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $site_url; ?>assets/css/custom.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="auth-page-wrapper pt-5">
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <?php /* ?><a href="<?php echo $site_url; ?>" class="d-inline-block auth-logo">
                                    <img src="assets/images/logo-light.png" alt="" height="20">
                                </a><?php */ ?>
                            </div>
                            <p class="mt-3 fs-15 fw-medium"><?php echo $site_name; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4 card-bg-fill">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Sign in to continue to <?php echo $site_name; ?></h5>

                                    <?php if($mymsg != "") { echo $mymsg; } ?>
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="<?php echo SITE_URL; ?>login-db.php" method="POST">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Email Address</label>
                                            <input required type="text" class="form-control" id="username" placeholder="Enter username" name="user_email_address">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input required type="password" class="form-control pe-5 password-input" placeholder="Enter password" name="user_password" id="password-input">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>document.write(new Date().getFullYear())</script> <?php echo $site_name; ?>. Developed by The Crazy Coders.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="<?php echo $site_url; ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $site_url; ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo $site_url; ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo $site_url; ?>assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?php echo $site_url; ?>assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="<?php echo $site_url; ?>assets/js/plugins.js"></script>

    <script src="<?php echo $site_url; ?>assets/libs/particles.js/particles.js"></script>
    <script src="<?php echo $site_url; ?>assets/js/pages/particles.app.js"></script>
    <script src="<?php echo $site_url; ?>assets/js/pages/password-addon.init.js"></script>
</body>
</html>