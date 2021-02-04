    <div class="row" id="form_pembelian">
      <div class="col-lg-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Input Retur</h3>
          </div>
          <div class="div-pembelian">
            <form method="post" class="form-vertical form" role="form" id="formid">
              <div class="box-body">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>No Surat Jalan</label>
                        <input type="text" class="form-control" name="xq" value="<?=$row->no_pengiriman?>" readonly>
                    </div>              
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="merk">No Permintaan:</label>
                        <input type="text" class="form-control" id="no_permintaan" name="no_permintaan" readonly>
                        <input type="hidden" class="form-control" id="id_surat_jalan" name="id_surat_jalan" readonly>
                    </div>              
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Item</label>
                        <input type="text" class="form-control" name="xqa" value="<?=$row->item?>" readonly>
                    </div>              
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipe</label>
                        <input type="text" class="form-control" name="xdsqa" value="<?=$row->tipe?>" readonly>
                    </div>              
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Warna</label>
                        <input type="text" class="form-control" name="xqaa" value="<?=$row->warna?>" readonly>
                    </div>              
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Bukaan</label>
                        <input type="text" class="form-control" name="xqsa" value="<?=$row->bukaan?>" readonly>
                    </div>              
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="merk">Lebar (mm):</label>
                        <input type="text" style="text-align: right;" class="form-control" id="lebar" value="<?=$row->lebar?>" name="lebar" placeholder="Lebar" autocomplete="off" readonly>
                        <span id="infolebar"></span>
                    </div>              
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label" for="merk">Tinggi (mm):</label>
                      <input type="hidden" class="form-control" id="id_invoice" name="id_invoice" readonly>
                      <input type="hidden" class="form-control" id="id_item" name="id_item" readonly>
                      <input type="hidden" class="form-control" id="id_tipe" name="id_tipe" readonly>
                      <input type="hidden" class="form-control" id="id_warna" name="id_warna" readonly>
                      <input type="hidden" class="form-control" id="bukaan" name="bukaan" readonly>
                      <input type="text" style="text-align: right;" class="form-control" id="tinggi" value="<?=$row->tinggi?>" name="tinggi" placeholder="Tinggi" autocomplete="off" readonly>
                      <span id="infotinggi"></span>
                    </div>              
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="merk">Quantity:</label>
                        <input type="text" style="text-align: right;" class="form-control" id="qty" name="qty" value="<?=$row->qty?>" placeholder="Quantity" autocomplete="off" readonly>
                        <span id="qtyKirim"></span>
                    </div>              
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="merk">Keterangan:</label>
                        <input type="text" class="form-control" id="ket_detail" name="ket_detail" value="<?=$row->keterangan?>" autocomplete="off" readonly>
                    </div>              
                  </div>
                </div>
                <hr>
                <div class="box-header with-border">
                  <h3 class="box-title">Item Pengganti</h3>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Tipe Permintaan</label>
                      <select id="tipe_baru" name="tipe_baru" class="form-control" style="width:100%" required>
                        <option value="">-- Tipe Permintaan --</option>
                        <?php foreach ($tipe_invoice as $valap):?>
                          <?php if($valap->id=='1'){$sel = "selected";}else{$sel = "";}?>
                          <option value="<?=$valap->id?>" <?=$sel?>><?=$valap->tipe?></option>
                        <?php endforeach;?>
                      </select>
                    </div>              
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Item</label>
                      <select id="item_baru" name="item_baru" class="form-control" style="width:100%" required>
                        <option value="">-- Select Item --</option>
                        <?php foreach ($item as $val):?>
                          <option value="<?=$val->id?>"><?=$val->item?></option>
                        <?php endforeach;?>
                      </select>
                    </div>              
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Warna</label>
                      <select id="warna_baru" name="warna_baru" class="form-control" style="width:100%" required>
                        <option value="">-- Select Warna --</option>
                        <?php foreach ($warna as $val):?>
                          <option value="<?=$val->id?>"><?=$val->warna?></option>
                        <?php endforeach;?>
                      </select>
                    </div>              
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label" for="merk">Bukaan:</label>
                      <select id="bukaan_baru" name="bukaan_baru" class="form-control" style="width:100%" required>
                        <option value="">-- Select Bukaan --</option>
                          <option value="R">R</option>
                          <option value="L">L</option>
                      </select>
                    </div>              
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label" for="merk">Lebar (mm):</label>
                      <input type="text" style="text-align: right;" class="form-control" id="lebar_baru" value="0" name="lebar_baru" placeholder="Lebar" autocomplete="off" readonly>
                      <span id="infolebar"></span>
                    </div>              
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label" for="merk">Tinggi (mm):</label>
                      <input type="text" style="text-align: right;" class="form-control" id="tinggi_baru" value="0" name="tinggi_baru" placeholder="Tinggi" autocomplete="off" readonly>
                      <span id="infotinggi"></span>
                    </div>              
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group harga_baru">
                      <label class="control-label" for="merk">Harga:</label>
                      <input type="text" style="text-align: right;" class="form-control" id="harga_baru" name="harga_baru" placeholder="Harga" autocomplete="off">
                    </div>              
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label" for="merk">Quantity:</label>
                      <input type="hidden" class="form-control" id="id_retur" name="id_retur" value="<?=$id_retur?>">
                      <input type="text" style="text-align: right;" class="form-control" id="qty_baru" name="qty_baru" placeholder="Quantity" autocomplete="off">
                    </div>              
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                    </div>              
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                    </div>              
                  </div>
                </div> 
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="form-group">
                        <a onclick="quotation()"  class="btn btn-info">Add Retur</a>
                      </div>
                    </div>              
                  </div>
                </div>
                
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Saved Item</h3>
          </div>
          <div class="box-body">
            <table width="100%" id="tableku" class="table table-bordered table-striped" style="font-size: smaller;">
              <thead>
                <tr>
                  <th width="5%">Act</th>
                  <th width="25%">Item</th>
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
    $.growl.notice({ title: 'Berhasil', message: "Retur selesai!"});
    load_silent("klg/retur/","#content");
  }
}
$(document).ready(function() {
  $('.datepicker').datepicker({
    autoclose: true
  });

  $("select").select2();
  $(".harga").hide();
  $('.harga_baru').hide()
  // $('.form_pembelian').hide();
});


var xi = 0;


$('#formid').on('keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if(e.keyCode==13 || e.keyCode==9){
    e.preventDefault();    
    quotation();
  }
});
function quotation() {
  if ($('#item').val() !='' && $('#lebar').val() != '' && $('#tinggi').val() != '' && $('#qty').val() !=''  ) 
  {

                  $.ajax({
                      type: "POST",
                      url: "<?=site_url('klg/retur/editreturDetail')?>",
                      dataType:'json',
                      data: {
                        'id_retur' : $("#id_retur").val(),
                        
                        'tipe_baru'      : $("#tipe_baru").val(),
                        'item_baru'      : $("#item_baru").val(),
                        'warna_baru'     : $("#warna_baru").val(),
                        'bukaan_baru'    : $("#bukaan_baru").val(),
                        'lebar_baru'     : $("#lebar_baru").val(),
                        'tinggi_baru'    : $("#tinggi_baru").val(),
                        'harga_baru'     : $("#harga_baru").val(),
                        'qty_baru'       : $("#qty_baru").val(),
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
                  <td width="25%">\
                    '+$('#item :selected').text()+' ('+$('#lebar').val()+'x'+$('#tinggi').val()+')\
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
                $('#qty').val('');
                $.growl.notice({ title: 'Sukses', message: "Berhasil menyimpan Retur"});
                
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

$("select[name=id_pengiriman]").change(function(){
    var x = $("select[name=item]");
    if($(this).val() == "") {
      x.html("<option>-- Select Item --</option>");
    }
    else {
      z = "<option>-- Select Item --</option>";
      $.ajax({
        url      : "<?=site_url('klg/retur/getItemInvoice')?>",
        dataType : "json",
        type     : "POST",
        data     : { "id" : $(this).val() },
        success  : function(data){

          var z = "<option value=''>-- Select Item --</option>";
          for(var i = 0; i<data.length; i++){
            z += '<option value='+data[i].id+'>'+data[i].item+'-'+data[i].tipe+'-'+data[i].warna+'-'+data[i].bukaan+'</option>';
          }

          x.html(z);
          // $('#warna').val('').trigger('change');
          // $('#bukaan').val('').trigger('change');         
        }
      });

    }
  });



$("#item").change(function(){
      $.ajax({
        url      : "<?= site_url('klg/retur/getDetailInvoice/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "id" : $(this).val(),
        },
        success  : function(img){
           $('#id_invoice').val(img['id_invoice']);
           $('#id_item').val(img['id_item']);
           $('#id_tipe').val(img['id_tipe']);
           $('#id_warna').val(img['id_warna']);
           $('#bukaan').val(img['bukaan']);
           $('#lebar').val(img['lebar']);
            $('#tinggi').val(img['tinggi']);
            $('#qty').val(img['qty']);
            $('#qty_baru').val(img['qty']);
            $('#qtyKirim').html('<font color="blue">Qty Terkirim = '+img['qty']+'</font>');
          }
      });

  
  });

$("#id_pengiriman").change(function(){
      $.ajax({
        url      : "<?= site_url('klg/retur/getNoInvoice/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "id" : $(this).val(),
        },
        success  : function(img){
           $('#no_permintaan').val(img['no_invoice']);
            $('#id_surat_jalan').val(img['id_surat_jalan']);
          }
      });

  
  });

$("#tipe_baru").change(function(){
    if ($(this).val()==2) {
      $('#lebar_baru').attr('readonly', false);
      $('#tinggi_baru').attr('readonly', false);
      $('.harga_baru').show(50);
      $('#lebar_baru').val(0);
      $('#tinggi_baru').val(0);
      $('#harga_baru').val(0);
    }else{
      $('#lebar_baru').attr('readonly', true);
      $('#tinggi_baru').attr('readonly', true);
      $('#harga_baru').val('0');
      $('.harga_baru').hide(50);
    }
});

$("#item_baru").change(function(){
      $.ajax({
        url      : "<?= site_url('klg/invoice/getDetailItem/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "item" : $(this).val(),
        },
        success  : function(img){
           if ($("#tipe_baru").val()==1) {
              $('#lebar_baru').val(img['lebar']);
              $('#tinggi_baru').val(img['tinggi']);
              $('#harga_baru').val(img['harga']);
            } 
          }
      });

  
  });
</script>