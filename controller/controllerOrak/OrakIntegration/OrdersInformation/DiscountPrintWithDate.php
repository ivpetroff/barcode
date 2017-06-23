<?php
//$sRemoteIP = $_SERVER['REMOTE_ADDR'];
//
//$arAllowedIPs = array(
//    "93.152.172.70"
//    , "93.152.172.71"
//    , "93.152.172.72"
//    , "93.152.172.92"
//	, "62.176.83.90"
//);
//
//if(!in_array($sRemoteIP, $arAllowedIPs) && strpos($sRemoteIP, "192.168.") !== 0){
//	echo "Нямате достъп до тази страница.";
//    exit();
//}
?>

<!DOCTYPE html>
<html lang="en" data-ng-app="Mercari">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mercari</title>
    <script src="./js/jquery.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/angular.min.js"></script>
	<script src="./js/angular-file-upload-shim.min.js"></script> 
	<script src="./js/angular-file-upload.min.js"></script> 
    <script src="./js/ui-bootstrap-tpls-0.12.0.min.js"></script>
    <script src="./js/AngularMercari.js"></script>
    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <link rel="stylesheet" href="./css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="./css/style.css" />
</head>
<body data-ng-controller="MercariController">
    <div class="settings_nav">
        <button class="btn" data-ng-click="SettingsOpen();">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </button>
    </div>
	 <div class="pause_nav" data-collapse="ShowTable">
        <button class="btn" data-ng-click="Mute();">
            <span class="glyphicon glyphicon-volume-{{VolumeIcon}}" aria-hidden="true"></span>
        </button>
    </div>
    <div class="container">
        <script type="text/ng-template" id="SettingsModal.html">
			<div class="modal-header">
				<h3 class="modal-title">Настройки на звуците</h3>
			</div>
			<div class="modal-body">
				<!--<div class="form-group">
					<div class="row">
						<div class="col-sm-4"><button class="btn" style="width: 100%;" accept=".mp3" ng-file-select ng-model="file_0" multiple="false">Качи нов файл за 0% отстъпка</button></div>
						<div class="col-sm-8"><progressbar style="height: 34px;" class="progress-striped active" value="progress_value_0"></progressbar></div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-4"><button class="btn" style="width: 100%;" accept=".mp3" ng-file-select ng-model="file_20" multiple="false">Качи нов файл за 20% отстъпка</button></div>
						<div class="col-sm-8"><progressbar style="height: 34px;" class="progress-striped active" value="progress_value_20"></progressbar></div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-4"><button class="btn" style="width: 100%;" accept=".mp3" ng-file-select ng-model="file_30" multiple="false">Качи нов файл за 30% отстъпка</button></div>
						<div class="col-sm-8"><progressbar style="height: 34px;" class="progress-striped active" value="progress_value_30"></progressbar></div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-4"><button class="btn" style="width: 100%;" accept=".mp3" ng-file-select ng-model="file_50" multiple="false">Качи нов файл за 50% отстъпка</button></div>
						<div class="col-sm-8"><progressbar style="height: 34px;" class="progress-striped active" value="progress_value_50"></progressbar></div>
					</div>
				</div>-->
				<div class="form-group">
					<div class="row">
						<div class="col-sm-4"><button class="btn" style="width: 100%;" accept=".mp3" ng-file-select ng-model="file_100" multiple="false">Качи нов файл за 100% отстъпка</button></div>
						<div class="col-sm-8"><progressbar style="height: 34px;" class="progress-striped active" value="progress_value_100"></progressbar></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" ng-click="close()">Затвори</button>
			</div>
        </script>
     <!--   <audio id="Sound0" volume="1" preload="auto">
            <source src="Audio/0.mp3" type="audio/mpeg"></source>
        </audio>
        <audio id="Sound20" volume="1" preload="auto">
            <source src="Audio/20.mp3" type="audio/mpeg"></source>
        </audio>
        <audio id="Sound30" volume="1" preload="auto">
            <source src="Audio/30.mp3" type="audio/mpeg"></source>
        </audio>
        <audio id="Sound50" volume="1" preload="auto">
            <source src="Audio/50.mp3" type="audio/mpeg"></source>
        </audio>-->
        <audio id="Sound100" volume="1" preload="auto">
            <source src="Audio/100.mp3" type="audio/mpeg"></source>
        </audio>
        <form class="form-horizontal {{ShowCompanyObjectSelect}}" style="margin-top: 15px;">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Магазин</label>
                <div class="col-sm-4">
                    <select id="CompanyObjectID" class="form-control" name="CompanyObjectID" data-ng-options="CompanyObject.Name for CompanyObject in CompanyObjects" data-ng-model="CompanyObject"></select>
                </div>
            </div>
        </form>
        <table class="table {{ShowTable}}">
            <tr style="text-align: center;">
                <td style="border-top: 0;">Баркод</td>
                <td style="border-top: 0;">Артикулен номер</td>
                <td style="border-top: 0;">Продажна цена</td>
                <td style="border-top: 0; border-left: 2px solid #ddd; padding: 0;"></td>
                <td style="border-top: 0;">Отстъпка %</td>
                <td style="border-top: 0;">Цена с отстъпка</td>
                <td style="border-top: 0;">Дата</td>
            </tr>
            <tr data-ng-repeat="Barcode in Barcodes">
                <td>
                    <input type="text" id="Barcode_{{Barcode.RowID}}" data-on-change="{{Barcode}}" data-ng-keyup="OnBarcodeKeyUp($event, Barcode);" data-ng-model="Barcode.Barcode" class="form-control" />
                </td>
                <td>
                    <input type="text" data-ng-model="Barcode.Name" class="form-control" disabled="" />
                </td>
                <td>
                    <input type="text" data-ng-model="Barcode.Price" class="form-control" disabled="" />
                </td>
                <td style="border-left: 2px solid #ddd; padding: 0;"></td>
                <td>
                    <input type="text" data-ng-model="Barcode.Discount" class="form-control" disabled="" />
                </td>
                <td>
                    <input type="text" data-ng-model="Barcode.DiscountPrice" class="form-control" disabled="" />
                </td>
                <td>
                    <input type="text" data-ng-model="Barcode.DiscountDate" class="form-control" disabled="" />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="button" class="form-control btn btn-default" value="Изпрати" data-ng-click="SendEmail(false)" />
                </td>
                <td colspan="4"></td>
                <td colspan="2">
                    <input type="button" class="form-control btn btn-default" value="Печат на етикети с отстъпка" data-ng-click="Print()" />
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
