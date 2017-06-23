<?php

Class viewLabels extends Database {
 
    public function getBGLabels() {
        
        $DB = new Database();
        $DB->connect();               
        $DB->select('barcode_info');
        $RESULTS = $DB->getResult();
        return $RESULTS;
        
    }

    public function getROLabels($ROWS = '*', $WHERE = '1', $ORDER_BY = 'id', $LIMIT = '100') {
        
        $DB = new Database();
        $DB->connect();               
        $DB->select('barcode_info', $ROWS, $WHERE, $ORDER_BY, $LIMIT);
        $RESULTS = $DB->getResult();
        return $RESULTS;
        
    }
}
