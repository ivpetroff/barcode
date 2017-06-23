<?php

class EditBarcodeLabel  extends Database {
    
    
    function getBarcodeLabel ($barcode){
        
        $this->barcode = $barcode;
        
        $DB = new Database;
        $DB->connect();
        $DB->select('barcode_label' ,$this->barcode);
        $GET_RS = $DB->getResult();
        return $GET_RS;
        
    }
    
    function insertBarcodeLabel($INSERT){
        
        $DB = new Database;
        $DB->connect();
        $DB->insert('barcode_label',$INSERT) ;
        $RS= $DB->getResult();
    }
    
    function updateBarcodeLabel($UPDATE, $WHERE = '1'){
        
        $DB = new Database;
        $DB->connect();
        $DB->update('barcode_label',$UPDATE , $WHERE) ;
        return $res = $DB->getResult();
        
    }
    
    function deleteBarcodeLabel($ID){
        
        $DB = new Database;
        $DB->connect();
        $DB->delete('barcode_label',$ID) ;
        return $res = $DB->getResult();
        
    }
    
    
}

 
 
 
 