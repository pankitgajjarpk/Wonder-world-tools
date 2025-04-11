<?php
include_once("includes/connection.php");
include_once("includes/functions.php");

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

$action = isset($_REQUEST["err"]) ? strtolower(trim($_REQUEST["err"])) : "";
$mymsg = isset($_REQUEST["errmsg"]) ? $_REQUEST["errmsg"] : "";
$err = isset($_REQUEST["err"]) ? strtolower(trim($_REQUEST["err"])) : "";
$msg = isset($_REQUEST["msg"]) ? strtolower(trim($_REQUEST["msg"])) : "";

if($_SESSION["logged_user_id"] != "") {
    header ("Location: dashboard.php");
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
    <link href="<?php echo $site_url; ?>layouts/vertical-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $site_url; ?>layouts/vertical-light-menu/loader.js"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?php echo $site_url; ?>src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo $site_url; ?>layouts/vertical-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $site_url; ?>src/assets/css/light/authentication/auth-boxed.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo $site_url; ?>layouts/vertical-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $site_url; ?>src/assets/css/dark/authentication/auth-boxed.css" rel="stylesheet" type="text/css" />
</head>

<body class="form">
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>

    <div class="auth-container d-flex">
        <div class="container mx-auto align-self-center">
            <div class="row">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
                            <form action="login-db.php" method="POST">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h2>Sign In</h2>
                                        <p>Enter your email address and password to login</p>
                                        <?php if($mymsg != "") { echo $mymsg; } ?>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email Address</label>
                                            <input required type="email" name="user_email_address" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label">Password</label>
                                            <input required type="password" name="user_password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <input type="submit" class="btn btn-secondary w-100" value="SIGN IN">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <script src="<?php echo $site_url; ?>src/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>