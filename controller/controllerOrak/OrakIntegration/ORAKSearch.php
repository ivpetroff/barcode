<?php

class ORAKSearch
{
    private static $Host = "http://31.13.228.190:8088/GetStokaInfo";
    
    private static function SendRequest($sBarcode){
        $Request = curl_init(self::$Host);
        
        curl_setopt($Request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($Request, CURLOPT_POST, true);
        curl_setopt($Request, CURLOPT_POSTFIELDS, "Kod=".urlencode($sBarcode));
        
        $sResponse = curl_exec($Request);
        
        $sResponse = mb_convert_encoding($sResponse, "utf-8", "windows-1251");
        $sResponse = str_replace('<?xml version="1.0" encoding="windows-1251"?>', '<?xml version="1.0" encoding="utf-8"?>', $sResponse);
        
        return $sResponse;  
    }
    
    public static function Find($sBarcode){
        $sResponse = self::SendRequest($sBarcode);
        if(empty($sResponse))
            return null;

        $Document = new DOMDocument();
        $Document->encoding = "utf-8";
        $Document->preserveWhiteSpace = false;
        $Document->loadXML($sResponse);

        $XPath = new DOMXPath($Document); 
        $NodeList = $XPath->query("//root/row");
        
        if($NodeList->length == 0)
            return null;
        
        $Item = $NodeList->item(0);

        $arInfo = array();
        
        $arInfo["Type"] = $Item->getAttribute("Name");
        $arInfo["Quantity"] = $Item->getAttribute("MixAvailability");
        $arInfo["Sebest"] = $Item->getAttribute("Sebest");
        $arInfo["Price"] = $Item->getAttribute("Price");
        
        return $arInfo;
    }
}

?>