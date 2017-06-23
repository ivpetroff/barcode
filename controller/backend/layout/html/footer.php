 <!-- **********************************************************************************************************************************************************
                        RIGHT SIDEBAR CONTENT
                        *********************************************************************************************************************************************************** -->                  
                    </div> 
                </section>
            </section>
        </section>
        
      
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="assets/css/bootstrap-datepicker3.css"/>

<script type="text/javascript">
             
    
     
    (function($){
  


     $('.btn-filter').on('click', function () {
        var $target = $(this).data('target');
        if ($target != 'all') {
            $('.table tbody tr').css('display', 'none');
            $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
        } else {
            $('.table tbody tr').css('display', 'none').fadeIn('slow');
        }
    });
    

    $('#checkall').on('click', function () {
        if ($("#mytable #checkall").is(':checked')) {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
    }); 
})(jQuery);
        jQuery.noConflict();
        jQuery( document ).ready(function( $ ){ 
		var date_input=$('input[name="start"]'); //our date input has the name "date"
		var date_end=$('input[name="end"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'yyyy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true, 
		});
		date_end.datepicker({
			format: 'yyyy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true, 
		})
	   });
</script>

        <script src="assets/js/jquery.js"></script>
        <!--<script src="assets/js/jquery-1.8.3.min.js"></script>--> 
        <!--<script src="assets/js/bootstrap.min.js"></script>-->
   
        
        
        <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
<!--        <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="assets/js/jquery.sparkline.js"></script>-->


      
        <script src="assets/js/common-scripts.js"></script>
        
         <!--add labels js/bootstrap-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
      
        
 
    </body>
</html>

