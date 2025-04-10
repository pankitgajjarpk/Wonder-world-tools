<?php
$uploadimagetype = array('jpeg', 'jpg', 'png');

$uploaddocumenttype = array('jpeg', 'jpg', 'png', 'pdf', 'doc', 'docx');

function myFormErr($action, $err, $errfld) {
	global $_REQUEST;

	echo "<form name='myfrm' method='post' action='$action'>\n";
	echo "<input type='hidden' name='err' value='$err'>\n";
	echo "<input type='hidden' name='errfld' value='$errfld'>\n";

	foreach($_REQUEST as $key=>$value) {
		if(is_array($value))
			$myValue = implode(",",$value);
		else
			$myValue = $value;
		print "<input type='hidden' name='$key' value='$myValue'>\n";
	}

	echo "</form>
	<script language='Javascript'>document.myfrm.submit();</script>";
	exit;
}

function myFormMsg($action, $msg, $msgfld) {
	global $_REQUEST;
	
	echo "<form name='myfrm' method='post' action='$action'>\n";
	echo "<input type='hidden' name='msg' value='$msg'>\n";
	echo "<input type='hidden' name='msgfld' value='$msgfld'>\n";

	foreach($_REQUEST as $key=>$value) {
		if(is_array($value))
			$myValue = implode(",",$value);
		else
			$myValue = $value;
		print "<input type='hidden' name='$key' value='$myValue'>\n";
	}

	echo "</form>
		<script language='Javascript'>document.myfrm.submit();</script>";
	exit;
}

function myFormMutiple($action, $msg, $field, $msgfld) {
	global $_REQUEST;
	echo "<form name='myfrm' method='post' action='$action'>\n";
	echo "<input type='hidden' name='msg' value='$msg'>\n";
	echo "<input type='hidden' name='field' value='$field'>\n";
	echo "<input type='hidden' name='msgfld' value='$msgfld'>\n";

	foreach($_REQUEST as $key=>$value) {
		if(is_array($value))
			$myValue = implode(",",$value);
		else
			$myValue = $value;
		print "<input type='hidden' name='$key' value='$myValue'>\n";
	}

	echo "</form>
		<script language='Javascript'>document.myfrm.submit();</script>";
	exit;
}

function decrypt($string, $key) {
	$result = '';
	$string = base64_decode($string);	
	for($i=0; $i<strlen($string); $i++) 
	{
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
	}
	return $result;
}

function getValue($tbl,$dispFld,$IdFld,$val) {
	$qry = "SELECT ".$dispFld." FROM ".$tbl." WHERE ".$IdFld." = '".$val."'";
	$result = mysqli_query($DatabaseConnection,$qry) or die("Select value error");
	
	if($arow = mysqli_fetch_assoc($result)) {
		$myN = $arow[$dispFld];
	} else {
		$myN = "";
	}
	return $myN;
}

function getNameFromID($tblname,$fldname,$keyfld,$keyval) {
	$member_id = 0;
	$qry_get = "SELECT ".$fldname. " FROM ".$tblname." WHERE ".$keyfld."='".$keyval."'";
	$rs_get =mysql_query($qry_get) or die ("erro in getNameFromID".mysql_error());

	if($rw_get=mysql_fetch_array($rs_get)) {
		$member_id = $rw_get[$fldname];
	}
	return $member_id;
}

function getRandom($length) {
	$myChars = "abcdefghijklmnopqrstuvwxyz";
	$myChars .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$myChars .= "1234567890";
	
	$myRand = "";
	
	mt_srand((double)microtime()*1234567);
	
	for($r=0;$r<$length;$r++)
		$myRand .= $myChars[mt_rand(0,strlen($myChars)-1)];
	
	return $myRand;
}

function RandomOTP($n) {
	$str = "";
	
	$generator = "0123456789";
	for ($i = 1; $i <= $n; $i++) { 
        $str .= substr($generator, (rand()%(strlen($generator))), 1); 
    }

	return $str;
}

function RandomStringPW($length = 8) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('a','z'), range('1','9'));
	//$characters = array_merge(range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}

function RandomID($length = 10) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('a','z'), range('1','9'));
	//$characters = array_merge(range('1','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}

function RemoveSpecialChar($value){
	$result  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$value);
	return $result;
}

function myForm($action, $err, $errfld) {
	global $_REQUEST;

	echo "<form name='myfrm' method='post' action='$action'>\n";
	echo "<input type='hidden' name='err' value='$err'>\n";
	echo "<input type='hidden' name='errfld' value='$errfld'>\n";

	foreach($_REQUEST as $key=>$value) {
		if(is_array($value))
			$myValue = implode(",",$value);
		else
			$myValue = $value;

		print "<input type='hidden' name='$key' value='$myValue'>\n";
	}

	echo "</form>
		<script language='Javascript'>document.myfrm.submit();</script>";
	exit;
}

function compressedImage($source, $path, $quality) {
    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/jpg') 
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png') 
                $image = imagecreatefrompng($source);

    imagejpeg($image, $path, $quality);
}

function get_single_data($tblname,$fieldname,$wherefields){
	global $pdo;

    $selectsingledata = $pdo->query("SELECT $fieldname FROM $tblname WHERE $wherefields");
	$resultsingledata = $selectsingledata->fetch(PDO::FETCH_ASSOC);
	
	return $resultsingledata[$fieldname];
}

function get_multiple_data($tblname,$fieldname1,$fieldname2,$wherefields) {
	global $pdo;

	$selectmultipledata = $pdo->query("SELECT $fieldname1,$fieldname2 FROM $tblname where $wherefields");
	$resultmultipledata = $selectmultipledata->fetch(PDO::FETCH_ASSOC);

    $output = $resultmultipledata[$fieldname1]." ".$resultmultipledata[$fieldname2];

    return $output;
}

function ind_money_format($number){
    $decimal = (string)($number - floor($number));
    $money = floor($number);
    $length = strlen($money);
    $delimiter = '';
    $money = strrev($money);

    for($i=0;$i<$length;$i++){
        if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
            $delimiter .=',';
        }
        $delimiter .=$money[$i];
    }

    $result = strrev($delimiter);
    $decimal = preg_replace("/0\./i", ".", $decimal);
    $decimal = substr($decimal, 0, 3);

    if( $decimal != '0'){
        $result = $result.$decimal;
    }

    return $result;
}

function getIndianCurrency(float $number) {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh','Crore');

    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = " ".implode('', array_reverse($str));
    $paise = ($decimal > 0) ? " and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . ' ' : '') . $paise;
}

function CheckPermission($Userid, $AccessName, $PageRedirect) {
	global $pdo;
	$accesdetails = 0;
	
	$selectaccesdetails = $pdo->query("SELECT user_type_id FROM tbl_user_type_details WHERE user_type_id = '".$Userid."' AND FIND_IN_SET('".$AccessName."', user_type_sub)");
    $accesdetails = $selectaccesdetails->rowCount();

    if($accesdetails == 0 && $PageRedirect != '') {
        header ("Location:".$PageRedirect);
        exit;
    } else {
    	return $accesdetails;
    }
}

function CheckBtnPermission() {
	global $pdo;
	$accesdetails = 0;
	
	$selectaccesdetails = $pdo->query("SELECT user_type_id FROM tbl_user_type_details WHERE user_type_id = '".$_SESSION["logged_user_type_id"]."' AND FIND_IN_SET(12, user_type_sub)");
    $accesdetails = $selectaccesdetails->rowCount();
    
    return $accesdetails;
}