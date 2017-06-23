<?php

$sURL = current(explode('Print.php', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));

$sLang = "bg";
if(isset($_POST["Language"]))
    $sLang = $_POST["Language"];

$sPriceText = ($sLang == "ro") ? "Imprimare" : "ПЕЧАТ";
$sCurrencyText = ($sLang == "ro") ? "LEI" : "лв";

$sHtml = "<button id='PrintButton' type='button' onclick='PrintPage();'>".$sPriceText."</button>";
$sHtml .= '<div  style="clear: both; display: block;"></div>';
if(isset($_POST["Items"]) && sizeof($_POST["Items"]) > 0){
    $arItems = $_POST["Items"];
    if(isset($_POST["PlainPrint"]) && $_POST["PlainPrint"] == true){
        $nCount = 0;
		//echo '<pre>';
		//var_dump($arItems);
		//echo '</pre>';
        foreach($arItems as $vItemInfo){
			$dOldPrice = 0;
            if(is_array($vItemInfo)){
                $sName = isset($vItemInfo["Name"]) ? $vItemInfo["Name"] : null;
                $dPrice = isset($vItemInfo["Price"]) ? $vItemInfo["Price"] : null;
				$dOldPrice = isset($vItemInfo["OldPrice"]) ? $vItemInfo["OldPrice"] : null;
            }else{
                list($sName, $dPrice) = explode("_", $vItemInfo);
            }
            
            if(empty($sName) == false && empty($dPrice) == false) {
                $sHtml .= '<div class="main">';
                $sHtml .= '<div class="small">'.$sName.'</div>';
                $sHtml .= '<div class="large">';
                $sHtml .= number_format($dPrice, 2).'<span class="medium">'.$sCurrencyText.'</span>';
                $sHtml .= '</div>';
				if(!empty($dOldPrice)) {
					$sHtml .= '<div class="xMedium">';
					$sHtml .= '<img class="_strike" src="'.$sURL.'../Resources/discount_strike.png"/>';
					$sHtml .= number_format($dOldPrice, 2).'<span class="medium">'.$sCurrencyText.'</span>';
					$sHtml .= '</div>';
				}
                $sHtml .= '</div>';

                if($nCount == 18){
                    $sHtml .= '<div style="page-break-after:always"></div>';
                }

                $nCount ++;
            }
        }
    }else{
        $sOldPriceText = ($sLang == "ro") ? "PRET VECHI" : "СТАРА ЦЕНА";
        $sDiscountImg = ($sLang == "ro") ? "discount_ro.png" : "discount.png";
        foreach($arItems as $arItemInfo){
            $sName = isset($arItemInfo["Name"]) ? $arItemInfo["Name"] : null;
            $dPrice = isset($arItemInfo["Price"]) ? $arItemInfo["Price"] : null;
            $dDiscountPrice = isset($arItemInfo["DiscountPrice"]) ? $arItemInfo["DiscountPrice"] : null;
            $sBarcode = isset($arItemInfo["Barcode"]) ? $arItemInfo["Barcode"] : null;

            if(empty($sName) == false && empty($dPrice) == false && empty($dDiscountPrice) == false){
                $sHtml .= '<div class="main">';
                $sHtml .= '<img src="'.$sURL.'../Resources/'.$sDiscountImg.'" style="position: absolute; width:227px; z-index:-1;"/>';
                $sHtml .= '<div class="small">'.$sName.'</div>';
                $sHtml .= '<div class="large">';
                $sHtml .= number_format($dDiscountPrice, 2).'<span class="medium">'.$sCurrencyText.'</span>';
                $sHtml .= '</div>';
				$sHtml .= '<div class="xSmall">';
				$sHtml .= $sOldPriceText;
				$sHtml .= '</div>';
				//$sHtml .= '<div style="text-align: center;"><img src="'.$sURL.'../PriceTagPrint/barcode/Image.php?num='.$sBarcode.'" '.(strlen($sBarcode) == 13 ? 'style="width: 158.4px; height: 42.4px;"' : '').' /></div>';
				$sHtml .= '<div class="xMedium">';
				$sHtml .= '<img class="_strike" src="'.$sURL.'../Resources/discount_strike.png"/>';
				$sHtml .= number_format($dPrice, 2).'<span class="medium">'.$sCurrencyText.'</span>';
				$sHtml .= '</div>';
                $sHtml .= '</div>';
            }
        }
    }
}

function GetItemPlainPrintHtml(){
    
}

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <script type="text/javascript">
    	function PrintPage() {
    		var printButton = document.getElementById("PrintButton");
    		printButton.style.visibility = 'hidden';

    		window.print();

    		printButton.style.visibility = 'visible';
    	}
    </script>
    <title>Print</title>
    <style type="text/css" media="all">
        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }
        /* HTML5 display-role reset for older browsers */
        article, aside, details, figcaption, figure,
        footer, header, hgroup, menu, nav, section {
            display: block;
        }

        body {
            line-height: 1;
        }

        ol, ul {
            list-style: none;
        }

        blockquote, q {
            quotes: none;
        }

            blockquote:before, blockquote:after,
            q:before, q:after {
                content: '';
                content: none;
            }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        body {
            font-family: 'Arial Black', sans-serif;
            font-weight: 900;
        }

        button {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .small {
            font-size: 6pt;
            width: 100px;
            height: 30px;
            vertical-align: top;
            padding-top: 18px;
            padding-left: 10px;
        }

        .main {
            border: 1px solid black;
            display: block;
            float: left;
            height: 151.181102px;
            width: 226.771654px;
            margin-left: -1px;
            margin-top: -1px;
            position: relative;
        }

        .medium {
            font-size: 14pt;
            padding-left: 5px;
            padding-right: 10px;
        }

        .large {
            font-size: 36pt;
            text-align: right;
            float: right;
            padding-top: 5px;
        }

        .xSmall {
            font-size: 5pt;
            text-align: right;
            position: absolute;
            bottom: 30px;
            right: 10px;
        }

        .xMedium {
            font-size: 16pt;
            color: #969696;
            text-align: right;
            position: absolute;
            bottom: 5px;
            right: 0px;
        }

        ._xMedium {
            font-size: 16pt;
            color: #969696;
            text-align: right;
            position: absolute;
            top: 10px;
            right: 0px;
        }

        ._strike {
            position: absolute;
            left: 40%;
            margin-left: -32px;
            top: 4px;
        }

        .strike {
            position: absolute;
            left: 50%;
            margin-left: -32px;
            top: 4px;
        }
    </style>
</head>
<body>
    <div style="margin: 0 auto; width: 690px">
        <?php echo $sHtml ?>
    </div>
</body>
</html>
