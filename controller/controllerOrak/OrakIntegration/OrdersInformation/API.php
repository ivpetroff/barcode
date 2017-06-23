<?php

require_once("DB.php");

include("../api/ORAKSearch.php");
if(isset($_POST['Barcode']) && $_POST['Barcode'] != ""){

    $sBarcode = $_POST['Barcode'];

    $vResult = ORAKSearch::Find($sBarcode);

    if(is_null($vResult) && !is_array($vResult)) {
        echo 'error';
    } else {
        if(isset($_POST['Language']) && $_POST['Language'] == "ro"){
            $DB = new DB();
            $Result = $DB->Query("SELECT * FROM InventoryItemType WHERE InventoryItemType.`Name` ='".$vResult["Type"]."'");
            if($Item = $Result->fetch_object()) {
                $vResult = array();
                $vResult['Type'] = $Item->NameInOtherLanguage;
                $vResult['Price'] = $Item->RONSalePrice;
            }
            $DB->Close();
        }

        echo json_encode($vResult);
    }
}

?>