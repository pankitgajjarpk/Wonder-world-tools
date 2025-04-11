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

if($site_logo_value == "" || $_POST["site_name"] == "" || $_POST["site_email_address"] == "" || $_POST["site_mobile_number"] == "" || $_POST["site_address"] == "" || $_POST["site_challan_prefix"] == "") {
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

	if(!in_array($ext, $userimagename)) {
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

$site_quotation_prefix_data = str_replace(array( "\'", "'", ";", "<", ">", "_", "&", "*", "/", "-", "!", "@", "#", "(", ")", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", ".", "?", "$", "%", "^", " "), '', $_POST["site_quotation_prefix"]);

$site_proforma_prefix_data = str_replace(array( "\'", "'", ";", "<", ">", "_", "&", "*", "/", "-", "!", "@", "#", "(", ")", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", ".", "?", "$", "%", "^", " "), '', $_POST["site_proforma_prefix"]);

$data = [
    'site_logo' => $site_logo_text,
    
    'site_name' => trim(strtoupper($_POST["site_name"])),
    'site_email_address' => trim($_POST["site_email_address"]),
    'site_mobile_number' => trim($_POST["site_mobile_number"]),
    'site_gst_number' => trim($_POST["site_gst_number"]),
    'site_address' => trim(htmlspecialchars(ucwords($_POST["site_address"]))),
    'site_website' => trim($_POST["site_website"]),
    
    'site_bank_name' => trim(strtoupper($_POST["site_bank_name"])),
    'site_account_name' => trim(strtoupper($_POST["site_account_name"])),
    'site_ifsc_code' => trim(strtoupper($_POST["site_ifsc_code"])),
    'site_swift_code' => trim(strtoupper($_POST["site_swift_code"])),
    'site_account_number' => trim($_POST["site_account_number"]),
    'site_bank_address' => trim(htmlspecialchars(strtoupper($_POST["site_bank_address"]))),
    
    'site_quotation_prefix' => trim($site_quotation_prefix_data ),
    'site_proforma_prefix' => trim($site_proforma_prefix_data),
    'site_client_name' => trim($_POST["site_client_name"]),
    'site_client_number' => trim($_POST["site_client_number"]),
    'site_client_gst_number' => trim($_POST["site_client_gst_number"]),
    'site_client_address' => trim($_POST["site_client_address"]),
    
    'site_terms_title_one' => trim(strtoupper($_POST["site_terms_title_one"])),
    'site_terms_one' => trim($site_terms_one_db),
    'site_terms_title_two' => trim(strtoupper($_POST["site_terms_title_two"])),
    'site_terms_two' => trim($site_terms_two_db),
    'site_terms_title_three' => trim(strtoupper($_POST["site_terms_title_three"])),
    'site_terms_three' => trim($site_terms_three_db),
    
    'site_indiamart_key_details' => trim($_POST["site_indiamart_key_details"]),
];

//echo "<pre>"; print_r($data); echo "</pre>"; exit;

$updategeneraldetails = "UPDATE tbl_site_details SET site_logo = :site_logo, site_rectangle_logo = :site_rectangle_logo, site_home_screen = :site_home_screen, site_signature = :site_signature, site_name = :site_name, site_short_name = :site_short_name, site_email_address = :site_email_address, site_mobile_number = :site_mobile_number, site_gst_number = :site_gst_number, site_address = :site_address, site_website = :site_website, site_bank_name = :site_bank_name, site_account_name = :site_account_name, site_ifsc_code = :site_ifsc_code, site_swift_code = :site_swift_code, site_account_number = :site_account_number, site_bank_address = :site_bank_address, site_quotation_prefix = :site_quotation_prefix, site_proforma_prefix = :site_proforma_prefix, site_client_name = :site_client_name, site_client_number = :site_client_number, site_client_gst_number = :site_client_gst_number, site_client_address = :site_client_address, site_terms_title_one = :site_terms_title_one, site_terms_one = :site_terms_one, site_terms_title_two = :site_terms_title_two, site_terms_two = :site_terms_two, site_terms_title_three = :site_terms_title_three, site_terms_three = :site_terms_three, site_indiamart_key_details = :site_indiamart_key_details WHERE site_id = 1";
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