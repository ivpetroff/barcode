
<!-- **********************************************************************************************************************************************************
                                                                                   MAIN  
*********************************************************************************************************************************************************** --> 
<div class="table-title">
    <img src="assets/img/logo.png">
</div>
<table class="table-fill">
    <thead>
        <tr>
            <th class="text-left">Баркод</th>
            <th class="text-left">Превод(RO)</th>
            <th class="text-left">Цена (в Лей)</th>
        </tr>
    </thead>
    <form action="index.php" method="POST"  class="formPrint">
        <tbody class="table-hover"> 
            <tr>
                <td class="text-left"><input   maxlength="11"   class="form_in_search form-control focused"  type="text" name="barcode_price[]" /> </td>
                <td class="text-left"><input   maxlength="11"  class="focused form_in_search form-control" type="text" name="barcode_ro[]" /></td>
                <td class="text-left "><input  maxlength="11"  class="   form_in_search form-control "  maxlength="11" type="text" name="price_lei[]" /></td>
            </tr>
            <tr>
                <td class="text-left"><input  maxlength="11"  class=" form_in_search form-control "  maxlength="11" type="text" name="barcode_price[]" /> </td>
                <td class="text-left"><input   maxlength="11"   class=" form_in_search form-control "  maxlength="11" type="text" name="barcode_ro[]" /></td>
                <td class="text-left "><input   maxlength="11"  class=" form_in_search form-control "  type="text" maxlength="11"name="price_lei[]" /></td>
            </tr>
            <tr>
                <td class="text-left"><input    maxlength="11"  class=" form_in_search form-control " maxlength="11"type="text" name="barcode_price[]" /> </td>
                <td class="text-left"><input    maxlength="11"  class=" form_in_search form-control " maxlength="11" type="text" name="barcode_ro[]" /></td>
                <td class="text-left "><input  maxlength="11"   class=" form_in_search form-control " type="text" maxlength="11" name="price_lei[]" /></td>
            </tr>
            <tr>
                <td class="text-left"><input   maxlength="11"   class=" form_in_search form-control " type="text" name="barcode_price[]" /> </td>
                <td class="text-left"><input   maxlength="11"   class=" form_in_search form-control " type="text" name="barcode_ro[]" /></td>
                <td class="text-left "><input  maxlength="11"  class=" form_in_search form-control " type="text" name="price_lei[]" /></td>
            </tr>
            <tr>
                <td class="text-left"><input  class=" form_in_search focused"  maxlength="11"  type="text" name="barcode_price[]" /> </td>
                <td class="text-left"><input  class=" form_in_search focused"  maxlength="11"  type="text" name="barcode_ro[]"  /></td>
                <td class="text-left "><input class=" form_in_search focused"  maxlength="11"  type="text" name="price_lei[]"  /></td>
                
                
                
                
                <input class=" form_in_search focused"  maxlength="11" >
                <input class=" form_in_search"  maxlength="11" maxlength="11" > 
                <input class=" form_in_search"  maxlength="11" > 
                <input class=" form_in_search"  maxlength="11" > 
                <input class=" form_in_search"  maxlength="11" > 
                <input class=" form_in_search"  maxlength="11" > 
                <input class=" form_in_search"  maxlength="11" > 
                <input class=" form_in_search"  maxlength="11" > 
                <input class=" form_in_search"  maxlength="11" > 
                <input class=" form_in_search form_send"  maxlength="11" > 
            </tr> 
            <input type="hidden" autofocus="true" />
        <input  type="hidden" name="send" value="1" />
        </tbody>
    </form>
</table> 
<div class="row">
    <div class="col-lg-3 align-self-center add-new-row">
        <button type="button"  id="add-new-row" class="btn btn-primary-row" data-toggle="button" aria-pressed="false" autocomplete="off">
            ДОБАВИ НОВ РЕД
        </button>
    </div>
    <div class="col-lg-3 align-self-center send_print">
        <button type="button" class="btn btn-primary-print sendPrint" data-toggle="button" aria-pressed="false" autocomplete="off">
            РАЗПЕЧАТАЙ 
        </button>
    </div>
</div> 

         
             
                
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js" maxlength="11" ></script >

<script>
    $('.form_in_search').bind('keydown', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });
     
    $('.focused').focus();
    
    
    $(".form_in_search").keyup(function () {
       
        
            
          var $next = $(this).next('.form_in_search'); 
          console.log(this.value.length);
          
          if ($next.length){
              
              if(this.value.length == 9)
              {
                  var  nextd  =  $(this).next('.form_in_search');

                    setTimeout(function(){
                      nextd.focus();
                       
                    }, 100);

              }else if(this.value.length  == 11){
                  
                  $(this).next('.form_in_search').focus();
                  
              }
              
          }else{ 
              //$(this).blur(); 
          }
    });
    
</script>
 



<script>

    $('.form_in_search').bind('keydown', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

    $('.focused').focus();
    
          var c  = 0;
          
    $(".form_in_search").keyup(function () {


        var $next = $(this).next('.form_in_search');
        
        if ($next.val.length) {
                
            var count = this.value.length;
             if (count == 11) {
                 
                $(this).removeClass('focused');
                console.log($('input')[c]);
                var newRow = $('input')[c];
                console.log($(newRow).addClass('focused'));
                $(this).next('.form_in_search').focus();
                
            }

        } else {
            //$(this).blur(); 
        }
        
        c  = parseInt(c +1);
        console.log(c);
    });





</script>


<!-- **********************************************************************************************************************************************************
                                                                                    MAIN  
*********************************************************************************************************************************************************** --> 
<script src="../js/jquery.js"></script>
<script src="assets/js/jquery.js"></script>
<script type="text/javascript">


//Try to get tbody first with jquery children. works faster!
    var tbody = $('.table-fill').children('tbody');

//Then if no tbody just select your table 
    var table = tbody.length ? tbody : $('.table-fill');


    $('#add-new-row').click(function () {
        //Add row
        table.append('<tr><td class="text-left"><input    class=" form_in_search form-control " type="text" name="barcode_price[]"/></td>\n\
                      <td class="text-left"><input    class=" form_in_search form-control " type="text" name="barcode_ro[]" /></td>\n\
                      <td class="text-left "><input   class="form_in_search form-control " type="text" name="price_lei[]" /></td>\n\
                </tr>');
    })

//Orak
//
//    	$(document).ready(function () {
//    		$(".").change(function () {
//
//    			 = $(this);
//    			ProductRow = $(this).closest('.row');
//
//    			var dataString = 'Barcode=' + $(this).val();
//    			dataString = dataString + '&Language=' + $("#Language").val();
//
//    			$.ajax({
//    				url: "../controller/controllerOrak/OrakIntegration/API.php",
//    				context: document.body,
//    				data: dataString,
//    				type: 'POST',
//    				success: function (data) {
//    					if (data == "error") {
//    						var sStyles = {
//    							border: "1px solid #FF0000"
//    						};
//    						.css(sStyles);
//    						alert('Ненамерен баркод, моля свържете се с Централен склад за корекция.');
//    						.focus();
//    					} else {
//    						ProductData = jQuery.parseJSON(data);
//
//    						var sStyles = {
//    							border: "1px solid #000000"
//    						};
//
//    						//console.log(data);
//
//    						.css(sStyles);
//    						ProductRow.find(".").val(ProductData.Type);
//    						dPrice = parseFloat(ProductData.Price);
//    						ProductRow.find(".").val(dPrice.toFixed(2));
//    					}
//
//    				}
//    			});
//
//
//    			$(".DiscountPercent").change(function () {
//    				ProductRow = $(this).closest('.row');
//    				dDiscountPercent = $(this).val();
//    				dPrice = ProductRow.find(".").val();
//    				result = (dPrice - dPrice * (dDiscountPercent / 100));
//    				ProductRow.find(".DiscountPrice").val(result.toFixed(2));
//    			});
//
//    			$(".DiscountPrice").change(function () {
//    				ProductRow = $(this).closest('.row');
//    				dDiscount = $(this).val();
//    				dPrice = ProductRow.find(".").val();
//    				result = 100 - ((dDiscount / dPrice) * 100);
//
//    				ProductRow.find(".DiscountPercent").val(result.toFixed(2));
//    			});
//
//    		});
//
//    		$(".").keypress(function (event) {
//    			if (event.which == 13) {
//    				event.preventDefault();
//    				$(this).closest(".row").next('.row').find('.').focus();
//    			}
//
//    		});
//
//    	});


//
//    	function isNumberKey(evt) {
//    		var charCode = (evt.which) ? evt.which : event.keyCode;
//    		if (charCode > 31 && (charCode != 46 && (charCode < 48 || charCode > 57)))
//    			return false;
//    		return true;
//    	}
//
//
//    	function Print() {
//    		var Args = "";
//    		Args += ',channelmode=1';
//    		Args += ', scrollbars=1';
//
//    		var PrintWindow = window.open('Print.php', 'PrintWindow', Args);
//    		if (window.focus) {
//    			PrintWindow.focus()
//    		}
//
//    		return false;
//    	}
//
//    	function PPrint() {
//    		document.PrintItems.PlainPrint.value = 1;
//    	}
//
//    	function DPrint() {
//    		document.PrintItems.PlainPrint.value = 0;
//    	}
</script>

