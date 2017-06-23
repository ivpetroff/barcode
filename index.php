<?php    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        

// include config
include  __DIR__."/backend/config/config.php";

// include Class create Label.par
include  __DIR__.'/controller/controllerCreateFilePrint/controllerCreateFilePrint.php';

        $select = '*'; 

        $getLabelDesigns  = new CreateFilePrint('*');
        $getLabelDesigns->getLabelDesign($select); 
        
        

        if(!empty($_POST['sendFormPrint']))
        {
                for($i=0; $i < count($_POST['barcode_price']); $i++)
                {
                        if(empty($_POST['barcode_price'][$i])){
                                unset($_POST['barcode_price']);
                                unset($_POST['price_lei']);
                                unset($_POST['barcode_ro']);
                        }else{
                            $barcodeInfo['barcode128'][] = $_POST['barcode_price'][$i];
                            $barcodeInfo['price'][]  =     $_POST['price_lei'][$i];
                            $barcodeInfo['barcode_ro'][] = $_POST['barcode_ro'][$i];
                        }
                }
        }
        
       
        
        //TODO  взимане на mercari_info_row_one, mercari_info_row_two ,  currency, date format, time format, 
        $FileInfgo = new FilesLib();
        $FileInfgo->lfile($FILE_PAR);        
        $barcodeInfo['date']                 = date("d-m-Y");
        $barcodeInfo['time']                 = $time = date("h:m:s", time());
        $barcodeInfo['currency']             = 'lei'; 
        $barcodeInfo['mercari_info_row_one'] = 'mercari_info_1'; 
        $barcodeInfo['mercari_info_row_two'] = 'mercari_infp_2';
        
//        if(!empty($barcodeInfo['price']))
//        {
//             
//            for($i=0; $i<count($barcodeInfo['price']); $i++)
//            {
//                $FileInfgo->lwrite("MERV2|1|".$barcodeInfo['price'][$i].'|'.$barcodeInfo['barcode_ro'][$i].'|'.$barcodeInfo['barcode128'][$i]."|".$barcodeInfo['mercari_info_row_one']."|".$barcodeInfo['mercari_info_row_two']."|".$barcodeInfo['date']."|".$barcodeInfo['time']."|".$barcodeInfo['currency']); 
//                $FileInfgo->lclose();
//            }
//                  
//        }
// include html
include  __DIR__.'/layout/loader.php';
 


