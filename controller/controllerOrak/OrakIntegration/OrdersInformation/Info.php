<?php
//
//$sRemoteIP = $_SERVER['REMOTE_ADDR'];
//
//$arAllowedIPs = array(
//        "93.152.172.70"
//        , "93.152.172.71"
//        , "93.152.172.72"
//        , "93.152.172.92"
//        , "78.90.251.63"
//        , "5.104.176.250"
//        , "109.104.207.50"
//        , "5.104.176.16"
//        , "93.183.131.46"
//        , "212.233.246.43"
//        , "95.168.230.113"
//        , "87.126.146.90"
//        , "95.43.166.138"
//        , "94.101.204.54"
//        , "77.78.23.86"
//        , "84.54.139.192"
//        , "94.190.227.129"
//        , "94.190.227.214"
//        , "151.237.19.90"
//        , "94.190.227.171"
//        , "95.43.131.102"
//        , "94.190.227.139"
//        , "77.78.56.197"
//        , "109.199.139.89"
//        , "95.43.152.26"
//        , "62.204.158.122"
//        , "151.237.22.46"
//        , "87.126.146.34"
//        , "84.238.140.253"
//    );
//
//if(!in_array($sRemoteIP, $arAllowedIPs) && strpos($sRemoteIP, "192.168.") !== 0){
//    echo "Access is denied.";
//    exit();
//}

define("PROJECT_PATH", "http://213.91.151.234:5080/Impero/Intranet/");
define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASS", "");
define("DB_NAME", "ImperoMercari");

function Dump($oObject, $bDump = false, $sIPCondition = "", $bXmlError = false){
	#echo $4_SESSION['s_nUserId'];
	/*if($4_SESSION['s_nUserId'] != -1)
	return true;*/

	if($sIPCondition != "" && $sIPCondition != $_SERVER['REMOTE_ADDR'])
		return;

	if($bXmlError){
		echo '<error><url>'. htmlentities($_SERVER['QUERY_STRING']) .'</url><message><![CDATA[';
	}else{
		echo '========== Dump =========='."\n";
	}
	if($bDump){
		var_dump($oObject);
	}else{
		print_r($oObject);
	}
	if($bXmlError){
		echo ']]></message></error>';
	}else{
		echo "\n".'========== /Dump =========='."\n"."\n";
	}

    echo "<br/>";
}

$sCompanyObjectCode = isset($_GET["CompanyObjectCode"]) ? $_GET["CompanyObjectCode"] : null;

if(empty($sCompanyObjectCode)){
    echo "Моля, към адреса добавете ?CompanyObjectCode=[Влиден код на магазин]!";
    exit();
}

$DBConnection = new mysqli(DB_HOST, DB_USERNAME, DB_PASS, DB_NAME);
$DBConnection->query("SET NAMES utf8");

$rsData = $DBConnection->query("
    SELECT
        CompanyObject.CompanyObjectID
        , CompanyObject.`Name`
    FROM
        CompanyObject
    WHERE
        CompanyObject.`Code`='".$sCompanyObjectCode."';
");

if($rsData->num_rows == 0){
    echo "Въведеният код не е валиден! Моля, към адреса добавете ?CompanyObjectCode=[Влиден код на магазин]!";
    exit();
}

$nCompanyObjectID = null;

$arRow = mysqli_fetch_array($rsData, MYSQL_ASSOC);
$nCompanyObjectID = $arRow["CompanyObjectID"];
$sCompanyObjectName = $arRow["Name"];

$rsData = $DBConnection->query("
    SELECT
        _AOStatus.AOStatusID
        , _AOStatus.`Code`
    FROM
        _AOStatus
    WHERE
        _AOStatus.`Code` IN ('OG_NEW', 'OG_PROCESSING', 'OG_FINISHED');
");

$nFinishedStatusID = null;
$nNewStatusID = null;
$nProcessingStatusID = null;

while($arRow = mysqli_fetch_array($rsData, MYSQL_ASSOC)){
    if($arRow["Code"] == "OG_FINISHED")
        $nFinishedStatusID = $arRow["AOStatusID"];
    elseif($arRow["Code"] == "OG_PROCESSING")
        $nProcessingStatusID = $arRow["AOStatusID"];
    else
        $nNewStatusID = $arRow["AOStatusID"];

}

$rsData = $DBConnection->query("
    SELECT
        ShopOrderInventoryItem.ObjectCode AS ObjectCode
        , ShopOrderInventoryItem.RecordID AS RecordID
        , SUM(IFNULL(ShopOrderInventoryItem.TotalPrice, 0)) AS TotalPrice
	    , IF(ShopOrderInventoryItem.ObjectCode='InventoryItem', InventoryItem.`Name`, InventoryItemGroup.`Name`) AS Name
	    , IFNULL(SUM(ShopOrderInventoryItem.Quantity), 0) AS Quantity
        , IF(IFNULL(SUM(ShopOrderInventoryItem.Quantity), 0) !=0, SUM(IFNULL(ShopOrderInventoryItem.TotalPrice, 0)) / IFNULL(SUM(ShopOrderInventoryItem.Quantity), 0), 0) AS SinglePrice
	    , IF(ShopOrderInventoryItem.ObjectCode='InventoryItem', InventoryItem.Photo, InventoryItemGroup.Photo) AS Photo
    FROM
	    ShopOrderInventoryItem
	    JOIN ShopOrder ON
		    ShopOrderInventoryItem.ShopOrderID=ShopOrder.ShopOrderID
		    AND ShopOrder.CurrentORDER_GENERALAOStatusID IN (".$nProcessingStatusID.", ".$nNewStatusID.")
		    AND ShopOrder.CompanyObjectID=".$nCompanyObjectID."
	    LEFT JOIN InventoryItem ON IF(
			            ShopOrderInventoryItem.ObjectCode='InventoryItem'
			            , InventoryItem.InventoryItemID=ShopOrderInventoryItem.RecordID
			            , FALSE
		            )
	    LEFT JOIN InventoryItemGroup ON IF(
			            ShopOrderInventoryItem.ObjectCode='InventoryItemGroup'
			            , InventoryItemGroup.InventoryItemGroupID=ShopOrderInventoryItem.RecordID
			            , FALSE
		            )
    GROUP BY ShopOrderInventoryItem.ObjectCode, ShopOrderInventoryItem.RecordID
");

$sIIUploadDir = PROJECT_PATH."Uploads/ProductPhotos/";
$sIIGUploadDir = PROJECT_PATH."Uploads/ProductGroupPhotos/";
$sNoPhotoFileName = PROJECT_PATH."Resources/no-photo.jpg";

$sHtml = "<table class='tableNew'>";
$sTableContentHtml = "";

if($rsData->num_rows == 0)
    $sTableContentHtml .= "<tr><td>НЯМА</td></tr>";

$dTotal = 0;

while($arRow = mysqli_fetch_array($rsData, MYSQL_ASSOC)){

    $sUploadDir = ($arRow["ObjectCode"] == "InventoryItem") ? $sIIUploadDir : $sIIGUploadDir;

    $sFileName = empty($arRow["Photo"]) ? $sNoPhotoFileName : $sUploadDir.$arRow["Photo"];
    $sTableContentHtml .= "<tr>";
    $sTableContentHtml .= "<td><input type='checkbox' onclick='EnableDisablePrint();' name='Items[]' value='".$arRow["Name"]."_".$arRow["SinglePrice"]."'/></td>";
    $sTableContentHtml .= "<td class='tdImage'>";
    $sTableContentHtml .= "<img src='".$sFileName."'/>";
    $sTableContentHtml .= "</td>";
    $sTableContentHtml .= "<td class='tdName'>";
    $sTableContentHtml .= $arRow["Name"];
    $sTableContentHtml .= "</td>";
    $sTableContentHtml .= "<td class='tdQuantity'>";
    $sTableContentHtml .= $arRow["Quantity"]." бр.";
    $sTableContentHtml .= "</td>";
    $sTableContentHtml .= "<td class='tdQuantity'>";
    $sTableContentHtml .= number_format($arRow["SinglePrice"], 2)." лв.";
    $sTableContentHtml .= "</td>";
    $sTableContentHtml .= "<td class='tdQuantity'>";
    $sTableContentHtml .= number_format($arRow["TotalPrice"], 2)." лв.";
    $sTableContentHtml .= "</td>";
    $sTableContentHtml .= "</tr>";

    $dTotal += $arRow["TotalPrice"];
}

$rsData = $DBConnection->query("
    SELECT
        ShopOrder.`Code` AS Code
        , DATE_FORMAT(ShopOrder.Date, '%d.%m.%Y') AS Date
    FROM
        ShopOrder
    WHERE
		ShopOrder.CurrentORDER_GENERALAOStatusID=".$nNewStatusID."
		AND ShopOrder.CompanyObjectID=".$nCompanyObjectID."
    LIMIT 0, 1
");

$sNewOrderInfoHTML = "";

if($arRow = mysqli_fetch_array($rsData, MYSQL_ASSOC)){
    $sNewOrderInfoHTML = "№ ".$arRow["Code"]." - ".$arRow["Date"];
}

$sHtml .= "<tr><td class='header' colspan='4'>Текуща поръчка ".$sNewOrderInfoHTML."</td><td class='total' colspan='2'>".number_format($dTotal, 2)." лв.</td><tr>";
$sHtml .= $sTableContentHtml;
$sHtml .= "</table>";

$sHtml .= "<table class='tableFinished'>";

$rsData = $DBConnection->query("
    SELECT
        ShopOrder.ShopOrderID
        , ShopOrder.`Code` AS Code
        , DATE_FORMAT(ShopOrder.Date, '%d.%m.%Y') AS Date
    FROM
	    ShopOrder
		JOIN ShopOrderStatusHistory ON
			ShopOrderStatusHistory.RecordID=ShopOrder.ShopOrderID
			AND ShopOrderStatusHistory.AOStatusID=".$nFinishedStatusID."
        JOIN ShopOrderInventoryItem ON ShopOrderInventoryItem.ShopOrderID=ShopOrder.ShopOrderID
    WHERE
		ShopOrder.CurrentORDER_GENERALAOStatusID=".$nFinishedStatusID."
		AND ShopOrder.CompanyObjectID=".$nCompanyObjectID."
    ORDER BY ShopOrderStatusHistory.DateCreated DESC
    LIMIT 0, 1
");

$nOrderID = 0;
$sLastFinishedOrderInfoHTML = "";

if($arRow = mysqli_fetch_array($rsData, MYSQL_ASSOC)){
    $nOrderID = $arRow["ShopOrderID"];
    $sLastFinishedOrderInfoHTML = "№ ".$arRow["Code"]." - ".$arRow["Date"];
}

$rsData = $DBConnection->query("
    SELECT
        ShopOrderInventoryItem.ObjectCode AS ObjectCode
        , ShopOrderInventoryItem.RecordID AS RecordID
	    , IF(ShopOrderInventoryItem.ObjectCode='InventoryItem', InventoryItem.`Name`, InventoryItemGroup.`Name`) AS Name
	    , IFNULL(SUM(ShopOrderInventoryItem.TotalPrice), 0) AS TotalPrice
	    , IFNULL(SUM(ShopOrderInventoryItem.Quantity), 0) AS Quantity
        , IF(IFNULL(SUM(ShopOrderInventoryItem.Quantity), 0) !=0, SUM(IFNULL(ShopOrderInventoryItem.TotalPrice, 0)) / IFNULL(SUM(ShopOrderInventoryItem.Quantity), 0), 0) AS SinglePrice
	    , IF(ShopOrderInventoryItem.ObjectCode='InventoryItem', InventoryItem.Photo, InventoryItemGroup.Photo) AS Photo
    FROM
	    ShopOrderInventoryItem
	    JOIN ShopOrder ON
		    ShopOrderInventoryItem.ShopOrderID=ShopOrder.ShopOrderID
            AND ShopOrderInventoryItem.ShopOrderID=".$nOrderID."
		    AND ShopOrder.CurrentORDER_GENERALAOStatusID=".$nFinishedStatusID."
		    AND ShopOrder.CompanyObjectID=".$nCompanyObjectID."
	    LEFT JOIN InventoryItem ON IF(
			            ShopOrderInventoryItem.ObjectCode='InventoryItem'
			            , InventoryItem.InventoryItemID=ShopOrderInventoryItem.RecordID
			            , FALSE
		            )
	    LEFT JOIN InventoryItemGroup ON IF(
			            ShopOrderInventoryItem.ObjectCode='InventoryItemGroup'
			            , InventoryItemGroup.InventoryItemGroupID=ShopOrderInventoryItem.RecordID
			            , FALSE
		            )
    GROUP BY ShopOrderInventoryItem.ObjectCode, ShopOrderInventoryItem.RecordID
");

if($rsData->num_rows == 0)
    $sHtml .= "<tr><td>НЯМА</td></tr>";

$dTotal = 0;
$sFinishedOrderTableContentHtml = "";

while($arRow = mysqli_fetch_array($rsData, MYSQL_ASSOC)){
    $sUploadDir = ($arRow["ObjectCode"] == "InventoryItem") ? $sIIUploadDir : $sIIGUploadDir;

    $sFileName = empty($arRow["Photo"]) ? $sNoPhotoFileName : $sUploadDir.$arRow["Photo"];
    $sFinishedOrderTableContentHtml .= "<tr>";
    $sFinishedOrderTableContentHtml .= "<td><input type='checkbox' onclick='EnableDisablePrint();' name='Items[]' value='".$arRow["Name"]."_".$arRow["SinglePrice"]."'/></td>";
    $sFinishedOrderTableContentHtml .= "<td class='tdImage'>";
    $sFinishedOrderTableContentHtml .= "<img src='".$sFileName."'/>";
    $sFinishedOrderTableContentHtml .= "</td>";
    $sFinishedOrderTableContentHtml .= "<td class='tdName'>";
    $sFinishedOrderTableContentHtml .= $arRow["Name"];
    $sFinishedOrderTableContentHtml .= "</td>";
    $sFinishedOrderTableContentHtml .= "<td class='tdQuantity'>";
    $sFinishedOrderTableContentHtml .= $arRow["Quantity"]." бр.";
    $sFinishedOrderTableContentHtml .= "</td>";
    $sFinishedOrderTableContentHtml .= "<td class='tdQuantity'>";
    $sFinishedOrderTableContentHtml .= number_format($arRow["SinglePrice"], 2)." лв.";
    $sFinishedOrderTableContentHtml .= "</td>";
    $sFinishedOrderTableContentHtml .= "<td class='tdQuantity'>";
    $sFinishedOrderTableContentHtml .= number_format($arRow["TotalPrice"], 2)." лв.";
    $sFinishedOrderTableContentHtml .= "</td>";
    $sFinishedOrderTableContentHtml .= "</tr>";

    $dTotal += $arRow["TotalPrice"];
}

$sHtml .= "<tr><td class='header' colspan='4'>Изпълнена поръчка ".$sLastFinishedOrderInfoHTML."</td><td class='total' colspan='2'>".number_format($dTotal, 2)." лв.</td><tr>";
$sHtml .= $sFinishedOrderTableContentHtml;
$sHtml .= "</table>";

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script type="text/javascript">
	    function PPrint(){
			document.PrintItems.PlainPrint.value = 1;
	    }

        function DPrint(){
			document.PrintItems.PlainPrint.value = 0;
            window.open('DiscountPrint.php', '_self');
	    }

        function Print(){
        
            var Args = "";
            Args += ',channelmode=1';
            Args += ', scrollbars=1';

            var PrintWindow = window.open('Print.php', 'PrintWindow', Args);
            if (window.focus) {
                PrintWindow.focus()
            }

            return false;
        }
        function EnableDisablePrint(){
            var Inputs = document.getElementsByTagName("input"); 

            var bDisabled = true;
            
            for (var i = 0; i < Inputs.length; i++) {  
              if (Inputs[i].type == "checkbox") {  
                if (Inputs[i].checked) {  
                  bDisabled = false;
                  break;
                } 
              }  
            } 
            
            var Button = document.getElementById("PrintPlainButton");
            Button.disabled = bDisabled;
        }
    </script>
    <title>Orders Information</title>
    <style type="text/css">
        body {
           font-family: 'Segoe UI_', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
        }
        table {
            border-collapse:collapse;
        }
        img {
            height: 100px;
            width: 100px;
        }
        .tdImage {
            width: 120px;
        }
        .header {
            text-align: left;
            vertical-align: bottom;
            height: 30px;
            font-size: 11pt;
            border-bottom: 2px solid black;
        }
        .total{
            text-align: right;
            vertical-align: bottom;
            font-size: 12pt;
            border-bottom: 2px solid black;
        }
        div {
            font-size: 15pt;
            width: 50%;
            float: left;
        }
        .tdQuantity {
            text-align: right;
        }
        .tdName {
            width: 30%;
            text-align: left;
        }
        .tableNew {
            font-size: 10pt;
            width: 45%;
            position:center;
            float:left;
            margin-right: 5%;
            margin-top: 10px;
        }
        .tableFinished {
            font-size: 10pt;
            width: 45%;
            position:center;
            float:left;
            margin-top: 10px;
        }
        .button {
            width: 35%;
            margin-right: 5%;
            height: 50px;
        }
    </style>
</head>
<body>
    <form name='PrintItems' method='post' action="Print.php" target="PrintWindow" onsubmit="Print();">
        <div>
            <? echo $sCompanyObjectName." - ".date("d.m.Y") ?>
        </div>
        <div>
            <input type='hidden' name='PlainPrint' />
            <button id='PrintPlainButton' class="button" type='submit' onclick="PPrint();" disabled="disabled">Генерирай етикет<br/>от доставка</button>
            <button class="button" type='button' onclick='DPrint();'>Генерирай етикет<br/>с отстъпка/ стандартен</button>
        </div>
        <? echo $sHtml ?>
    </form>
</body>
</html>
