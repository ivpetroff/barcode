<?php

//$sRemoteIP = $_SERVER['REMOTE_ADDR'];
//
//$arAllowedIPs = array(
//    "93.152.172.70"
//    , "93.152.172.71"
//    , "93.152.172.72"
//    , "93.152.172.92"
//	, "62.176.83.90"
//);
//
//if(!in_array($sRemoteIP, $arAllowedIPs) && strpos($sRemoteIP, "192.168.") !== 0){
//    $vResult['Error'] = 1;
//    $vResult['Message'] = "Нямате достъп до API-то.";
//	echo json_encode($vResult);
//    exit();
//}

require_once("DB.php");

$vResult = array();

if(isset($_GET['GetCompanyObjects']) && $_GET['GetCompanyObjects'] == 1) {
    $DB = new DB();
	$Result = $DB->Query("SELECT * FROM CompanyObject");

	while($Item = $Result->fetch_object()) {
		$vResult[] = array("CompanyObjectID" => $Item->CompanyObjectID, "Name" => $Item->Name);
	}
	echo json_encode($vResult);
	exit;
}

if(isset($_GET['Barcode']) && $_GET['Barcode'] != "" && isset($_GET['CompanyObjectID']) && $_GET['CompanyObjectID'] != ""){
    $DB = new DB();
    $sBarcode = $DB->real_escape_string($_GET['Barcode']);
    $nCompanyObjectID = $DB->real_escape_string($_GET['CompanyObjectID']);
    $Result = $DB->Query("
     SELECT
            InventoryItemBarcode.`Code` AS Barcode
            , InventoryItemBracodeCompanyObjectDiscount.Discount AS Discount
            , InventoryItemBracodeCompanyObjectDiscount.DiscountDate AS DiscountDate
            , InventoryItem.`Name` AS `Name`
            , InventoryItem.PriceWithVat AS Price
        FROM
            InventoryItemBarcode
        JOIN InventoryItem ON InventoryItem.InventoryItemID = InventoryItemBarcode.InventoryItemID
        JOIN InventoryItemBracodeCompanyObjectDiscount ON InventoryItemBracodeCompanyObjectDiscount.InventoryItemBarcodeID = InventoryItemBarcode.InventoryItemBarcodeID
            AND InventoryItemBracodeCompanyObjectDiscount.CompanyObjectID = ".$nCompanyObjectID."
        WHERE
            InventoryItemBarcode.`Code` = '".$sBarcode."'
    ");
    
    if($Item = $Result->fetch_object()) {
        $vResult['Barcode'] = $Item->Barcode;
        $vResult['Discount'] = $Item->Discount;
        $vResult['DiscountDate'] = empty($Item->DiscountDate) ? '' : date("d/m/Y", strtotime($Item->DiscountDate));
        $vResult['Name'] = $Item->Name;
        $vResult['Price'] = $Item->Price;
        $vResult['DiscountPrice'] = empty($Item->Discount) || empty($Item->Price) ? '' : number_format($Item->Price - (($Item->Price * $Item->Discount)/100), 2);
    } else {
        $Result = $DB->Query("
            SELECT
                InventoryItemBarcode.`Code` AS Barcode
                , InventoryItem.`Name` AS `Name`
                , InventoryItem.PriceWithVat AS Price
            FROM
                InventoryItemBarcode
            JOIN InventoryItem ON InventoryItem.InventoryItemID = InventoryItemBarcode.InventoryItemID
            WHERE
                InventoryItemBarcode.`Code` = '".$sBarcode."'
        ");
        if($Item = $Result->fetch_object()) {
            $vResult['Barcode'] = $Item->Barcode;
            $vResult['Discount'] = 0;
            $vResult['DiscountDate'] = '';
            $vResult['Name'] = $Item->Name;
            $vResult['Price'] = $Item->Price;
            $vResult['DiscountPrice'] = $Item->Price;
            //$vResult['Error'] = 1;
            //$vResult['Message'] = "Няма информация за този баркод към избраният магазин.";
        } else {
            include("../ORAKSearch/ORAKSearch.php");
            $vSearchResult = ORAKSearch::Find($sBarcode);
            if(is_null($vSearchResult)){
                $vResult['Error'] = 1;
                $vResult['Message'] = "Няма данни в Имперо за баркод '".$sBarcode."'";
            } else {
                $vResult['Barcode'] = $sBarcode;
                $vResult['Discount'] = 0;
                $vResult['DiscountDate'] = '';
                $vResult['Name'] = $vSearchResult['Type'];
                $vResult['Price'] = $vSearchResult['Price'];
                $vResult['DiscountPrice'] = $vSearchResult['Price'];
            }
        }
    }
    $DB->Close();

} else {
    $vResult['Error'] = 1;
    $vResult['Message'] = "Моля въведете баркод";
}

header('Content-Type: application/json');
echo json_encode($vResult);

?>