<?php
include_once("includes/connection.php");
include_once("includes/functions.php");

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;

$myaction = isset($_REQUEST["myaction"])?strtolower(trim($_REQUEST["myaction"])):"";

$formresponse = array();

$hidden_site_logo = trim($_POST["hidden_site_logo"]);

$site_logo = $_FILES['site_logo']['name'];

if($site_logo != "") {
	$site_logo_value = $site_logo;
} else {
	$site_logo_value = $hidden_site_logo;
}

if($site_logo_value == "" || $_POST["site_name"] == "" || $_POST["site_email_address"] == "" || $_POST["site_mobile_number"] == "" || $_POST["site_address"] == "" || $_POST["site_gst_number"] == "" || $_POST["site_challan_prefix"] == "") {
	$formresponse['status'] = 2;
	echo json_encode($formresponse);
	exit;
}

if (!filter_var($_POST["site_email_address"], FILTER_VALIDATE_EMAIL)) {
	$formresponse['status'] = 3;
	echo json_encode($formresponse);
	exit;
}

$count_mobile_number = strlen($_POST["site_mobile_number"]);
if($count_mobile_number != '10') {
	$formresponse['status'] = 4;
	echo json_encode($formresponse);
	exit;
}

if($_FILES['site_logo']['name'] != "") {
	$site_logo_name = $_FILES['site_logo']['name'];
	$ext = pathinfo($site_logo_name, PATHINFO_EXTENSION);

	if(!in_array($ext, $uploadimagetype)) {
		$formresponse['status'] = 11;
		echo json_encode($formresponse);
		exit;
	}

	if($_FILES['site_logo']['size'] > 1048000) {
		$formresponse['status'] = 5;
		echo json_encode($formresponse);
		exit;
	} else {
		if(file_exists('images/'.$hidden_site_logo)) {
			unlink('images/'.$hidden_site_logo);
		}
 		
		$site_logo_text = $tmptime.str_replace(" ","-",$_FILES['site_logo']['name']);
		$site_logo_db = copy($_FILES['site_logo']['tmp_name'],'images/'.$site_logo_text);
	}				
} else {
	$site_logo_text = $hidden_site_logo;
}

$site_challan_prefix_data = str_replace(array( "\'", "'", ";", "<", ">", "_", "&", "*", "/", "-", "!", "@", "#", "(", ")", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", ".", "?", "$", "%", "^", " "), '', $_POST["site_challan_prefix"]);

$data = [
    'site_logo' => $site_logo_text,
    
    'site_name' => trim(strtoupper($_POST["site_name"])),
    'site_email_address' => trim($_POST["site_email_address"]),
    'site_mobile_number' => trim($_POST["site_mobile_number"]),
    'site_gst_number' => trim(strtoupper($_POST["site_gst_number"])),
    'site_address' => trim(htmlspecialchars(ucwords($_POST["site_address"]))),
    
    'site_challan_prefix' => trim($site_challan_prefix_data ),
];

//echo "<pre>"; print_r($data); echo "</pre>"; exit;

$updategeneraldetails = "UPDATE tbl_site_details SET site_logo = :site_logo, site_name = :site_name, site_email_address = :site_email_address, site_mobile_number = :site_mobile_number, site_gst_number = :site_gst_number, site_address = :site_address, site_challan_prefix = :site_challan_prefix WHERE site_id = 1";
$updategeneraldetails = $pdo->prepare($updategeneraldetails);

if($updategeneraldetails->execute($data)) {
	$formresponse['status'] = 1;
	echo json_encode($formresponse);
	exit;
} else {
	$formresponse['status'] = 6;
	echo json_encode($formresponse);
	exit;
}