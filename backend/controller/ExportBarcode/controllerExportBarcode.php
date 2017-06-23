<?php

class ExportBarcode extends Database{
 
    public function __construct($barcode){
        
        $this->exportBarcode = $barcode;
        
    }
    
    public function getExportBarcode($ROWS, $WHERE, $ORDER_BY, $LIMIT){
        

        //getExportBarcode
        $DB = new Database;
        $DB->connect();
        $DB->select('barcode_info', $ROWS, $WHERE, $ORDER_BY, $LIMIT);
        $RS_EXPORT = $DB->getResult();
        return $RS_EXPORT;
        
    }
    
    public function setExportBarcode($barcode){
        $this->exportBarcode = $barcode; 
    }
    
    public function dateExportBarcode($barcode){
        $this->exportBarcode = $barcode; 
    }
 
    
}
 