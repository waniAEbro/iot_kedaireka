    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
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
                        <label>No Retur</label>
                        <input type="text" class="form-control" value="<?=$row->no_retur?>" id="no_retur" name="no_retur" autocomplete="off" readonly>
                    </div>              
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Retur</label>
                        <select id="jenis_retur" name="jenis_retur" class="form-control" style="width:100%" required>
                          <option value="">-- Select Jenis Retur --</option>
                          <?php foreach ($jenis_retur as $val):?>
                            <?php if($valap->id==$row->id_jenis_retur){$selb="selected";}else{$selb="";}?>
                            <option value="<?=$val->id?>" <?=$selb?>><?=$val->jenis_retur?></option>
                          <?php endforeach;?>
                        </select>
                    </div>              
                  </div>
                 </div>
                 <div class="row tglkirim">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label>Tanggal Pengiriman</label>
                        <input type="text" data-date-format="yyyy-mm-dd" value="<?=$row->tgl_kirim?>" class="form-control datepicker" id="tgl_kirim" placeholder="Tanggal Pengiriman" required>
                    </div>              
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label>Store</label>
                        <select id="store" name="store" class="form-control" style="width:100%" required>
                          <option value="">-- Select Store --</option>
                          <?php foreach ($store as $val):?>
                            <?php if($val->id==$row->id_store){$selc="selected";}else{$selc="";}?>
                            <option value="<?=$val->id?>" <?=$selc?>><?=$val->store?></option>
                          <?php endforeach;?>
                        </select>
                    </div>              
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label>Item</label>
                        <select id="item" name="item" class="form-control" style="width:100%" required>
                          <option value="">-- Select Item --</option>
                        </select>
                    </div>              
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="merk">Lebar (mm):</label>
                        <input type="text" style="text-align: right;" class="form-control" id="lebar" value="0" name="lebar" placeholder="Lebar" autocomplete="off" readonly>
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
                      <input type="text" style="text-align: right;" class="form-control" id="tinggi" value="0" name="tinggi" placeholder="Tinggi" autocomplete="off" readonly>
                      <span id="infotinggi"></span>
                    </div>              
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="merk">Quantity:</label>
                        <input type="text" style="text-align: right;" class="form-control" id="qty" name="qty" placeholder="Quantity" autocomplete="off">
                        <span id="qtyKirim"></span>
                    </div>              
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="merk">Keterangan:</label>
                        <input type="text" class="form-control" id="ket_detail" name="ket_detail" autocomplete="off">
                    </div>              
                  </div>
                </div>
                <hr>
                <div class="box-header with-border">
                  <h3 class="box-title jdl">Item Pengganti</h3>
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
                          <option value="-">tdk ada</option>
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
  $("#qty").blur(function(){
    $("#qty_baru").val($("#qty").val());
  });
  $(".tglkirim").hide();
  $('.datepicker').datepicker({
    autoclose: true
  });
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



$("select[name=store]").change(function(){
    var x = $("select[name=item]");
    if($(this).val() == "") {
      x.html("<option>-- Select Item --</option>");
    }
    else {
      z = "<option>-- Select Item --</option>";
      $.ajax({
        url      : "<?=site_url('klg/retur/getItemStore')?>",
        dataType : "json",
        type     : "POST",
        data     : { "id" : $(this).val() },
        success  : function(data){

          var z = "<option value=''>-- Select Item --</option>";
          for(var i = 0; i<data.length; i++){
            z += '<option value='+data[i].id+'>'+data[i].item+'-'+data[i].tipe+' ('+data[i].lebar+'x'+data[i].tinggi+') '+'-'+data[i].warna+'-'+data[i].bukaan+'</option>';
          }

          x.html(z);
          // $('#warna').val('').trigger('change');
          // $('#bukaan').val('').trigger('change');         
        }
      });

    }
  });

$("#jenis_retur").change(function(){
      if ($(this).val() == 2) {
        $(".tglkirim").show(50);
      } else{
        $(".tglkirim").hide(50);
      };

      if ($(this).val() == 3) {
        $(".jdl").html('Item Kanibal (baru)');
      } else{
        $(".jdl").html('Item Pengganti');
      };

  
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

function quotation() {
  if ($('#item').val() !='' && $('#lebar').val() != '' && $('#tinggi').val() != '' && $('#qty').val() !=''  ) 
  {

                  $.ajax({
                      type: "POST",
                      url: "<?=site_url('klg/retur/savereturDetail')?>",
                      dataType:'json',
                      data: {
                        
                        'no_retur'       : $("#no_retur").val(),
                        'jenis_retur'    : $("#jenis_retur").val(),
                        'tgl_kirim'       : $("#tgl_kirim").val(),
                        'id_store'       : $("#store").val(),
                        'id_invoice'     : $("#id_invoice").val(),
                        'item'           : $("#id_item").val(),
                        'tipe'           : $("#id_tipe").val(),
                        'warna'          : $("#id_warna").val(),
                        'bukaan'         : $("#bukaan").val(),
                        'lebar'          : $("#lebar").val(),
                        'tinggi'         : $("#tinggi").val(),
                        'keterangan'     : $("#ket_detail").val(),
                        'qty'            : $("#qty").val(),
                        
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
                  
                $.growl.notice({ title: 'Sukses', message: "Berhasil menyimpan Retur"});
                load_silent("klg/retur/","#content");
                
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
</script>