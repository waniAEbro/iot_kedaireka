
<div class="row">
  <div class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Laporan Penjualan</h3>
      </div>
      <div class="box-body">
      <?php 
      $level = from_session('level');
       if ($level != '4') {
       
      ?>
        <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Select Store</label>
                <select id="store" name="store" class="form-control select2">
                  <option value="">-- All Store --</option>
                  <?php foreach ($store->result() as $valap):?>
                    <?php if($store_skr==$valap->id){$selected='selected';}else{$selected='';}?>
                    <option value="<?=$valap->id?>" <?=$selected?> ><?=$valap->store?></option>
                  <?php endforeach;?>
                </select>
              </div>              
            </div>
            <div class="col-md-4">
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
            <div class="col-md-4">
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
              <th>Grafik Rekap Produksi Item Common</th>
              
            </tr>
          </thead>
          <tbody>
          <?php foreach ($item->result() as $key) {
            $jml_produksi = @$produksi[$key->id];
            if ($jml_produksi < 1) {
              $jml = 0;
            } else {
              $jml = $jml_produksi;
            }
            
           ?>
          <tr>
            <td><?=$key->item?></td>
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
  var store = $('#store').val();
  if (store != '') { var str = store; } else{ var str = '<?=$store_skr?>'; };
  var tahun = $('#tahun').val();
  if (tahun != '') { var thn = tahun; } else{ var thn = '<?=$tahun?>'; };
  var bulan  = $('#bulan').val();
  if (bulan != '') { var bln = bulan; } else{ var bln = '<?=$bulan_skr?>'; };
  load_silent("warehouse/laporan/diSet/"+str+"/"+bln+"/"+thn+"/","#content");
  
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
                text: 'Jml Produksi'
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