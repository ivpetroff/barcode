<script type="text/javascript" src="https://formden.com/static/cdn/formden.js"></script>
<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
<style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: black}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}</style>

 
<div class="row margin_top">
    <div class="col-md-12">
        <div class="content-panel">
            <div class="row">
                <div class="title_section  col-md-3"><h4><i class="fa fa-angle-right"></i>Експорт на записи</h4></div>
                <div class="title_section  col-md-4">
                    <!-- HTML Form (Date) -->
                    <div class="bootstrap-iso" >
                        <form action="#" class="form-horizontal" method="post">
                            <div class="input-daterange" id="datepicker">
                                <input type="text" class=" col-md-4 date-control" name="start" />
                                <span class="input-group-addon col-md-4">до</span>
                                <input type="text" class=" date-control col-md-4" name="end" />
                                <input type="hidden" name="submit" value="1" />
                                <input type="submit"  class="getDate-bnt btn-success" value="Покажи"  />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr>
            <?php if(!empty($barcode_view)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Баркод</th>
                        <th>Превод(BG)</th> 
                        <th>Цена(в лев.)</th> 
                        <th>Превод(RO)</th> 
                        <th>Цена (в лей.)</th> 
                        <th>Дата</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($barcode_view as $barcode): ?>
                        <tr>
                            <td><?php echo $barcode['price_barcode'] ?></td>
                            <td><?php echo $barcode['barcode_bg'] ?></td>
                            <td><?php echo $barcode['bprice_bg'] ?></td>
                            <td><?php echo $barcode['barcode_ro'] ?></td>
                            <td><?php echo $barcode['bprice_ro'] ?></td>
                            <td><?php echo $barcode['date'] ?></td>
                        </tr>        
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="mgn_big"  >
                Няма намерени записи 
                <div class="mgn_big sub_mgn"><?php echo $_POST['start'] . ' - ' . $_POST['end']; ?></div>
            </div>
            <div class="mgn_small">
                Резултати с дата: 
                <form action="index.php?view=export#" method="POST">
                    <button type="submit" class="return_bnt btn-success active">  <?php echo date('Y-m-d')  ?></button>
                </form>
            </div>
            <?php endif; ?>
            
            
        </div><!--content-panel -->
    </div><!--col-md-12 -->
</div> <!--row-->

<div class="row">
    <div class="col-md-12">
        <div class="export_bnt btn-success active">
            <form action="export&excel" method="POST">
                <input type='hidden' name='from' value="<?php echo $from ?>">
                <input type='hidden' name='to' value="<?php  echo $to ?>">
                <input type='hidden' name='export' value="1">
                <input type='submit'  value="Експорт">
            </form>
        </div>
    </div>
</div>
