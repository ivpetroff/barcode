<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script>
    function showEdit(editableObj) {
//        $(editableObj).css("background", "#FFF");
    }


    $(document).on('click', 'td.editable', function () {

        var row = $(this).attr('contenteditable', 'true');

    });
    
    
    //edit row 
    $(document).on('click', '.btn-default', function () {

        var row = $(this).attr('contenteditable', 'true');
        var getRow = $(this).closest('tr').find('td');
        $(getRow).attr('contenteditable', 'true');

        var changeBnt = $(getRow[0]).find('a');
        changeBnt.addClass('save');

        $(getRow[1]).addClass('edit');
        $(getRow[2]).addClass('edit');
        $(getRow[3]).addClass('edit');
        $(getRow[4]).addClass('edit');

        //   change icon
        var getIcons = $(getRow[0]).find('span');
        $(getIcons[0]).removeClass('glyphicon-pencil');
        $(getIcons[0]).addClass('glyphicon-floppy-disk');

    });
 
     //save row 
    $(document).on('click', '.save', function () {

        var getRow = $(this).closest('tr').find('td');
        $(getRow).attr('contenteditable', 'false');

        var changeBnt = $(getRow[0]).find('a');
        changeBnt.removeClass('save');
        $(getRow[1]).removeClass('edit');
        $(getRow[2]).removeClass('edit');
        $(getRow[3]).removeClass('edit');

        var getIcons = $(getRow[0]).find('span');
        $(getIcons[0]).removeClass('glyphicon-floppy-disk');
        $(getIcons[0]).addClass('glyphicon-pencil');


    });

    //delete rows 
    $(document).on('click', '.trash', function () {
        
        var getRows = $(this);
        var col_2 = getRows.closest('tr').find('td');
        var id = $(col_2)[0].id;
        var dateleData = "id=" + id +'&delete=row';  
       
        $.ajax({
            url: "?view=editlabels&lang=ro",
            type: "POST",
            data: dateleData,
            success: function (data) {
                //$(editableObj).css("background", "#f9f9f9");

                var trRow = getRows.closest('tr')[0];
            
                $(trRow).hide( 1000, function() {
                    $(this).remove();
                });
            }
        });
        
    });
    
    
    
    function saveToDatabase(editableObj, column, id, rosw) {
        
        
        if (rosw == 2)
        {
            var getRows = $("td#newrow"); 
            var col_2 =  $(getRows)[0];
            var col_3 =  $(getRows)[1];
            var col_4 =  $(getRows)[2];  
            var col_5 =  $(getRows)[3];  
             
            var datas = 'data=' + col_2.textContent + '|' + col_3.textContent + '|' + col_4.textContent + col_5.textContent + '&insert=row';
            urls = "?view=editlabels&lang=ro";
            
        } else{
          
            var datas = 'column=' + column + '&editval=' + editableObj.innerHTML + '&id=' + id;
        }
        
        $(editableObj).css("background", "#fff url(./assets/img/loaderIcon.gif) no-repeat right");
        $.ajax({
            url: "?view=editlabels&lang=ro",
            type: "POST",
            data: datas,
            success: function (data) {
                $(editableObj).css("background", "#f9f9f9");
            }
        });
    }
    
</script>

<div class="col-md-12 margin_top">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3>Етикет :: Редакция</h3>
                        </div>

                        <!--button filter-->
                        <div  style="display: none;" class="col col-xs-6 text-right">
                            <div class="pull-right">
                                <div class="btn-group" data-toggle="buttons">
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
                                <th class="hidden-xs">Дефиниране </th>
                                <th class="col-text">Преглед<span></span></th>
                                <th class="col-text"> Баркод (RO)</th>
                                <th class="col-text"> Баркод (BG)</th>
                            </tr>
                        </thead>

                        <?php  $barcodes = $EditBarcodeLabel->getBarcodeLabel('*'); ?>

                        <tbody>
                            <?php foreach ($barcodes as $key => $barcode): ?>
                                <tr id="ese" data-status="completed">
                                    <td id="<?php echo $barcodes[$key]['id']; ?>" align="center">
                                        <a class="btn btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                        <a class="btn btn-danger trash"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                    </td>
                                    <td contenteditable="false" onBlur="saveToDatabase(this, 'variables', '<?php echo $barcodes[$key]["id"]; ?>, 1')"   id="ro" class="editable hidden-xs"><?php echo $barcodes[$key]['variables']; ?></td>
                                    <td contenteditable="false" onBlur="saveToDatabase(this, 'variables_view', '<?php echo $barcodes[$key]["id"]; ?>, 1')"   id="bg" class="editable"><?php echo $barcodes[$key]['variables_view']; ?></td>
                                    <td contenteditable="false"  onBlur="saveToDatabase(this, 'variables_ro', '<?php echo $barcodes[$key]["id"]; ?>, 1')"   id="sr" class="editable"><?php echo $barcodes[$key]['variables_ro']; ?></td>
                                    <td contenteditable="false"  onBlur="saveToDatabase(this, 'variables_bg', '<?php echo $barcodes[$key]["id"]; ?>, 1')"   id="sr" class="editable"><?php echo $barcodes[$key]['variables_bg']; ?></td>
                                </tr>
                                <?php $new_id = $barcodes[$key]['id'] + 1; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <?php echo $Pages->displayPaginationBelow(); ?>
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
                                <td id="<?php echo $new_id ?>" align="center">\n\
                                    <a class="btn btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>\n\
                                    <a class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>\n\
                                </td>\n\
                                <td contenteditable="false" id="newrow" onBlur="saveToDatabase(this,1 ,<?php echo $barcodes[$key]["id"]; ?>, 2)" class=" editable hidden-xs">Variables</td>\n\
                                <td contenteditable="false" id="newrow" onBlur="saveToDatabase(this,2  ,<?php echo $barcodes[$key]["id"]; ?>, 2)" class=" editable "></td>\n\
                                <td contenteditable="false" id="newrow" onBlur="saveToDatabase(this,3 ,<?php echo $barcodes[$key]["id"]; ?>, 2)" class=" editable">Var (RO)</td>\n\
                                <td contenteditable="false" id="newrow" onBlur="saveToDatabase(this,4 ,<?php echo $barcodes[$key]["id"]; ?>, 2)" class=" editable">Var(BG)</td>\n\
                            </tr>');
    });



</script>