<?php

$sRemoteIP = $_SERVER['REMOTE_ADDR'];

$arAllowedIPs = array(
    "93.152.172.70"
    , "93.152.172.71"
    , "93.152.172.72"
    , "93.152.172.92"
);

if(!in_array($sRemoteIP, $arAllowedIPs) && strpos($sRemoteIP, "192.168.") !== 0){
    echo "Access is denied ($sRemoteIP).";
    exit();
}

header('Content-Type: application/json');
if(!isset($_POST['CompanyObjectName'])) {
	$vResult['Error'] = 1;
	$vResult['Message'] = 'Намя избран магазин.';
	echo json_encode($vResult);
	exit;
}
$sCompanyObjectName = $_POST['CompanyObjectName'];

$sMailTo = "jeleva.mercari@gmail.com"; //tests@ladger.com

$sContent = '';
if(isset($_POST['Items'])) {
	foreach($_POST['Items'] as $Item) {
		$sBarcode = $Item['Barcode'];
		if(!empty($sBarcode)) {
			$sContent .= $sBarcode.chr(13).chr(10);
		}
	}
}
$sFileName = 'Barcode_'.md5(microtime()).'.txt';

if(!is_dir('./Temp/')) {
	mkdir('./Temp/', 0777, true);
}

file_put_contents('./Temp/'.$sFileName, $sContent);

require_once("./PHPMailer/PHPMailerAutoload.php");

$email = new PHPMailer(true);
$email->From      = 'impero-mercari@ladger.com';
$email->CharSet   = 'utf-8';
$email->FromName  = 'ImperoMercari';
$email->Subject   = $sCompanyObjectName.' ('.date("d/m/Y", time()).')';
$email->Body      = " ";
$email->AddAddress($sMailTo);
$email->AddAttachment('./Temp/'.$sFileName , $sFileName);

$vResult = array();
if($email->Send()) {
	$vResult['Error'] = 0;
	$vResult['Message'] = 'Имейлът е успешно изпратен.';
} else {
	$vResult['Error'] = 1;
	$vResult['Message'] = 'Възникна неочаквана грешка при изпращането на имейла. Моля, опитайте пак.';
}
unlink('./Temp/'.$sFileName);
echo json_encode($vResult);