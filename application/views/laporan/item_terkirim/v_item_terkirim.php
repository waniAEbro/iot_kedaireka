
<div class="row">
  <div class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Grafik Item Terkirim</h3>
      </div>
      <div class="box-body">
      <?php 
      $level = from_session('level');
       if ($level != '4') {
       
      ?>
        <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Select Bulan</label>
                <select id="bulan" name="bulan" class="form-control select2">
                  <option value="">-- Select Bulan --</option>
                  <?php foreach ($bulan->result() as $valap):?>
                    <?php if($bulan_skr==$valap->bulan){$selected='selected';}else{$selected='';}?>
                    <option value="<?=$valap->bulan?>" <?=$selected?> ><?=$valap->nama_bulan?></option>
                  <?php endforeach;?>
                </select>
              </div>              
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Tahun</label>
                <input type="text" class="form-control datepicker" value="<?=$tahun?>" id="tahun" name="tahun" placeholder="Tahun">
              </div>              
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box-tools pull-right">
              <a class="btn btn-success" onclick="setAplikator()">Filter</a>
            </div>
           </div>
        </div>
        <?php } ?>
      </div>
      <div class="box-body">
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        <table id="datatable" class="table table-striped" style="display:;">
          <thead>
            <tr style="display:none;">
              <th></th>
              <th>Grafik Rekap Item Terkirim ke Store</th>
              
            </tr>
          </thead>
          <tbody>
          <?php foreach ($store->result() as $key) {
            $jml_terkirim = @$terkirim[$key->id];
            if ($jml_terkirim < 1) {
              $jml = 0;
            } else {
              $jml = $jml_terkirim;
            }
            
           ?>
          <tr>
            <td><?=$key->store?></td>
            <td><?=$jml?></td>
          </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>
        <div class="clearfix"></div>
        <div class="or-spacer">
          <div class="mask"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script language="javascript">
$(document).ready(function() {
  $('select').select2();
  $('.datepicker').datepicker({
    autoclose: true
  });
});

function setAplikator (argument) {
  var tahun = $('#tahun').val();
  if (tahun != '') { var thn = tahun; } else{ var thn = '<?=$tahun?>'; };
  var bulan  = $('#bulan').val();
  if (bulan != '') { var bln = bulan; } else{ var bln = '<?=$bulan_skr?>'; };
  load_silent("laporan/item_terkirim/diSet/"+bln+"/"+thn+"/","#content");
  
}

$('#container').highcharts({
        data: {
            table: 'datatable'
        },
        chart: {
            type: 'column'
        },
        lang : {
            decimalPoint: '.',
            thousandsSep: " "
        },
        title: {
            text: ''
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Item Terkirim'
            }
        },
        tooltip: {
            formatter: function () {
                return '<b>' + 'Jumlah' + '</b><br/>' +
                    this.point.y + ' ' + this.point.name.toLowerCase();
            }
        }
        });
</script>