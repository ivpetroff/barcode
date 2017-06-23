<?php
error_reporting(E_ALL);
set_time_limit(0);
date_default_timezone_set('Europe/London');

echo "<pre>" . print_r(__DIR__, 1) . "</pre>";
include  __DIR__ . '/../ExportBarcode/Classes/PHPExcel.php';

        
        /** Include path **/
//        set_include_path(get_include_path() . PATH_SEPARATOR . './controller/PhpExcel/Classes/');

        /** PHPExcel_IOFactory */
//        include 'PHPExcel/IOFactory.php';
 
        
         $file =  'excel.xlsx';
        
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        return $sheetData;
        
   