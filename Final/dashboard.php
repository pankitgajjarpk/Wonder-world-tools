<?php
include_once("includes/admin_top.php");
include_once("includes/admin_left.php");

/*
1 - Admin Dashboard Target
2 - Admin Dashboard Quotation / Order
3 - Admin Dashboard Show Today Followup

4 - Target
5 - Quotation / Order
6 - Items Page
7 - Leads Tag
8 - Full Access (New Leads)

9 - User Dashboard Target
10 - User Dashboard Quotation / Order
11 - User Dashboard Show Today Followup

12 - Submit Button
*/

/*$insertmainuser = $pdo->query("INSERT INTO `tbl_user_details` (`user_id`, `user_code`, `user_type`, `user_image`, `user_name`, `user_email_address`, `user_password`, `user_mobile_number`, `user_designation`, `user_status`, `user_smtp_username`, `user_smtp_password`, `user_smtp_host`, `user_smtp_secure`, `user_smtp_port`, `user_register_date`, `user_register_date_time`) VALUES ('99', NULL, '1', NULL, 'Master Admin', 'info@adsenginemedia.com', MD5('India@2240'), '9726041648', 'Master Admin', 'Yes', NULL, NULL, NULL, NULL, NULL, '2024-10-11', '2024-10-11 19:01:33'");
$pdo->exec($insertmainuser);*/

$clientyesarray = array();

if ($_SESSION["logged_user_type_main"] == 1) {
    $client_user_id = '';
    $followup_user_id = '';
    $quotation_user_id = '';
    $order_user_id = '';
    $target_user_id = '';

    $selectnotifications = $pdo->query("SELECT notification_sent_id, notification_user_id, notification_details, notification_date FROM tbl_notification_details WHERE notification_date = '" . $tmpdate . "' ORDER BY notification_id DESC LIMIT 0,10");
    $notificationcount = $selectnotifications->rowCount();

    $selectclientyes = $pdo->query("SELECT client_id FROM tbl_client_details WHERE client_allocation_status = 'Yes' $client_user_id");
    while ($clientyesdetails = $selectclientyes->fetch(PDO::FETCH_ASSOC)) {
        $yes_client_id = $clientyesdetails['client_id'];

        array_push($clientyesarray, $yes_client_id);
    }
    $totalclientids = implode(",", $clientyesarray);
    if ($totalclientids != "") {
        $clientyesids = $totalclientids;
    } else {
        $clientyesids = 0;
    }

    $selecttargetdetails = $pdo->query("SELECT * FROM tbl_target_details ORDER BY target_id DESC");
} else {
    $client_user_id = " AND client_user_id = '" . $_SESSION["logged_user_id"] . "'";
    $followup_user_id = " AND followup_user_id = '" . $_SESSION["logged_user_id"] . "'";
    $quotation_user_id = " AND quotation_user_id = '" . $_SESSION["logged_user_id"] . "'";
    $order_user_id = " AND order_user_id = '" . $_SESSION["logged_user_id"] . "'";
    $target_user_id = " AND target_user_id = '" . $_SESSION["logged_user_id"] . "'";

    $selectnotifications = $pdo->query("SELECT notification_sent_id, notification_user_id, notification_details, notification_date FROM tbl_notification_details WHERE notification_date = '" . $tmpdate . "' AND (notification_sent_id = '" . $_SESSION["logged_user_id"] . "' OR FIND_IN_SET('" . $_SESSION["logged_user_id"] . "', notification_user_id) OR notification_user_id = 0) ORDER BY notification_id DESC  LIMIT 0,10");
    $notificationcount = $selectnotifications->rowCount();

    $selectclientyes = $pdo->query("SELECT client_id FROM tbl_client_details WHERE client_allocation_status = 'Yes' $client_user_id");
    while ($clientyesdetails = $selectclientyes->fetch(PDO::FETCH_ASSOC)) {
        $yes_client_id = $clientyesdetails['client_id'];

        array_push($clientyesarray, $yes_client_id);
    }
    $totalclientids = implode(",", $clientyesarray);
    if ($totalclientids != "") {
        $clientyesids = $totalclientids;
    } else {
        $clientyesids = 0;
    }

    $selecttargetdetails = $pdo->query("SELECT * FROM tbl_target_details WHERE target_user_id = '" . $_SESSION["logged_user_id"] . "' ORDER BY target_id DESC LIMIT 0,6");
}

/* Clients */
//$selecttotalclients = $pdo->query("SELECT client_id FROM tbl_client_details WHERE client_allocation_status = 'Yes' " . $client_user_id);
$selecttotalclients = $pdo->query("SELECT client_id FROM leads_list WHERE 1 = 1 " . $client_user_id);
$totalclients = $selecttotalclients->rowCount();

$selectmonthclients = $pdo->query("SELECT client_id FROM tbl_client_details WHERE client_allocation_status = 'Yes' AND month(client_register_date) = month('" . $tmpdate . "') AND year(client_register_date) = year('" . $tmpdate . "') " . $client_user_id);
$totalmonthclients = $selectmonthclients->rowCount();

$selecttodayclients = $pdo->query("SELECT client_id FROM tbl_client_details WHERE client_allocation_status = 'Yes' AND client_register_date = '" . $tmpdate . "' " . $client_user_id);
$totaltodayclients = $selecttodayclients->rowCount();

/* Follow Ups */
$selecttotalfollowups = $pdo->query("SELECT followup_id FROM tbl_client_followup_details WHERE followup_client_id IN(" . $clientyesids . ") " . $followup_user_id);
$totalfollowups = $selecttotalfollowups->rowCount();

$selectallfollowups = $pdo->query("SELECT followup_id FROM tbl_client_followup_details WHERE followup_client_id IN(" . $clientyesids . ") " . $followup_user_id);
$allfollowups = $selectallfollowups->rowCount();

$selectmonthfollowups = $pdo->query("SELECT followup_id, followup_added_date FROM tbl_client_followup_details WHERE month(followup_added_date) = month('" . $tmpdate . "') AND year(followup_added_date) = year('" . $tmpdate . "') " . $followup_user_id);
$totalmonthfollowups = $selectmonthfollowups->rowCount();

$selecttodayfollowup = $pdo->query("SELECT followup_id FROM tbl_client_followup_details WHERE followup_client_id IN(" . $clientyesids . ") AND followup_added_date = '" . $tmpdate . "' " . $followup_user_id);
$totaltodayfollowup = $selecttodayfollowup->rowCount();

/* Quotations */
$selecttotalquotations = $pdo->query("SELECT quotation_id FROM tbl_quotation_details WHERE quotation_status = 'Yes' " . $quotation_user_id);
$totalquotations = $selecttotalquotations->rowCount();

$selectmonthquotations = $pdo->query("SELECT quotation_id FROM tbl_quotation_details WHERE quotation_status = 'Yes' AND month(quotation_date) = month('" . $tmpdate . "') AND year(quotation_date) = year('".$tmpdate."') " . $quotation_user_id);
$totalmonthquotations = $selectmonthquotations->rowCount();

$selecttodayquotations = $pdo->query("SELECT quotation_id FROM tbl_quotation_details WHERE quotation_status = 'Yes' AND quotation_date = '" . $tmpdate . "' " . $quotation_user_id);
$totaltodayquotations = $selecttodayquotations->rowCount();

/* Orders */
$selecttotalorders = $pdo->query("SELECT order_id FROM tbl_order_details WHERE order_status = 'Yes' " . $order_user_id);
$totalorders = $selecttotalorders->rowCount();

$selectmonthorders = $pdo->query("SELECT order_id FROM tbl_order_details WHERE order_status = 'Yes' AND month(order_date) = month('" . $tmpdate . "') AND year(order_date) = year('".$tmpdate."') " . $order_user_id);
$totalmonthorders = $selectmonthorders->rowCount();

$selecttodayorders = $pdo->query("SELECT order_id FROM tbl_order_details WHERE order_status = 'Yes' AND order_date = '" . $tmpdate . "' " . $order_user_id);
$totaltodayorders = $selecttodayorders->rowCount();

if ($_SESSION["logged_user_type_main"] == 1) {
    $checkdashboardtarget = CheckPermission($_SESSION["logged_user_type_id"], 1, '');
    $checkdashboardquotationorder = CheckPermission($_SESSION["logged_user_type_id"], 2, '');
    $checkdashboardfollowups = CheckPermission($_SESSION["logged_user_type_id"], 3, '');
} else {
    $checkdashboardtarget = CheckPermission($_SESSION["logged_user_type_id"], 9, '');
    $checkdashboardquotationorder = CheckPermission($_SESSION["logged_user_type_id"], 10, '');
    $checkdashboardfollowups = CheckPermission($_SESSION["logged_user_type_id"], 11, '');
}

$selecttotalleads = $pdo->query("SELECT count(client_id) as TotalLeads FROM tbl_client_details WHERE client_allocation_status = 'Yes'");
$totalLeaddetails = $selecttotalleads->fetch(PDO::FETCH_ASSOC);
$TotalLeadscount = $totalLeaddetails['TotalLeads'];

if ($TotalLeadscount > 0) {
    $TotalLeads = $TotalLeadscount;
} else {
    $TotalLeads = 0;
}
?>
<div class="container-xxl flex-grow-1 container-p-y dashbord-details">
    <div class="row topdashboardtotals">
        <div class="col-xl-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="row space-between align-center">
                    <div class="col-xl-6 col-md-6 col-6 mb-3">
                        <div class="icondata">
                            <div class="iconbg">
                                <i class="ti ti-users ti-md"></i>
                            </div>
                            <h5>Leads</h5>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-6 mb-2">
                        <div class="totaldata">
                            <h5><?php if ($totalclients > 0) { echo $totalclients; } else { echo '0'; } ?></h5>
                            <small>Total Leads</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-6 mb-2">
                        <div class="monthleads">
                            <h5><?php if ($totalmonthclients > 0) { echo $totalmonthclients; } else { echo '0'; } ?></h5>
                            <small><?php echo date('F - Y'); ?></small>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-6">
                        <div class="todayleads">
                            <h5><?php if ($totaltodayclients > 0) { echo $totaltodayclients; } else { echo '0'; } ?></h5>
                            <small><?php echo date('d-m-Y'); ?></small>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="totalmorelink">
                            <span>View All</span>
                            <span><a href="<?php echo SITE_URL; ?>leads-list"><i class="fa-solid fa-arrow-right"></i></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="row space-between align-center">
                    <div class="col-xl-6 col-md-6 col-6 mb-3">
                        <div class="icondata">
                            <div class="iconbg">
                                <i class="ti ti-phone-call ti-md"></i>
                            </div>
                            <h5>Follow-up</h5>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-6 mb-2">
                        <div class="totaldata">
                            <h5><?php if ($totalfollowups > 0) { echo $totalfollowups; } else { echo '0'; } ?></h5>
                            <small>Total Follow-up</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-6 mb-2">
                        <div class="monthleads">
                            <h5><?php if ($totalmonthfollowups > 0) { echo $totalmonthfollowups; } else { echo '0'; } ?></h5>
                            <small><?php echo date('F - Y'); ?></small>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-6">
                        <div class="todayleads">
                            <h5><?php if ($totaltodayfollowup > 0) { echo $totaltodayfollowup; } else { echo '0'; } ?></h5>
                            <small><?php echo date('d-m-Y'); ?></small>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="totalmorelink">
                            <span>View All</span>
                            <span><a href="<?php echo SITE_URL; ?>follow-up-history"><i class="fa-solid fa-arrow-right"></i></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="row space-between align-center">
                    <div class="col-xl-6 col-md-6 col-6 mb-3">
                        <div class="icondata">
                            <div class="iconbg">
                                <i class="ti ti-clipboard ti-md"></i>
                            </div>
                            <h5>Quotations</h5>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-6 mb-2">
                        <div class="totaldata">
                            <h5><?php if ($totalquotations > 0) { echo $totalquotations; } else { echo '0'; } ?></h5>
                            <small>Total Quotations</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-6 mb-2">
                        <div class="monthleads">
                            <h5><?php if ($totalmonthquotations > 0) { echo $totalmonthquotations; } else { echo '0'; } ?></h5>
                            <small><?php echo date('F - Y'); ?></small>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-6">
                        <div class="todayleads">
                            <h5><?php if ($totaltodayquotations > 0) { echo $totaltodayquotations; } else { echo '0'; } ?></h5>
                            <small><?php echo date('d-m-Y'); ?></small>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="totalmorelink">
                            <span>View All</span>
                            <span><a href="<?php echo SITE_URL; ?>quotation-list"><i class="fa-solid fa-arrow-right"></i></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="row space-between align-center">
                    <div class="col-xl-6 col-md-6 col-6 mb-3">
                        <div class="icondata">
                            <div class="iconbg">
                                <i class="ti ti-shopping-cart ti-md"></i>
                            </div>
                            <h5>Orders</h5>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-6 mb-2">
                        <div class="totaldata">
                            <h5><?php if ($totalorders > 0) { echo $totalorders; } else { echo '0'; } ?></h5>
                            <small>Total Orders</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-6 mb-2">
                        <div class="monthleads">
                            <h5><?php if ($totalmonthorders > 0) { echo $totalmonthorders; } else { echo '0'; } ?></h5>
                            <small><?php echo date('F - Y'); ?></small>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-6">
                        <div class="todayleads">
                            <h5><?php if ($totaltodayorders > 0) { echo $totaltodayorders; } else { echo '0'; } ?></h5>
                            <small><?php echo date('d-m-Y'); ?></small> 
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="totalmorelink">
                            <span>View All</span>
                            <span><a href="<?php echo SITE_URL; ?>quotation-list"><i class="fa-solid fa-arrow-right"></i></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php /* ?><div class="row webdashboardtotals">
        <div class="col-xl-3 col-md-3 col-3 mb-4">
            <div class="card">
                <div class="card-body" style="background-color: #E5F8ED; border: 1px solid #5e5873; border-radius: 2px;">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-12">
                            <div class="badge p-2 mb-2 rounded" style="background-color: #fff; color: #28c76f;">
                                <i class="ti ti-users ti-md"></i>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-8 col-12 text-right">
                            <button type="button" onclick="window.location = '<?php echo SITE_URL; ?>leads-list'" class="btn btn-primary waves-effect waves-float waves-light">View All</button>
                        </div>
                    </div>
                    <h5 class="card-title mb-2 pt-2">Total Leads</h5>
                    <h5 class="card-title mb-0">
                        <?php if ($totalclients > 0) {
                            echo $totalclients;
                        } else {
                            echo '0';
                        } ?>
                    </h5>
                    <small>All Time</small>
                    <hr>
                    <h5 class="card-title mb-0">
                        <?php if ($totalmonthclients > 0) {
                            echo $totalmonthclients;
                        } else {
                            echo '0';
                        } ?>
                    </h5>
                    <small><?php echo date('F - Y'); ?></small>
                    <hr>
                    <h5 class="card-title mb-0">
                        <?php if ($totaltodayclients > 0) {
                            echo $totaltodayclients;
                        } else {
                            echo '0';
                        } ?>
                    </h5>
                    <small><?php echo date('d-m-Y'); ?></small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 col-3 mb-4">
            <div class="card">
                <div class="card-body" style="background-color: #FFEDDD; border: 1px solid #5e5873; border-radius: 2px;">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-12">
                            <div class="badge p-2 mb-2 rounded" style="background-color: #fff; color: #ff9f43;">
                                <i class="ti ti-phone-call ti-md"></i>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-8 col-12 text-right">
                            <button type="button" onclick="window.location = '<?php echo SITE_URL; ?>follow-up-history'" class="btn btn-primary waves-effect waves-float waves-light">View All</button>
                        </div>
                    </div>
                    <h5 class="card-title mb-2 pt-2">Total Follow-up Updated</h5>
                    <h5 class="card-title mb-0">
                        <?php if ($totalfollowups > 0) {
                            echo $totalfollowups;
                        } else {
                            echo '0';
                        } ?>
                    </h5>
                    <small>All Time</small>
                    <hr>
                    <h5 class="card-title mb-0">
                        <?php if ($totalmonthfollowups > 0) {
                            echo $totalmonthfollowups;
                        } else {
                            echo '0';
                        } ?>
                    </h5>
                    <small><?php echo date('F - Y'); ?></small>
                    <hr>
                    <h5 class="card-title mb-0">
                        <?php if ($totaltodayfollowup > 0) {
                            echo $totaltodayfollowup;
                        } else {
                            echo '0';
                        } ?>
                    </h5>
                    <small><?php echo date('d-m-Y'); ?></small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 col-3 mb-4">
            <div class="card">
                <div class="card-body" style="background-color: #EEECFE; border: 1px solid #5e5873; border-radius: 2px;">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-12">
                            <div class="badge p-2 mb-2 rounded" style="background-color: #fff; color: #7367f0;">
                                <i class="ti ti-clipboard ti-md"></i>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-8 col-12 text-right">
                            <button type="button" onclick="window.location = '<?php echo SITE_URL; ?>quotation-list'" class="btn btn-primary waves-effect waves-float waves-light">View All</button>
                        </div>
                    </div>
                    <h5 class="card-title mb-2 pt-2">Total Quotations</h5>
                    <h5 class="card-title mb-0">
                        <?php if ($totalquotations > 0) {
                            echo $totalquotations;
                        } else {
                            echo '0';
                        } ?>
                    </h5>
                    <small>All Time</small>
                    <hr>
                    <h5 class="card-title mb-0">
                        <?php if ($totalmonthquotations > 0) {
                            echo $totalmonthquotations;
                        } else {
                            echo '0';
                        } ?>
                    </h5>
                    <small><?php echo date('F - Y'); ?></small>
                    <hr>
                    <h5 class="card-title mb-0">
                        <?php if ($totaltodayquotations > 0) {
                            echo $totaltodayquotations;
                        } else {
                            echo '0';
                        } ?>
                    </h5>
                    <small><?php echo date('d-m-Y'); ?></small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 col-3 mb-4">
            <div class="card">
                <div class="card-body" style="background-color: #D2F6FC; border: 1px solid #5e5873; border-radius: 2px;">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-12">
                            <div class="badge p-2 mb-2 rounded" style="background-color: #fff; color: #00cfe8;">
                                <i class="ti ti-shopping-cart ti-md"></i>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-8 col-12 text-right">
                            <button type="button" onclick="window.location = '<?php echo SITE_URL; ?>order-list'" class="btn btn-primary waves-effect waves-float waves-light">View All</button>
                        </div>
                    </div>
                    <h5 class="card-title mb-2 pt-2">Total Orders</h5>
                    <h5 class="card-title mb-0"><?php if ($totalorders > 0) {
                        echo $totalorders;
                    } else {
                        echo '0';
                    } ?>
                    </h5>
                    <small>All Time</small>
                    <hr>
                    <h5 class="card-title mb-0">
                        <?php if ($totalmonthorders > 0) {
                            echo $totalmonthorders;
                        } else {
                            echo '0';
                        } ?>
                    </h5>
                    <small><?php echo date('F - Y'); ?></small>
                    <hr>
                    <h5 class="card-title mb-0">
                        <?php if ($totaltodayorders > 0) {
                            echo $totaltodayorders;
                        } else {
                            echo '0';
                        } ?>
                    </h5>
                    <small><?php echo date('d-m-Y'); ?></small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mobiledashboardtotals">
        <div class="col-xl-3 col-md-3 col-12 mb-2">
            <div class="card">
                <div class="card-body" style="background-color: #E5F8ED; border: 1px solid #5e5873; border-radius: 2px;">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-2">
                            <div class="badge p-2 mb-2 rounded" style="background-color: #fff; color: #28c76f;">
                                <i class="ti ti-users ti-md"></i>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-8 col-6">
                            <h5 class="card-title mb-0">Total Leads</h5>
                            <h5 class="card-title mb-0">
                                <?php if ($totalclients > 0) {
                                    echo $totalclients;
                                } else {
                                    echo '0';
                                } ?>
                            </h5>
                            <small>All Time</small>
                        </div>
                        <div class="col-xl-8 col-md-8 col-4 text-right mt-2">
                            <button type="button" onclick="window.location = '<?php echo SITE_URL; ?>leads-list'" class="btn btn-primary waves-effect waves-float waves-light">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 col-12 mb-2">
            <div class="card">
                <div class="card-body" style="background-color: #FFEDDD; border: 1px solid #5e5873; border-radius: 2px;">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-2">
                            <div class="badge p-2 mb-2 rounded" style="background-color: #fff; color: #ff9f43;">
                                <i class="ti ti-phone-call ti-md"></i>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-8 col-6">
                            <h5 class="card-title mb-0">Total Follow-up Updated</h5>
                            <h5 class="card-title mb-0">
                                <?php if ($totalfollowups > 0) {
                                    echo $totalfollowups;
                                } else {
                                    echo '0';
                                } ?>
                            </h5>
                            <small>All Time</small>
                        </div>
                        <div class="col-xl-8 col-md-8 col-4 text-right mt-2">
                            <button type="button" onclick="window.location = '<?php echo SITE_URL; ?>follow-up-history'" class="btn btn-primary waves-effect waves-float waves-light">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 col-12 mb-2">
            <div class="card">
                <div class="card-body" style="background-color: #EEECFE; border: 1px solid #5e5873; border-radius: 2px;">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-2">
                            <div class="badge p-2 mb-2 rounded" style="background-color: #fff; color: #7367f0;">
                                <i class="ti ti-clipboard ti-md"></i>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-8 col-6">
                            <h5 class="card-title mb-0">Total Quotations</h5>
                            <h5 class="card-title mb-0">
                                <?php if ($totalquotations > 0) {
                                    echo $totalquotations;
                                } else {
                                    echo '0';
                                } ?>
                            </h5>
                            <small>All Time</small>
                        </div>
                        <div class="col-xl-8 col-md-8 col-4 text-right mt-2">
                            <button type="button" onclick="window.location = '<?php echo SITE_URL; ?>quotation-list'" class="btn btn-primary waves-effect waves-float waves-light">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 col-12 mb-2">
            <div class="card">
                <div class="card-body" style="background-color: #D2F6FC; border: 1px solid #5e5873; border-radius: 2px;">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-2">
                            <div class="badge p-2 mb-2 rounded" style="background-color: #fff; color: #00cfe8;">
                                <i class="ti ti-shopping-cart ti-md"></i>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-8 col-6">
                            <h5 class="card-title mb-0">Total Orders</h5>
                            <h5 class="card-title mb-0">
                                <?php if ($totalorders > 0) {
                                    echo $totalorders;
                                } else {
                                    echo '0';
                                } ?>
                            </h5>
                            <small>All Time</small>
                        </div>
                        <div class="col-xl-8 col-md-8 col-4 text-right mt-2">
                            <button type="button" onclick="window.location = '<?php echo SITE_URL; ?>order-list'" class="btn btn-primary waves-effect waves-float waves-light">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><?php */ ?>

    <!-- Lead Followup Status & Leads Source Status -->
    <div class="row">
        <div class="col-xl-4 col-md-4 col-12 mb-4">
            <div class="card h-100 custom-data-border">
                <div class="card-header d-flex justify-content-between dashboardchart">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Leads Source (Top 5 Source)</h5>
                        <!-- <small class="text-muted">Top 5 Source</small> -->
                    </div>
                </div>
                <div class="card-body">                    
                    <?php
                    $totalleadsources = 1;

                    $selectleadsources = $pdo->query("SELECT count(client_id) as TotalLeadSourceClients, client_inquiry_source FROM tbl_client_details WHERE client_allocation_status = 'Yes' AND client_id IN(" . $clientyesids . ") AND client_inquiry_source != '' GROUP By client_inquiry_source ORDER BY TotalLeadSourceClients DESC LIMIT 0,5");
                    while ($leadourcesdetails = $selectleadsources->fetch(PDO::FETCH_ASSOC)) {
                        $TotalLeadSourceClients = $leadourcesdetails['TotalLeadSourceClients'];
                        $client_inquiry_source = $leadourcesdetails['client_inquiry_source'];

                        $dbsourcedetails = get_single_data("tbl_inquiry_source_details", "inquiry_source_name", "inquiry_source_id = '" . $client_inquiry_source . "'");

                        if ($TotalLeadSourceClients > 0 && $TotalLeads > 0) {
                            $totalsourceper = $TotalLeadSourceClients * 100 / $TotalLeads;
                        } else {
                            $totalsourceper = 0;
                        }
                        ?>
                        <div class="row progress-bar-data">
                            <div class="col-xl-2 col-md-2 col-2 <?php if($totalleadsources != 5) { echo 'mb-4'; } else { echo 'mb-2'; } ?>">
                                <div class="badge source-data p-2 me-3 rounded">
                                    <i class="ti ti-hook ti-sm"></i>
                                </div>
                            </div>
                            <div class="col-xl-8 col-md-8 col-8 <?php if($totalleadsources != 5) { echo 'mb-4'; } else { echo 'mb-2'; } ?>">
                                <h5 class="mb-2 link-dark"><?php echo $dbsourcedetails; ?></h5>
                                <div class="progress w-100 me-3" style="height: 8px">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo round($totalsourceper); ?>%" aria-valuenow="<?php echo $TotalLeadSourceClients; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="me-3" style="height: 8px">
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-2 mb-0">
                                <span class="text-muted">
                                    <?php if ($TotalLeadSourceClients > 0) {
                                        echo $TotalLeadSourceClients;
                                    } else {
                                        echo '0';
                                    } ?>
                                </span>
                            </div>
                        </div>
                        <?php
                        $totalleadsources++;
                    }
                    ?>

                    <?php /* ?><ul class="p-0 m-0">
                        $selectleadsources = $pdo->query("SELECT count(client_id) as TotalLeadSourceClients, client_inquiry_source FROM tbl_client_details WHERE client_allocation_status = 'Yes' AND client_inquiry_source != '' GROUP By client_inquiry_source ORDER BY TotalLeadSourceClients DESC LIMIT 0,5");
                        while ($leadourcesdetails = $selectleadsources->fetch(PDO::FETCH_ASSOC)) {
                            $TotalLeadSourceClients = $leadourcesdetails['TotalLeadSourceClients'];
                            $client_inquiry_source = $leadourcesdetails['client_inquiry_source'];

                            if ($totalleadsources == 1)
                                $colorcode = 'success';
                            if ($totalleadsources == 2)
                                $colorcode = 'primary';
                            if ($totalleadsources == 3)
                                $colorcode = 'purple';
                            if ($totalleadsources == 4)
                                $colorcode = 'orange';
                            if ($totalleadsources == 5)
                                $colorcode = 'danger';

                            $dbsourcedetails = get_single_data("tbl_inquiry_source_details", "inquiry_source_name", "inquiry_source_id = '" . $client_inquiry_source . "'");

                            if ($TotalLeadSourceClients > 0 && $TotalLeads > 0) {
                                $totalsourceper = $TotalLeadSourceClients * 100 / $TotalLeads;
                            } else {
                                $totalsourceper = 0;
                            }
                            ?>
                            <li class="mb-2 pb-2 d-flex">
                                <div class="d-flex w-50 align-items-center me-3">
                                    <div class="badge bg-label-<?php echo $colorcode; ?> p-2 me-3 rounded">
                                        <i class="ti ti-hook ti-sm"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 link-<?php echo $colorcode; ?>"><?php echo $dbsourcedetails; ?></h5>
                                    </div>
                                </div>
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <div class="progress w-100 me-3" style="height: 8px">
                                        <div class="progress-bar bg-<?php echo $colorcode; ?>" role="progressbar" style="width: <?php echo round($totalsourceper); ?>%" aria-valuenow="<?php echo $TotalLeadSourceClients; ?>" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <div class="w-100 me-3" style="height: 8px">
                                    </div>
                                    <span class="text-muted">
                                        <?php if ($TotalLeadSourceClients > 0) {
                                            echo $TotalLeadSourceClients;
                                        } else {
                                            echo '0';
                                        } ?>
                                    </span>
                                </div>
                            </li>
                            <?php
                            $totalleadsources++;
                        }
                        ?>
                    </ul><?php */ ?>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-12 mb-4">
            <div class="card h-100 custom-data-border">
                <div class="card-header d-flex justify-content-between dashboardchart">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Leads Type (Top 5 Types)</h5>
                        <!-- <small class="text-muted">Top 5 Types</small> -->
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $totalleadtypes = 1;

                    $selectleadtypes = $pdo->query("SELECT count(client_id) as TotalLeadTypeClients, client_inquiry_type FROM tbl_client_details WHERE client_inquiry_type != '' AND client_id IN(" . $clientyesids . ") GROUP By client_inquiry_type ORDER BY TotalLeadTypeClients DESC LIMIT 0,5");
                    while ($leadtypedetails = $selectleadtypes->fetch(PDO::FETCH_ASSOC)) {
                        $TotalLeadTypeClients = $leadtypedetails['TotalLeadTypeClients'];
                        $client_inquiry_type = $leadtypedetails['client_inquiry_type'];

                        $dbtypedetails = get_single_data("tbl_inquiry_type_details", "inquiry_type_name", "inquiry_type_id = '" . $client_inquiry_type . "'");

                        if ($TotalLeadTypeClients > 0 && $TotalLeads > 0) {
                            $totaltypeper = $TotalLeadTypeClients * 100 / $TotalLeads;
                        } else {
                            $totaltypeper = 0;
                        }
                        ?>
                        <div class="row progress-bar-data">
                            <div class="col-xl-2 col-md-2 col-2 <?php if($totalleadtypes != 5) { echo 'mb-4'; } else { echo 'mb-2'; } ?>">
                                <div class="badge type-data p-2 me-3 rounded">
                                    <i class="ti ti-briefcase ti-sm"></i>
                                </div>
                            </div>
                            <div class="col-xl-8 col-md-8 col-8 <?php if($totalleadtypes != 5) { echo 'mb-4'; } else { echo 'mb-2'; } ?>">
                                <h5 class="mb-2 link-dark"><?php echo $dbtypedetails; ?></h5>
                                <div class="progress w-100 me-3" style="height: 8px">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo round($totaltypeper); ?>%" aria-valuenow="<?php echo $TotalLeadTypeClients; ?>" aria-valuemin="0"                   aria-valuemax="100"></div>
                                </div>
                                <div class="me-3" style="height: 8px">
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-2 mb-0">
                                <span class="text-muted">
                                    <?php if ($TotalLeadTypeClients > 0) { echo $TotalLeadTypeClients; } else { echo '0'; } ?>
                                </span>
                            </div>
                        </div>
                        <?php
                        $totalleadtypes++;
                    }
                    ?>

                    <?php /* ?><ul class="p-0 m-0">
                        <?php
                        $totalleadtypes = 1;

                        $selectleadtypes = $pdo->query("SELECT count(client_id) as TotalLeadTypeClients, client_inquiry_type FROM tbl_client_details WHERE client_inquiry_type != '' GROUP By client_inquiry_type ORDER BY TotalLeadTypeClients DESC LIMIT 0,5");
                        while ($leadtypedetails = $selectleadtypes->fetch(PDO::FETCH_ASSOC)) {
                            $TotalLeadTypeClients = $leadtypedetails['TotalLeadTypeClients'];
                            $client_inquiry_type = $leadtypedetails['client_inquiry_type'];

                            if ($totalleadtypes == 1)
                                $colorcode = 'success';
                            if ($totalleadtypes == 2)
                                $colorcode = 'primary';
                            if ($totalleadtypes == 3)
                                $colorcode = 'purple';
                            if ($totalleadtypes == 4)
                                $colorcode = 'orange';
                            if ($totalleadtypes == 5)
                                $colorcode = 'danger';

                            $dbtypedetails = get_single_data("tbl_inquiry_type_details", "inquiry_type_name", "inquiry_type_id = '" . $client_inquiry_type . "'");

                            if ($TotalLeadTypeClients > 0 && $TotalLeads > 0) {
                                $totaltypeper = $TotalLeadTypeClients * 100 / $TotalLeads;
                            } else {
                                $totaltypeper = 0;
                            }
                            ?>
                            <li class="mb-2 pb-2 d-flex">
                                <div class="d-flex w-50 align-items-center me-3">
                                    <div class="badge bg-label-<?php echo $colorcode; ?> p-2 me-3 rounded">
                                        <i class="ti ti-hook ti-sm"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 link-<?php echo $colorcode; ?>"><?php echo $dbtypedetails; ?></h5>
                                    </div>
                                </div>
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <div class="progress w-100 me-3" style="height: 8px">
                                        <div class="progress-bar bg-<?php echo $colorcode; ?>" role="progressbar" style="width: <?php echo round($totaltypeper); ?>%" aria-valuenow="<?php echo $TotalLeadTypeClients; ?>" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <div class="w-100 me-3" style="height: 8px">
                                    </div>
                                    <span class="text-muted">
                                        <?php if ($TotalLeadTypeClients > 0) {
                                            echo $TotalLeadTypeClients;
                                        } else {
                                            echo '0';
                                        } ?>                                            
                                    </span>
                                </div>
                            </li>
                            <?php
                            $totalleadtypes++;
                        }
                        ?>
                    </ul><?php */ ?>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-12 mb-4">
            <div class="card h-100 custom-data-border">
                <div class="card-header d-flex justify-content-between dashboardchart">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Leads Status (Top 5 Status)</h5>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $totalleadstatus = 1;

                    $selectleadstatus = $pdo->query("SELECT count(followup_id) as TotalLeadStatusId, followup_status FROM tbl_client_followup_details WHERE followup_tag = '1' AND followup_client_id IN(" . $clientyesids . ") AND followup_status != 99 AND followup_status != 0 GROUP By followup_status ORDER BY TotalLeadStatusId DESC LIMIT 0,5");
                    while ($leadstatusdetails = $selectleadstatus->fetch(PDO::FETCH_ASSOC)) {
                        $TotalLeadStatusId = $leadstatusdetails['TotalLeadStatusId'];
                        $client_followup_status = $leadstatusdetails['followup_status'];

                        $dbstatusdetails = get_single_data("tbl_inquiry_status_details", "inquiry_status_name", "inquiry_status_id = '" . $client_followup_status . "'");

                        //echo $TotalLeadStatusId. ' - '.$TotalLeads. ' - '.$totalfollowups;
                        if ($TotalLeadStatusId > 0 && $TotalLeads > 0 && $totalfollowups > 0) {
                            $totalstatusper = $TotalLeadStatusId * 100 / $totalfollowups;
                        } else {
                            $totalstatusper = 0;
                        }
                        ?>
                        <div class="row progress-bar-data">
                            <div class="col-xl-2 col-md-2 col-2 <?php if($totalleadstatus != 5) { echo 'mb-4'; } else { echo 'mb-2'; } ?>">
                                <div class="badge status-data p-2 me-3 rounded">
                                    <i class="ti ti-headphones ti-sm"></i>
                                </div>
                            </div>
                            <div class="col-xl-8 col-md-8 col-8 <?php if($totalleadstatus != 5) { echo 'mb-4'; } else { echo 'mb-2'; } ?>">
                                <h5 class="mb-2 link-dark"><?php echo $dbstatusdetails; ?></h5>
                                <div class="progress w-100 me-3" style="height: 8px">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo round($totalstatusper); ?>%" aria-valuenow="<?php echo $TotalLeadStatusId; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="me-3" style="height: 8px">
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-2 mb-0">
                                <span class="text-muted">
                                    <?php if ($TotalLeadStatusId > 0) { echo $TotalLeadStatusId; } else { echo '0'; } ?>
                                </span>
                            </div>
                        </div>
                        <?php
                        $totalleadstatus++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php if ($checkdashboardtarget == 1) { ?>
            <!-- Target -->
            <div class="col-lg-12 col-12 mb-4 mobilehidesection">
                <div class="card h-100 custom-data-border">
                    <div class="card-header text-center" style="padding: 15px 0px 12px 0px; background: linear-gradient(50deg, rgba(60, 155, 61, 1) 45%, rgba(1, 160, 164, 1) 65%);">
                        <h5 class="card-title m-0 me-2" style="color: #FFF;">Target Report (Only Domestic orders count in
                            target section)</h5>
                    </div>
                    <?php if ($_SESSION["logged_user_type_main"] == 1) { ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>User</th>
                                        <th style="text-align:center;">Total Target</th>
                                        <th style="text-align:center;">Total Collection</th>
                                        <th style="text-align:center;">Performance (%)</th>
                                        <th style="text-align:center;" class="no-sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $selectuserdetails = $pdo->query("SELECT user_id, user_name FROM tbl_user_details WHERE user_id != '99' AND  user_status = 'Yes' ORDER BY user_id ASC");
                                    while ($userdetails = $selectuserdetails->fetch(PDO::FETCH_ASSOC)) {
                                        $user_id = $userdetails['user_id'];
                                        $user_name = $userdetails['user_name'];

                                        $totaltargetamount = $pdo->query("SELECT sum(target_domestic_amount) AS TotalTargetAmounts FROM tbl_target_details WHERE target_user_id = '" . $user_id . "'");
                                        $targetamount = $totaltargetamount->fetch(PDO::FETCH_ASSOC);
                                        $total_target_amount = $targetamount['TotalTargetAmounts'];

                                        $totalorderamount = $pdo->query("SELECT sum(order_after_discount_amount) AS TotalOrderAmounts FROM tbl_order_details WHERE order_type = 'domestic' AND order_user_id = '" . $user_id . "'");
                                        $orderamount = $totalorderamount->fetch(PDO::FETCH_ASSOC);
                                        $usertotalsalesamount = $orderamount['TotalOrderAmounts'];
                            
                                        if ($usertotalsalesamount > 0 && $total_target_amount > 0) {
                                            $average = $usertotalsalesamount * 100 / $total_target_amount;
                                        } else {
                                            $average = 0;
                                        }
                                        ?>
                                        <tr>
                                            <td><strong><?php echo $user_name; ?></strong></td>
                                            <td style="text-align:center;">
                                                <?php echo "Rs. " . ind_money_format($total_target_amount); ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <span class="item-edit link-success">
                                                    <?php if ($usertotalsalesamount > 0) {
                                                        echo "Rs. " . ind_money_format($usertotalsalesamount);
                                                    } else {
                                                        echo "Rs. 0";
                                                    } ?>
                                                </span>
                                            </td>
                                            <td style="text-align:center;">
                                                <span class="item-edit link-info">
                                                    <?php if ($usertotalsalesamount > 0) {
                                                        echo round($average) . "%";
                                                    } else {
                                                        echo "0%";
                                                    }
                                                    ?>                                                    
                                                </span>
                                            </td>
                                            <td style="text-align:center;">
                                                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-primary" data-bs-original-title="View Collection" href="target-collection-details/<?php echo base64_encode($user_id); ?>" class="btn btn-sm btn-icon delete-record link-primary"><i class="ti ti-eye mx-2 ti-sm"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>Month</th>
                                        <th style="text-align:center;">Total Target</th>
                                        <th style="text-align:center;">Total Collection</th>
                                        <th style="text-align:center;">Performance (%)</th>
                                        <th style="text-align:center;" class="no-sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $selecttargets = $pdo->query("SELECT target_id, target_year, target_month, target_domestic_amount FROM tbl_target_details WHERE target_user_id  = '" . $_SESSION["logged_user_id"] . "' GROUP BY target_year, target_month ORDER BY target_year DESC, target_month DESC");
                                    while ($targetdetails = $selecttargets->fetch(PDO::FETCH_ASSOC)) {
                                        $target_id = $targetdetails['target_id'];
                                        $target_month = $targetdetails['target_month'];
                                        $target_month = str_pad($target_month, 2, "0", STR_PAD_LEFT);
                                        $target_year = $targetdetails['target_year'];
                                        $target_domestic_amount = $targetdetails['target_domestic_amount'];

                                        $selecttotalorderamount = $pdo->query("SELECT sum(order_after_discount_amount) As TotalOrderAmounts FROM tbl_order_details WHERE DATE_FORMAT(order_date,'%Y-%m') = '" . $target_year . "-" . $target_month . "' AND order_type = 'domestic' AND order_user_id = '" . $_SESSION["logged_user_id"] . "'");
                                        $totalotalorderamounts = $selecttotalorderamount->fetch(PDO::FETCH_ASSOC);
                                        $TotalOrderAmounts = $totalotalorderamounts['TotalOrderAmounts'];

                                        if ($target_domestic_amount > 0 && $TotalOrderAmounts > 0) {
                                            $average = $TotalOrderAmounts * 100 / $target_domestic_amount;
                                        } else {
                                            $average = 0;
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo date('F', mktime(0, 0, 0, $target_month, 10)); ?> - <?php echo $target_year; ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo "Rs. " . ind_money_format($target_domestic_amount); ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php if ($TotalOrderAmounts > 0) {
                                                    echo "Rs. " . ind_money_format($TotalOrderAmounts);
                                                } else {
                                                    echo "Rs. " . "0";
                                                } ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php if ($TotalOrderAmounts > 0) {
                                                    echo round($average) . "%";
                                                } else {
                                                    echo "0%";
                                                } ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-primary" data-bs-original-title="View Collection" href="<?php echo SITE_URL; ?>target-order-details/<?php echo base64_encode($_SESSION["logged_user_id"]); ?>/<?php echo base64_encode($target_id); ?>" class="btn btn-sm btn-icon delete-record link-primary"><i class="ti ti-eye mx-2 ti-sm"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <!-- Notifications -->
        <?php if ($notificationcount > 0) { ?>
            <div class="col-lg-12 col-12 mb-4 mobilehidesection">
                <div class="card h-100 custom-data-border">
                    <div class="card-header text-center" style="padding: 15px 0px 12px 0px; background: linear-gradient(50deg, rgba(60, 155, 61, 1) 45%, rgba(1, 160, 164, 1) 65%);">
                        <h5 class="card-title m-0 me-2" style="color: #FFF;">Notifications</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <?php
                                while ($notificationdetails = $selectnotifications->fetch(PDO::FETCH_ASSOC)) {
                                    $notification_details = $notificationdetails['notification_details'];
                                    $notification_sent_id = $notificationdetails['notification_sent_id'];
                                    $notification_user_id = $notificationdetails['notification_user_id'];
                                    $notification_date = date("d-m-Y", strtotime($notificationdetails['notification_date']));

                                    $dbsendername = get_single_data("tbl_user_details", "user_name", "user_id = '" . $notification_sent_id . "'");

                                    if ($notification_user_id != 0) {
                                        $dbreceivename = get_single_data("tbl_user_details", "user_name", "user_id = '" . $notification_user_id . "'");
                                    } else {
                                        $dbreceivename = 'All';
                                    }
                                    ?>
                                    <tr>
                                        <td style="padding: 0.25rem 0.5rem;">
                                            New Notification From: 
                                            <span class="item-edit link-primary" style="margin: 5px 5px 5px 5px; display: inline-block; font-weight: bold;"> <?php echo $dbsendername; ?></span>
                                            <span class="item-edit link-dark" style="margin: 5px 0px 5px 0px; display: inline-block; font-weight: bold;">To</span>
                                            <span class="item-edit link-warning" style="margin: 5px 5px 5px 5px; display: inline-block; font-weight: bold;"><?php echo $dbreceivename; ?></span>
                                            <span style="margin: 0px;">(<?php echo nl2br($notification_details); ?>) - Date: <?php echo $notification_date; ?></span>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="3" class="custom-btn">
                                        <a class="btn btn-success waves-effect waves-float waves-light" href="<?php echo SITE_URL; ?>notification-list">View All</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php
        if ($checkdashboardfollowups == 1) {
            $selecttodayfollowups = $pdo->query("SELECT followup_id, followup_client_id, followup_user_id, followup_details, followup_date_time, followup_date, followup_type, followup_status FROM tbl_client_followup_details WHERE followup_client_id IN (" . $clientyesids . ") AND followup_tag = 1 AND date(followup_date) = '" . $tmpdate . "' " . $followup_user_id . " ORDER BY followup_id ASC LIMIT 0,20");
            $todayfollowupcount = $selecttodayfollowups->rowCount();
            ?>
            <!-- Follow Up List -->
            <div class="col-lg-12 col-12 mb-4">
                <div class="card h-100 custom-data-border">
                    <div class="card-header text-center" style="padding: 15px 0px 12px 0px; background: linear-gradient(50deg, rgba(60, 155, 61, 1) 45%, rgba(1, 160, 164, 1) 65%);">
                        <h5 class="card-title m-0 me-2" style="color: #FFF;">Last 20 Today Follow-up</h5>
                    </div>
                    <div class="table-responsive webfollowuplist">
                        <table class="table table-bordered followuplist">
                            <thead class="border-bottom">
                                <tr>
                                    <th class="no-sort">Followup Date</th>
                                    <th class="no-sort">Leads Details</th>
                                    <th class="no-sort">Contact Details</th>
                                    <th style="text-align:center;" class="no-sort">Lead Source</th>
                                    <th style="text-align:center;" class="no-sort">Lead Type</th>
                                    <th style="text-align:center;" class="no-sort">Lead Status</th>
                                    <th style="text-align:center;" class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($todayfollowupcount > 0) {
                                    foreach ($selecttodayfollowups as $followupdetails) {
                                        $followup_id = $followupdetails['followup_id'];
                                        $followup_user_id = $followupdetails['followup_user_id'];
                                        $followup_client_id = $followupdetails['followup_client_id'];
                                        $followup_date = $followupdetails['followup_date'];
                                        $followup_date_time = $followupdetails['followup_date_time'];
                                        $followup_details = $followupdetails['followup_details'];
                                        $followup_type = $followupdetails['followup_type'];
                                        $followup_status = $followupdetails['followup_status'];

                                        $selectclientdetails = $pdo->query("SELECT client_user_id, client_name, client_company_name, client_mobile_code, client_mobile_number_one, client_mobile_number_two, client_inquiry_source, client_inquiry_type, client_email_address, client_city, client_state_id FROM tbl_client_details WHERE client_id = '" . $followup_client_id . "'");
                                        $clientdetails = $selectclientdetails->fetch(PDO::FETCH_ASSOC);
                                        $client_user_id = $clientdetails['client_user_id'];
                                        $client_name = $clientdetails['client_name'];
                                        $client_inquiry_type = $clientdetails['client_inquiry_type'];
                                        $client_inquiry_source = $clientdetails['client_inquiry_source'];
                                        $client_company_name = $clientdetails['client_company_name'];
                                        $client_email_address = $clientdetails['client_email_address'];
                                        $client_mobile_code = $clientdetails['client_mobile_code'];
                                        $client_mobile_number_one = $clientdetails['client_mobile_number_one'];
                                        $client_mobile_number_two = $clientdetails['client_mobile_number_two'];
                                        $client_city = $clientdetails['client_city'];
                                        $client_state_id = $clientdetails['client_state_id'];

                                        if ($client_name != "") {
                                            $client_details = $client_company_name . ' - ' . $client_name;
                                        } else {
                                            $client_details = $client_company_name;
                                        }

                                        // if ($client_mobile_code != "") {
                                        //     $client_mobile_code_db = $client_mobile_code;
                                        // } else {
                                        //     $client_mobile_code_db = 91;
                                        // }

                                        $client_mobile_code_db = $client_mobile_code;

                                        if ($client_mobile_number_one != "" && $client_mobile_number_two != "") {
                                            $client_mobile_number_one_db = "+" . $client_mobile_code_db . $client_mobile_number_one;
                                            $client_mobile_number_two_db = "+" . $client_mobile_code_db . $client_mobile_number_two;

                                            $client_mobile_number = $client_mobile_number_one_db . ', ' . $client_mobile_number_two_db;

                                            $client_whatsapp_call_number = "+" . $client_mobile_code_db . $client_mobile_number_one;
                                        } else if ($client_mobile_number_one != "") {
                                            $client_mobile_number = "+" . $client_mobile_code_db . $client_mobile_number_one;

                                            $client_whatsapp_call_number = "+" . $client_mobile_code_db . $client_mobile_number_one;
                                        } else if ($client_mobile_number_two != "") {
                                            $client_mobile_number = "+" . $client_mobile_code_db . $client_mobile_number_two;

                                            $client_whatsapp_call_number = "+" . $client_mobile_code_db . $client_mobile_number_two;
                                        } else {
                                            $client_mobile_number = "";
                                        }

                                        $dbstatename = get_single_data("tbl_state_details", "state_name", "state_id = '" . $client_state_id . "'");

                                        $dbusername = get_single_data("tbl_user_details", "user_name", "user_id = '" . $followup_user_id . "'");

                                        $dbsourcedetails = get_single_data("tbl_inquiry_source_details", "inquiry_source_name", "inquiry_source_id = '" . $client_inquiry_source . "'");

                                        $dbtypedetails = get_single_data("tbl_inquiry_type_details", "inquiry_type_name", "inquiry_type_id = '" . $client_inquiry_type . "'");

                                        if ($followup_status == 0) {
                                            $dbstatusdetails = 'Fresh Lead';
                                        } else {
                                            $dbstatusdetails = get_single_data("tbl_inquiry_status_details", "inquiry_status_name", "inquiry_status_id = '" . $followup_status . "'");
                                        }

                                        if ($followup_status == 1) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-primary">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 2) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-purple">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 3) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-success">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 4) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-orange">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 5) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-danger">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 6) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-info">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 7) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-dark">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 8) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-purple">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 9) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-success">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 10) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-orange">' . $dbstatusdetails . '</span>';
                                        } else {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-primary">' . $dbstatusdetails . '</span>';
                                        }

                                        if ($dbstatename != "") {
                                            $client_address_details = $client_city . " - " . $dbstatename;
                                        } else {
                                            $client_address_details = $client_city;
                                        }

                                        $selectquotationdetails = $pdo->query("SELECT quotation_id, quotation_pdf FROM tbl_quotation_details WHERE quotation_client_id = '" . $followup_client_id . "' ORDER BY quotation_id DESC LIMIT 0,1");
                                        $totalquotations = $selectquotationdetails->rowCount();
                                        if ($totalquotations > 0) {
                                            $quotationdetails = $selectquotationdetails->fetch(PDO::FETCH_ASSOC);
                                            $quotation_id = $quotationdetails['quotation_id'];
                                            $quotation_pdf = $quotationdetails['quotation_pdf'];

                                            if ($quotation_pdf != "") {
                                                //$quotationid = '<a target="_blank" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-warning" data-bs-original-title="Quote: ' . $site_quotation_prefix . '-' . $quotation_id . '" href="quotation/' . $quotation_pdf . '"><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                                $quotationid = '<a style="cursor: pointer;" target="_blank" data-toggle="modal" data-target="#pdfModal" data-pdf="quotation/' . $quotation_pdf . '"><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            } else {
                                                $quotationid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-warning" data-bs-original-title="Quote: ' . $site_quotation_prefix . '-' . $quotation_id . '" href="#."><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            }
                                        } else {
                                            $quotationid = '';
                                        }

                                        $selectorderdetails = $pdo->query("SELECT order_id, order_proforma_pdf FROM tbl_order_details WHERE order_client_id = '" . $followup_client_id . "' ORDER BY order_id DESC LIMIT 0,1");
                                        $totalorders = $selectorderdetails->rowCount();
                                        if ($totalorders > 0) {
                                            $orderdetails = $selectorderdetails->fetch(PDO::FETCH_ASSOC);
                                            $order_id = $orderdetails['order_id'];
                                            $order_proforma_pdf = $orderdetails['order_proforma_pdf'];

                                            if ($order_proforma_pdf != "") {
                                                //$orderid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-original-title="Order: ' . $site_proforma_prefix . '-' . $order_id . '" href="proforma/' . $order_proforma_pdf . '"><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                                $orderid = '<a style="cursor: pointer;" target="_blank" data-toggle="modal" data-target="#pdfModal" data-pdf="proforma/' . $order_proforma_pdf . '"><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            } else {
                                                $orderid = '<a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-original-title="Order: ' . $site_proforma_prefix . '-' . $order_id . '" href="#."><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            }
                                        } else {
                                            $orderid = '';
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $dbusername; ?><br>
                                                <span
                                                    class="item-edit link-success"><b><?php echo date("d-m-Y", strtotime($followup_date)); ?></b></span>
                                            </td>
                                            <td>
                                                <strong><?php echo $client_details; ?></strong><br>
                                                <?php echo $client_address_details . ' ' . $quotationid . ' ' . $orderid; ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($client_mobile_number_one != "" || $client_mobile_number_two != "") {
                                                    echo $client_mobile_number;
                                                    echo '<br>';
                                                }

                                                if ($client_email_address != "") {
                                                    echo '<span class="item-edit link-warning">' . $client_email_address . '</span>';
                                                }
                                                ?>
                                            </td>
                                            <td><span><?php echo $dbsourcedetails; ?></span></td>
                                            <td><span><?php echo $dbtypedetails; ?></span></td>
                                            <td><?php echo $dbstatusdetailsname; ?></td>
                                            <td style="text-align:center;">
                                                <div class="d-inline-block">
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-primary" data-bs-original-title="View Last Follow-up Details" onclick="view_followup_details(`<?php echo $followup_client_id; ?>`,`<?php echo $followup_user_id; ?>`,`<?php echo $followup_date_time; ?>`,`<?php echo $followup_date; ?>`,`<?php echo $followup_details; ?>`)" href="javascript:void(0)" class="btn btn-sm btn-icon link-primary"><i class="ti ti-eye mx-2 ti-sm"></i></a>

                                                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="text-primary ti ti-dots-vertical"></i></a>
                                                    <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                                                        <li>
                                                            <a onclick="insert_record(`<?= base64_encode($followup_client_id) ?>`)" class="dropdown-item text-primary"><i class="ti ti-plus mx-2 ti-sm"></i>Add Follow-up</a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo SITE_URL; ?>feedback-details/view/<?php echo base64_encode($followup_client_id); ?>" class="dropdown-item text-warning"><i class="ti ti-history mx-2 ti-sm"></i>History</a>
                                                        </li>
                                                        <?php if (CheckBtnPermission() == 1) { ?>
                                                            <li>
                                                                <a href="tel:<?php echo $client_mobile_number_one; ?>" class="dropdown-item text-dark"><i class="ti ti-phone mx-2 ti-sm"></i>Call</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://wa.me/91<?php echo $client_mobile_number_one; ?>" target="_blank" class="dropdown-item text-success"><i class="ti ti-whatsapp mx-2 ti-sm"></i>WhatsApp</a>
                                                            </li>
                                                        <?php } else { ?>
                                                            <li><a href="#." class="dropdown-item text-dark"><i class="ti ti-phone mx-2 ti-sm"></i>Call</a></li>
                                                            <li><a href="#." class="dropdown-item text-success"><i class="ti ti-whatsapp mx-2 ti-sm"></i>WhatsApp</a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    $selecttodayfollowups->execute();
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center;">No Data Found</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive tabletfollowuplist">
                        <table class="table table-bordered followuplist">
                            <thead class="border-bottom">
                                <tr>
                                    <th class="no-sort">Followup Date</th>
                                    <th class="no-sort">Leads Details</th>
                                    <th style="text-align:center;" class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($todayfollowupcount > 0) {
                                    foreach ($selecttodayfollowups as $followupdetails) {
                                        $followup_id = $followupdetails['followup_id'];
                                        $followup_user_id = $followupdetails['followup_user_id'];
                                        $followup_client_id = $followupdetails['followup_client_id'];
                                        $followup_date = $followupdetails['followup_date'];
                                        $followup_date_time = $followupdetails['followup_date_time'];
                                        $followup_details = $followupdetails['followup_details'];
                                        $followup_type = $followupdetails['followup_type'];
                                        $followup_status = $followupdetails['followup_status'];

                                        $selectclientdetails = $pdo->query("SELECT client_user_id, client_name, client_company_name, client_mobile_code, client_mobile_number_one, client_mobile_number_two, client_inquiry_source, client_inquiry_type, client_email_address, client_city, client_state_id FROM tbl_client_details WHERE client_id = '" . $followup_client_id . "'");
                                        $clientdetails = $selectclientdetails->fetch(PDO::FETCH_ASSOC);
                                        $client_user_id = $clientdetails['client_user_id'];
                                        $client_name = $clientdetails['client_name'];
                                        $client_inquiry_type = $clientdetails['client_inquiry_type'];
                                        $client_inquiry_source = $clientdetails['client_inquiry_source'];
                                        $client_company_name = $clientdetails['client_company_name'];
                                        $client_email_address = $clientdetails['client_email_address'];
                                        $client_mobile_code = $clientdetails['client_mobile_code'];
                                        $client_mobile_number_one = $clientdetails['client_mobile_number_one'];
                                        $client_mobile_number_two = $clientdetails['client_mobile_number_two'];
                                        $client_city = $clientdetails['client_city'];
                                        $client_state_id = $clientdetails['client_state_id'];

                                        if ($client_name != "") {
                                            $client_details = $client_company_name . ' - ' . $client_name;
                                        } else {
                                            $client_details = $client_company_name;
                                        }

                                        // if ($client_mobile_code != "") {
                                        //     $client_mobile_code_db = $client_mobile_code;
                                        // } else {
                                        //     $client_mobile_code_db = 91;
                                        // }
                                        $client_mobile_code_db = $client_mobile_code;

                                        if ($client_mobile_number_one != "" && $client_mobile_number_two != "") {
                                            $client_mobile_number_one_db = "+" . $client_mobile_code_db . $client_mobile_number_one;
                                            $client_mobile_number_two_db = "+" . $client_mobile_code_db . $client_mobile_number_two;

                                            $client_mobile_number = $client_mobile_number_one_db . ', ' . $client_mobile_number_two_db;

                                            $client_whatsapp_call_number = "+" . $client_mobile_code_db . $client_mobile_number_one;
                                        } else if ($client_mobile_number_one != "") {
                                            $client_mobile_number = "+" . $client_mobile_code_db . $client_mobile_number_one;

                                            $client_whatsapp_call_number = "+" . $client_mobile_code_db . $client_mobile_number_one;
                                        } else if ($client_mobile_number_two != "") {
                                            $client_mobile_number = "+" . $client_mobile_code_db . $client_mobile_number_two;

                                            $client_whatsapp_call_number = "+" . $client_mobile_code_db . $client_mobile_number_two;
                                        } else {
                                            $client_mobile_number = "";
                                        }

                                        $dbstatename = get_single_data("tbl_state_details", "state_name", "state_id = '" . $client_state_id . "'");

                                        $dbusername = get_single_data("tbl_user_details", "user_name", "user_id = '" . $followup_user_id . "'");

                                        $dbsourcedetails = get_single_data("tbl_inquiry_source_details", "inquiry_source_name", "inquiry_source_id = '" . $client_inquiry_source . "'");

                                        $dbtypedetails = get_single_data("tbl_inquiry_type_details", "inquiry_type_name", "inquiry_type_id = '" . $client_inquiry_type . "'");

                                        if ($followup_status == 0) {
                                            $dbstatusdetails = 'Fresh Lead';
                                        } else {
                                            $dbstatusdetails = get_single_data("tbl_inquiry_status_details", "inquiry_status_name", "inquiry_status_id = '" . $followup_status . "'");
                                        }

                                        if ($followup_status == 1) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-primary">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 2) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-purple">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 3) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-success">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 4) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-orange">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 5) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-danger">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 6) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-info">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 7) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-dark">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 8) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-purple">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 9) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-success">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 10) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-orange">' . $dbstatusdetails . '</span>';
                                        } else {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-primary">' . $dbstatusdetails . '</span>';
                                        }

                                        if ($dbstatename != "") {
                                            $client_address_details = $client_city . " - " . $dbstatename;
                                        } else {
                                            $client_address_details = $client_city;
                                        }

                                        $selectquotationdetails = $pdo->query("SELECT quotation_id, quotation_pdf FROM tbl_quotation_details WHERE quotation_client_id = '" . $followup_client_id . "' ORDER BY quotation_id DESC LIMIT 0,1");
                                        $totalquotations = $selectquotationdetails->rowCount();
                                        if ($totalquotations > 0) {
                                            $quotationdetails = $selectquotationdetails->fetch(PDO::FETCH_ASSOC);
                                            $quotation_id = $quotationdetails['quotation_id'];
                                            $quotation_pdf = $quotationdetails['quotation_pdf'];

                                            if ($quotation_pdf != "") {
                                                //$quotationid = '<a target="_blank" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-warning" data-bs-original-title="Quote: ' . $site_quotation_prefix . '-' . $quotation_id . '" href="quotation/' . $quotation_pdf . '"><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                                $quotationid = '<a style="cursor: pointer;" target="_blank" data-toggle="modal" data-target="#pdfModal" data-pdf="quotation/' . $quotation_pdf . '"><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            } else {
                                                $quotationid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-warning" data-bs-original-title="Quote: ' . $site_quotation_prefix . '-' . $quotation_id . '" href="#."><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            }
                                        } else {
                                            $quotationid = '';
                                        }

                                        $selectorderdetails = $pdo->query("SELECT order_id, order_proforma_pdf FROM tbl_order_details WHERE order_client_id = '" . $followup_client_id . "' ORDER BY order_id DESC LIMIT 0,1");
                                        $totalorders = $selectorderdetails->rowCount();
                                        if ($totalorders > 0) {
                                            $orderdetails = $selectorderdetails->fetch(PDO::FETCH_ASSOC);
                                            $order_id = $orderdetails['order_id'];
                                            $order_proforma_pdf = $orderdetails['order_proforma_pdf'];

                                            if ($order_proforma_pdf != "") {
                                                //$orderid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-original-title="Order: ' . $site_proforma_prefix . '-' . $order_id . '" href="proforma/' . $order_proforma_pdf . '"><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                                $orderid = '<a style="cursor: pointer;" target="_blank" data-toggle="modal" data-target="#pdfModal" data-pdf="proforma/' . $order_proforma_pdf . '"><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            } else {
                                                $orderid = '<a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-original-title="Order: ' . $site_proforma_prefix . '-' . $order_id . '" href="#."><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            }
                                        } else {
                                            $orderid = '';
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $dbusername; ?><br>
                                                <span class="item-edit link-success"><b><?php echo date("d-m-Y", strtotime($followup_date)); ?></b></span>
                                            </td>
                                            <td>
                                                <strong><?php echo $client_details; ?></strong><br>
                                                <?php
                                                if ($client_mobile_number_one != "" || $client_mobile_number_two != "") {
                                                    echo $client_mobile_number;
                                                    echo '<br>';
                                                }
                                                if ($client_email_address != "") {
                                                    echo '<span class="item-edit link-warning">' . $client_email_address . '</span>';
                                                    echo '<br>';
                                                }
                                                ?>
                                                <?php echo $client_address_details . ' ' . $quotationid . ' ' . $orderid; ?> <br>
                                                <span class="tabletsource"><?php echo $dbsourcedetails; ?></span>
                                                <span class="tablettype"><?php echo $dbtypedetails; ?></span>
                                                <?php echo $dbstatusdetailsname; ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <div class="d-inline-block">
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-primary" data-bs-original-title="View Last Follow-up Details" onclick="view_followup_details(`<?php echo $followup_client_id; ?>`,`<?php echo $followup_user_id; ?>`,`<?php echo $followup_date_time; ?>`,`<?php echo $followup_date; ?>`,`<?php echo $followup_details; ?>`)" href="javascript:void(0)" class="btn btn-sm btn-icon link-primary"><i
                                                            class="ti ti-eye mx-2 ti-sm"></i></a>
                                                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="text-primary ti ti-dots-vertical"></i></a>
                                                    <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                                                        <li>
                                                            <a onclick="insert_record(`<?= base64_encode($followup_client_id) ?>`)" class="dropdown-item text-primary"><i class="ti ti-plus mx-2 ti-sm"></i>Add Follow-up</a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo SITE_URL; ?>feedback-details/view/<?php echo base64_encode($followup_client_id); ?>" class="dropdown-item text-warning"><i class="ti ti-history mx-2 ti-sm"></i>History</a>
                                                        </li>
                                                        <?php if (CheckBtnPermission() == 1) { ?>
                                                            <li>
                                                                <a href="tel:<?php echo $client_mobile_number_one; ?>" class="dropdown-item text-dark"><i class="ti ti-phone mx-2 ti-sm"></i>Call</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://wa.me/91<?php echo $client_mobile_number_one; ?>" target="_blank" class="dropdown-item text-success"><i class="ti ti-whatsapp mx-2 ti-sm"></i>WhatsApp</a>
                                                            </li>
                                                        <?php } else { ?>
                                                            <li><a href="#." class="dropdown-item text-dark"><i class="ti ti-phone mx-2 ti-sm"></i>Call</a></li>
                                                            <li><a href="#." class="dropdown-item text-success"><i class="ti ti-whatsapp mx-2 ti-sm"></i>WhatsApp</a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    $selecttodayfollowups->execute();
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="3" style="text-align:center;">No Data Found</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mobilefollowuplist">
                        <table class="table table-bordered followuplist">
                            <thead class="border-bottom">
                                <tr>
                                    <th class="no-sort">Leads Details</th>
                                    <th class="no-sort">Follow-Up</th>
                                    <th style="text-align:center;" class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($todayfollowupcount > 0) {
                                    foreach ($selecttodayfollowups as $followupdetails) {
                                        $followup_id = $followupdetails['followup_id'];
                                        $followup_user_id = $followupdetails['followup_user_id'];
                                        $followup_client_id = $followupdetails['followup_client_id'];
                                        $followup_date = $followupdetails['followup_date'];
                                        $followup_date_time = $followupdetails['followup_date_time'];
                                        $followup_details = $followupdetails['followup_details'];
                                        $followup_type = $followupdetails['followup_type'];
                                        $followup_status = $followupdetails['followup_status'];

                                        $selectclientdetails = $pdo->query("SELECT client_user_id, client_name, client_company_name, client_mobile_code, client_mobile_number_one, client_mobile_number_two, client_inquiry_source, client_inquiry_type, client_email_address, client_city, client_state_id FROM tbl_client_details WHERE client_id = '" . $followup_client_id . "'");
                                        $clientdetails = $selectclientdetails->fetch(PDO::FETCH_ASSOC);
                                        $client_user_id = $clientdetails['client_user_id'];
                                        $client_name = $clientdetails['client_name'];
                                        $client_inquiry_type = $clientdetails['client_inquiry_type'];
                                        $client_inquiry_source = $clientdetails['client_inquiry_source'];
                                        $client_company_name = $clientdetails['client_company_name'];
                                        $client_email_address = $clientdetails['client_email_address'];
                                        $client_mobile_code = $clientdetails['client_mobile_code'];
                                        $client_mobile_number_one = $clientdetails['client_mobile_number_one'];
                                        $client_mobile_number_two = $clientdetails['client_mobile_number_two'];
                                        $client_city = $clientdetails['client_city'];
                                        $client_state_id = $clientdetails['client_state_id'];

										if ($client_name != "") {
                                            $client_details = $client_company_name . ' - ' . $client_name;
                                        } else {
                                            $client_details = $client_company_name;
                                        }
										
                                        // if ($client_mobile_code != "") {
                                        //     $client_mobile_code_db = $client_mobile_code;
                                        // } else {
                                        //     $client_mobile_code_db = 91;
                                        // }
                                        $client_mobile_code_db = $client_mobile_code;

                                        if ($client_mobile_number_one != "" && $client_mobile_number_two != "") {
                                            $client_mobile_number_one_db = "+" . $client_mobile_code_db . $client_mobile_number_one;
                                            $client_mobile_number_two_db = "+" . $client_mobile_code_db . $client_mobile_number_two;

                                            $client_mobile_number = $client_mobile_number_one_db . ', ' . $client_mobile_number_two_db;

                                            $client_whatsapp_call_number = "+" . $client_mobile_code_db . $client_mobile_number_one;
                                        } else if ($client_mobile_number_one != "") {
                                            $client_mobile_number = "+" . $client_mobile_code_db . $client_mobile_number_one;

                                            $client_whatsapp_call_number = "+" . $client_mobile_code_db . $client_mobile_number_one;
                                        } else if ($client_mobile_number_two != "") {
                                            $client_mobile_number = "+" . $client_mobile_code_db . $client_mobile_number_two;

                                            $client_whatsapp_call_number = "+" . $client_mobile_code_db . $client_mobile_number_two;
                                        } else {
                                            $client_mobile_number = "";
                                        }

                                        $dbstatename = get_single_data("tbl_state_details", "state_name", "state_id = '" . $client_state_id . "'");

                                        $dbusername = get_single_data("tbl_user_details", "user_name", "user_id = '" . $followup_user_id . "'");

                                        $dbsourcedetails = get_single_data("tbl_inquiry_source_details", "inquiry_source_name", "inquiry_source_id = '" . $client_inquiry_source . "'");

                                        $dbtypedetails = get_single_data("tbl_inquiry_type_details", "inquiry_type_name", "inquiry_type_id = '" . $client_inquiry_type . "'");

                                        if ($followup_status == 0) {
                                            $dbstatusdetails = 'Fresh Lead';
                                        } else {
                                            $dbstatusdetails = get_single_data("tbl_inquiry_status_details", "inquiry_status_name", "inquiry_status_id = '" . $followup_status . "'");
                                        }

                                        if ($followup_status == 1) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-primary">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 2) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-purple">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 3) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-success">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 4) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-orange">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 5) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-danger">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 6) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-info">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 7) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-dark">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 8) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-purple">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 9) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-success">' . $dbstatusdetails . '</span>';
                                        } else if ($followup_status == 10) {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-orange">' . $dbstatusdetails . '</span>';
                                        } else {
                                            $dbstatusdetailsname = '<span class="badge badge-glow bg-primary">' . $dbstatusdetails . '</span>';
                                        }

                                        if ($dbstatename != "") {
                                            $client_address_details = $client_city . " - " . $dbstatename;
                                        } else {
                                            $client_address_details = $client_city;
                                        }

                                        $selectquotationdetails = $pdo->query("SELECT quotation_id, quotation_pdf FROM tbl_quotation_details WHERE quotation_client_id = '" . $followup_client_id . "' ORDER BY quotation_id DESC LIMIT 0,1");
                                        $totalquotations = $selectquotationdetails->rowCount();
                                        if ($totalquotations > 0) {
                                            $quotationdetails = $selectquotationdetails->fetch(PDO::FETCH_ASSOC);
                                            $quotation_id = $quotationdetails['quotation_id'];
                                            $quotation_pdf = $quotationdetails['quotation_pdf'];

                                            if ($quotation_pdf != "") {
                                                //$quotationid = '<a target="_blank" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-warning" data-bs-original-title="Quote: ' . $site_quotation_prefix . '-' . $quotation_id . '" href="quotation/' . $quotation_pdf . '"><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                                $quotationid = '<a style="cursor: pointer;" target="_blank" data-toggle="modal" data-target="#pdfModal" data-pdf="quotation/' . $quotation_pdf . '"><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            } else {
                                                $quotationid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-warning" data-bs-original-title="Quote: ' . $site_quotation_prefix . '-' . $quotation_id . '" href="#."><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            }
                                        } else {
                                            $quotationid = '';
                                        }

                                        $selectorderdetails = $pdo->query("SELECT order_id, order_proforma_pdf FROM tbl_order_details WHERE order_client_id = '" . $followup_client_id . "' ORDER BY order_id DESC LIMIT 0,1");
                                        $totalorders = $selectorderdetails->rowCount();
                                        if ($totalorders > 0) {
                                            $orderdetails = $selectorderdetails->fetch(PDO::FETCH_ASSOC);
                                            $order_id = $orderdetails['order_id'];
                                            $order_proforma_pdf = $orderdetails['order_proforma_pdf'];

                                            if ($order_proforma_pdf != "") {
                                                //$orderid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-original-title="Order: ' . $site_proforma_prefix . '-' . $order_id . '" href="proforma/' . $order_proforma_pdf . '"><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                                $orderid = '<a style="cursor: pointer;" target="_blank" data-toggle="modal" data-target="#pdfModal" data-pdf="proforma/' . $order_proforma_pdf . '"><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            } else {
                                                $orderid = '<a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-original-title="Order: ' . $site_proforma_prefix . '-' . $order_id . '" href="#."><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            }
                                        } else {
                                            $orderid = '';
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo $client_details; ?></strong><br>
                                                <?php echo $client_name; ?><br>
                                                <?php
                                                if ($client_mobile_number_one != "" || $client_mobile_number_two != "") {
                                                    echo $client_mobile_number;
                                                    echo '<br>';
                                                }
                                                ?>
                                                <?php echo $client_address_details . ' ' . $quotationid . ' ' . $orderid;
                                                echo '<br>'; ?>
                                                <span class="mobilesource"><?php echo $dbsourcedetails; ?></span>
                                                <span class="mobiletype"><?php echo $dbtypedetails; ?></span>
                                            </td>
                                            <td>
                                                <span class="item-edit link-success"><b><?php echo date("d-m-Y", strtotime($followup_date)); ?></b></span>
                                                <br>
                                                <?php
                                                echo $dbusername;
                                                echo '<br><br>';
                                                echo $dbstatusdetailsname;
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <div class="d-inline-block">
                                                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="text-primary ti ti-dots-vertical"></i></a>
                                                    <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                                                        <li>
                                                            <a onclick="insert_record(`<?= base64_encode($followup_client_id) ?>`)" class="dropdown-item text-primary"><i class="ti ti-plus mx-2 ti-sm"></i>Add Follow-up</a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo SITE_URL; ?>feedback-details/view/<?php echo base64_encode($followup_client_id); ?>" class="dropdown-item text-warning"><i class="ti ti-history mx-2 ti-sm"></i>History</a>
                                                        </li>
                                                        <?php if (CheckBtnPermission() == 1) { ?>
                                                            <li>
                                                                <a href="tel:<?php echo $client_mobile_number_one; ?>" class="dropdown-item text-dark"><i class="ti ti-phone mx-2 ti-sm"></i>Call</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://wa.me/91<?php echo $client_mobile_number_one; ?>" target="_blank" class="dropdown-item text-success"><i class="ti ti-whatsapp mx-2 ti-sm"></i>WhatsApp</a>
                                                            </li>
                                                        <?php } else { ?>
                                                            <li><a href="#." class="dropdown-item text-dark"><i class="ti ti-phone mx-2 ti-sm"></i>Call</a></li>
                                                            <li><a href="#." class="dropdown-item text-success"><i class="ti ti-whatsapp mx-2 ti-sm"></i>WhatsApp</a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    $selecttodayfollowups->execute();
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="3" style="text-align:center;">No Data Found</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php if ($checkdashboardquotationorder == 1) { ?>
        <!-- Quotations -->
        <div class="row mobilequotations">
            <div class="col-lg-12 col-12 mb-4">
                <div class="card h-100 custom-data-border">
                    <div class="card-header text-center" style="padding: 15px 0px 12px 0px; background: linear-gradient(50deg, rgba(60, 155, 61, 1) 45%, rgba(1, 160, 164, 1) 65%);">
                        <h5 class="card-title m-0 me-2" style="color: #FFF;">Last 5 Quotations</h5>
                    </div>
                    <?php
                    $selectlastquotationdetails = $pdo->query("SELECT quotation_order_status, quotation_id, quotation_unique_id, quotation_client_id, quotation_user_id, quotation_currency, quotation_tax_amount, quotation_sub_amount, quotation_discount_amount, quotation_final_amount, quotation_after_discount_amount, quotation_manage_date, quotation_date, quotation_pdf, quotation_status, quotation_type FROM tbl_quotation_details WHERE 1 = 1 " . $quotation_user_id . " ORDER BY quotation_id DESC LIMIT 0,5");
                    $totalquotations = $selectlastquotationdetails->rowCount();
                    ?>
                    <div class="table-responsive webquotations">
                        <table class="table table-bordered quotationlist">
                            <thead class="border-bottom">
                                <tr>
                                    <th class="no-sort">DATE</th>
                                    <th class="no-sort">LEAD DETAILS</th>
                                    <th class="no-sort">CONTACT DETAILS</th>
                                    <th class="no-sort">QUOTATION</th>
                                    <th>LEAD SOURCE</th>
                                    <th>TYPE</th>
                                    <th class="no-sort">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($totalquotations > 0) {
                                    foreach ($selectlastquotationdetails as $quotationdetails) {
                                        $quotation_id = $quotationdetails['quotation_id'];
                                        $quotation_unique_id = $quotationdetails['quotation_unique_id'];
                                        $quotation_client_id = $quotationdetails['quotation_client_id'];
                                        $quotation_user_id = $quotationdetails['quotation_user_id'];
                                        $quotation_currency = $quotationdetails['quotation_currency'];
                                        $quotation_sub_amount = $quotationdetails['quotation_sub_amount'];
                                        $quotation_discount_amount = $quotationdetails['quotation_discount_amount'];
                                        $quotation_after_discount_amount = $quotationdetails['quotation_after_discount_amount'];
                                        $quotation_final_amount = $quotationdetails['quotation_final_amount'];
                                        $quotation_pdf = $quotationdetails['quotation_pdf'];
                                        $quotation_status = $quotationdetails['quotation_status'];
                                        $quotation_type = $quotationdetails['quotation_type'];
                                        $quotation_order_status = $quotationdetails['quotation_order_status'];
                                        $quotation_manage_date = date("d-m-Y", strtotime($quotationdetails['quotation_manage_date']));
                                        $quotation_date = date("d-m-Y", strtotime($quotationdetails['quotation_date']));
                            
                                        if ($quotation_currency == "rupess") {
                                            $quotation_currency_symbol = "₹ ";
                                        } else if ($quotation_currency == "dollar") {
                                            $quotation_currency_symbol = "$ ";
                                        } else if ($quotation_currency == "pound") {
                                            $quotation_currency_symbol = "£ ";
                                        } else if ($quotation_currency == "euro") {
                                            $quotation_currency_symbol = "€ ";
                                        } else {
                                            $quotation_currency_symbol = "₹ ";
                                        }

                                        if ($quotation_order_status == 'Yes' && $quotation_pdf != '') {
                                            $selectorderdetails = $pdo->query("SELECT order_id, order_proforma_pdf FROM tbl_order_details WHERE order_quotation_id = " . $quotation_id . "");
                                            $orderdetails = $selectorderdetails->fetch(PDO::FETCH_ASSOC);
                                            $order_id = $orderdetails['order_id'];
                                            $order_proforma_pdf = $orderdetails['order_proforma_pdf'];

                                            if ($order_proforma_pdf != "") {
                                                //$orderid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-original-title="Order: ' . $site_proforma_prefix . '-' . $order_id . '" href="proforma/' . $order_proforma_pdf . '"><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                                $orderid = '<a style="cursor: pointer;" target="_blank" data-toggle="modal" data-target="#pdfModal" data-pdf="proforma/' . $order_proforma_pdf . '"><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            } else {
                                                $orderid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-original-title="Order: ' . $site_proforma_prefix . '-' . $order_id . '" href="#."><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            }
                                        } else {
                                            $orderid = '';
                                        }

                                        $selectclientdetails = $pdo->query("SELECT client_inquiry_source, client_name, client_company_name, client_email_address, client_mobile_code, client_mobile_number_one, client_state_id, client_city FROM tbl_client_details WHERE client_id = '" . $quotation_client_id . "'");
                                        $clientdetails = $selectclientdetails->fetch(PDO::FETCH_ASSOC);
                                        $client_inquiry_source = $clientdetails['client_inquiry_source'];
                                        $client_name = $clientdetails['client_name'];
                                        $client_company_name = $clientdetails['client_company_name'];
                                        $client_email_address = $clientdetails['client_email_address'];
                                        $client_mobile_code = $clientdetails['client_mobile_code'];
                                        $client_mobile_number_one = $clientdetails['client_mobile_number_one'];
                                        $client_state_id = $clientdetails['client_state_id'];
                                        $client_city = $clientdetails['client_city'];

                                        if ($client_company_name != "") {
                                            $client_details = $client_company_name . ' - ' . $client_name;
                                        } else {
                                            $client_details = $client_name;
                                        }

                                        // if ($client_mobile_code != "") {
                                        //     $client_mobile_code_db = $client_mobile_code;
                                        // } else {
                                        //     $client_mobile_code_db = 91;
                                        // }

                                        $client_mobile_code_db = $client_mobile_code;

                                        if ($client_mobile_number_one != "") {
                                            $client_mobile_number = "+" . $client_mobile_code_db . $client_mobile_number_one;
                                        } else {
                                            $client_mobile_number = "";
                                        }

                                        $dbuserdetails = get_single_data("tbl_user_details", "user_name", "user_id = '" . $quotation_user_id . "'");
                                        $dbsourcedetails = get_single_data("tbl_inquiry_source_details", "inquiry_source_name", "inquiry_source_id = '" . $client_inquiry_source . "'");
                                        $dbstatename = get_single_data("tbl_state_details", "state_name", "state_id = '" . $client_state_id . "'");

                                        if ($quotation_type == 'domestic') {
                                            $quotationtype = '<span class="badge badge-glow bg-warning">Domestic</span>';
                                        } else {
                                            $quotationtype = '<span class="badge badge-glow bg-info">International</span>';
                                        }

                                        $selectlastfollowup = $pdo->query("SELECT followup_user_id, followup_details, followup_date, followup_date_time FROM tbl_client_followup_details WHERE followup_client_id = '" . $quotation_client_id . "' ORDER BY followup_id DESC LIMIT 0,1");
                                        $lastfollowupdetails = $selectlastfollowup->fetch(PDO::FETCH_ASSOC);
                                        $followup_user_id = $lastfollowupdetails['followup_user_id'];
                                        $followup_details = $lastfollowupdetails['followup_details'];
                                        $followup_date = $lastfollowupdetails['followup_date'];
                                        $followup_date_time = $lastfollowupdetails['followup_date_time'];
                                        ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo $site_quotation_prefix . '-' . $quotation_id; ?></strong> <span class="item-edit link-primary"><?php echo $dbuserdetails; ?></span><br>
                                                <span class="item-edit link-primary"><strong><?php echo $quotation_manage_date; ?></strong></span>
                                            </td>
                                            <td>
                                                <strong><?php echo $client_details; ?></strong><br>
                                                <?php echo $dbstatename . ' - ' . $client_city . ' ' . $orderid; ?>
                                            </td>
                                            <td>
                                                <span class="item-edit link-primary"><?php echo $client_mobile_number; ?></span><br>
                                                <span class="item-edit link-warning"><?php echo $client_email_address; ?></span>
                                            </td>
                                            <td>
                                                <strong>Basic:</strong>
                                                <?php echo $quotation_currency_symbol . ind_money_format($quotation_after_discount_amount); ?><br>
                                                <strong>Final:</strong>
                                                <?php echo $quotation_currency_symbol . ind_money_format($quotation_final_amount); ?>
                                            </td>
                                            <td><span><?php echo $dbsourcedetails; ?></span></td>
                                            <td><?php echo $quotationtype; ?></td>
                                            <td style="text-align:center;">
                                                <div class="d-inline-block">
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-primary" data-bs-original-title="View Last Follow-up Details" onclick="view_followup_details(`<?php echo $quotation_client_id; ?>`,`<?php echo $followup_user_id; ?>`,`<?php echo $followup_date_time; ?>`,`<?php echo $followup_date; ?>`,`<?php echo $followup_details; ?>`)" href="javascript:void(0)" class="btn btn-sm btn-icon link-primary"><i class="ti ti-eye mx-2 ti-sm"></i></a>

                                                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="text-primary ti ti-dots-vertical"></i></a>
                                                    <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                                                        <?php
                                                        if ($_SESSION["logged_user_type_main"] == 1 || $quotation_user_id == $_SESSION["logged_user_id"]) {
                                                            if ($quotation_status == 'Yes') {
                                                                ?>
                                                                <li>
                                                                    <a onclick='doubleFunction(`<?php echo base64_encode($quotation_id); ?>`)' class="dropdown-item text-danger"><i class="ti ti-file-text mx-2 ti-sm"></i>Create PDF</a>
                                                                </li>
                                                                <?php
                                                            }
                                                        }

                                                        if ($quotation_pdf != "") {
                                                            ?>
                                                            <li>
                                                                <a data-toggle="modal" data-target="#pdfModal" data-pdf="quotation/<?php echo $quotation_pdf; ?>" class="dropdown-item text-primary"><i class="ti ti-file-text mx-2 ti-sm"></i>View PDF</a>
                                                            </li>
                                                            <?php
                                                        }

                                                        if (CheckBtnPermission() == 1) {
                                                            if ($quotation_pdf != "") {
                                                                ?>
                                                                <li>
                                                                    <a onclick="javascript:if(!confirm('Are you sure you want to send quotation details?')) return false;" href="<?php echo SITE_URL; ?>quotation-db.php?myaction=send&qid=<?php echo base64_encode($quotation_id); ?>" class="dropdown-item text-copper"><i class="ti ti-mail mx-2 ti-sm"></i>Mail</a>
                                                                </li>
                                                            <?php } ?>
                                                            <li>
                                                                <a href="tel:<?php echo $client_mobile_number_one; ?>" class="dropdown-item text-coffee"><i class="ti ti-phone mx-2 ti-sm"></i>Call</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://wa.me/91<?php echo $client_mobile_number_one; ?>" target="_blank" class="dropdown-item text-success"><i class="ti ti-whatsapp mx-2 ti-sm"></i>WhatsApp</a>
                                                            </li>
                                                        <?php } else { ?>
                                                            <li><a href="#." class="dropdown-item text-copper"><i class="ti ti-mail mx-2 ti-sm"></i>Mail</a></li>
                                                            <li><a href="#." class="dropdown-item text-dark"><i class="ti ti-phone mx-2 ti-sm"></i>Call</a></li>
                                                            <li><a href="#." class="dropdown-item text-success"><i class="ti ti-whatsapp mx-2 ti-sm"></i>WhatsApp</a></li>
                                                            <?php
                                                        }
                                                        ?>
                                                        <li>
                                                            <a target="_blank" href="<?php echo SITE_URL; ?>feedback-details/view/<?php echo base64_encode($quotation_client_id); ?>" class="dropdown-item text-orange"><i class="ti ti-history mx-2 ti-sm"></i>View History</a>
                                                        </li>

                                                        <?php
                                                        if ($_SESSION["logged_user_type_main"] == 1 || $quotation_user_id == $_SESSION["logged_user_id"]) {
                                                            if ($quotation_status == 'Yes' && $quotation_order_status == '') {
                                                                ?>
                                                                <div class="dropdown-divider"></div>
                                                                <li>
                                                                    <a onclick="window.location = '<?php echo SITE_URL; ?>quotation-edit/edit/<?php echo base64_encode($quotation_id); ?>'" class="dropdown-item text-magenta"><i class="ti ti-edit mx-2 ti-sm"></i>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a onclick="javascript:if(!confirm('Are you sure you want to generate order?')) return false;" href="<?php echo SITE_URL; ?>quotation-db.php?myaction=order&qid=<?php echo base64_encode($quotation_id); ?>" class="dropdown-item text-primary"><i class="ti ti-shopping-cart mx-2 ti-sm"></i>Convert Order</a>
                                                                </li>
                                                                <?php
                                                            }
                                                        }

                                                        if (($_SESSION["logged_user_type_main"] == 1 && $quotation_order_status == '') || ($quotation_order_status == '' && $quotation_user_id == $_SESSION["logged_user_id"])) {
                                                            ?>
                                                            <div class="dropdown-divider"></div>
                                                            <li>
                                                                <a onclick="javascript:if(!confirm('Are you sure you want to delete quotation details?')) return false;" href="<?php echo SITE_URL; ?>quotation-db.php?myaction=delete&qid=<?php echo base64_encode($quotation_id); ?>" class="dropdown-item text-danger delete-record"><i class="ti ti-trash mx-2 ti-sm"></i>Delete</a>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <script type="text/javascript">
                                        async function doubleFunction(id) {
                                            await window.open(`<?php echo SITE_URL; ?>quotation-pdf-generate.php?qid=${id}`,
                                                '_blank');
                                            window.setTimeout(function () {
                                                location.reload();
                                            }, 2000);
                                        }
                                        </script>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center;">No Data Found</td>
                                    </tr>
                                    <?php
                                }
                                $selectlastquotationdetails->execute();
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive tabletquotations">
                        <table class="table table-bordered quotationlist">
                            <thead class="border-bottom">
                                <tr>
                                    <th class="no-sort">DATE</th>
                                    <th class="no-sort">LEAD DETAILS</th>
                                    <th class="no-sort">QUOTATION</th>
                                    <th>LEAD SOURCE</th>
                                    <th>TYPE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($totalquotations > 0) {
                                    foreach ($selectlastquotationdetails as $quotationdetails) {
                                        $quotation_id = $quotationdetails['quotation_id'];
                                        $quotation_unique_id = $quotationdetails['quotation_unique_id'];
                                        $quotation_client_id = $quotationdetails['quotation_client_id'];
                                        $quotation_user_id = $quotationdetails['quotation_user_id'];
                                        $quotation_currency = $quotationdetails['quotation_currency'];
                                        $quotation_sub_amount = $quotationdetails['quotation_sub_amount'];
                                        $quotation_discount_amount = $quotationdetails['quotation_discount_amount'];
                                        $quotation_after_discount_amount = $quotationdetails['quotation_after_discount_amount'];
                                        $quotation_final_amount = $quotationdetails['quotation_final_amount'];
                                        $quotation_pdf = $quotationdetails['quotation_pdf'];
                                        $quotation_status = $quotationdetails['quotation_status'];
                                        $quotation_type = $quotationdetails['quotation_type'];
                                        $quotation_order_status = $quotationdetails['quotation_order_status'];
                                        $quotation_manage_date = date("d-m-Y", strtotime($quotationdetails['quotation_manage_date']));
                                        $quotation_date = date("d-m-Y", strtotime($quotationdetails['quotation_date']));

                                        if ($quotation_currency == "rupess") {
                                            $quotation_currency_symbol = "₹ ";
                                        } else if ($quotation_currency == "dollar") {
                                            $quotation_currency_symbol = "$ ";
                                        } else if ($quotation_currency == "pound") {
                                            $quotation_currency_symbol = "£ ";
                                        } else if ($quotation_currency == "euro") {
                                            $quotation_currency_symbol = "€ ";
                                        } else {
                                            $quotation_currency_symbol = "₹ ";
                                        }

                                        if ($quotation_order_status == 'Yes' && $quotation_pdf != '') {
                                            $selectorderdetails = $pdo->query("SELECT order_id, order_proforma_pdf FROM tbl_order_details WHERE order_quotation_id = " . $quotation_id . "");
                                            $orderdetails = $selectorderdetails->fetch(PDO::FETCH_ASSOC);
                                            $order_id = $orderdetails['order_id'];
                                            $order_proforma_pdf = $orderdetails['order_proforma_pdf'];

                                            if ($order_proforma_pdf != "") {
                                                //$orderid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-original-title="Order: ' . $site_proforma_prefix . '-' . $order_id . '" href="proforma/' . $order_proforma_pdf . '"><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                                $orderid = '<a style="cursor: pointer;" target="_blank" data-toggle="modal" data-target="#pdfModal" data-pdf="proforma/' . $order_proforma_pdf . '"><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            } else {
                                                $orderid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-original-title="Order: ' . $site_proforma_prefix . '-' . $order_id . '" href="#."><span class="orderpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            }
                                        } else {
                                            $orderid = '';
                                        }

                                        $selectclientdetails = $pdo->query("SELECT client_inquiry_source, client_name, client_company_name, client_email_address, client_mobile_code, client_mobile_number_one, client_state_id, client_city FROM tbl_client_details WHERE client_id = '" . $quotation_client_id . "'");
                                        $clientdetails = $selectclientdetails->fetch(PDO::FETCH_ASSOC);
                                        $client_inquiry_source = $clientdetails['client_inquiry_source'];
                                        $client_name = $clientdetails['client_name'];
                                        $client_company_name = $clientdetails['client_company_name'];
                                        $client_email_address = $clientdetails['client_email_address'];
                                        $client_mobile_code = $clientdetails['client_mobile_code'];
                                        $client_mobile_number_one = $clientdetails['client_mobile_number_one'];
                                        $client_state_id = $clientdetails['client_state_id'];
                                        $client_city = $clientdetails['client_city'];

                                        if ($client_company_name != "") {
                                            $client_details = $client_company_name . ' - ' . $client_name;
                                        } else {
                                            $client_details = $client_name;
                                        }

                                        // if ($client_mobile_code != "") {
                                        //     $client_mobile_code_db = $client_mobile_code;
                                        // } else {
                                        //     $client_mobile_code_db = 91;
                                        // }
                                        $client_mobile_code_db = $client_mobile_code;

                                        if ($client_mobile_number_one != "") {
                                            $client_mobile_number = "+" . $client_mobile_code_db . $client_mobile_number_one;
                                        } else {
                                            $client_mobile_number = "";
                                        }

                                        $dbuserdetails = get_single_data("tbl_user_details", "user_name", "user_id = '" . $quotation_user_id . "'");
                                        $dbsourcedetails = get_single_data("tbl_inquiry_source_details", "inquiry_source_name", "inquiry_source_id = '" . $client_inquiry_source . "'");
                                        $dbstatename = get_single_data("tbl_state_details", "state_name", "state_id = '" . $client_state_id . "'");

                                        if ($quotation_type == 'domestic') {
                                            $quotationtype = '<span class="badge badge-glow bg-warning">Domestic</span>';
                                        } else {
                                            $quotationtype = '<span class="badge badge-glow bg-info">International</span>';
                                        }

                                        $selectlastfollowup = $pdo->query("SELECT followup_user_id, followup_details, followup_date, followup_date_time FROM tbl_client_followup_details WHERE followup_client_id = '" . $quotation_client_id . "' ORDER BY followup_id DESC LIMIT 0,1");
                                        $lastfollowupdetails = $selectlastfollowup->fetch(PDO::FETCH_ASSOC);
                                        $followup_user_id = $lastfollowupdetails['followup_user_id'];
                                        $followup_details = $lastfollowupdetails['followup_details'];
                                        $followup_date = $lastfollowupdetails['followup_date'];
                                        $followup_date_time = $lastfollowupdetails['followup_date_time'];
                                        ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo $site_quotation_prefix . '-' . $quotation_id; ?></strong><br>
                                                <span class="item-edit link-primary"><?php echo $dbuserdetails; ?></span><br>
                                                <span class="item-edit link-primary"><strong><?php echo $quotation_manage_date; ?></strong></span>
                                            </td>
                                            <td>
                                                <strong><?php echo $client_details; ?></strong><br>
                                                <span class="item-edit link-primary"><?php echo $client_mobile_number; ?></span><br>
                                                <span class="item-edit link-warning"><?php echo $client_email_address; ?></span><br>
                                                <?php echo $dbstatename . ' - ' . $client_city . ' ' . $orderid; ?>
                                            </td>
                                            <td>
                                                <strong>Basic:</strong>
                                                <?php echo $quotation_currency_symbol . ind_money_format($quotation_after_discount_amount); ?><br>
                                                <strong>Final:</strong>
                                                <?php echo $quotation_currency_symbol . ind_money_format($quotation_final_amount); ?>
                                            </td>
                                            <td><span><?php echo $dbsourcedetails; ?></span></td>
                                            <td><?php echo $quotationtype; ?></td>
                                        </tr>
                                        <script type="text/javascript">
                                        async function doubleFunction(id) {
                                            await window.open(`quotation-pdf-generate.php?qid=${id}`, '_blank');
                                            window.setTimeout(function () {
                                                location.reload();
                                            }, 2000);
                                        }
                                        </script>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center;">No Data Found</td>
                                    </tr>
                                    <?php
                                }
                                $selectlastquotationdetails->execute();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="row mobileorders">
            <div class="col-lg-12 col-12 mb-4">
                <div class="card h-100 custom-data-border">
                    <div class="card-header text-center" style="padding: 15px 0px 12px 0px; background: linear-gradient(50deg, rgba(60, 155, 61, 1) 45%, rgba(1, 160, 164, 1) 65%);">
                        <h5 class="card-title m-0 me-2" style="color: #FFF;">Last 5 Converted Orders</h5>
                    </div>
                    <?php
                    $selectorderdetails = $pdo->query("SELECT order_quotation_id, order_id, order_unique_id, order_client_id, order_user_id, order_currency, order_tax_amount, order_sub_amount, order_discount_amount, order_after_discount_amount, order_final_amount, order_date, order_manage_date, order_status, order_type, order_proforma_pdf FROM tbl_order_details WHERE 1 = 1 " . $order_user_id . " ORDER BY order_id DESC LIMIT 0,5");
                    $totalorders = $selectorderdetails->rowCount();
                    ?>
                    <div class="table-responsive weborders">
                        <table class="table table-bordered orderlist">
                            <thead class="border-bottom">
                                <tr>
                                    <th class="no-sort">DATE</th>
                                    <th class="no-sort">LEAD DETAILS</th>
                                    <th class="no-sort">CONTACT DETAILS</th>
                                    <th class="no-sort">ORDER</th>
                                    <th>LEAD SOURCE</th>
                                    <th>TYPE</th>
                                    <th class="no-sort">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($totalorders > 0) {
                                    foreach ($selectorderdetails as $orderdetails) {
                                        $order_id = $orderdetails['order_id'];
                                        $order_quotation_id = $orderdetails['order_quotation_id'];
                                        $order_client_id = $orderdetails['order_client_id'];
                                        $order_user_id = $orderdetails['order_user_id'];
                                        $order_currency = $orderdetails['order_currency'];
                                        $order_sub_amount = $orderdetails['order_sub_amount'];
                                        $order_discount_amount = $orderdetails['order_discount_amount'];
                                        $order_after_discount_amount = $orderdetails['order_after_discount_amount'];
                                        $order_final_amount = $orderdetails['order_final_amount'];
                                        $order_pdf = $orderdetails['order_pdf'];
                                        $order_status = $orderdetails['order_status'];
                                        $order_type = $orderdetails['order_type'];
                                        $order_order_status = $orderdetails['order_order_status'];
                                        $order_proforma_pdf = $orderdetails['order_proforma_pdf'];
                                        $order_date = date("d-m-Y", strtotime($orderdetails['order_date']));
                                        $order_manage_date = date("d-m-Y", strtotime($orderdetails['order_manage_date']));

                                        if ($order_currency == "rupess") {
                                            $order_currency_symbol = "₹ ";
                                        } else if ($order_currency == "dollar") {
                                            $order_currency_symbol = "$ ";
                                        } else if ($order_currency == "pound") {
                                            $order_currency_symbol = "£ ";
                                        } else if ($order_currency == "euro") {
                                            $order_currency_symbol = "€ ";
                                        } else {
                                            $order_currency_symbol = "₹ ";
                                        }

                                        $selectclientdetails = $pdo->query("SELECT * FROM tbl_client_details WHERE client_id = '" . $order_client_id . "'");
                                        $clientdetails = $selectclientdetails->fetch(PDO::FETCH_ASSOC);
                                        $client_inquiry_source = $clientdetails['client_inquiry_source'];
                                        $client_inquiry_type = $clientdetails['client_inquiry_type'];
                                        $client_name = $clientdetails['client_name'];
                                        $client_company_name = $clientdetails['client_company_name'];
                                        $client_email_address = $clientdetails['client_email_address'];
                                        $client_mobile_code = $clientdetails['client_mobile_code'];
                                        $client_mobile_number_one = $clientdetails['client_mobile_number_one'];
                                        $client_state_id = $clientdetails['client_state_id'];
                                        $client_city = $clientdetails['client_city'];

                                        if ($client_company_name != "") {
                                            $client_details = $client_company_name . ' - ' . $client_name;
                                        } else {
                                            $client_details = $client_name;
                                        }

                                        // if ($client_mobile_code != "") {
                                        //     $client_mobile_code_db = $client_mobile_code;
                                        // } else {
                                        //     $client_mobile_code_db = 91;
                                        // }
                                        $client_mobile_code_db = $client_mobile_code;

                                        if ($client_mobile_number_one != "") {
                                            $client_mobile_number = "+" . $client_mobile_code_db . $client_mobile_number_one;
                                        } else {
                                            $client_mobile_number = "";
                                        }

                                        $dbuserdetails = get_single_data("tbl_user_details", "user_name", "user_id = '" . $order_user_id . "'");
                                        $dbsourcedetails = get_single_data("tbl_inquiry_source_details", "inquiry_source_name", "inquiry_source_id = '" . $client_inquiry_source . "'");
                                        $dbstatename = get_single_data("tbl_state_details", "state_name", "state_id = '" . $client_state_id . "'");

                                        if ($order_type == 'domestic') {
                                            $ordertype = '<span class="badge badge-glow bg-warning">Domestic</span>';
                                        } else {
                                            $ordertype = '<span class="badge badge-glow bg-info">International</span>';
                                        }

                                        $selectlastfollowup = $pdo->query("SELECT followup_user_id, followup_details, followup_date, followup_date_time FROM tbl_client_followup_details WHERE followup_client_id = '" . $order_client_id . "' ORDER BY followup_id DESC LIMIT 0,1");
                                        $lastfollowupdetails = $selectlastfollowup->fetch(PDO::FETCH_ASSOC);
                                        $followup_user_id = $lastfollowupdetails['followup_user_id'];
                                        $followup_details = $lastfollowupdetails['followup_details'];
                                        $followup_date = $lastfollowupdetails['followup_date'];
                                        $followup_date_time = $lastfollowupdetails['followup_date_time'];

                                        if ($order_quotation_id != "" && $order_quotation_id != "0") {
                                            $selectquotationdetails = $pdo->query("SELECT quotation_pdf FROM tbl_quotation_details WHERE quotation_id = " . $order_quotation_id . "");
                                            $quotationdetails = $selectquotationdetails->fetch(PDO::FETCH_ASSOC);
                                            $quotation_pdf = $quotationdetails['quotation_pdf'];

                                            if ($quotation_pdf != "") {
                                                //$orderid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-warning" data-bs-original-title="Quote: ' . $site_quotation_prefix . '-' . $order_quotation_id . '" href="quotation/' . $quotation_pdf . '"><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                                $orderid = '<a style="cursor: pointer;" target="_blank" data-toggle="modal" data-target="#pdfModal" data-pdf="quotation/' . $quotation_pdf . '"><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            } else {
                                                $orderid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-warning" data-bs-original-title="Quote: ' . $site_quotation_prefix . '-' . $order_quotation_id . '" href="#."><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            }
                                        } else {
                                            $orderid = '';
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo $site_proforma_prefix . '-' . $order_id; ?></strong> <span class="item-edit link-primary"><?php echo $dbuserdetails; ?></span><br>
                                                <span class="item-edit link-primary"><strong><?php echo $order_manage_date; ?></strong></span>
                                            </td>
                                            <td>
                                                <strong><?php echo $client_details; ?></strong><br>
                                                <?php echo $dbstatename . ' - ' . $client_city . ' ' . $orderid; ?>
                                            </td>
                                            <td>
                                                <span class="item-edit link-primary"><?php echo $client_mobile_number; ?></span><br>
                                                <span class="item-edit link-warning"><?php echo $client_email_address; ?></span>
                                            </td>
                                            <td>
                                                <strong>Basic:</strong>
                                                <?php echo $order_currency_symbol . ind_money_format($order_after_discount_amount); ?><br>
                                                <strong>Final:</strong>
                                                <?php echo $order_currency_symbol . ind_money_format($order_final_amount); ?>
                                            </td>
                                            <td><span><?php echo $dbsourcedetails; ?></span></td>
                                            <td><?php echo $ordertype; ?></td>
                                            <td style="text-align:center;">
                                                <div class="d-inline-block">
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-primary" data-bs-original-title="View Last Follow-up Details" onclick="view_followup_details(`<?php echo $order_client_id; ?>`,`<?php echo $followup_user_id; ?>`,`<?php echo $followup_date_time; ?>`,`<?php echo $followup_date; ?>`,`<?php echo $followup_details; ?>`)" href="javascript:void(0)" class="btn btn-sm btn-icon link-primary"><i class="ti ti-eye mx-2 ti-sm"></i></a>

                                                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="text-primary ti ti-dots-vertical"></i></a>
                                                    <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                                                        <?php
                                                        if ($_SESSION["logged_user_type_main"] == 1 || $order_user_id == $_SESSION["logged_user_id"]) {
                                                            ?>
                                                            <li>
                                                                <a onclick='doubleFunction(`<?php echo base64_encode($order_id); ?>`)' class="dropdown-item text-danger"><i class="ti ti-file-text mx-2 ti-sm"></i>Create Proforma</a>
                                                            </li>
                                                            <?php
                                                            if ($order_proforma_pdf != "") {
                                                                ?>
                                                                <li>
                                                                    <a data-toggle="modal" data-target="#pdfModal" data-pdf="proforma/<?php echo  $order_proforma_pdf; ?>" class="dropdown-item text-primary"><i class="ti ti-file-text mx-2 ti-sm"></i>View Proforma</a>
                                                                </li>
                                                                <li>
                                                                    <a onclick="javascript:if(!confirm('Are you sure you want to send proforma invoice details?')) return false;" href="<?php echo SITE_URL; ?>order-db.php?myaction=send&oid=<?php echo base64_encode($order_id); ?>" class="dropdown-item text-copper"><i class="ti ti-mail mx-2 ti-sm"></i>Mail</a>
                                                                </li>
                                                                <?php
                                                            }
                                                        }

                                                        if ($order_status == 'Yes') {
                                                            if ($_SESSION["logged_user_type_main"] == 1 || $order_user_id == $_SESSION["logged_user_id"]) {
                                                                ?>
                                                                <li>
                                                                    <a onclick="window.location = '<?php echo SITE_URL; ?>order-edit/edit/<?php echo base64_encode($order_id); ?>'" class="dropdown-item text-magenta"><i class="ti ti-edit mx-2 ti-sm"></i>Edit</a>
                                                                </li>
                                                                <?php
                                                            }
                                                        }

                                                        if (CheckBtnPermission() == 1) {
                                                            ?>
                                                            <li>
                                                                <a href="tel:<?php echo $client_mobile_number_one; ?>" class="dropdown-item text-coffee"><i class="ti ti-phone mx-2 ti-sm"></i>Call</a>
                                                            </li>
                                                            <li>
                                                                <a href="http://wa.me/91<?php echo $client_mobile_number_one; ?>" target="_blank" class="dropdown-item text-success"><i class="ti ti-whatsapp mx-2 ti-sm"></i>WhatsApp</a>
                                                            </li>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <li>
                                                                <a href="#." class="dropdown-item text-dark"><i class="ti ti-phone mx-2 ti-sm"></i>Call</a>
                                                            </li>
                                                            <li>
                                                                <a href="#." class="dropdown-item text-success"><i class="ti ti-whatsapp mx-2 ti-sm"></i>WhatsApp</a>
                                                            </li>
                                                            <?php
                                                        }

                                                        if ($_SESSION["logged_user_type_main"] == 1 && $order_status == 'Yes') {
                                                            ?>
                                                            <div class="dropdown-divider"></div>
                                                            <?php if (CheckBtnPermission() == 1) { ?>
                                                            <li>
                                                                <a onclick="javascript:if(!confirm('Are you sure you want to delete order details?')) return false;" href="order-db.php?myaction=delete&oid=<?php echo base64_encode($order_id); ?>" class="dropdown-item text-danger delete-record"><i class="ti ti-trash mx-2 ti-sm"></i>Delete</a>
                                                            </li>
                                                            <?php } else { ?>
                                                            <li>
                                                                <a href="#." class="dropdown-item text-danger delete-record"><i class="ti ti-trash mx-2 ti-sm"></i>Delete</a>
                                                            </li>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    $selectorderdetails->execute();
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center;">No Data Found</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive tabletorders">
                        <table class="table table-bordered orderlist">
                            <thead class="border-bottom">
                                <tr>
                                    <th class="no-sort">DATE</th>
                                    <th class="no-sort">LEAD DETAILS</th>
                                    <th class="no-sort">ORDER</th>
                                    <th>LEAD SOURCE</th>
                                    <th>TYPE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($totalorders > 0) {
                                    foreach ($selectorderdetails as $orderdetails) {
                                        $order_id = $orderdetails['order_id'];
                                        $order_quotation_id = $orderdetails['order_quotation_id'];
                                        $order_client_id = $orderdetails['order_client_id'];
                                        $order_user_id = $orderdetails['order_user_id'];
                                        $order_currency = $orderdetails['order_currency'];
                                        $order_sub_amount = $orderdetails['order_sub_amount'];
                                        $order_discount_amount = $orderdetails['order_discount_amount'];
                                        $order_after_discount_amount = $orderdetails['order_after_discount_amount'];
                                        $order_final_amount = $orderdetails['order_final_amount'];
                                        $order_pdf = $orderdetails['order_pdf'];
                                        $order_status = $orderdetails['order_status'];
                                        $order_type = $orderdetails['order_type'];
                                        $order_order_status = $orderdetails['order_order_status'];
                                        $order_proforma_pdf = $orderdetails['order_proforma_pdf'];
                                        $order_date = date("d-m-Y", strtotime($orderdetails['order_date']));
                                        $order_manage_date = date("d-m-Y", strtotime($orderdetails['order_manage_date']));

                                        if ($order_currency == "rupess") {
                                            $order_currency_symbol = "₹ ";
                                        } else if ($order_currency == "dollar") {
                                            $order_currency_symbol = "$ ";
                                        } else if ($order_currency == "pound") {
                                            $order_currency_symbol = "£ ";
                                        } else if ($order_currency == "euro") {
                                            $order_currency_symbol = "€ ";
                                        } else {
                                            $order_currency_symbol = "₹ ";
                                        }

                                        $selectclientdetails = $pdo->query("SELECT * FROM tbl_client_details WHERE client_id = '" . $order_client_id . "'");
                                        $clientdetails = $selectclientdetails->fetch(PDO::FETCH_ASSOC);
                                        $client_inquiry_source = $clientdetails['client_inquiry_source'];
                                        $client_inquiry_type = $clientdetails['client_inquiry_type'];
                                        $client_name = $clientdetails['client_name'];
                                        $client_company_name = $clientdetails['client_company_name'];
                                        $client_email_address = $clientdetails['client_email_address'];
                                        $client_mobile_code = $clientdetails['client_mobile_code'];
                                        $client_mobile_number_one = $clientdetails['client_mobile_number_one'];
                                        $client_state_id = $clientdetails['client_state_id'];
                                        $client_city = $clientdetails['client_city'];

                                        if ($client_company_name != "") {
                                            $client_details = $client_company_name . ' - ' . $client_name;
                                        } else {
                                            $client_details = $client_name;
                                        }

                                        // if ($client_mobile_code != "") {
                                        //     $client_mobile_code_db = $client_mobile_code;
                                        // } else {
                                        //     $client_mobile_code_db = 91;
                                        // }
                                        $client_mobile_code_db = $client_mobile_code;

                                        if ($client_mobile_number_one != "") {
                                            $client_mobile_number = "+" . $client_mobile_code_db . $client_mobile_number_one;
                                        } else {
                                            $client_mobile_number = "";
                                        }

                                        $dbuserdetails = get_single_data("tbl_user_details", "user_name", "user_id = '" . $order_user_id . "'");
                                        $dbsourcedetails = get_single_data("tbl_inquiry_source_details", "inquiry_source_name", "inquiry_source_id = '" . $client_inquiry_source . "'");
                                        $dbstatename = get_single_data("tbl_state_details", "state_name", "state_id = '" . $client_state_id . "'");

                                        if ($order_type == 'domestic') {
                                            $ordertype = '<span class="badge badge-glow bg-warning">Domestic</span>';
                                        } else {
                                            $ordertype = '<span class="badge badge-glow bg-info">International</span>';
                                        }

                                        $selectlastfollowup = $pdo->query("SELECT followup_user_id, followup_details, followup_date, followup_date_time FROM tbl_client_followup_details WHERE followup_client_id = '" . $order_client_id . "' ORDER BY followup_id DESC LIMIT 0,1");
                                        $lastfollowupdetails = $selectlastfollowup->fetch(PDO::FETCH_ASSOC);
                                        $followup_user_id = $lastfollowupdetails['followup_user_id'];
                                        $followup_details = $lastfollowupdetails['followup_details'];
                                        $followup_date = $lastfollowupdetails['followup_date'];
                                        $followup_date_time = $lastfollowupdetails['followup_date_time'];

                                        if ($order_quotation_id != "" && $order_quotation_id != "0") {
                                            $selectquotationdetails = $pdo->query("SELECT quotation_pdf FROM tbl_quotation_details WHERE quotation_id = " . $order_quotation_id . "");
                                            $quotationdetails = $selectquotationdetails->fetch(PDO::FETCH_ASSOC);
                                            $quotation_pdf = $quotationdetails['quotation_pdf'];

                                            if ($quotation_pdf != "") {
                                                //$orderid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-warning" data-bs-original-title="Quote: ' . $site_quotation_prefix . '-' . $order_quotation_id . '" href="quotation/' . $quotation_pdf . '"><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                                $orderid = '<a style="cursor: pointer;" target="_blank" data-toggle="modal" data-target="#pdfModal" data-pdf="quotation/' . $quotation_pdf . '"><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            } else {
                                                $orderid = '<a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-warning" data-bs-original-title="Quote: ' . $site_quotation_prefix . '-' . $order_quotation_id . '" href="#."><span class="quotationpdf"><i class="ti ti-circle-check"></i></span></a>';
                                            }
                                        } else {
                                            $orderid = '';
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo $site_proforma_prefix . '-' . $order_id; ?></strong> <span class="item-edit link-primary"><br><?php echo $dbuserdetails; ?></span><br>
                                                <span class="item-edit link-primary"><strong><?php echo $order_manage_date; ?></strong></span>
                                            </td>
                                            <td>
                                                <strong><?php echo $client_details; ?></strong><br>
                                                <span class="item-edit link-primary"><?php echo $client_mobile_number; ?></span><br>
                                                <span class="item-edit link-warning"><?php echo $client_email_address; ?></span><br>
                                                <?php echo $dbstatename . ' - ' . $client_city . ' ' . $orderid; ?>
                                            </td>
                                            <td>
                                                <strong>Basic:</strong>
                                                <?php echo $order_currency_symbol . ind_money_format($order_after_discount_amount); ?><br>
                                                <strong>Final:</strong>
                                                <?php echo $order_currency_symbol . ind_money_format($order_final_amount); ?>
                                            </td>
                                            <td><span><?php echo $dbsourcedetails; ?></span></td>
                                            <td><?php echo $ordertype; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    $selectorderdetails->execute();
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center;">No Data Found</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel"></div>
<div id="backdrop"></div>

<?php include_once("includes/admin_bottom.php"); ?>

<script type="text/javascript">
function insert_record(recordid) {
    var data = {
        recordid
    };
    $.ajax({
        type: "POST",
        url: '<?php echo SITE_URL; ?>feedback-add.php',
        data: data,
        async: false,
        cache: false,
        success: function (res) {
            $("#offcanvasEnd").empty().append(res),
                $('#offcanvasEnd').addClass('show');
            $('#backdrop').addClass('offcanvas-backdrop fade show');
            $('body').css({
                'overflow': 'hidden',
                'padding-right': '15px'
            });
            $("#offcanvasEnd .followup_client_id").select2({
                tags: true,
                dropdownParent: $("#offcanvasEnd")
            });
        }
    })
}

function close_data_process() {
    $('body').removeAttr('style');
    $('#offcanvasEnd').removeClass('fade show');
    $('#backdrop').removeClass('offcanvas-backdrop fade show');
}

function manage_data_process() {
    event.preventDefault();

    $.ajax({
        type: "POST",
        url: "<?php echo SITE_URL; ?>feedback-details-db.php",
        data: new FormData($("#dataform")[0]),

        beforeSend: function () {
            $('#inquiryloading').html(
                '<img src="<?php echo SITE_URL; ?>images/ajax-loader.gif"/>'
            );
        },

        contentType: !1,
        processData: !1,
        success: function (e) {
            var html = jQuery.parseJSON(e);
            if (html.status == 1) {
                $('#inquiryloading').css("display", "none");

                $(".form-blank-error").css("display", "none");
                $(".form-error").css("display", "none");

                $('.form-message').html(
                    '<div class="alert alert-success my-3" role="alert">Follow-up details has been added successfully.</div>'
                ).fadeIn('slow');

                $(".form-message").show().delay(5000).fadeOut('slow');

                setTimeout(function () {
                    location.reload();
                }, 2000);
            } else if (html.status == 2) {
                $('#inquiryloading').css("display", "none");

                $('.form-error').html(
                    '<div class="alert alert-danger my-3" role="alert">Please fill out all fields.</div>'
                ).fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            } else {
                $('#inquiryloading').css("display", "none");

                $('.form-error').html(
                    '<div class="alert alert-danger my-3" role="alert">There was an error. Please try again.</div>'
                ).fadeIn('slow');

                $(".form-error").show().delay(2000).fadeOut('slow');
            }
        }
    });
}

function view_followup_details(client_id, user_id, followup_date_time, followup_date, followup_details) {
    var data = {
        client_id,
        user_id,
        followup_date_time,
        followup_date,
        followup_details
    };
    $.ajax({
        type: "POST",
        url: '<?php echo SITE_URL; ?>followup-details.php',
        data: data,
        async: false,
        cache: false,
        success: function (res) {
            $("#offcanvasEnd").empty().append(res),
                $('#offcanvasEnd').addClass('show');
            $('#backdrop').addClass('offcanvas-backdrop fade show');
            $('body').css({
                'overflow': 'hidden',
                'padding-right': '15px'
            });
        }
    })
}
</script>