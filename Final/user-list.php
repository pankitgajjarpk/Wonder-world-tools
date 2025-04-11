<?php
include_once("includes/admin_top.php");
include_once("includes/admin_left.php");

if ($_SESSION["logged_user_id"] != 1 && $_SESSION["logged_user_id"] != 2) {
    myFormErr("dashboard.php", "", "");
    exit;
}

$Page_Title = "Users List";

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

$err = isset($_REQUEST["err"]) ? strtolower(trim($_REQUEST["err"])) : "";
$msg = isset($_REQUEST["msg"]) ? strtolower(trim($_REQUEST["msg"])) : "";

if (strlen($err) > 0) {
    if ($err == "tryagain") {
        $mymsg = '<div class="alert alert-danger alert-dismissible" role="alert">There was an error. Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    } else {
    }
}

if (strlen($msg) > 0) {
    if ($msg == "delete") {
        $mymsg = '<div class="alert alert-success alert-dismissible" role="alert">User details has been updated successfully.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    } else {
    }
}

$selectusersdetails = $pdo->query("SELECT user_id, user_name, user_mobile_number, user_email_address, user_register_date, user_status FROM tbl_user_details WHERE user_id != '0' ORDER BY user_register_date ASC");
$totalcount = $selectusersdetails->rowCount();
?>
<div class="secondary-nav">
    <div class="breadcrumbs-container" data-page-heading="Analytics">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="btn-toggle sidebarCollapse">&nbsp;</a>
            <div class="d-flex breadcrumb-content">
                <div class="page-header">
                    <div class="page-title">
                    </div>
                    <nav class="breadcrumb-style-five" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $Page_Title; ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </header>
    </div>
</div>

<?php if ($mymsg != "") { echo $mymsg; } ?>

<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th class="no-content sorting">Mobile Number</th>
                        <th class="no-content sorting">Email Address</th>
                        <th style="text-align:center;">Joining Date</th>
                        <th style="text-align:center;" class="no-content sorting">Status</th>
                        <th style="text-align:center;" class="no-content sorting">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($selectusersdetails as $userdetails) {
                        $user_id = $userdetails['user_id'];
                        $user_name = $userdetails['user_name'];
                        $user_mobile_number = $userdetails['user_mobile_number'];
                        $user_email_address = $userdetails['user_email_address'];
                        $user_status = $userdetails['user_status'];
                        
                        if ($user_status == 'Yes') {
                            $userstatus = '<span class="badge badge-success">Active</span>';
                        } else {
                            $userstatus = '<span class="badge badge-danger">Deactivate</span>';
                        }
                        ?>
                        <tr>
                            <td><strong><?php echo $user_name; ?></strong></td>
                            <td><?php echo $user_mobile_number; ?></td>
                            <td><?php echo $user_email_address; ?></td>
                            <td></td>
                            <td style="text-align:center;"><?php echo $userstatus; ?></td>
                            <td style="text-align:center;">
                                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-original-title="Edit User Details" onclick="update_record(`<?= base64_encode($user_id) ?>`)" class="btn btn-sm btn-icon link-success"><i class="ti ti-edit mx-2 ti-sm"></i></a>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-danger" data-bs-original-title="Delete User Details" onclick="javascript:if(!confirm('Are you sure you want to delete user details?')) return false;" href="<?php echo SITE_URL; ?>user-db.php?myaction=delete&uid=<?php echo base64_encode($user_id); ?>" class="btn btn-sm btn-icon delete-record link-danger"><i class="ti ti-trash mx-2 ti-sm"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    $selectusersdetails->execute();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once("includes/admin_bottom.php"); ?>

<script type="text/javascript">
/*function manage_data_process() {
    event.preventDefault();

    $.ajax({
        type: "POST",
        url: "<?php echo SITE_URL; ?>user-db.php",
        data: new FormData($("#dataform")[0]),

        beforeSend: function () {
            $('#inquiryloading').html(
                '<img src="<?php echo SITE_URL; ?>images/ajax-loader.gif"/>'
            );
        },
        complete: function () {
            $("#inquiryloading").show().delay(1000).fadeOut('slow');
        },

        contentType: !1,
        processData: !1,
        success: function (e) {
            var html = jQuery.parseJSON(e);
            if (html.status == 1) {
                $(".form-error").css("display", "none");

                $('.form-message').html('<div class="alert alert-success my-3" role="alert">User details has been added successfully.</div>').fadeIn('slow');

                $(".form-message").show().delay(2000).fadeOut('slow');

                setTimeout(function () { window.location = '<?php echo SITE_URL; ?>user-list'; }, 2000);
            } else if (html.status == 11) {
                $(".form-error").css("display", "none");

                $('.form-message').html('<div class="alert alert-success my-3" role="alert">User details has been upadated successfully.</div>').fadeIn('slow');

                $(".form-message").show().delay(2000).fadeOut('slow');

                setTimeout(function () { window.location = '<?php echo SITE_URL; ?>user-list'; }, 2000);
            } else if (html.status == 2) {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">Please fill out all fields.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            } else if (html.status == 3) {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">Invalid email address.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            } else if (html.status == 4) {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">Email address already exists.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            } else if (html.status == 5) {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">Mobile number should be of 10 digit.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            } else if (html.status == 6) {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">Mobile number already exists.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            } else if (html.status == 7) {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">File too big, maximum file size is 1MB.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            } else if (html.status == 8) {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">Password Requirements: Must be at least 10 characters long and include at least one uppercase letter, one digit, and one special character.</div>').fadeIn('slow');
        }  else if (html.status == 15) {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">Upload jpg, jpeg, png file only.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            } else {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">There was an error. Please try again.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            }
        }
    });
}*/
</script>