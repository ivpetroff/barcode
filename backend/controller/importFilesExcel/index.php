<?php

error_reporting(E_ALL);
set_time_limit(0);
date_default_timezone_set('Europe/London');
 
include  __DIR__ . '/../ExportBarcode/Classes/PHPExcel.php';
include  __DIR__ . '/../../config/config.php';

$DB = new Database();
$DB->connect();

 $file =  'dbExcelMercari.xlsx';
        
$objPHPExcel = PHPExcel_IOFactory::load($file);

$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);



//date_insert
//sr_id_date
//sr_id
//bg_ro_id
//price_ro
//barcode_ro
//price_bg
//barcode_bg


for($i = 0; $i< count($sheetData);$i++)
{
    
    $labels_bg = $sheetData[$i]["A"];
    $labels_ro = $sheetData[$i]["B"];
    $price_ro  = $sheetData[$i]["C"];
    
    echo "<pre>" . print_r($labels_bg, 1) . "</pre>";
    
    
    $DB->insert('barcode_lang',array(
        
        'barcode_bg'  => $labels_bg,
        'price_bg'    => $price_bg,
        'barcode_ro'  => $labels_ro,
        'price_ro'    => $price_ro,
        'bg_ro_id'    => $i,
        'sr_id'       => $i,
        'sr_id_date'  => date("Y-m-d"),
        'date_insert' => date("Y-m-d")
        
    ));
    $RS_LABELS = $DB->getResult();
    echo "<pre>" . print_r($i, 1) . "</pre>";
    if($i == 0){break;}
}
 

        
       
        
         