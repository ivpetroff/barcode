<div  class="row labels_header">
            <div class="col-md-12">
                <div class="content-panel">
                    <h4><i class="fa fa-angle-right"></i>Магазини <span>(BG)</span></h4>
                    <hr>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Магазин</th>
                                <th>Адрес</th>
                                <th>Номер</th>
                                <th>Оператори</th>
                                <th>Редакция</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($getROLabels as $labels_ro):  ?>
                                <tr>
                                    <td>София 5</td> 
                                    <td>София 5</td> 
                                    <td>София 5</td> 
                                    <td>София 5</td> 
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div><!--content-panel -->

                <div class="content-panel">
                    <h4><i class="fa fa-angle-right"></i> Магазини<span>(RO)</span></h4>
                    <hr>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Баркод</th>
                                <th>Превод(BG)</th> 
                                <th>Цена (в лев.)</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($getBGLabels as $labels_bg): ?>
                                <tr>
                                    <td><?php echo $labels_bg['price_barcode']; ?></td>
                                    <td><?php echo $labels_bg['barcode_bg']; ?></td>
                                    <td><?php echo $labels_bg['bprice_bg']; ?></td> 
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div> 
            </div> 
</div>