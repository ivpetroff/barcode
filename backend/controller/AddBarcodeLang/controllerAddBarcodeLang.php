<?php


class AddBarcodeLang  extends Database {
    
    
    function __construct($barcode) {
        
        $this->barcode = $barcode;
        
    }
    
    function getBarcodeLang ($barcode){
        
        $this->barcode = $barcode;
        
        $DB = new Database;
        $DB->connect();
        $DB->select('barcode_lang' ,$this->barcode);
        $GET_RS = $DB->getResult();
        return $GET_RS;
        
    }
    
    function insertBarcodeLang($INSERT){
        
        $DB = new Database;
        $DB->connect();
        $DB->insert('barcode_lang',$INSERT) ;
        $RS= $DB->getResult();
    }
    
    function updateBarcodeLang($UPDATE, $WHERE = '1'){
        
        $DB = new Database;
        $DB->connect();
        $DB->update('barcode_lang',$UPDATE , $WHERE) ;
        return $res = $DB->getResult();
        
    }
    
    function deleteBarcodeLang($ID){
        
        $DB = new Database;
        $DB->connect();
        $DB->delete('barcode_lang',$ID) ;
        return $res = $DB->getResult();
        
    }
    
    
}

 
 
 
 