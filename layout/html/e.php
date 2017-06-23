<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js" maxlength="11" ></script >
            <label class="label_search" maxlength="11" >Поръчка №:</label maxlength="11" >
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
            <script maxlength="11" >
 

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
 