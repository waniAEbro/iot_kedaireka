<div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Form Retur</h3>

        <div class="box-tools pull-right">
          <button type="button" id="tutup" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <form method="post" class="form-vertical form_faktur" role="form">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>No Retur</label>
                <input type="text" class="form-control" id="no_retur" name="no_retur" value="<?=$no_retur?>" placeholder="No Invoice" readonly required>
              </div>              
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label>Jenis Retur</label>
                  <select id="jenis_retur" name="jenis_retur" class="form-control" style="width:100%" required>
                    <option value="">-- Select Jenis Retur --</option>
                    <?php foreach ($jenis_retur as $val):?>
                      <option value="<?=$val->id?>"><?=$val->jenis_retur?></option>
                    <?php endforeach;?>
                  </select>
              </div>              
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label>Alasan Retur</label>
                  <select id="alasan_retur" name="alasan_retur" class="form-control" style="width:100%" required>
                    <option value="">-- Select Jenis Retur --</option>
                    <?php foreach ($alasan_retur as $val):?>
                      <option value="<?=$val->id?>"><?=$val->alasan_retur?></option>
                    <?php endforeach;?>
                  </select>
              </div>              
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Store/Mitra</label>
                <select id="store" name="store" class="form-control" style="width:100%" required>
                  <option value="">-- Store/Mitra --</option>
                  <?php foreach ($store as $valap):?>
                    <option value="<?=$valap->id?>"><?=$valap->store?></option>
                  <?php endforeach;?>
                </select>
              </div>              
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Tanggal Penarikan</label>
                <input type="text" data-date-format="yyyy-mm-dd" class="form-control datepicker" id="tgl_penarikan" placeholder="Tanggal Penarikan" required>
              </div>             
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Keterangan</label>
                <input type="text" class="form-control" id="keterangan" placeholder="Keterangan">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Upload Lampiran</label>
                <?php echo form_upload(array('name'=>'lampiran','id'=>'lampiran'));?>
                <span style="color:red">*) Lampiran File berformat .pdf|.jpg|.jpeg|.png maks 2MB</span>
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
      <div class="col-lg-4">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Item Retur</h3>
          </div>
          <div class="div-pembelian">
            <form method="post" class="form-vertical form" role="form" id="formid">
              <div class="box-body">
                <div class="form-group">
                  <label>Item</label>
                  <select id="item" name="item" class="form-control" style="width:100%" required>
                    <option value="">-- Select Item --</option>
                  </select>
                  <span id='gbritem'></span>
                  <span id='jenis_barang'></span>
                </div>
                <div class="form-group" style="display:none;">
                  <input type="text" class="form-control" id="id_tipe" name="id_tipe" readonly>
                  <input type="text" class="form-control" id="id_item" name="id_item" readonly>
                  <input type="text" class="form-control" id="id_warna" name="id_warna" readonly>
                  <input type="text" class="form-control" id="bukaan" name="bukaan" readonly>
                  <input type="text" class="form-control" id="lebar" name="lebar" readonly>
                  <input type="text" class="form-control" id="tinggi" name="tinggi" readonly>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Quantity:</label>
                  <input type="hidden" class="form-control" id="id_retur" name="id_retur" readonly>
                  <input type="text" style="text-align: right;" class="form-control" id="qty" name="qty" placeholder="Quantity" autocomplete="off">
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Keterangan:</label>
                  <input type="text" class="form-control" id="ket_detail" name="ket_detail" autocomplete="off">
                </div>
              </div>
            </form>
          </div>
          <div class="div-pengembalian">
          <div class="box-header with-border">
            <h3 class="box-title">Item Pengganti</h3>
          </div>
            <form method="post" class="form-vertical form" role="form" id="formid">
              <div class="box-body">
                <div class="form-group">
                  <label>Tipe Item</label>
                  <select id="tipe_item" name="tipe_item" class="form-control" style="width:100%" required>
                    <option value="">-- Tipe Item --</option>
                    <?php foreach ($tipe_item as $valap):?>
                      <option value="<?=$valap->id?>"><?=$valap->tipe?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Item</label>
                  <select id="item_baru" name="item_baru" class="form-control" style="width:100%" required>
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
                  <select id="warna_baru" name="warna_baru" class="form-control" style="width:100%" required>
                    <option value="">-- Select Warna --</option>
                    <?php foreach ($warna as $val):?>
                      <option value="<?=$val->id?>"><?=$val->warna?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Bukaan:</label>
                  <select id="bukaan_baru" name="bukaan_baru" class="form-control" style="width:100%" required>
                    <option value="">-- Select Bukaan --</option>
                      <option value="R">R</option>
                      <option value="L">L</option>
                      <option value="-">tdk ada</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Lebar (mm):</label>
                  <input type="text" style="text-align: right;" class="form-control" id="lebar_baru" value="0" name="lebar_baru" placeholder="Lebar" autocomplete="off" readonly>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Tinggi (mm):</label>
                  <input type="text" style="text-align: right;" class="form-control" id="tinggi_baru" value="0" name="tinggi_baru" placeholder="Tinggi" autocomplete="off" readonly>
                </div>                
                <div class="form-group">
                  <label class="control-label" for="merk">Quantity:</label>
                  <input type="text" style="text-align: right;" class="form-control" id="qty_baru" name="qty_baru" placeholder="Quantity" autocomplete="off">
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Keterangan:</label>
                  <input type="text" class="form-control" id="ket_detail_baru" name="ket_detail_baru" autocomplete="off">
                </div>
                
                
              </div>
            </form>
          </div>
          <div>
                <div class="form-group">
                  <a onclick="quotation()"  class="btn btn-info">Add Retur</a>
                </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Saved Item</h3>
          </div>
          <div class="box-body">
            <table width="100%" id="tableku" class="table table-bordered table-striped" style="font-size: smaller;">
              <thead>
                <tr>
                  <th width="5%">Act</th>
                  <th width="30%">Item Retur</th>
                  <th width="5%">Qty Retur</th>
                  <th width="30%">Item Pengganti</th>
                  <th width="5%">Qty Pengganti</th>
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

  <div class="row" id="retur4">
      <div class="col-lg-3">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Input Item</h3>
          </div>
          <div>
            <form method="post" class="form-vertical form" role="form" id="formid">
              <div class="box-body">
              <div class="form-group">
                  <label>Tipe Item</label>
                  <select id="tipe4" name="tipe4" class="form-control" style="width:100%" required>
                    <option value="">-- Tipe Item --</option>
                    <?php foreach ($tipe_item as $valap):?>
                      <option value="<?=$valap->id?>"><?=$valap->tipe?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Item</label>
                  <select id="item4" name="item4" class="form-control" style="width:100%" required>
                    <option value="">-- Select Item --</option>
                    <?php foreach ($item as $val):?>
                      <option value="<?=$val->id?>"><?=$val->item?></option>
                    <?php endforeach;?>
                  </select>
                  <span id='gbritem'></span>
                </div>
                <div class="form-group">
                  <label>Warna</label>
                  <select id="warna4" name="warna4" class="form-control" style="width:100%" required>
                    <option value="">-- Select Warna --</option>
                    <?php foreach ($warna as $val):?>
                      <option value="<?=$val->id?>"><?=$val->warna?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Bukaan:</label>
                  <select id="bukaan4" name="bukaan4" class="form-control" style="width:100%" required>
                    <option value="">-- Select Bukaan --</option>
                      <option value="R">R</option>
                      <option value="L">L</option>
                      <option value="-">tdk ada</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Lebar (mm):</label>
                  <input type="text" style="text-align: right;" class="form-control" id="lebar4" value="0" name="lebar4" placeholder="Lebar" autocomplete="off">
                  <span id="infolebar"></span>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Tinggi (mm):</label>
                  <input type="text" style="text-align: right;" class="form-control" id="tinggi4" value="0" name="tinggi4" placeholder="Tinggi" autocomplete="off">
                  <span id="infotinggi"></span>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Quantity:</label>
                  <input type="text" style="text-align: right;" class="form-control" id="qty4" name="qty4" placeholder="Quantity" autocomplete="off">
                </div>

                <div class="form-group">
                  <label class="control-label" for="merk">Keterangan:</label>
                  <input type="text" class="form-control" id="ket_detail4" name="ket_detail4" autocomplete="off">
                </div>
                
                <div class="form-group">
                  <a onclick="quotation4()"  class="btn btn-info">Add Retur</a>
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
                  <th width="30%">Item Retur</th>
                  <th width="5%">Qty Retur</th>
                  <th width="30%">Item Pengganti</th>
                  <th width="5%">Qty Pengganti</th>
                </tr>
              </thead>
              <tbody id="dataTbl4">
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
$(document).ready(function() {
  $("#lampiran").fileinput({
    'showUpload'            :true
    });
  $('.fileinput-upload-button').hide();
  $("#qty").blur(function(){
    $("#qty_baru").val($("#qty").val());
  });
  $('.datepicker').datepicker({
    autoclose: true
  });

  $("select").select2();
  
  $('#form_pembelian').hide();
  $('#retur4').hide();
  $(".div-pengembalian").hide();
});

function finish() {
  if(confirm('Anda yakin ingin menyelesaikan?'))
  {
    $.growl.notice({ title: 'Berhasil', message: "Tambah Permintaan selesai!"});
    load_silent("klg/retur/finish/"+$("#id_retur").val()+"","#content");
    // load_silent("klg/invoice/finish/"+$("#id_invoice").val()+"","#content");
  }
}





function save()
{
  $(this).find("button[type='submit']").prop('disabled',true);
  $('#proses').hide();
  var path = $("#lampiran").val().replace('C:\\fakepath\\', '');
    if(path == ''){
    $.ajax({
        type: "POST",
        url:site+'klg/retur/saveRetur',
        dataType:'json',
        data: {
            no_retur          : $("#no_retur").val(),
            jenis_retur          : $("#jenis_retur").val(),
            alasan_retur          : $("#alasan_retur").val(),
            store     : $("#store").val(),
            tgl_penarikan     : $("#tgl_penarikan").val(),
            keterangan   : $("#keterangan").val(),
          
        },
        success   : function(data)
        {
          $('#id_retur').val(data['id']);
          $.growl.notice({ title: 'Sukses', message: data['msg']});
          $('#tutup').click();
          if ($("#jenis_retur").val() == 4) {
            $('#retur4').show(50);
          } else{
            $('#form_pembelian').show(50);
            if ($("#jenis_retur").val() != 2) {
              $(".div-pengembalian").show(50);
            } else{
              $(".div-pengembalian").hide(50);
            }
          }
          
        }
      });
    }else{
      $.ajaxFileUpload
          ({
            url:site+'klg/retur/saveReturImage',
            secureuri:false,
            fileElementId:'lampiran',
            dataType: 'json',
            data: {
                no_retur          : $("#no_retur").val(),
                jenis_retur          : $("#jenis_retur").val(),
                alasan_retur          : $("#alasan_retur").val(),
                store     : $("#store").val(),
                tgl_penarikan     : $("#tgl_penarikan").val(),
                keterangan   : $("#keterangan").val(),
              },
            success: function (data)
            {
              $('#id_retur').val(data['id']);
              $.growl.notice({ title: 'Sukses', message: data['msg']});
              $('#tutup').click();
              if ($("#jenis_retur").val() == 4) {
                $('#retur4').show(50);
              } else{
                $('#form_pembelian').show(50);
                if ($("#jenis_retur").val() != 2) {
                  $(".div-pengembalian").show(50);
                } else{
                  $(".div-pengembalian").hide(50);
                }
              }
            },
            error: function (data, e)
            {
              $("#info").html(e);
            }
          })
          return false;
    }
  
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
  if ($('#id_retur').val() !='' && $('#item').val() !='' && $("#qty").val()!='' ) 
  {


                  $.ajax({
                      type: "POST",
                      url: "<?=site_url('klg/retur/saveReturDetail')?>",
                      dataType:'json',
                      data: {

                        'id_retur'     : $("#id_retur").val(),
                        
                        'id_tipe'      : $("#id_tipe").val(),
                        'id_item'      : $("#id_item").val(),
                        'id_warna'     : $("#id_warna").val(),
                        'bukaan'       : $("#bukaan").val(),
                        'lebar'        : $("#lebar").val(),
                        'tinggi'       : $("#tinggi").val(),
                        'qty'          : $("#qty").val(),
                        'keterangan'          : $("#ket_detail").val(),

                        'id_tipe_baru'      : $("#tipe_item").val(),
                        'id_item_baru'      : $("#item_baru").val(),
                        'id_warna_baru'     : $("#warna_baru").val(),
                        'bukaan_baru'       : $("#bukaan_baru").val(),
                        'lebar_baru'        : $("#lebar_baru").val(),
                        'tinggi_baru'       : $("#tinggi_baru").val(),
                        'qty_baru'          : $("#qty_baru").val(),
                        'keterangan_baru'          : $("#ket_detail_baru").val(),
                      },
                    })
                    .success(function(datasaved)
                    {
                  //code here
                  xi++;
                  var i = datasaved['id'];
                  
                  if ($("#jenis_retur").val() !=2) {
                  var x = '<tr id="output_data_'+i+'" class="output_data">\
                  <td width="5%" align="center">\
                    <a href="javascript:void(0)" onClick="hapus('+i+')">\
                      <i class="fa fa-trash"></i>\
                    </a>\
                  </td>\
                  <td width="30%">\
                    '+$('#item :selected').text()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#qty').val()+'\
                  </td>\
                  <td width="30%">\
                    '+$('#item_baru :selected').text()+'_'+$('#tipe_item :selected').text()+'_'+$('#lebar_baru').val()+'x'+$('#tinggi_baru').val()+'_'+$('#warna_baru :selected').text()+'_'+$('#bukaan_baru :selected').text()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#qty_baru').val()+'\
                  </td>\
                </tr>';
                } else{
                  var x = '<tr id="output_data_'+i+'" class="output_data">\
                  <td width="5%" align="center">\
                    <a href="javascript:void(0)" onClick="hapus('+i+')">\
                      <i class="fa fa-trash"></i>\
                    </a>\
                  </td>\
                  <td width="30%">\
                    '+$('#item :selected').text()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#qty').val()+'\
                  </td>\
                  <td width="30%">\
                    '+'tdk ada'+'\
                  </td>\
                  <td width="5%">\
                    '+'tdk ada'+'\
                  </td>\
                </tr>';
                };

                $('tr.odd').remove();
                $('#dataTbl').append(x);
                $('#item').val('').trigger('change');
                $('#qty').val('');
                $("#ket_detail").val(''),

                $('#tipe_item').val('').trigger('change');
                $('#item_baru').val('').trigger('change');
                $('#warna_baru').val('').trigger('change');
                $('#bukaan_baru').val('').trigger('change');
                $('#lebar_baru').val('');
                $('#tinggi_baru').val('');
                
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


function quotation4() {
  if ($('#id_retur').val() !='' && $('#item4').val() !='' && $("#qty4").val()!='' ) 
  {


                  $.ajax({
                      type: "POST",
                      url: "<?=site_url('klg/retur/saveReturDetail')?>",
                      dataType:'json',
                      data: {

                        'id_retur'     : $("#id_retur").val(),
                        
                        'id_tipe'      : $("#tipe4").val(),
                        'id_item'      : $("#item4").val(),
                        'id_warna'     : $("#warna4").val(),
                        'bukaan'       : $("#bukaan4").val(),
                        'lebar'        : $("#lebar4").val(),
                        'tinggi'       : $("#tinggi4").val(),
                        'qty'          : $("#qty4").val(),
                        'keterangan'          : $("#ket_detail4").val(),

                        'id_tipe_baru'      : '',
                        'id_item_baru'      : '',
                        'id_warna_baru'     : '',
                        'bukaan_baru'       : '',
                        'lebar_baru'        : '',
                        'tinggi_baru'       : '',
                        'qty_baru'          : '',
                        'keterangan_baru'   : '',
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
                  <td width="30%">\
                    '+$('#item4 :selected').text()+'_'+$('#tipe4 :selected').text()+'_'+$('#lebar4').val()+'x'+$('#tinggi4').val()+'_'+$('#warna4 :selected').text()+'_'+$('#bukaan4 :selected').text()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#qty4').val()+'\
                  </td>\
                  <td width="30%">\
                    '+'tdk ada'+'\
                  </td>\
                  <td width="5%">\
                    '+'tdk ada'+'\
                  </td>\
                </tr>';

                $('tr.odd').remove();
                $('#dataTbl4').append(x);
                $('#item4').val('').trigger('change');
                $('#warna4').val('').trigger('change');
                $('#bukaan4').val('').trigger('change');
                $('#lebar4').val('');
                $('#tinggi4').val('');
                $('#qty4').val('');
                $("#ket_detail4").val(''),

                
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
      url: "<?=site_url('klg/invoice/deleteItem')?>",
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
            z += '<option value='+data[i].id+'>'+data[i].item+'_'+data[i].tipe+'_'+data[i].lebar+'x'+data[i].tinggi+'_'+data[i].warna+'_'+data[i].bukaan+'</option>';
          }

          x.html(z);        
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

$("#jenis_retur").change(function(){
      if ($(this).val() != 2 ) {
        $(".div-pengembalian").show(50);
      } else{
        $(".div-pengembalian").hide(50);
      };
  
  });

$("#tipe_item").change(function(){
    $('#item_baru').val('').trigger('change');
    if ($(this).val()==2) {
      $('#lebar_baru').attr('readonly', false);
      $('#tinggi_baru').attr('readonly', false);
    }else{
      $('#lebar_baru').attr('readonly', true);
      $('#tinggi_baru').attr('readonly', true);
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
           if ($("#tipe_item").val()==1) {
              $('#lebar_baru').val(img['lebar']);
              $('#tinggi_baru').val(img['tinggi']);
              $('#harga_baru').val(img['harga']);
            } 
          }
      });

  
  });
</script>