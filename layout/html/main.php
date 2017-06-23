<!--
--><script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script><!--

<!-- **********************************************************************************************************************************************************
                                                                                   MAIN  
*********************************************************************************************************************************************************** --> 
<div class="table-title">
    <img src="assets/img/logo.png">
</div>
<div style='text-align:center'>
    Проби с : 9902092410048
</div>
<table class="table-fill">
    <thead>
        <tr>
            <th >Баркод</th>
            <th >Превод(RO)</th>
            <th >Цена (в Лей)</th>
        </tr>
    </thead>
    <form action="index.php" method="POST"  class="formPrint" >
        <tbody class="table-hover"> 
            <?php for($i = 0; $i < 10;$i++): ?>
                <tr>
                    <td ><input    maxlength="13" dataRow="<?php echo $i ?>" id="Barcode_<?php echo $i; ?>" class="form_in_search form-control focused BarcodeInput" type="text" name="barcode_price[]" /> </td>
                    <td ><input    maxlength="13" dataRow="<?php echo $i ?>" id="Name_<?php echo $i; ?>" class="form_in_search form-control NameInput" type="text" name="barcode_ro[]" /></td>
                    <td ><input   maxlength="13"  dataRow="<?php echo $i ?>" id="Price_<?php echo $i; ?>" class="form_in_search form-control PriceInput" type="text" name="price_lei[]" /></td>
                </tr>
            <?php endfor; ?>
        </tbody>
        <input  type="hidden" name="sendFormPrint" value="1" />
    </form>
</table> 
<div class="row">
    <div class="col-lg-3 align-self-center add-new-row">
        <button type="button" id="add-new-row" class="btn btn-primary-row" data-toggle="button" aria-pressed="false" autocomplete="off">
            ДОБАВИ НОВ РЕД
        </button>
    </div>
    <div class="col-lg-3 align-self-center send_print">
        <button type="button" class="btn btn-primary-print sendPrint" data-toggle="button" aria-pressed="false" autocomplete="off">
            РАЗПЕЧАТАЙ 
        </button>
    </div>
</div> 

 
<script type="text/javascript">
     
     
     
    $('.form_in_search').bind('keydown', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });
     var inputFocus = $('.focused')[0];
         $(inputFocus).focus();
    
    
    $(".form_in_search").keyup(function () {
       
          var $next = $(this).next('.form_in_search'); 
             
          if (this.value.length){
                
              if(this.value.length == 13)
              {
                
                    var nextRow;
                    nextRow = $(this).closest('tr').next('tr');
                    $(nextRow).find('.BarcodeInput').focus()
                    var setFocus = $('.focused');
                    var getVal = $(setFocus).val();
                    
              }
              
          }else{ 
//              $(this).blur(); 
          }
    });
    
   
</script>


<!-- **********************************************************************************************************************************************************
                                                                                    MAIN  
*********************************************************************************************************************************************************** --> 


<script>

    // Send Barcode for Print
    $(document).on('click', 'button.sendPrint', function(){
        $('.formPrint').submit();
    })


//Try to get tbody first with jquery children. works faster!
var tbody = $('.table-fill').children('tbody');
 
//Then if no tbody just select your table 
var table = tbody.length ? tbody : $('.table-fill');


$('#add-new-row').click(function(){
    //Add row
    table.append('<tr><td ><input    maxlength="13"  class="form_in_search form-control focused BarcodeInput" type="text" name="barcode_price[]"/></td>\n\
                      <td ><input    maxlength="13"  class="form_in_search form-control NameInput" type="text" name="barcode_ro[]" /></td>\n\
                      <td><input    maxlength="13"  class="form_in_search form-control PriceInput" type="text" name="price_lei[]" /></td>\n\
                </tr>');
})








</script>



  