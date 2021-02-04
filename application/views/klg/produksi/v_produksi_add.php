<div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Form Produksi</h3>

        <div class="box-tools pull-right">
          <button type="button" id="tutup" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <form method="post" class="form-vertical form_faktur" role="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Tanggal Produksi</label>
                <input type="hidden" value="<?=$no_produksi?>" class="form-control datepicker" id="no_produksi" readonly>
                <input type="text" data-date-format="yyyy-mm-dd" value="<?=date('Y-m-d')?>" class="form-control datepicker" id="tgl" placeholder="Tanggal Produksi" required>
              </div>             
            </div>
          </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" onclick="save()" id="proses" class="btn btn-success">Process</button>
        </div>
      </form>
    </div>

    <div class="row" id="form_pembelian">
      <div class="col-lg-3">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Input Item</h3>
          </div>
          <div class="div-pembelian">
            <form method="post" class="form-vertical form" role="form" id="formid">
              <div class="box-body">
                <div class="form-group">
                  <label>Item</label>
                  <select id="item" name="item" class="form-control" style="width:100%" required>
                    <option value="">-- Select Item --</option>
                    <?php foreach ($item as $val):?>
                      <option value="<?=$val->id?>"><?=$val->item?></option>
                    <?php endforeach;?>
                  </select>
                  <span id='gbritem'></span>
                  <span id='jenis_barang'></span>
                </div>
                <div class="form-group">
                  <label>Warna</label>
                  <select id="warna" name="warna" class="form-control" style="width:100%" required>
                    <option value="">-- Select Warna --</option>
                    <?php foreach ($warna as $val):?>
                      <option value="<?=$val->id?>"><?=$val->warna?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Bukaan:</label>
                  <select id="bukaan" name="bukaan" class="form-control" style="width:100%" required>
                    <option value="">-- Select Bukaan --</option>
                      <option value="R">R</option>
                      <option value="L">L</option>
                      <option value="-">tdk ada</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Lebar (mm):</label>
                  <input type="hidden" class="form-control" id="id_produksi" name="id_produksi" readonly>
                  <input type="text" style="text-align: right;" class="form-control" id="lebar" value="0" name="lebar" placeholder="Lebar" autocomplete="off" readonly>
                  <span id="infolebar"></span>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Tinggi (mm):</label>
                  <input type="text" style="text-align: right;" class="form-control" id="tinggi" value="0" name="tinggi" placeholder="Tinggi" autocomplete="off" readonly>
                  <span id="infotinggi"></span>
                </div>
                <div class="form-group harga">
                  <label class="control-label" for="merk">Harga:</label>
                  <input type="text" style="text-align: right;" class="form-control" id="harga" name="harga" placeholder="Harga" autocomplete="off">
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Quantity:</label>
                  <input type="text" style="text-align: right;" class="form-control" id="qty" name="qty" value="1" placeholder="Quantity" autocomplete="off" readonly>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Cek Kesesuaian Ukuran:</label>
                  <input type="text" class="form-control" id="cek1" name="cek1" autocomplete="off">
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Cek Kerapihan:</label>
                  <input type="text" class="form-control" id="cek2" name="cek2" autocomplete="off">
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Cek Kelengkapan Unit:</label>
                  <input type="text" class="form-control" id="cek3" name="cek3" autocomplete="off">
                </div>
                
                <div class="form-group">
                  <a onclick="quotation()"  class="btn btn-info">Add Produksi</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Saved Item</h3>
          </div>
          <div class="box-body">
            <table width="100%" id="tableku" class="table table-bordered table-striped" style="font-size: smaller;">
              <thead>
                <tr>
                  <th width="5%">Act</th>
                  <th width="10%">Number</th>
                  <th width="15%">Item</th>
                  <th width="10%">Ukuran</th>
                  <th width="10%">Warna</th>
                  <th width="5%">Bukaan</th>
                  <th width="5%">Quantity</th>
                </tr>
              </thead>
              <tbody id="dataTbl">
              </tbody>
            </table>
          </div>
          <div class="box-footer">
                <a onclick="finish()"  class="btn btn-success pull-right"> Finish</a>
            </div>
        </div>
      </div>
  </div>

<script language="javascript">
function finish() {
  if(confirm('Anda yakin ingin menyelesaikan?'))
  {
    $.growl.notice({ title: 'Berhasil', message: "Produksi selesai!"});
    load_silent("klg/produksi/","#content");
  }
}
$(document).ready(function() {
  $('.datepicker').datepicker({
    autoclose: true
  });

  $("select").select2();
  $(".harga").hide();
  
   $('#form_pembelian').hide();
});

function save()
{
  $(this).find("button[type='submit']").prop('disabled',true);
      $.ajax({
        type: "POST",
        url:site+'klg/produksi/saveProduksi',
        dataType:'json',
        data: {
            no_produksi          : $("#no_produksi").val(),
            tgl          : $("#tgl").val(),
          
        },
        success   : function(data)
        {
          $('#id_produksi').val(data['id']);
          $.growl.notice({ title: 'Sukses', message: data['msg']});
          $('#tutup').click();
          $('#form_pembelian').show(1000);
        }
      });
          return false;
  
}

var xi = 0;


$('#formid').on('keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if(e.keyCode==13 || e.keyCode==9){
    e.preventDefault();    
    quotation();
  }
});
function quotation() {

  if ($('#cek1').val() !='' && $('#cek2').val() !='' && $('#cek3').val() !='' && $('#id_produksi').val() !='' && $('#item').val() !='' && $('#bukaan').val() !='' && $('#warna').val() != '' && $('#lebar').val() != '' && $('#tinggi').val() != '' && $('#qty').val() !='') 
  {

                  $.ajax({
                      type: "POST",
                      url: "<?=site_url('klg/produksi/saveProduksiDetail')?>",
                      dataType:'json',
                      data: {
                        'id_produksi'      : $('#id_produksi').val(),
                        'item'            : $("#item").val(),
                        'warna'           : $("#warna").val(),
                        'bukaan'          : $("#bukaan").val(),
                        'lebar'            : $("#lebar").val(),
                        'tinggi'          : $("#tinggi").val(),
                        'harga'         : $("#harga").val(),
                        'cek1'       : $("#cek1").val(),
                        'cek2'       : $("#cek2").val(),
                        'cek3'       : $("#cek3").val(),
                        'qty'            : $("#qty").val(),
                      },
                    })
                    .success(function(datasaved)
                    {
                  //code here
                  xi++;
                  var i = datasaved['id'];
                  

                  var x = '<tr id="output_data_'+i+'" class="output_data">\
                  <td width="5%" align="center">\
                    <a href="javascript:void(0)" onClick="hapus('+i+')">\
                      <i class="fa fa-trash"></i>\
                    </a>\
                  </td>\
                  <td width="10%">\
                    '+datasaved['nomor']+'\
                  </td>\
                  <td width="15%">\
                    '+$('#item :selected').text()+'\
                  </td>\
                  <td width="10%">\
                    '+$('#lebar').val()+'x'+$('#tinggi').val()+'\
                  </td>\
                  <td width="10%">\
                    '+$('#warna :selected').text()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#bukaan').val()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#qty').val()+'\
                  </td>\
                </tr>';
                $('tr.odd').remove();
                $('#dataTbl').append(x);
                $('#item').val('').trigger('change');
                $('#warna').val('').trigger('change');
                $('#bukaan').val('').trigger('change');
                $('#lebar').val('');
                $('#harga').val('');
                $('#tinggi').val('');
                $('#cek1').val('');
                $('#cek2').val('');
                $('#cek3').val('');
                $("#gbritem").html('');
                $.growl.notice({ title: 'Sukses', message: "Berhasil menyimpan Produksi"});
                
              })
.fail(function(XHR){
  if (XHR.readyState==0) {
    $.growl.error({ title: 'Peringatan', message: 'Terjadi Kesalahan! KONEKSI TERPUTUS' });
    $('#jumlah').val('');
  }else{
    $.growl.error({ title: 'Peringatan', message: 'Terjadi Kesalahan! UNKNOWN ERROR' });
    $('#jumlah').val('');
  }
});



  } else{$.growl.error({ title: 'Peringatan', message: 'Lengkapi Form dulu!' });};
}

function hapus(i)
{
  if(confirm('Lanjutkan Proses Hapus?'))
  {
    $.ajax({
      type: "POST",
      url: "<?=site_url('klg/produksi/deleteItem')?>",
      dataType:'json',
      data: {        
        'id' : i
      }
    })
    .success(function(datasaved)
    {
      $.growl.notice({ title: 'Sukses', message: datasaved.msg});
      $('#output_data_'+i).remove();
      hitungJml(xi);
    });    
  }
}


$("#item").change(function(){
      $('#bukaan').val('').trigger('change');
      $.ajax({
        url      : "<?= site_url('klg/produksi/getDetailItem/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "item" : $(this).val(),
        },
        success  : function(img){
           $("#gbritem").html('<div class="form-group"> <label class="control-label">Picture : </label> <img style="padding:10px;" src="<?php echo base_url()."'+img['gambar']+'"; ?>" class="file-preview-image"></div>');
            
              $('#lebar').val(img['lebar']);
              $('#tinggi').val(img['tinggi']);
              $('#harga').val(img['harga']);
              $('#jenis_barang').html('Jenis Barang : '+img['jenis_barang']);
              
             
          }
      });

  
  });
</script>