    <?php   error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// include config 
include __DIR__ . '/config/config.php';

switch ($_GET['view']){

    case '':
        header("Location: ". '?view=index');
        break;
    
    
    case 'index':
        
        include  __DIR__ . '/layout/html/head.php';    
        include  __DIR__ . '/layout/html/header.php';    
        include  __DIR__ . '/layout/html/main.php';    
        include  __DIR__ . '/layout/html/footer.php';    
        break;
    
    
    case 'addlabels':

            include __DIR__ . '/controller/AddBarcodeLang/controllerAddBarcodeLang.php';

            $AddBarcodeLang = new AddBarcodeLang('*');

            if(!empty($_POST['column']))
            {

                $id = explode(',', $_POST["id"]);
                $UPDATE        = array($_POST["column"]=>$_POST["editval"]);
                $WHERE         = "id=".$id[0];
                $UPDATE_ROW    = new AddBarcodeLang('*');
                $UPDATE_ROW->updateBarcodeLang($UPDATE, $WHERE);           

            }

            
            if(!empty($_POST['insert']))
            {
    
                $column        = $_POST['data'];
                $values        = explode("|", $column);
                
                $INSERT        = array('barcode_ro'=>$values[0], 'barcode_bg' => $values[1], 'sr_id'=>$values[2]);
                $INSERT_ROW    = new AddBarcodeLang('*');
                $INSERT_ROW->insertBarcodeLang($INSERT);           

            }
            
            
            if(!empty($_POST['delete']))
            {
                $ID = "id=" . $_POST['id'];
                $DELETE_ROW    = new AddBarcodeLang('*');
                $DELETE_ROW->deleteBarcodeLang($ID);  
            }
        break;
        
        
    case 'labels':
        
            include __DIR__ . '/controller/Labels/controllerLabels.php';
        
            $viewLabels = new viewLabels();   
            $getROLabels = $viewLabels->getROLabels();
            $getBGLabels = $viewLabels->getBGLabels($ROWS, $WHERE); 
           
            
        break;
    
    case 'export':

            include __DIR__ . '/controller/ExportBarcode/controllerExportBarcode.php';

            $EXPORT = new ExportBarcode('*');
            
            if ($_POST["submit"] == '1') {
                
                
                $barcode      = '*';
                $from         = $_POST['start'];
                $to           = $_POST['end'];
                $WHERE        = "date >= '" . $from . "' AND date <= '" . $to . "'";
                $barcode_view = $EXPORT->getExportBarcode($barcode, $WHERE);
                
            } else {
                
                $ROWS = '*';
                $barcode_view = $EXPORT->getExportBarcode($ROWS, $WHERE, $LIMIT);
                
            }
            
        break;
    
            
    case 'editlabels':
        
            include __DIR__ . '/controller/EditBarcodeLabel/controllerEditBarcodeLabel.php';
        
            $EditBarcodeLabel = new EditBarcodeLabel();
            
           
    
            if(!empty($_POST['column']))
            {

                $id = explode(',', $_POST["id"]);
                $UPDATE        = array($_POST["column"]=>$_POST["editval"]);
                $WHERE         = "id=".$id[0];
                $UPDATE_ROW    = new EditBarcodeLabel('*');
                $UPDATE_ROW->updateBarcodeLabel($UPDATE, $WHERE);           

            }

            if(!empty($_POST['insert']))
            {
    
    
                $column        = $_POST['data'];
                $values        = explode("|", $column);
                
                $INSERT        = array('variables'=>$values[0], 'variables_view' => $values[1], 'variables_bg'=>$values[2], 'variables_ro'=>$values[3] );
                $INSERT_ROW    = new EditBarcodeLabel('*');
                $INSERT_ROW->insertBarcodeLabel($INSERT);           

            }
            
    
            
            
            if(!empty($_POST['delete']))
            {
                $ID = "id=" . $_POST['id'];
                $DELETE_ROW    = new EditBarcodeLabel('*');
                $DELETE_ROW->deleteBarcodeLabel($ID);  
            }
        break;
        
    case 'import':
    { 
            header("Location: /controller/ImportFilesExcel/");
            exit;
    }
}

//Pagination
 include __DIR__ . '/controller/pagination/controllerPagination.php';

//echo "<pre>" . print_r($page, 1) . "</pre>";
$Pages = new PagePagination($page,$pageLimit);
 
include __DIR__ . '/layout/loader.php';





