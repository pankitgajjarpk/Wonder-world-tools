<?php
include_once("connection.php");
include_once("functions.php");
?>
<div class="app-menu navbar-menu">
    <div class="navbar-brand-box" style="padding-left: 0px;">
        <a href="<?php echo $site_url; ?>" class="logo logo-light">
            <span style="color: #FFF; font-weight: bold; font-size: 15px;">Challan Book</span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>

            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link" href="dashboard.php">
                        <i class="ri-dashboard-line"></i> <span data-key="t-widgets">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="dashboard.php">
                        <i class="ri-account-circle-line"></i> <span data-key="t-widgets">Clients</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="dashboard.php">
                        <i class="ri-pages-line"></i> <span data-key="t-widgets">Challan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="dashboard.php">
                        <i class="ri-user-3-line"></i> <span data-key="t-widgets">Users</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="dashboard.php">
                        <i class="ri-logout-circle-r-line"></i> <span data-key="t-widgets">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>

<div class="main-content">