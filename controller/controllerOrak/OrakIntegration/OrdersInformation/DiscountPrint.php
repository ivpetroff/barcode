<?php


$sHtml = "";

$sLang = "bg";
if(isset($_GET["lang"]))
    $sLang = $_GET["lang"];

if($sLang == "ro"){
    $sBarcodeText = "Cod de bare";
    $sTypeText = "Număr articol";
    $sPriceText = "Preţ de vânzare";
    $sOldPriceText = "Preț vechi";
    $sDiscountPercentText = "Reducere %";
    $sDiscountPriceText = "Preţ redus";
    $sPlainPrintText = "Imprimare etichetă standard";
    $sDiscountPrintText = "Imprimare etichetă cu reducere";
}else{
    $sBarcodeText = "Баркод";
    $sTypeText = "Артикулен номер";
    $sPriceText = "Продажна цена";
    $sOldPriceText = "Стара цена";
    $sDiscountPercentText = "Отстъпка %";
    $sDiscountPriceText = "Цена с отстъпка";
    $sPlainPrintText = "Печат на стандартен етикет";
    $sDiscountPrintText = "Печат на етикети с отстъпка"; 
}

for($i = 1; $i <= 18; $i ++){
    $bFirst = ($i == 1);

    $sHtml .= '
        <div class="row">
            <div style="clear: both; display: block;"></div>
            <div class="divItem" style="width:13%">
                '.($bFirst ? $sBarcodeText.'<br />' : "").'
                <input id="Barcode_1" name="Items['.$i.'][Barcode]" type="text" style="text-align: right;" class="BarcodeInput"  />
            </div>
            <div class="divItem" style="width:40%">
                '.($bFirst ? $sTypeText.'<br />' : "").'
                <input id="Name_1" name="Items['.$i.'][Name]" type="text" style="text-align: left;" class="NameInput" />
            </div>
            <div class="divItem" style="width:10%; min-width: 107px;">
                '.($bFirst ? $sPriceText.'<br />' : "").'
                <input id="Price_1" name="Items['.$i.'][Price]" type="text" style="text-align: right;" class="PriceInput" />
            </div>
            <div class="divItem" style="width:10%">
                '.($bFirst ? $sOldPriceText.'<br />' : "").'
                <input id="OldPrice_1" name="Items['.$i.'][OldPrice]" type="text" style="text-align: right;"/>
            </div>
            <div class="divItem" style="border-left: 2px solid black;padding-left: 5px; width: 10%;">
                '.($bFirst ? $sDiscountPercentText.'<br />' : "").'
                <input id="DiscountPercent_1" type="text" class="DiscountPercent" onkeypress="return isNumberKey(event);" style="text-align: right;"/>
            </div>
            <div class="divItem" style="width: 10%;min-width: 113px;">
                '.($bFirst ? $sDiscountPriceText.'<br />' : "").'
                <input id="Discount_1" name="Items['.$i.'][DiscountPrice]" type="text" class="DiscountPrice" onkeypress="return isNumberKey(event);" style="text-align: right;"/>
            </div>
        </div>
    ';
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script src="./js/jquery.js"></script>
    <script type="text/javascript">
    	$(document).ready(function () {
    		$(".BarcodeInput").change(function () {

    			BarcodeInput = $(this);
    			ProductRow = $(this).closest('.row');

    			var dataString = 'Barcode=' + $(this).val();
    			dataString = dataString + '&Language=' + $("#Language").val();

    			$.ajax({
    				url: "API.php",
    				context: document.body,
    				data: dataString,
    				type: 'POST',
    				success: function (data) {
    					if (data == "error") {
    						var sStyles = {
    							border: "1px solid #FF0000"
    						};
    						BarcodeInput.css(sStyles);
    						alert('Ненамерен баркод, моля свържете се с Централен склад за корекция.');
    						BarcodeInput.focus();
    					} else {
    						ProductData = jQuery.parseJSON(data);

    						var sStyles = {
    							border: "1px solid #000000"
    						};

    						//console.log(data);

    						BarcodeInput.css(sStyles);
    						ProductRow.find(".NameInput").val(ProductData.Type);
    						dPrice = parseFloat(ProductData.Price);
    						ProductRow.find(".PriceInput").val(dPrice.toFixed(2));
    					}

    				}
    			});


    			$(".DiscountPercent").change(function () {
    				ProductRow = $(this).closest('.row');
    				dDiscountPercent = $(this).val();
    				dPrice = ProductRow.find(".PriceInput").val();
    				result = (dPrice - dPrice * (dDiscountPercent / 100));
    				ProductRow.find(".DiscountPrice").val(result.toFixed(2));
    			});

    			$(".DiscountPrice").change(function () {
    				ProductRow = $(this).closest('.row');
    				dDiscount = $(this).val();
    				dPrice = ProductRow.find(".PriceInput").val();
    				result = 100 - ((dDiscount / dPrice) * 100);

    				ProductRow.find(".DiscountPercent").val(result.toFixed(2));
    			});

    		});

    		$(".BarcodeInput").keypress(function (event) {
    			if (event.which == 13) {
    				event.preventDefault();
    				$(this).closest(".row").next('.row').find('.BarcodeInput').focus();
    			}

    		});

    	});



    	function isNumberKey(evt) {
    		var charCode = (evt.which) ? evt.which : event.keyCode;
    		if (charCode > 31 && (charCode != 46 && (charCode < 48 || charCode > 57)))
    			return false;
    		return true;
    	}


    	function Print() {
    		var Args = "";
    		Args += ',channelmode=1';
    		Args += ', scrollbars=1';

    		var PrintWindow = window.open('Print.php', 'PrintWindow', Args);
    		if (window.focus) {
    			PrintWindow.focus()
    		}

    		return false;
    	}

    	function PPrint() {
    		document.PrintItems.PlainPrint.value = 1;
    	}

    	function DPrint() {
    		document.PrintItems.PlainPrint.value = 0;
    	}
    </script>
    <title>DiscountPrint</title>
    <style type="text/css">
        body {
            font-family: 'Segoe UI_', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
            font-size: 10pt;
        }
        div {
            text-align: center;
            margin-left: 5px;
        }
        input {
            height: 30px;
            font-size: 12pt;
            margin-top: 5px;
			width: 100%;
			padding: 5px;
        }
        .NameInput, .PriceInput {
            border: 1px solid black;
            background-color: #E6E6E6;
        }
        .divItem{
            float: left;
            width: 15%;
        }
        button {
            margin: 5px;
        }
    </style>
</head>
<body>
    <form name='PrintItems' method='post' action="Print.php" target="PrintWindow" onsubmit="Print();" onkeypress="return event.keyCode != 13;">
        <div style="width: 100%">
            <?php echo $sHtml ?>
            <div style="clear: both; display: block;"></div>
            <input type='hidden' name='PlainPrint'/>
            <input type='hidden' name='Language' id="Language" value='<?php echo $sLang ?>'/>
            <div style="width: 100%">
                <button style="margin-top: 20px; position:absolute; width:400px;" type='submit' onclick="PPrint();"><?php echo $sPlainPrintText ?></button>
                <button style="margin-top: 20px; margin-left: 50%; width:350px;" type='submit' onclick='DPrint();'><?php echo $sDiscountPrintText ?></button>
            </div>
        </div>
    </form>
</body>
</html>
