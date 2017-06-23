<?php
 
include '/../../backend/config/config.php';

class BarcodeTranslate extends Database
{
    
    public function setBarcodeTranslate($row = '*', $where)
    {
        
        $DB = new Database;
        $DB->connect();
        $DB->select('barcode_lang', $row, $where);
        $GET_TRANSLATE = $DB->getResult();
        return $GET_TRANSLATE;
        
    }
    
    
}