<?php


error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

// VIP PRODUCTS
$PIER_ONE          = 'PIER';  
$ZIGN              = 'ZIGN';
$ANNA_FIELD        = 'ANNA';
$BROKLYN_S_OWN     = 'BROKLYN';
$EVEN_ODD          = 'EVEN';
$FRIBOO            = 'FRIBOO';
$FULLSTOP          = 'FULLSTOP';
$KIOMI             = 'KIOMI';
$MAI_PIU_SENZA     = 'MAI'; 
$MINT_BERRY        = 'MINT'; 
$STUPS             = 'STUPS';
$TWINTIP           = 'TWINTIP';
$YOUR_TURN         = 'YOUR';
$ZALANDO           = 'ZALANDO';  
$PIER_ONE          = 'PIER ONE';
$EVEN_ODD          = 'EVEN';  
$ZALANDO_SHOES     = 'ZALANDO SHOES';
        
 


require_once dirname(__FILE__) . '/PhpExcel/Classes/PHPExcel.php';

define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        

//if (!file_exists($inputFileName)) {
//    exit("Can't find file." . EOL);
//}
//
//$objReader = new PHPExcel_Reader_Excel2007();
//$objReader->setReadDataOnly(true);
//$objPHPExcel = $objReader->load($inputFileName);
//


/** detect the type of file * */
PHPExcel_Cell::setValueBinder(new PHPExcel_Cell_AdvancedValueBinder());
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
/** load the data,* */
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
/** if we read only the data, then dates are funky * */
//$objReader->setReadDataOnly(true);
$objReader->setLoadAllSheets();
$objPHPExcel = $objReader->load($inputFileName);


$highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn(); // e.g. "EL" 
$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

$spreadsheet_data = array();

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    //echo 'Worksheet - ' , $worksheet->getTitle() , EOL;

    foreach ($worksheet->getRowIterator() as $row) {
        // echo ' Row number - ' , $row->getRowIndex() , EOL;

        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
        foreach ($cellIterator as $cell) {
            if (!is_null($cell)) {
                if (PHPExcel_Shared_Date::isDateTime($cell)) {
                    // echo ' Cell - ' , $cell->getColumn() , $cell->getRow() , ' - ' , date('r',PHPExcel_Shared_Date::ExcelToPHP($cell->getValue())) ,  '(' , $cell->getDataType(), ')', EOL;
                    $spreadsheet_data[$cell->getColumn()][$cell->getRow()] = PHPExcel_Shared_Date::ExcelToPHP($cell->getValue());
                } else {
                    //echo ' Cell - ' , $cell->getColumn() , $cell->getRow() , ' - ' , $cell->getFormattedValue() ,  '(' , $cell->getDataType(), ')', EOL;
                    $spreadsheet_data[$cell->getColumn()][$cell->getRow()] = $cell->getValue();
                }
            }
        }
    }
}






echo date('H:i:s'), " Set document properties", EOL;
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");

//$getData = $query->fetch_assoc();
//$highestRow += (int) $result;

                          
                                                
						$objPHPExcel->getActiveSheet()->setCellValue("A" . $cData, $getData['num'] . '-');
						$objPHPExcel->getActiveSheet()->setCellValue("B" . $cData, $getData['from_date'] . '-');
						$objPHPExcel->getActiveSheet()->setCellValue("C" . $cData, $getData['barcode'].'-'.$getData['suffix']);
                                                $objPHPExcel->getActiveSheet()->setCellValue("D" . $cData, 'Обувки'); 
						$objPHPExcel->getActiveSheet()->setCellValue("E" . $cData, $getData['shoes_1']);
                                             

$objPHPExcel->getActiveSheet()->setTitle('dfsd');

// Create a new worksheet called "My Data"
$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel);

// Attach the "My Data" worksheet as the first worksheet in the PHPExcel object
//$objPHPExcel->addSheet($myWorkSheet, 1);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

echo 'Files have been created in ', getcwd(), EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->setPreCalculateFormulas(true);
ob_end_clean();
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' .$products.'_'. $_POST['date'] . '".xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
