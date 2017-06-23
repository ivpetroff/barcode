<?php

require_once("DB.php");
include __DIR__ . '/../../controllerBarcodeTranslate/controllerBarcodeTranslate.php';

include("ORAKSearch.php");
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
        
        
        
        $barcode_ro = $vResult['Type'];
        $row = '*';
        $where  = 'barcode_bg ' . ' LIKE ' . "'%".$barcode_ro."%'";
        
        $GET_TRANSLATE_RS = new BarcodeTranslate();
        $Barcode_TranslatreRS =  $GET_TRANSLATE_RS->setBarcodeTranslate($row, $where);
        
//        
//        switch ($Barcode_TranslatreRS)
//        {
//            case(!$Barcode_TranslatreRS[0]['price_ro']):
//                $er = 'Няма регистрирана цена';
//                break;
//        }
        
//        
        if(empty($Barcode_TranslatreRS[0]['price_ro']))
        {
             $er['price_ro'] = 'Няма регистрирана цена';
            
        }else if(empty($Barcode_TranslatreRS[0]['barcode_ro'])){

             $er['barcode_ro'] = 'Няма превод за този баркод';
             
        }else if(empty($Barcode_TranslatreRS[0]['barcode_bg'])){
            
            $er['barcode_bg'] = 'Ненамерен баркод, моля свържете се със Управител за корекция';
     
        }else if(empty($Barcode_TranslatreRS[0]['price_bg'])){
            
            $er['price_bg'] = 'Няма регистрирана цена';
            
        }
  
        
        foreach ( $Barcode_TranslatreRS as $Barcode_Translatre)
        {
            
            $vResult['errx']  =  $er;
            $vResult['Barcode']  = $_POST['Barcode'];
            $vResult['Type']  = $Barcode_Translatre['barcode_ro'];
            $vResult['Price'] = $Barcode_Translatre['price_ro'];

        }
        

           echo json_encode($vResult);
    }
}

?>