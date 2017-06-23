'use strict'

angular.module('Mercari', ['ui.bootstrap', 'angularFileUpload'])
    .directive('onChange', function () {
        return function (scope, element, attrs) {
            element.bind('change', function () {
                scope.$evalAsync(function () {
                    scope.GetBarcodeInfo(JSON.parse(attrs.onChange));
                });
            })
        }
    }).controller('MercariController', ['$scope', '$http', '$window', '$modal', function ($scope, $http, $window, $modal) {
        $scope.API_URL = "DiscountAPI.php";
        $scope.SEND_EMAIL_URL = "SendEmail.php";
        $scope.PRINT_URL = "Print.php";
        $scope.CompanyObject = null;
        $scope.CompanyObjects = [];
        $scope.ShowTable = "hide";
        $scope.ShowCompanyObjectSelect = "";
        $scope.ShowCompanyObjectSelect = "";
        $scope.Barcodes = [];
        $scope.ID = 0;
        $scope.NeedMailSend = false;
        $scope.IsMuted = false;
        $scope.VolumeIcon = 'up';

        $scope.$watch('CompanyObject', function (newValue, oldValue) {
            if (newValue != '' && newValue != null && $scope.ShowTable == "hide") {
                $scope.ShowTable = "";
                $scope.ShowCompanyObjectSelect = "hide";
                $scope.AddNewRow();
                $scope.AddNewRow();
            }
        });
        $scope.$watch('IsMuted', function (newValue, oldValue) {
            $scope.VolumeIcon = newValue ? 'off' : 'up';
        });
        $scope.AddNewRow = function () {
            $scope.Barcodes.push({ "RowID": $scope.ID++, "Barcode": "", "Name": "", "Price": "", "Discount": "", "DiscountPrice": "", "DiscountDate": "" });
        }

        $scope.Request = function (sURL, vData) {
            var request = $http({
                method: 'GET',
                url: sURL,
                params: vData,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            });

            return (request.then(function (response) { return response.data }, function (response) { return new Error(response.statusText, response.status); }));
        }

        $scope.PostRequest = function (sURL, vData) {
            var request = $http({
                method: 'POST',
                url: sURL,
                data: $.param(vData),
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            });

            return (request.then(function (response) { return response.data }, function (response) { return new Error(response.statusText, response.status); }));
        }

        $scope.OnBarcodeKeyUp = function (event, Barcode) {
            if (event.keyCode == 13) {
                //$scope.GetBarcodeInfo(Barcode);
                //if(Barcode.Barcode == '' || Barcode.Barcode == null){
                //} else {
                //}
            }
        }

        $scope.Print = function () {
            $.post($scope.PRINT_URL, { "Items": $scope.Barcodes }, function (d) {
                var new_window = window.open();
                $(new_window.document.body).append(d);
                var element = new_window.document.getElementById('PrintButton');
                $(element).click(function () {
                    element.style.visibility = 'hidden';
                    new_window.print();
                    element.style.visibility = 'visible';
                });
            });
        }

        $window.onbeforeunload = function () {
            if ($scope.NeedMailSend) {
                $scope.SendEmail(true);
                return 'Сигурни ли сте, че сте приключили с опцерацията по въвеждане на баркодове.';
            }
        }

        $scope.SendEmail = function (hidden) {
            $scope.PostRequest($scope.SEND_EMAIL_URL, { "CompanyObjectName": $scope.CompanyObject.Name, "Items": $scope.Barcodes }).then(function (vData) {
                if (vData.Error == 1) {
                    if (!hidden) {
                        alert("Неочаквана грешка. Моля, опитайте отново.");
                    }
                    console.dir(vData.Message);
                    return;
                }
                if (!hidden) {
                    alert(vData.Message);
                }
                $scope.NeedMailSend = false;
            }, function (Error) {
                if (!hidden) {
                    alert("Неочаквана грешка. Моля, опитайте отново.");
                }
                console.dir(Error);
            });
        }

        $scope.GetBarcodeInfo = function (Barcode) {
            for (var i = $scope.Barcodes.length - 1; i >= 0; i--) {
                if ($scope.Barcodes[i].RowID == Barcode.RowID) {
                    Barcode = $scope.Barcodes[i];
                    break;
                }
            }
            var sBarcode = Barcode.Barcode;
            if (sBarcode == '' || sBarcode == null) {
                $("#Barcode_" + Barcode.RowID).focus();
                return false;
            }

            $scope.Request($scope.API_URL, { "Barcode": sBarcode, "CompanyObjectID": $scope.CompanyObject.CompanyObjectID }).then(
                function (vData) {
                    if (vData.Error !== undefined && vData.Error == 1) {
                        $("#Barcode_" + Barcode.RowID).val('');
                        alert(vData.Message);
                        $("#Barcode_" + Barcode.RowID).focus();
                        return false;
                    }
                    Barcode.Name = vData.Name;
                    Barcode.Price = vData.Price;
                    Barcode.Discount = vData.Discount;
                    Barcode.DiscountPrice = vData.DiscountPrice;
                    Barcode.DiscountDate = vData.DiscountDate;
                    var SoundFile = "";

                    // if (vData.Discount <= 0) {
                    	// SoundFile = "Sound0";
                    // } else {
                    	// if (vData.Discount <= 20) {
                    		// SoundFile = "Sound20";
                    	// } else {
                    		// if (vData.Discount <= 30) {
                    			// SoundFile = "Sound30";
                    		// } else {
                    			// if (vData.Discount <= 50) {
                    				// SoundFile = "Sound50";
                    			// } else {
                    				// SoundFile = "Sound100";
                    			// }
                    		// }
                    	// }
                    // }

                    if (vData.Discount == 100) {
                       SoundFile = "Sound100";
                    }
                    if (SoundFile != "") {
                        $scope.Pause();
                        document.getElementById(SoundFile).play();
                    }
                    $scope.AddNewRow();
                    $("#Barcode_" + (Barcode.RowID + 1)).focus();
                    $scope.NeedMailSend = true;
                }, function (Error) {
                    alert("Неочаквана грешка. Моля, опитайте отново.");
                    console.dir(Error);
                    return false;
                });
        }

        $scope.Request($scope.API_URL, { "GetCompanyObjects": 1 }).then(function (vData) {
            if (vData.Error !== undefined && vData.Error == 1) {
                alert(vData.Message);
                return false;
            }
            $scope.CompanyObjects = vData;
        }, function (Error) {
            console.dir(Error);
        });

        $scope.PreloadAudio = function () {
            // document.getElementById("Sound0").load();
            // document.getElementById("Sound20").load();
            // document.getElementById("Sound30").load();
            // document.getElementById("Sound50").load();
            document.getElementById("Sound100").load();
        }

        $scope.SettingsOpen = function () {
            var modalInstance = $modal.open({
                templateUrl: 'SettingsModal.html',
                controller: 'ModalSettingsCtrl',
                size: 'lg',
            });

            modalInstance.result.then(function () {
                $scope.PreloadAudio();
            }, function () {
                $scope.PreloadAudio();
            });
        }

        $scope.Pause = function () {
            // var Sound0 = document.getElementById("Sound0");
            // var Sound20 = document.getElementById("Sound20");
            // var Sound30 = document.getElementById("Sound30");
            // var Sound50 = document.getElementById("Sound50");
            var Sound100 = document.getElementById("Sound100");
            // Sound0.pause();
            // Sound20.pause();
            // Sound30.pause();
            // Sound50.pause();
            Sound100.pause();
            // Sound0.currentTime = 0;
            // Sound20.currentTime = 0;
            // Sound30.currentTime = 0;
            // Sound50.currentTime = 0;
            Sound100.currentTime = 0;
        }

        $scope.Mute = function () {
            $scope.IsMuted = !$scope.IsMuted;
            var Volume = $scope.IsMuted ? 0 : 1;
            // var Sound0 = document.getElementById("Sound0");
            // var Sound20 = document.getElementById("Sound20");
            // var Sound30 = document.getElementById("Sound30");
            // var Sound50 = document.getElementById("Sound50");
            var Sound100 = document.getElementById("Sound100");
            // Sound0.volume = Volume;
            // Sound20.volume = Volume;
            // Sound30.volume = Volume;
            // Sound50.volume = Volume;
            Sound100.volume = Volume;
        }
    }]);

angular.module('Mercari').controller('ModalSettingsCtrl', ['$scope', '$modalInstance', '$upload', function ($scope, $modalInstance, $upload) {
    // $scope.file_0 = null;
    // $scope.file_20 = null;
    // $scope.file_30 = null;
    // $scope.file_50 = null;
    $scope.file_100 = null;
    // $scope.progress_value_0 = 0;
    // $scope.progress_value_20 = 0;
    // $scope.progress_value_30 = 0;
    // $scope.progress_value_50 = 0;
    $scope.progress_value_100 = 0;
    $scope.API_UPLOAD = "Upload.php";

    $scope.close = function () {
        $modalInstance.close();
    };

    // $scope.$watch('file_0', function () {
        // if ($scope.file_0 !== null) {
            // $scope.UploadFile($scope.file_0, '0');
        // }
    // });
    // $scope.$watch('file_20', function () {
        // if ($scope.file_20 !== null) {
            // $scope.UploadFile($scope.file_20, '20');
        // }
    // });
    // $scope.$watch('file_30', function () {
        // if ($scope.file_30 !== null) {
            // $scope.UploadFile($scope.file_30, '30');
        // }
    // });
    // $scope.$watch('file_50', function () {
        // if ($scope.file_50 !== null) {
            // $scope.UploadFile($scope.file_50, '50');
        // }
    // });
    $scope.$watch('file_100', function () {
        if ($scope.file_100 !== null) {
            $scope.UploadFile($scope.file_100, '100');
        }
    });

    $scope.UploadFile = function (file, sFileName) {
        $scope.upload = $upload.upload({
            url: $scope.API_UPLOAD,
            data: { myObj: $scope.myModelObj, 'FileName': sFileName + '.mp3' },
            file: file,
        }).progress(function (evt) {
            switch (sFileName) {
                case "0":
                    $scope.progress_value_0 = parseInt(100.0 * evt.loaded / evt.total);
                    break;
                case "20":
                    $scope.progress_value_20 = parseInt(100.0 * evt.loaded / evt.total);
                    break;
                case "30":
                    $scope.progress_value_30 = parseInt(100.0 * evt.loaded / evt.total);
                    break;
                case "50":
                    $scope.progress_value_50 = parseInt(100.0 * evt.loaded / evt.total);
                    break;
                case "100":
                    $scope.progress_value_100 = parseInt(100.0 * evt.loaded / evt.total);
                    break;
            }
        }).success(function (data, status, headers, config) {
            alert(data.Message);
            //console.log('file ' + config.file.name + 'is uploaded successfully. Response: ' + data);
        });
    }
}]);