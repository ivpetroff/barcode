</body> 
</html>
<script type="text/javascript">


    $(document).ready(function () {
        $(".BarcodeInput").change(function () {

            BarcodeInput = $(this);
            ProductRow = $(this).closest('.table-hover');
            dataRow = $(this).attr('dataRow');
            var dataString = 'Barcode=' + $(this).val();
            dataString = dataString + '&Language=' + $("#Language");

            $.ajax({
                url: "controller/controllerOrak/OrakIntegration/API.php",
                context: document.body,
                data: dataString,
                type: 'POST',
                success: function (data) {
                    if (data == "error") {
                        var sStyles = {

                        };
                        BarcodeInput.css(sStyles);
                        alert('Ненамерен баркод, моля свържете се със Управител за корекция.');
                        BarcodeInput.focus();

                    } else {

                        ProductData = jQuery.parseJSON(data);
                        var sStyles = {

                        };
                        
                        $.ajax({

                            url: "controller/controllerBarcodeTranslate/controllerGetTranslate.php",
                            context: document.body,
                            data: 'data=' + data,
                            type: 'POST',
                            success: function () {

                            }

                        });
                        
                        if(typeof ProductData.errx != "undefined")
                        {
                                console.log(ProductData.errx.price_ro);
                                ProductRow.find('input#Name_' + dataRow).val(ProductData.errx.barcode_ro);
                                ProductRow.find('input#Price_' + dataRow).val(ProductData.errx.price_ro);
                                
                        }else{
                                BarcodeInput.css(sStyles);
                                ProductRow.find('input#Barcode_' + dataRow).val(ProductData.Barcode);
                                ProductRow.find('input#Name_' + dataRow).val(ProductData.Type);
                                dPrice = parseFloat(ProductData.Price);
                                ProductRow.find('input#Price_' + dataRow).val(dPrice.toFixed(2));
                        }

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