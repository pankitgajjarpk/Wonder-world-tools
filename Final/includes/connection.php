<?php
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

error_reporting(E_ALL);
ini_set("error_reporting", 1);

date_default_timezone_set("Asia/Kolkata");

setlocale(LC_MONETARY, 'en_IN');

@session_start();
ob_start();

extract($_GET);
extract($_POST);
extract($_REQUEST);

$currentmonth = date('n');
$currentyear = date('Y');

$tmptime = date("His");
$tmpdate = date("Y-m-d");
$tmpdatetime = date("Y-m-d H:i:s");

$DB_Host = "localhost";
$DB_Name = "wonderworldtools";
$DB_Username = "root";
$DB_Password = "";

/*$DB_Host = "localhost";
$DB_Name = "";
$DB_Username = "";
$DB_Password = "";*/

try {
    $pdo = new PDO("mysql:host=$DB_Host;dbname=$DB_Name",$DB_Username,$DB_Password);
} catch(Exception $e){  
    echo "Connection failed: " . $e->getMessage();  
}

$cur_page_arr = explode("/",$_SERVER['PHP_SELF']);
$cur_page = $cur_page_arr[count($cur_page_arr)-1];

$site_url = "http://localhost/Wonder-world-tools/Final/";
//$site_url = "";

define("SITE_URL","http://localhost/Wonder-world-tools/Final/");
//define("SITE_URL","");

$selectsitesettengs = $pdo->query("SELECT * FROM tbl_site_details WHERE site_id = 1");
$sitesettengs = $selectsitesettengs->fetch(PDO::FETCH_ASSOC);
$site_logo = $sitesettengs['site_logo'];
$site_name = $sitesettengs['site_name'];
$site_email_address = $sitesettengs['site_email_address'];
$site_mobile_number = $sitesettengs['site_mobile_number'];
$site_address = $sitesettengs['site_address'];

$site_challan_prefix = $sitesettengs['site_challan_prefix'];