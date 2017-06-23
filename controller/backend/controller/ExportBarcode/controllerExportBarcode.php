<?php

class ExportBarcode extends Database{
 
    public function __construct($barcode){
        
        $this->exportBarcode = $barcode;
        
    }
    
    public function getExportBarcode($barcode, $WHERE = '1', $ORDER_BY = '1'){
        
        $this->exportBarcode = $barcode; 
        $this->where = $WHERE; 
        $this->order_by = $ORDER_BY; 

        //getExportBarcode
        $DB = new Database;
        $DB->connect();
        $DB->select('barcode_info', $this->exportBarcode , '', $this->where , $this->order_by);
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
 