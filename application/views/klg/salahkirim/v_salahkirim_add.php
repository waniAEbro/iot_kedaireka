    <div class="row" id="form_pembelian">
      <div class="col-lg-3">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Salah Kirim</h3>
          </div>
          <div class="div-pembelian">
            <form method="post" class="form-vertical form" role="form" id="formid">
              <div class="box-body">
                <div class="form-group">
                  <label>No Surat Jalan</label>
                  <select id="id_pengiriman" name="id_pengiriman" class="form-control" style="width:100%" required>
                    <option value="">-- Select No Surat Jalan --</option>
                    <?php foreach ($no_pengiriman as $val):?>
                      <option value="<?=$val->id?>"><?=$val->no_pengiriman?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">No Permintaan:</label>
                  <input type="text" class="form-control" id="no_permintaan" name="no_permintaan" readonly>
                  <input type="hidden" class="form-control" id="id_surat_jalan" name="id_surat_jalan" readonly>
                </div>
                <div class="form-group">
                  <label>Item</label>
                  <select id="item" name="item" class="form-control" style="width:100%" required>
                    <option value="">-- Select Item --</option>
                  </select>
                  <span id='gbritem'></span>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Lebar (mm):</label>
                  <input type="hidden" class="form-control" id="id_produksi" name="id_produksi" readonly>
                  <input type="text" style="text-align: right;" class="form-control" id="lebar" value="0" name="lebar" placeholder="Lebar" autocomplete="off" readonly>
                  <span id="infolebar"></span>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Tinggi (mm):</label>
                  <input type="hidden" class="form-control" id="id_item" name="id_item" readonly>
                  <input type="hidden" class="form-control" id="id_tipe" name="id_tipe" readonly>
                  <input type="hidden" class="form-control" id="id_warna" name="id_warna" readonly>
                  <input type="hidden" class="form-control" id="bukaan" name="bukaan" readonly>
                  <input type="text" style="text-align: right;" class="form-control" id="tinggi" value="0" name="tinggi" placeholder="Tinggi" autocomplete="off" readonly>
                  <span id="infotinggi"></span>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Quantity:</label>
                  <input type="text" style="text-align: right;" class="form-control" id="qty" name="qty" placeholder="Quantity" autocomplete="off">
                  <span id="qtyKirim"></span>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Keterangan:</label>
                  <input type="text" class="form-control" id="ket_detail" name="ket_detail" autocomplete="off">
                </div>
                
                <div class="form-group">
                  <a onclick="quotation()"  class="btn btn-info">Add salahkirim</a>
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
                  <th width="25%">Item</th>
                  <th width="5%">Lebar</th>
                  <th width="5%">Tinggi</th>
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
    $.growl.notice({ title: 'Berhasil', message: "Quotation selesai!"});
    load_silent("klg/salahkirim/","#content");
  }
}
$(document).ready(function() {
  $('.datepicker').datepicker({
    autoclose: true
  });

  $("select").select2();
  $(".harga").hide();
  
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
                      url: "<?=site_url('klg/salahkirim/savesalahkirimDetail')?>",
                      dataType:'json',
                      data: {
                        'id_surat_jalan'            : $("#id_surat_jalan").val(),
                        'item'            : $("#id_item").val(),
                        'tipe'           : $("#id_tipe").val(),
                        'warna'           : $("#id_warna").val(),
                        'bukaan'          : $("#bukaan").val(),
                        'lebar'            : $("#lebar").val(),
                        'tinggi'          : $("#tinggi").val(),
                        'keterangan'       : $("#ket_detail").val(),
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
                  <td width="25%">\
                    '+$('#item :selected').text()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#lebar').val()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#tinggi').val()+'\
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
                $.growl.notice({ title: 'Sukses', message: "Berhasil menyimpan salahkirim"});
                
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
        url      : "<?=site_url('klg/salahkirim/getItemInvoice')?>",
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

// $("select[name=item]").change(function(){
//     var x = $("select[name=warna]");
//     if($(this).val() == "") {
//       x.html("<option>-- Select Warna --</option>");
//     }
//     else {
//       z = "<option>-- Select Warna --</option>";
//       $.ajax({
//         url      : "<?=site_url('klg/salahkirim/getWarnaItem')?>",
//         dataType : "json",
//         type     : "POST",
//         data     : { 
//           "id_invoice" : $('#id_pengiriman').val(),
//           "id_item" : $(this).val(), 
//         },
//         success  : function(data){

//           var z = "<option value=''>-- Select Warna --</option>";
//           for(var i = 0; i<data.length; i++){
//             z += '<option value='+data[i].id+'>'+data[i].warna+'</option>';
//           }

//           x.html(z);
//           $('#bukaan').val('').trigger('change');         
//         }
//       });

//     }
//   });

// $("select[name=warna]").change(function(){
//     var x = $("select[name=bukaan]");
//     if($(this).val() == "") {
//       x.html("<option>-- Select Bukaan --</option>");
//     }
//     else {
//       z = "<option>-- Select Bukaan --</option>";
//       $.ajax({
//         url      : "<?=site_url('klg/salahkirim/getBukaanItem')?>",
//         dataType : "json",
//         type     : "POST",
//         data     : { 
//           "id_invoice" : $('#id_pengiriman').val(),
//           "id_item" : $('#item').val(),  
//           "id_warna" : $(this).val()  
//         },
//         success  : function(data){

//           var z = "<option value=''>-- Select Bukaan --</option>";
//           for(var i = 0; i<data.length; i++){
//             z += '<option value='+data[i].bukaan+'>'+data[i].bukaan+'</option>';
//           }

//           x.html(z);         
//         }
//       });

//     }
//   });

// $("#bukaan").change(function(){
//       $.ajax({
//         url      : "<?= site_url('klg/salahkirim/getLebarTinggi/')?>",
//         dataType : "json",
//         type     : "POST",
//         data     : { 
//           "id_invoice" : $('#id_pengiriman').val(),
//           "id_item" : $('#item').val(),  
//           "id_warna" : $('#warna').val(),
//           "bukaan" : $(this).val(),
//         },
//         success  : function(img){
//            $('#lebar').val(img['lebar']);
//             $('#tinggi').val(img['tinggi']);
//             $('#qtyKirim').html('<font color="blue">Qty Terkirim = '+img['qty']+'</font>');
//           }
//       });

  
//   });

$("#item").change(function(){
      $.ajax({
        url      : "<?= site_url('klg/salahkirim/getDetailInvoice/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "id" : $(this).val(),
        },
        success  : function(img){
           $('#id_item').val(img['id_item']);
           $('#id_tipe').val(img['id_tipe']);
           $('#id_warna').val(img['id_warna']);
           $('#bukaan').val(img['bukaan']);
           $('#lebar').val(img['lebar']);
            $('#tinggi').val(img['tinggi']);
            $('#qtyKirim').html('<font color="blue">Qty Terkirim = '+img['qty']+'</font>');
          }
      });

  
  });

$("#id_pengiriman").change(function(){
      $.ajax({
        url      : "<?= site_url('klg/salahkirim/getNoInvoice/')?>",
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
</script>