<?php
include  __DIR__.'/html/head.php';
include  __DIR__.'/html/header.php';


switch($_GET['view'])
{
    
    case '':
        include  __DIR__ . '/html/main.php';    
        break;
    
    case 'export':
         include  __DIR__ . '/html/Export/Export_Html.php';
         break;
     
    case 'addlabels':
        include __DIR__ . '/html/AddLabels/AddLabels_html.php';
         break;
     
    case 'editlabels':
        include __DIR__ . '/html/EditBarcodeLabel/EditBarcodeLabel_html.php';
        break;
    
    case 'labels':
        include __DIR__ . '/html/Labels/Labels_html.php';
        break;
    
    case 'shops':
        include __DIR__ . '/html/Shops/Shops_html.php';
        break;
        
}

include  __DIR__ . '/html/footer.php';




?>
