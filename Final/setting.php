<?php
include_once("includes/admin_top.php");
include_once("includes/admin_left.php");

if ($_SESSION["logged_user_id"] != 1 && $_SESSION["logged_user_id"] != 2) {
    myFormErr("dashboard.php", "", "");
    exit;
}

$Page_Title = "Profile Details";

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
        $mymsg = '<div class="alert alert-success alert-dismissible" role="alert">Item details has been updated successfully.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    } else {
    }
}

$selectsitesettengs = $pdo->query("SELECT * FROM tbl_site_details WHERE site_id = 1");
$sitesettengs = $selectsitesettengs->fetch(PDO::FETCH_ASSOC);
$site_logo = $sitesettengs['site_logo'];
$site_rectangle_logo = $sitesettengs['site_rectangle_logo'];
$site_home_screen = $sitesettengs['site_home_screen'];
$site_signature = $sitesettengs['site_signature'];

$site_name = $sitesettengs['site_name'];
$site_short_name = $sitesettengs['site_short_name'];
$site_email_address = $sitesettengs['site_email_address'];
$site_mobile_number = $sitesettengs['site_mobile_number'];
$site_gst_number = $sitesettengs['site_gst_number'];
$site_address = $sitesettengs['site_address'];
$site_website = $sitesettengs['site_website'];

$site_quotation_prefix = $sitesettengs['site_quotation_prefix'];
$site_proforma_prefix = $sitesettengs['site_proforma_prefix'];

$site_client_name = $sitesettengs['site_client_name'];
$site_client_number = $sitesettengs['site_client_number'];
$site_client_gst_number = $sitesettengs['site_client_gst_number'];
$site_client_address = $sitesettengs['site_client_address'];

$site_bank_name = $sitesettengs['site_bank_name'];
$site_account_name = $sitesettengs['site_account_name'];
$site_ifsc_code = $sitesettengs['site_ifsc_code'];
$site_swift_code = $sitesettengs['site_swift_code'];
$site_account_number = $sitesettengs['site_account_number'];
$site_bank_address = $sitesettengs['site_bank_address'];

$site_terms_title_one = $sitesettengs['site_terms_title_one'];
$site_terms_one = $sitesettengs['site_terms_one'];
$site_terms_title_two = $sitesettengs['site_terms_title_two'];
$site_terms_two = $sitesettengs['site_terms_two'];
$site_terms_title_three = $sitesettengs['site_terms_title_three'];
$site_terms_three = $sitesettengs['site_terms_three'];
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

<div class="row layout-top-spacing">
    <div id="basic" class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>CRM Profile</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form class="custom-search-form" id="dataform" method="post">
                    <div class="row mb-3">
                        <label for="inputEmail2" class="col-sm-2 col-form-label">Logo <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input required type="file" name="site_logo" class="form-control redborder" accept=".jpeg, .jpg, .png">
                            <?php if ($site_logo != "") { ?>
                                <br>
                                <img src="images/<?php echo $site_logo; ?>" width="50" />
                                <input type="hidden" name="hidden_site_logo" value="<?php echo $site_logo; ?>">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail2" class="col-sm-2 col-form-label">Company Name <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input required type="text" placeholder="Company Name – Display Name" name="site_name" value="<?php echo $site_name; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail2" class="col-sm-2 col-form-label">Email Address <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input required type="email" placeholder="Mail id" name="site_email_address" value="<?php echo $site_email_address; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail2" class="col-sm-2 col-form-label">Mobile Number <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input required type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10" placeholder="Mobile Number" name="site_mobile_number" value="<?php echo $site_mobile_number; ?>" class="form-control" onkeypress="return PhoneNumber(event)">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail2" class="col-sm-2 col-form-label">GST Number <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input required type="text" placeholder="GST Number" name="site_gst_number" value="<?php echo $site_gst_number; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail2" class="col-sm-2 col-form-label">Address <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <textarea required placeholder="Address" name="site_address" rows="4" class="form-control" id="exampleFormControlTextarea1" required><?php echo $site_address; ?></textarea>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div id="inquiryloading"></div>
                        <div class="form-message"></div>
                        <div class="form-error"></div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="button" id="submitbtn" class="btn btn-success _effect--ripple waves-effect waves-light me-2">Submit</button>
                            <button type="button" onclick="window.location = 'dashboard.php'" class="btn btn-danger _effect--ripple waves-effect waves-light">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>    

<?php include_once("includes/admin_bottom.php"); ?>

<script type="text/javascript">
jQuery('#submitbtn').click(function () {
    event.preventDefault();

    $.ajax({
        type: "POST",
        url: "<?php echo SITE_URL; ?>setting-db.php",
        data: new FormData($("#dataform")[0]),

        beforeSend: function () {
            $('#inquiryloading').html(
                '<img src="src/assets/img/ajax-loader.gif"/>'
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

                $('.form-message').html('<div class="alert alert-success my-3" role="alert">Profile details has been updated successfully.</div>').fadeIn('slow');

                $(".form-message").show().delay(2000).fadeOut('slow');

                setTimeout(function () { window.location = '<?php echo SITE_URL; ?>setting'; }, 2000);
            } else if (html.status == 2) {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">Please fill out all fields.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            } else if (html.status == 3) {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">Invalid email address.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            } else if (html.status == 4) {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">Mobile number should be of 10 digit.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            } else if (html.status == 5) {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">File too big, maximum file size is 1MB.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            } else if (html.status == 11) {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">Upload jpg, jpeg, png file only.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            } else {
                $('.form-error').html('<div class="alert alert-danger my-3" role="alert">There was an error. Please try again.</div>').fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            }
        }
    });
});
</script>