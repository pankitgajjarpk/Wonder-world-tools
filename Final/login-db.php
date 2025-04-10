<?php
include_once("includes/connection.php");
include_once("includes/functions.php");

$action = isset($_REQUEST["err"]) ? strtolower(trim($_REQUEST["err"])) : "";
$mymsg = isset($_REQUEST["errmsg"]) ? $_REQUEST["errmsg"] : "";
$err = isset($_REQUEST["err"]) ? strtolower(trim($_REQUEST["err"])) : "";

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;

if($_SESSION["logged_user_id"] != "") {
	header("Location: dashboard.php");
	exit;
}

if($_POST["user_email_address"] == "" || $_POST["user_password"] == "") {
	myFormErr("index.php","blank","");
	exit;
}

if (!filter_var($_POST["user_email_address"], FILTER_VALIDATE_EMAIL)) {
	myFormErr("index.php","invalidemail","");
	exit;
}

$user_email_address = trim($_POST["user_email_address"]);
$user_password  = md5($_POST["user_password"]);

$selectuserdetails = $pdo->query("SELECT * FROM tbl_user_details WHERE user_email_address = '".$user_email_address."' AND user_password = '".$user_password."'");
$querycount = $selectuserdetails->rowCount();

if($querycount > 0) {
	$userdetails = $selectuserdetails->fetch(PDO::FETCH_ASSOC);

	$user_type_id = $userdetails['user_type'];
	$user_status = $userdetails['user_status'];
	
	if($user_status == 'No') {
		myFormErr(SITE_URL."index.php", "notallow", "");
		exit;
	} else {
		$_SESSION["logged_user_id"] = $userdetails['user_id'];
		$_SESSION["logged_user_name"] = $userdetails['user_name'];
		$_SESSION["logged_user_email_address"] = $userdetails['user_email_address'];

		header("Location: dashboard.php");
		exit;
	}	
} else {
	myFormErr("index.php", "incorrect", "");
	exit;
}

header("Location: dashboard.php");
exit;