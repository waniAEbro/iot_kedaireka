<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Cetak Pivot Summary</h3>
          </div>

          <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Jenis Barang</label>
                    <select id="jenis_barang" name="jenis_barang" multiple="multiple" class="form-control">
                      <option value="">-- Select Jenis Barang --</option>
                      <?php foreach ($jenis_barang->result() as $valap):?>
                        <option value="<?=$valap->id?>"><?=$valap->jenis_barang?></option>
                      <?php endforeach;?>
                    </select>
                  </div>              
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Warna</label>
                    <select id="warna" name="warna" multiple="multiple" class="form-control">
                      <option value="">-- Select Warna --</option>
                      <?php foreach ($warna->result() as $valap):?>
                        <option value="<?=$valap->id?>"><?=$valap->warna?></option>
                      <?php endforeach;?>
                    </select>
                  </div>              
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Bukaan</label>
                    <select id="bukaan" name="bukaan" multiple="multiple" class="form-control">
                      <option value="">-- Select Bukaan --</option>
                      <?php foreach ($bukaan->result() as $valap):?>
                        <option value="<?=$valap->id?>"><?=$valap->bukaan?></option>
                      <?php endforeach;?>
                    </select>
                  </div>              
                </div>
                

            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="box-tools pull-right">
                  <a class="btn btn-success" onclick="pivotstock()">Cetak Pivot Summary</a>
                </div>
               </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Cetak Pivot OTS (Blm Dikirim)</h3>
          </div>

          <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Jenis Barang</label>
                    <select id="jenis_barangx" name="jenis_barangx" multiple="multiple" class="form-control">
                      <option value="">-- Select Jenis Barang --</option>
                      <?php foreach ($jenis_barang->result() as $valap):?>
                        <option value="<?=$valap->id?>"><?=$valap->jenis_barang?></option>
                      <?php endforeach;?>
                    </select>
                  </div>              
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Warna</label>
                    <select id="warnax" name="warnax" multiple="multiple" class="form-control">
                      <option value="">-- Select Warna --</option>
                      <?php foreach ($warna->result() as $valap):?>
                        <option value="<?=$valap->id?>"><?=$valap->warna?></option>
                      <?php endforeach;?>
                    </select>
                  </div>              
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Bukaan</label>
                    <select id="bukaanx" name="bukaanx" multiple="multiple" class="form-control">
                      <option value="">-- Select Bukaan --</option>
                      <?php foreach ($bukaan->result() as $valap):?>
                        <option value="<?=$valap->id?>"><?=$valap->bukaan?></option>
                      <?php endforeach;?>
                    </select>
                  </div>              
                </div>
                

            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="box-tools pull-right">
                  <a class="btn btn-success" onclick="pivotots()">Cetak Pivot OTS</a>
                </div>
               </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript">
  $(document).ready(function() {
    
    $("select").select2();
  });

  function pivotstock () {
    var warna  = $('#warna').val();
    var jenis_barang  = $('#jenis_barang').val();
    var bukaan  = $('#bukaan').val();
    if (warna!=null && jenis_barang!=null && bukaan!=null) {
    var x = warna.toString();
    var warnax = x.replace(/\,/g, '-');
     var y = jenis_barang.toString();
    var jenis_barangy = y.replace(/\,/g, '-');
    var z = bukaan.toString();
    var bukaanz = z.replace(/\,/g, '-');
    var url = "<?=site_url('klg/pivot/cetakstock/"+warnax+"/"+jenis_barangy+"/"+bukaanz+"')?>";
    window.open(url, "_blank");
    } else{
      $.growl.error({ title: 'Gagal', message: 'Lengkapi Form!'});
    };
    
  }

  function pivotots () {
    var warna  = $('#warnax').val();
    var jenis_barang  = $('#jenis_barangx').val();
    var bukaan  = $('#bukaanx').val();
    if (warna!=null && jenis_barang!=null && bukaan!=null) {
    var x = warna.toString();
    var warnax = x.replace(/\,/g, '-');
     var y = jenis_barang.toString();
    var jenis_barangy = y.replace(/\,/g, '-');
    var z = bukaan.toString();
    var bukaanz = z.replace(/\,/g, '-');
    var url = "<?=site_url('klg/pivot/cetakots/"+warnax+"/"+jenis_barangy+"/"+bukaanz+"')?>";
    window.open(url, "_blank");
    } else{
      $.growl.error({ title: 'Gagal', message: 'Lengkapi Form!'});
    };
    
  }

</script>