  
    <script src="../js/jquery.js"></script>
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

    						console.log(data);

    						BarcodeInput.css(sStyles);
    						ProductRow.find(".NameInput").val(ProductData.Type);
    						dPrice = parseFloat(ProductData.Price);
    						ProductRow.find(".PriceInput").val(dPrice.toFixed(2));
    					}

    				}
    			});
 
    		}); 
    	});


 

    	 
    </script>
     
      <div class="row">  
                <input   type="text"   class="BarcodeInput"> 
                <input    type="text"  class="PriceInput">   
        </div>
      