<?php

include 'FilesLib.php';

Class CreateFilePrint extends Database
{   
     
    protected $_WHERE;
    protected $_SELECT;
    
    public function __construct() {
        
        $DB  = new Database;
        $DB->connect();
        $DB->select('barcode_label', $this->_SELECT);
        return $DB->getResult();
    }
  
    public function createFile($FILE_INFO_ARRAY){
            
        
    }
    
    public function setDataBarcode(){
        
        
    }
    
    public function getLabelDesign($select)
    {
        $this->_SELECT = $select;
        $this->_WHERE = $where;
        
    }
    
}
