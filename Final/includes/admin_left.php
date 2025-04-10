<?php
include_once("connection.php");
include_once("functions.php");

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

if($_SESSION["logged_user_type_main"] == 1) {
    $selectnotifications = $pdo->query("SELECT notification_sent_id, notification_date, notification_details FROM tbl_notification_details WHERE notification_date = '".$tmpdate."' ORDER BY notification_id DESC LIMIT 0,3");

    $totalnotification = $pdo->query("SELECT notification_id FROM tbl_notification_details WHERE notification_user_id = '".$_SESSION["logged_user_id"]."' AND notification_view_status = 'No'");
    $notificationquerycount = $totalnotification->rowCount();
    
    $client_user_id = '';

    $checktarget = 1;
    $checkquotationorder = 1;
    $checkitem = 1;
    $checkleadtags = 1;
    $checknewleads = 1;
} else {
    $selectnotifications = $pdo->query("SELECT notification_sent_id, notification_date, notification_details FROM tbl_notification_details WHERE notification_date = '".$tmpdate."' AND (notification_sent_id = '".$_SESSION["logged_user_id"]."' OR FIND_IN_SET('".$_SESSION["logged_user_id"]."', notification_user_id)) ORDER BY notification_id DESC LIMIT 0,3");

    $totalnotification = $pdo->query("SELECT notification_id FROM tbl_notification_details WHERE notification_user_id = '".$_SESSION["logged_user_id"]."' AND notification_view_status = 'No'");
    $notificationquerycount = $totalnotification->rowCount();
    
    $checkdeletepermission = CheckPermission($_SESSION["logged_user_type_id"], 8, '');

    if($checkdeletepermission == 1) {
        $client_user_id = '';
    } else {
        $client_user_id = " AND client_user_id = '".$_SESSION["logged_user_id"]."'";
    }
    
    $checktarget = CheckPermission($_SESSION["logged_user_type_id"], 4, '');
    $checkquotationorder = CheckPermission($_SESSION["logged_user_type_id"], 5, '');
    $checkitem = CheckPermission($_SESSION["logged_user_type_id"], 6, '');
    $checkleadtags = CheckPermission($_SESSION["logged_user_type_id"], 7, '');
    $checknewleads = CheckPermission($_SESSION["logged_user_type_id"], 8, '');
}

// $selectclients = $pdo->query("SELECT client_id FROM tbl_client_details WHERE (client_entry = 'Tradeindia' OR client_entry = 'IndiaMart' OR client_entry = 'Facebook' OR client_entry = 'Aajjo' OR client_entry = 'Website') AND client_status = 'Yes' AND client_allocation_status = 'No' $client_user_id");
// $clientcount = $selectclients->rowCount();

// $follow_up_sql = "SELECT * FROM follow_up_history f1 WHERE followup_status = 0 AND f1.followup_date_time = ( SELECT MAX(f2.followup_date_time) FROM follow_up_history f2 WHERE f1.followup_client_id = f2.followup_client_id ) GROUP BY f1.followup_client_id";

// $followup_new_assign_count = $pdo->query($follow_up_sql)->rowCount();

$web_protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
$web_cur_page = $_SERVER['SERVER_NAME'];

$selectclients = $pdo->query("SELECT client_id FROM tbl_client_details WHERE client_allocation_status = 'Yes'");
$totalcount = $selectclients->rowCount();

//echo $protocol. "://" .$cur_page;
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?php echo SITE_URL; ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img class="img-fluid" src="<?php if($site_logo != "") { echo SITE_URL.'images/'.$site_logo; } else { echo SITE_URL; ?>images/default/favicon.png<?php } ?>" alt="<?php echo $site_name; ?>" />
            </span>
            <span class="app-brand-text demo menu-text fw-bold" style="color: #<?php echo $site_color_code; ?>"><?php echo $site_short_name; ?></span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">QUICK LINKS</span>
        </li>

        <li class="<?php if($cur_page == "dashboard.php") { echo "active"; } ?> menu-item">
            <a class="menu-link" href="<?php echo SITE_URL; ?>dashboard">
                <i class="menu-icon tf-icons ti ti-smart-home link-purple"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- Leads -->
        <li class="<?php if($cur_page == "leads-edit.php" || $cur_page == "new-leads-details.php" || $cur_page == "new-leads-list.php" || $cur_page == "new-leads.php" || $cur_page == "leads-list.php" || $cur_page == "leads.php" || $cur_page == "lead-search.php" || $cur_page == "new-leads-edit.php" || $cur_page == "new-assign.php") { echo "active open"; } ?> menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users link-success"></i>
                <div data-i18n="Leads">Leads</div>
            </a>
            <ul class="menu-sub">
                <li class="<?php if($cur_page == "import-leads-details.php" || $cur_page == "leads-edit.php" || $cur_page == "leads-list.php" || $cur_page == "leads.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>leads-list" class="menu-link">
                        <div data-i18n="All Leads">All Leads</div>
                    </a>
                </li>
                <li class="<?php if($cur_page == "new-leads-list.php" || $cur_page == "new-leads.php" || $cur_page == "new-leads-edit.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>new-leads-list" class="menu-link">
                        <div class="<?php if($cur_page != "new-leads-list.php") { echo "text-success"; } ?>" data-i18n="New Leads">New Leads</div>
                        <?php /* if($clientcount > 0) { ?><div class="badge bg-label-danger rounded-pill ms-auto"><?php echo $clientcount; ?></div><?php } */ ?>
                    </a>
                </li>
                <li class="<?php if($cur_page == "new-assign.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>new-assign" class="menu-link">
                        <div class="<?php if($cur_page != "new-assign.php") { echo "text-primary"; } ?>" data-i18n="New Assign">New Assign</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Follow-up -->
        <li class="<?php if($cur_page == "follow-up-history.php" || $cur_page == "not-interested-list.php" || $cur_page == "feedback.php" || $cur_page == "feedback-details.php" || $cur_page == "expired-follow-up-list.php" || $cur_page == "follow-up-list.php") { echo "active open"; } ?> menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-phone-call link-orange"></i>
                <div data-i18n="Follow-up">Follow-up</div>
            </a>
            <ul class="menu-sub">
                <li class="<?php if($cur_page == "feedback-details.php" || $cur_page == "follow-up-list.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>follow-up-list" class="menu-link">
                        <div data-i18n="Upcoming Follow-up">Upcoming Follow-up</div>
                    </a>
                </li>
                <li class="<?php if($cur_page == "expired-follow-up-list.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>expired-follow-up-list" class="menu-link">
                        <div data-i18n="Expired Follow-up">Expired Follow-up</div>
                    </a>
                </li>
                <li class="<?php if($cur_page == "not-interested-list.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>not-interested-list" class="menu-link">
                        <div data-i18n="Not Interested">Not Interested</div>
                    </a>
                </li>
                <li class="<?php if($cur_page == "follow-up-history.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>follow-up-history" class="menu-link">
                        <div data-i18n="Follow-up Report">Follow-up Report</div>
                    </a>
                </li>
            </ul>
        </li>

        <?php if($checkquotationorder == 1) { ?>
        <!-- Quotation -->
        <li class="<?php if($cur_page == "quotation-list.php" || $cur_page == "quotations.php" || $cur_page == "quotation-edit.php") { echo "active"; } ?> menu-item">
            <a class="menu-link" href="<?php echo SITE_URL; ?>quotation-list">
                <i class="menu-icon tf-icons ti ti-clipboard link-danger"></i>
                <div data-i18n="Quotation">Quotation</div>
            </a>
        </li>

        <!-- Order -->
        <li class="<?php if($cur_page == "order-list.php" || $cur_page == "order.php" || $cur_page == "order-edit.php") { echo "active"; } ?> menu-item">
            <a class="menu-link" href="<?php echo SITE_URL; ?>order-list">
                <i class="menu-icon tf-icons ti ti-shopping-cart link-primary"></i>
                <div data-i18n="Orders">Orders</div>
            </a>
        </li>
        <?php } ?>

        <?php if($checktarget == 1) { ?>
        <!-- Target -->
        <li class="<?php if($cur_page == "target-order-details.php" || $cur_page == "target-collection-details.php" || $cur_page == "target-list.php" || $cur_page == "target.php") { echo "active"; } ?> menu-item">
            <a class="menu-link" href="<?php echo SITE_URL; ?>target-list">
                <i class="menu-icon tf-icons ti ti-target link-pink"></i>
                <div data-i18n="Target">Target</div>
            </a>
        </li>
        <?php } ?>

        <!-- Notification -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">USER ELEMENTS</span>
        </li>
        <li class="<?php if($cur_page == "notification-list.php" || $cur_page == "notification.php") { echo "active"; } ?> menu-item">
            <a class="menu-link" href="<?php echo SITE_URL; ?>notification-list">
                <i class="menu-icon tf-icons ti ti-bell link-warning"></i>
                <div data-i18n="Notifications">Notifications</div>
            </a>
        </li>

        <?php if($checkitem == 1) { ?>
        <!-- Item -->
        <li class="<?php if($cur_page == "item-list.php" || $cur_page == "item.php") { echo "active"; } ?> menu-item">
            <a class="menu-link" href="<?php echo SITE_URL; ?>item-list">
                <i class="menu-icon tf-icons ti ti-briefcase link-info"></i>
                <div data-i18n="Items">Items</div>
            </a>
        </li>
        <?php } ?>

        <?php if($checkleadtags == 1) { ?>
        <!-- Lead Tags -->
        <li class="<?php if($cur_page == "type-list.php" || $cur_page == "type.php" || $cur_page == "source-list.php" || $cur_page == "source.php" || $cur_page == "status-list.php" || $cur_page == "status.php") { echo "active open"; } ?> menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-flag link-magenta"></i>
                <div data-i18n="Lead Tags">Lead Tags</div>
            </a>
            <ul class="menu-sub">
                <li class="<?php if($cur_page == "source-list.php" || $cur_page == "source.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>source-list" class="menu-link">
                        <div data-i18n="Lead Source">Lead Source</div>
                    </a>
                </li>
                <li class="<?php if($cur_page == "type-list.php" || $cur_page == "type.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>type-list" class="menu-link">
                        <div data-i18n="Lead Type">Lead Type</div>
                    </a>
                </li>
                <li class="<?php if($cur_page == "status-list.php" || $cur_page == "status.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>status-list" class="menu-link">
                        <div data-i18n="Lead Status">Lead Status</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>

        <?php if($_SESSION["logged_user_type_main"] == 1) { ?>
        <!-- User & User Controls -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">ACCESS CONTROL</span>
        </li>
        <li class="<?php if($cur_page == "user-list.php" || $cur_page == "user.php" || $cur_page == "user-control-list.php" || $cur_page == "user-control.php") { echo "active open"; } ?> menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users link-mint"></i>
                <div data-i18n="Users">Users</div>
            </a>
            <ul class="menu-sub">
                <li class="<?php if($cur_page == "user-list.php" || $cur_page == "user.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>user-list" class="menu-link">
                        <div data-i18n="All Users">All Users</div>
                    </a>
                </li>
                <li class="<?php if($cur_page == "user-control-list.php" || $cur_page == "user-control.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>user-control-list" class="menu-link">
                        <div data-i18n="User Type">User Type</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- API Connect -->
        <?php if($_SESSION["logged_user_type_main"] == 1) { ?>
        <li class="menu-item">
            <a class="menu-link" href="<?php echo SITE_URL; ?>api-connect">
                <i class="menu-icon tf-icons ti ti-plug link-primary link-redgold"></i>
                <div data-i18n="API Connect">API Connect</div>
            </a>
        </li>
        <?php } ?>

        <!-- Profile (Settings) & Mail Template -->
        <li class="<?php if($cur_page == "setting.php" || $cur_page == "smtp.php") { echo "active open"; } ?> menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-settings link-yellow"></i>
                <div data-i18n="Settings">Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="<?php if($cur_page == "setting.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>setting" class="menu-link">
                        <div data-i18n="Profile">Profile</div>
                    </a>
                </li>
                <li class="<?php if($cur_page == "smtp.php") { echo "active"; } ?> menu-item">
                    <a href="<?php echo SITE_URL; ?>smtp" class="menu-link">
                        <div data-i18n="Plug-in">Mail Template</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>

        <!-- Logout -->
        <li class="menu-item">
            <a class="menu-link" href="<?php echo SITE_URL; ?>logout">
                <i class="menu-icon tf-icons ti ti-logout link-redgold"></i>
                <div data-i18n="Logout">Logout</div>
            </a>
        </li>

        <?php if($_SESSION["logged_user_type_main"] == 1) { ?>
        <li class="menu-item ">
            <a href="<?php echo $web_protocol. "://" .$web_cur_page; ?>/adsweb/cp-control" target="_blank" class="menu-link custom-head-button" style="background: linear-gradient(50deg, rgba(60, 155, 61, 1) 45%, rgba(1, 160, 164, 1) 65%) !important">
                <i class="menu-icon fa-solid fa-up-right-from-square" style="color: #FFF; font-size: 1rem;"></i>
                <div data-i18n="Website Admin Panel" style="color: #FFF;">Website Admin Panel</div>
            </a>
        </li>
        <?php } ?>
    </ul>
</aside>

<div class="layout-page">
    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="ti ti-menu-2 ti-sm"></i>
            </a>
        </div>
        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <div class="navbar-nav align-items-center">
                <div class="nav-item navbar-search-wrapper mb-0">
                    <span class="d-none d-md-inline-block"><strong>Welcome to <?php echo $site_name; ?></strong></span>
                </div>
            </div>
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                    <a class="nav-link dropdown-toggle hide-arrow link-primary" href="<?php echo SITE_URL; ?>lead-search" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Search Client" data-bs-auto-close="outside" aria-expanded="false">
                        <i class="ti ti-search ti-md"></i>
                    </a>
                </li>
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                    <a class="nav-link dropdown-toggle hide-arrow link-danger" href="javascript:void(0)" data-bs-toggle="dropdown"  data-bs-auto-close="outside" aria-expanded="false">
                        <i class="ti ti-bell ti-md"></i>
                        <?php if($notificationquerycount > 0) { ?>
                        <span class="badge bg-success rounded-pill badge-notifications"><?php echo $notificationquerycount; ?></span>
                        <?php } ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end py-0">
                        <li class="dropdown-menu-header border-bottom">
                            <div class="dropdown-header d-flex align-items-center py-3">
                                <h5 class="text-body mb-0 me-auto">Notification</h5>
                                <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Notification"><i class="ti ti-mail-opened fs-4"></i></a>
                            </div>
                        </li>
                        <li class="dropdown-notifications-list scrollable-container">
                            <ul class="list-group list-group-flush">
                                <?php
                                while ($notificationdetails = $selectnotifications->fetch(PDO::FETCH_ASSOC)) {
                                    $notification_sent_id = $notificationdetails['notification_sent_id'];
                                    $notification_date = $notificationdetails['notification_date'];
                                    $notification_details = $notificationdetails['notification_details'];

                                    $dbusername = get_single_data("tbl_user_details", "user_name", "user_id = '".$notification_sent_id."'");
                                    ?>
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1"><?php echo $dbusername.' - '.date("d-m-Y",strtotime($notification_date)); ?></h6>
                                                <p class="mb-0"><?php echo $notification_details; ?></p>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown-menu-footer border-top">
                            <a href="<?php echo SITE_URL; ?>notification-list" class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">View All Notifications</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <?php if($_SESSION["logged_user_image"] != "") { ?>
                                <img src="<?php echo SITE_URL.'images/'.$_SESSION["logged_user_image"]; ?>" class="h-auto rounded-circle" />
                            <?php } else { ?>
                                <img src="<?php echo SITE_URL; ?>images/default/default-user-logo.jpg" class="h-auto rounded-circle" />
                            <?php } ?>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#.">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block"><?php echo $_SESSION["logged_user_name"]; ?></span>
                                        <small class="text-muted"><?php echo $_SESSION["logged_user_type"]; ?></small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <?php if($totalcount < $site_leads) { ?>
                        <li>
                            <a class="dropdown-item" href="<?php echo SITE_URL; ?>leads">
                                <i class="ti ti-users link-success me-2 ti-sm"></i>
                                <span class="align-middle">Add New Lead</span>
                            </a>
                        </li>
                        <?php } ?>

                        <?php //if($checknewleads == 1) { ?>
                        <li>
                            <a class="dropdown-item" href="<?php echo SITE_URL; ?>new-leads-list">
                                <i class="ti ti-users link-success me-2 ti-sm"></i>
                                <span class="align-middle">Check New Leads</span>
                            </a>
                        </li>
                        <?php //} ?>

                        <li>
                            <a class="dropdown-item" href="<?php echo SITE_URL; ?>follow-up-history">
                                <i class="ti ti-inbox link-purple me-2 ti-sm"></i>
                                <span class="align-middle">View Follow-up Report</span>
                            </a>
                        </li>

                        <?php if($checkquotationorder == 1) { ?>
                        <li class="mobilehidebtn tablethidebtn">
                            <a class="dropdown-item" href="<?php echo SITE_URL; ?>quotations">
                                <i class="ti ti ti-clipboard link-danger me-2 ti-sm"></i>
                                <span class="align-middle">Add New Quotation</span>
                            </a>
                        </li>
                        <li class="mobilehidebtn tablethidebtn">
                            <a class="dropdown-item" href="<?php echo SITE_URL; ?>order">
                                <i class="ti ti-shopping-cart link-primary me-2 ti-sm"></i>
                                <span class="align-middle">Add New Order</span>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if($_SESSION["logged_user_type_main"] == 1) { ?>
                        <li>
                            <a class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-primary" onclick="view_switch_user()" href="javascript:void(0)">
                                <i class="fa-solid fa-arrow-right-arrow-left link-dark me-2" style="font-size: 1rem !important;margin-right: 0.75rem !important;!i;!;margin-left: 0.25rem;"></i>
                                <span class="align-middle">Switch User</span>
                            </a>
                        </li>
                        <?php } ?>

                        <li>
                            <a class="dropdown-item" href="<?php echo SITE_URL; ?>change-password">
                                <i class="ti ti-user-check link-yellow me-2 ti-sm"></i>
                                <span class="align-middle">Change Password</span>
                            </a>
                        </li>

                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo SITE_URL; ?>logout">
                                <i class="ti ti ti-logout link-redgold me-2 ti-sm"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    
    <div class="offcanvas offcanvas-end" tabindex="-1" id="switchUserSide" aria-labelledby="switchUserSideLabel"></div>
    <div id="switchUserbackdrop"></div>

    <div class="content-wrapper">