 
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function () {
//			var count = 0;
//			$('#data_table').dataTable({
//				"sServerMethod": "POST", 
//				"bProcessing": true,
//				"bServerSide": true,
//				"sAjaxSource": "get_data.php"
//			});

        // Inline editing
        var oldValue = null;
        $(document).on('dblclick', '.editable', function () {
            
                
                oldValue = $(this).html();
                var input = $(this).find('input');
             
                if(input.length == 0)
                {
                    var getId = $(this).attr('id');


                    $(this).removeClass('editable');	// to stop from making repeated request
                    $(this).html('<input type="text" name="'+getId+'" style="width:100%;" class="update form-control" value="' + oldValue + '" />');
                    $(this).find('.update').focus();
                }
            
          });
        
        
                        var newValue = null;
			$(document).on('blur', '.update', function(){
                        
                        
                        
                        
                        
                        
                                var elem    = $(this);
                                newValue 	= $(this).val();
                                
                                
                                var $tr = $(this).closest('tr');
                                var $td = $tr.children();
                                  
                                var id = $td[0].id;
                                c =0;
//                                for(c; c < $td.length; c++)
//                                {
//                                    var ddds = $td[c];
//                                    console.log($(ddds).className);;
//                                }

                      
  
                                $.each($td, function( i, l ){
                                  alert( "Index #" + i + ": " + l );
                                });
                                
                                console.log($td);
                                console.log(ro);
                                console.log(sr);
                              
//				if(ro || bg || sr)
//				{
//					$.ajax({
//						url : 'controller/addlabels/ajaxAddLabels.php',
//						method : 'post',
//						data : 
//						{
//                                                      barcode_ro: ro,
//                                                      barcode_bg: bg,
//                                                      sr: sr,
//                                                      id: id
//						},
//						success : function(respone)
//						{
//							$(elem).parent().addClass('editable');
//							$(elem).parent().html(newValue);
//						}
//					});
//				}
//				else
//				{
//					$(elem).parent().addClass('editable');
//					$(this).parent().html(newValue);
//				}
			});
        
        
        
                    $(document).on('click', '.btn-default', function () {

                        var c = 1;
                        oldValue = $('.editable').html();
                        

                        getRow = $(this).closest('tr');
                        getTd  = $(getRow).children('td');
                        $(getTd[c]).find('span:first').removeClass('glyphicon-pencil').addClass('glyphicon-floppy-saved');
                        $(getTd[c]).find('a:first').addClass('save');

                        var c;
                        for(c=2; c < getTd.length; c++)
                        {

                             var td = getTd[c];
                             var input = $(td).find('input');

                             if(input.length == 0)
                             {
                                 $(td).removeClass('editable');	// to stop from making repeated request
                                 oldValue =  $(td).html();
                                 $(td).html('<input type="text" name="bg_barcode" style="width:100%;" class="saveInput form-control" value="' + oldValue + '" />'); 
                             }
                        }
                         $(td).find('.update').focus();
                     });
        
        
          $(document).on('click', '.save', function () {
                    
                    getRow = $(this).closest('tr');
                    getTd  = $(getRow).children('td');
                    
                    var c;
                    for(c=2; c < getTd.length; c++)
                    {
                        
                        var newValue = null;
                        
                            var barcode_bg  = $(getTd[4]).find('input').val();
                            var sr          = $(getTd[5]).find('input').val();
                            
                            
                       
//                            console.log(idn);
                            if (barcode_bg)
                            {
                                $.ajax({
                                    
                                    url: '?view=addlabels&lang=ro',
                                    method: 'post',
                                    data: {
                                                barcode_ro: barcode_ro,
                                                barcode_bg: barcode_bg,
                                                sr: sr
                                          },
                                    success: function (respone)
                                    {
//                                        $(input).parent().addClass('editable');
//                                        $(elem).parent().html(newValue);
                                        
//                                        $(getTd[c]).find('span:first').removeClass('glyphicon-pencil').addClass('glyphicon-floppy-saved');
//                                        $(getTd[c]).find('a:first').addClass('save');
                                        
                                    }
                                });
                            } else{
                                $(elem).parent().addClass('editable');
                                $(this).parent().html(newValue);
                            }
                        
                    }
          });
    });



function addCell(tableRowID) {
  // Get a reference to the tableRow
  var rowRef = document.getElementById(tableRowID);
  console.log(rowRef);
  // Insert a cell in the row at cell index 0
  var newCell   = rowRef;

  // Append a text node to the cell
  var newText  = document.createTextNode('New cell')
  newCell.appendChild(newText);
}

// Call addCell() with the ID of a table row
addCell('ese');
            



</script>

<div class="col-md-12 margin_top">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3>Добави етикети</h3>
                        </div>

                        <!--button filter-->
                        <div class="col col-xs-6 text-right">
                            <div class="pull-right">
                                <div class="btn-group" data-toggle="buttons">
                                    <!--
                                    @completed
                                    @pending
                                    @all
                                    --->

                                    <label class="btn btn-success btn-filter active" data-target="completed">
                                        <input type="radio" name="options" id="option1" autocomplete="off" checked>
                                        Дрехи
                                    </label>
                                    <label class="btn btn-warning btn-filter" data-target="pending">
                                        <input type="radio" name="options" id="option2" autocomplete="off"> Обувки
                                    </label>
                                    <label class="btn btn-default btn-filter" data-target="all">
                                        <input type="radio" name="options" id="option3" autocomplete="off"> Всички
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!--button filter-->
                    </div>
                </div>
                <div class="panel-body">
                    <table id="mytable" class="table table-striped table-bordered table-list">
                        <thead>
                            <tr>
                                <th class="col-tools"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></th>
                                <th class="hidden-xs">Баркод(RO)</th>
                                <th class="col-text">Баркод(BG)</th>
                                <th class="col-text">Стоков Разделител</th>
                            </tr>
                        </thead>
                        
                        <?php $barcodes = $AddBarcodeLang->getBarcodeLang('*');  ?>
                        
                        <tbody>
                            <?php   foreach ($barcodes as $barcode):  ?>
                                <tr id="ese" data-status="completed">
                                    <td id="<?php echo $barcode['id']; ?>" align="center">
                                        <a class="btn btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                        <a class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                    </td>
                                    <td id="ro" class="editable hidden-xs"><?php echo $barcode['barcode_ro']; ?></td>
                                    <td id="bg" class="editable"><?php echo $barcode['barcode_bg']; ?></td>
                                    <td id="sr" class="editable"><?php echo $barcode['sr_id']; ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col col-xs-offset-3 col-xs-6">
                            <nav aria-label="Page navigation" class="text-center">
                                <ul class="pagination">
                                    <li>
                                        <a href="#" aria-label="Previous">
                                            <span aria-hidden="true">«</span>
                                        </a>
                                    </li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li>
                                        <a href="#" aria-label="Next">
                                            <span aria-hidden="true">»</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col col-xs-3">
                            <div class="pull-right">
                                <button type="button" id="addlabels" class="btn btn-primary-addlabels">
                                    <span class="glyphicon glyphicon-plus"
                                          aria-hidden="true"></span>
                                    Нов етикет 
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">



// Add row

//Try to get tbody first with jquery children. works faster!
    var tbody = $('#mytable').children('tbody');

//Then if no tbody just select your table 
    var table = tbody.length ? tbody : $('#mytable');


    $('#addlabels').click(function () {
        table.append('\n\
                            <tr data-status="completed">\n\
                                <td align="center">\n\
                                    <a class="btn btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>\n\
                                    <a class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>\n\
                                </td>\n\
                                <td class="editable hidden-xs">ДОБАВИ БАРКОД НА РУМЪНСКИ</td>\n\
                                <td class="editable">ДОБАВИ БАРКОД НА БЪЛГАРСКИ</td>\n\
                                <td class="editable">SR</td>\n\
                            </tr>');
    });



</script>