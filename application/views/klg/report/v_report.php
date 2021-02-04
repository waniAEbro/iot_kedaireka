
<div class="row" id="form_pembelian">
  <div class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Report Status Quotation</h3>
      </div>
      <div class="box-body">
      <?php 
      $level = from_session('level');
       if ($level != '4') {
       
      ?>
        <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Dari Tanggal</label>
                <input type="text" data-date-format="yyyy-mm-dd" class="form-control datepicker" value="<?=$dari?>" id="dari_tgl" name="dari_tgl" placeholder="Date" required>
              </div>              
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Sampai Tanggal</label>
                <input type="text" data-date-format="yyyy-mm-dd" value="<?=$sampai?>" class="form-control datepicker" id="sampai_tgl" name="sampai_tgl" placeholder="Date" required>
              </div>              
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Select Brand</label>
                <select id="aplikator" name="aplikator" class="form-control select2" required>
                  <option value="">-- Select Brand --</option>
                  <?php foreach ($aplikator->result() as $valap):?>
                    <?php if($kode==$valap->id){$selected='selected';}else{$selected='';}?>
                    <option value="<?=$valap->id?>" <?=$selected?> >[<?=$valap->id?>] - <?=$valap->brand?></option>
                  <?php endforeach;?>
                </select>
              </div>              
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box-tools pull-right">
              <a class="btn btn-success" onclick="setAplikator()">Pilih Brand</a>
            </div>
           </div>
        </div>
        <?php } ?>
      </div>
      <div class="box-body">
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        <table id="datatable" style="display:none;">
          <thead>
            <tr>
              <th></th>
              <th>Report Rekap Status</th>
              
            </tr>
          </thead>
          <tbody>
          <tr>
            <td>Pending</td>
            <td><?=$g1?></td>
          </tr>
          <tr>
            <td>Deal</td>
            <td><?=$g2?></td>
          </tr>
          <tr>
            <td>Cancel</td>
            <td><?=$g3?></td>
          </tr>

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
  var dari_tgl   = $('#dari_tgl').val();
  if (dari_tgl != '') { var dari = dari_tgl; } else{ var dari = 'x'; };
  var sampai_tgl = $('#sampai_tgl').val();
  if (sampai_tgl != '') { var sampai = sampai_tgl; } else{ var sampai = 'x'; };
  var aplikator  = $('#aplikator').val();
  if (aplikator != '') { var kode = aplikator; } else{ var kode = 'x'; };
  load_silent("klg/report/diSet/"+kode+"/"+dari+"/"+sampai+"/","#content");
  
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
                text: 'Pendapatan'
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