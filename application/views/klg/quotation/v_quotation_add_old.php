<?php if(from_session('level')==1){?>
<script type="text/javascript">
$(function(){
  $('#aplikator').change(function() {
    var no_quo = "<?php echo $no_quotation ?>";
    var dy = "<?php echo date('m').'/'.date('Y');?>";
    var text= no_quo.padStart(3, '0')+"/ALLURE/"+$(this).val()+"/"+dy;
    $('#no_quotation').val(text);  
    $('#kode_aplikator').val($(this).val());
    $.ajax({
      url      : "<?= site_url('klg/quotation/getKetentuan/')?>",
      dataType : "json",
      type     : "POST",
      data     : { 
        "kode_aplikator"    : $(this).val(),
      },
      success  : function(img){
          CKEDITOR.instances.keterangan.setData( img['ketentuan'] );  
        }
    });
  });
});
</script>
<?php } ?>
<div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Set Quotation</h3>

        <div class="box-tools pull-right">
          <button type="button" id="tutup" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <form method="post" class="form-vertical form_faktur" role="form">
        <?php if(from_session('level')<=2){?>
        <div class="box-header with-border">
          <h3 class="box-title">Aplikator</h3>

          <div class="form-group">
          <select id="aplikator" name="aplikator" class="form-control" style="width:100%" required>
                  <option value="">-- Select Aplikator --</option>
                  <?php foreach ($aplikator->result() as $valap):?>
                    <option value="<?=$valap->kode?>">[<?=$valap->kode?>] - <?=$valap->aplikator?></option>
                  <?php endforeach;?>
                </select>
          </div>
          <input type="text" id="kode_aplikator" name="kode_aplikator" value="<?php echo from_session('kode_aplikator') ?>" style="display:none;">
          <?php } ?>
        </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>No Quotation</label>
                <input type="text" class="form-control" id="no_quotation" name="no_quotation" placeholder="No Quotation" readonly required>
              </div>              
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Currency</label>
                <select id="currency" name="currency" class="form-control" style="width:100%" required>
                  <option value="">-- Select Currency --</option>
                  <?php foreach ($currency as $val):?>
                    <option value="<?=$val->id?>">[<?=$val->nama?>] - <?=$val->keterangan?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Nama Proyek</label>
                <input type="text" class="form-control" id="nama_proyek" placeholder="Nama Proyek" >
              </div>              
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Owner</label>
                <input type="text" class="form-control" id="owner" placeholder="Nama Owner" >
              </div>              
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Kontak</label>
                <input type="text" class="form-control" id="kontak" name="kontak" placeholder="Kontak">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>No Quotation Customer</label>
                <input type="text" class="form-control" id="no_quotation_cus" name="no_quotation_cus" placeholder="No Quotation Cus">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat">
              </div>              
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Keterangan</label><br>
                <textarea id="keterangan" name="keterangan" rows="10" cols="150">

                </textarea>
              </div>              
            </div>
          </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" onclick="save()" id="proses" class="btn btn-success">Process</button>
          <?= button('load_silent("klg/quotation/","#content")','Cancel','btn btn-default');?>
          <!-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
          the plugin. -->
        </div>
      </form>
    </div>
    <!-- /.box -->
    <div class="row" id="form_pembelian">
      <div class="col-lg-3">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Input Quotation</h3>
          </div>
          <div class="div-pembelian">
            <form method="post" class="form-vertical form" role="form" id="formid">
              <div class="box-body">
                <div class="form-group">
                  <label class="control-label" for="merk">No Quotation:</label>
                  <input type="text" class="form-control" id="no_quotation_input" name="no_quotation_input" placeholder="No Quotation" readonly>
                  <input type="hidden" class="form-control" id="id_quotation" name="id_quotation" readonly>
                </div>
                <div class="form-group" id="form_kode_gambar_baru">
                  <a onclick="inputKodeGambar()"  class="btn btn-success">Tampilkan Adjusment/Diskon</a>
                </div>
              </div>
              <div class="box-body" id="form_kode_gambar">
                <div class="form-group">
                  <label>Kode Gambar</label>
                  <input type="text" class="form-control" id="kode_gambar" name="kode_gambar" placeholder="Kode Gambar" autocomplete="off">
                  <input type="hidden" class="form-control" id="id_kode_gambar" name="id_kode_gambar" readonly>
                </div>
                <div class="form-group">
                  <label>Keterangan Kode Gambar</label>
                  <input type="text" class="form-control" id="keterangan_kg" name="keterangan_kg" placeholder="Keterangan Kode Gambar">
                  <!-- <span id="status_kode_gambar"></span> -->
                  <!-- <a onclick="cekKodeGambar()"  class="btn btn-success">Tambahkan Kode Gambar</a> -->
                </div>
              </div>

              <div class="box-footer" id="form_item">
                <div class="form-group">
                  <label>Lokasi</label>
                  <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lokasi">
                  <input type="hidden" class="form-control" id="id_lokasi" name="id_lokasi" readonly>
                  <!-- <span id="status_lokasi"></span> -->
                  <!-- <a onclick="cekLokasi()"  class="btn btn-success">Tambahkan Lokasi</a> -->
                </div>
                <div class="form-group">
                  <label>Pilih Jenis Item</label>
                  <select id="jenis_item" name="jenis_item" class="form-control" style="width:100%" required>
                    <option value="">-- Select Item --</option>
                    <option value="1">Item Utama</option>
                    <option value="2">Item Tambahan</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Item</label>
                  <select id="item" name="item" class="form-control" style="width:100%" required>
                    <option value="">-- Select Item --</option>
                    <?php foreach ($item as $val):?>
                      <option value="<?=$val->kode?>">[<?=$val->kode?>] - <?=$val->item?></option>
                    <?php endforeach;?>
                  </select>
                  <span id='info'></span>
                </div>
                <div class="form-group fortipe">
                  <label>Tipe</label>
                  <select id="tipe" name="tipe" class="form-control" style="width:100%" required>
                    <option value="">-- Select Tipe --</option>
                  </select>
                </div>
                <div class="form-group fortipe">
                  <label class="control-label" for="merk">Daun</label>
                  <input type="text" style="text-align: right;" class="form-control" id="daun" name="daun" placeholder="Daun" autocomplete="off">
                </div>
                <div class="form-group">
                  <label>Warna</label>
                  <select id="warna" name="warna" class="form-control" style="width:100%" required>
                    <option value="">-- Select Warna --</option>
                    <?php foreach ($warna as $val):?>
                      <option value="<?=$val->kode?>">[<?=$val->kode?>] - <?=$val->warna?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group fortipe">
                  <label class="control-label" for="merk">Tinggi:</label>
                  <input type="text" style="text-align: right;" class="form-control" id="panjang" name="panjang" placeholder="Tinggi" autocomplete="off">
                </div>
                <div class="form-group fortipe">
                  <label class="control-label" for="merk">Lebar:</label>
                  <input type="text" style="text-align: right;" class="form-control" id="lebar" name="lebar" placeholder="Lebar" autocomplete="off">
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Quantity:</label>
                  <input type="text" style="text-align: right;" class="form-control" id="jumlah" name="jumlah" placeholder="Quantity" autocomplete="off">
                </div>
                <div class="form-group">
                  <a onclick="quotation()"  class="btn btn-info">Add to Quotation</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Saved Quotation</h3>
          </div>
          <div class="box-body">
            <table width="100%" id="tableku" class="table table-bordered table-striped" style="font-size: smaller;">
              <thead>
                <tr>
                  <th width="5%">Act</th>
                  <th width="5%">Kode Gambar</th>
                  <th width="8%">Lokasi</th>
                  <th width="12%">Item</th>
                  <th width="5%">Tipe</th>
                  <th width="5%">Daun</th>
                  <th width="5%">Warna</th>
                  <th width="5%">Tinggi</th>
                  <th width="5%">Lebar</th>
                  <th width="5%">Qty</th>
                </tr>
              </thead>
              <tbody id="dataTbl">
              </tbody>
            </table>
            <br/>
            
            <div class="box-footer">
            <?php
                $lvl = from_session('level');
                if ($lvl == '3') {                
              ?>
                <a onclick="saveDp()"  class="btn btn-info"> Save DownPayment</a>
            <?php } ?>
                <a onclick="finish()"  class="btn btn-success pull-right"> Finish</a>
            </div>

          </div>
        </div>
      </div>
    </div>


<script language="javascript">
$(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('keterangan');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
$("#kode_gambar").blur(function(){
    cekKodeGambar();
  });

$("#keterangan_kg").blur(function(){
    cekKodeGambarKet();
  });

function cekKodeGambar() {
  $.ajax({
    url      : "<?= site_url('klg/quotation/cekKodeGambar/')?>",
    dataType : "json",
    type     : "POST",
    data     : { 
      "id_quotation"    : $("#id_quotation").val(),
      "kode_gambar"          : $("#kode_gambar").val(),
    },
    success  : function(img){
        if (img['id_kode_gambar'] != 'empty') {
          $("#id_kode_gambar").val(img['id_kode_gambar']);
          $("#keterangan_kg").val(img['keterangan_kg']);
        };
      }
  });
}

function cekKodeGambarKet() {
  $.ajax({
    url      : "<?= site_url('klg/quotation/cekKodeGambarKet/')?>",
    dataType : "json",
    type     : "POST",
    data     : { 
      "id_kode_gambar"    : $("#id_kode_gambar").val(),
      "keterangan_kg"    : $("#keterangan_kg").val(),
    },
    success  : function(img){
          $('#form_kode_gambar_baru').show(1000);
      }
  });
}

function inputKodeGambar() {
  var id_kode_gambar =  $("#id_kode_gambar").val();
  var x = '<tr>\
      <td width="5%" align="center">\
      </td>\
      <td colspan="2">\
      <span id="adjustment_'+id_kode_gambar+'">Adjustment 0%</span>\
      </td>\
      <td colspan="2">\
      <span id="diskon_'+id_kode_gambar+'">Diskon 0%</span>\
      </td>\
      <td colspan="5">\
        <a class="btn btn-success" href="javascript:void(0)" onClick="diskon('+id_kode_gambar+')">\
          Adjustment dan Diskon\
        </a>\
      </td>\
    </tr>';
    // $('tr.odd').remove();
    $('#dataTbl').append(x);
    $('#form_kode_gambar_baru').hide(100);
    
    $('#kode_gambar').removeAttr('readonly');
    $('#keterangan_kg').removeAttr('readonly');
    // $('#form_kode_gambar').show(100);
    $("#kode_gambar").val('');
    // $("#adjustment_"+id_kode_gambar).html('0%');
    // $("#adjustment_"+id_kode_gambar).html('0%');
    $("#keterangan_kg").val('');
    $("#lokasi").val('');
}

function diskon(id_kode_gambar) {
  $('#myModalku').modal('show');
}

function saveDiskon() {
  var id_kode_gambar =  $("#id_kode_gambar").val();
  $.ajax({
        url      : "<?= site_url('klg/quotation/saveDiskon/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "id_kode_gambar" : id_kode_gambar, 
          "adjustment" : $('#adjustment').val(), 
          "diskon" : $('#diskon').val(), 
        },
        success  : function(data){
            $.growl.notice({ title: 'Sukses', message: data['msg']});
            $('#adjustment').val('');
            $('#diskon').val('');
            $("#adjustment_"+id_kode_gambar).html('Adjustment '+data['adjustment']+'%');
            $("#diskon_"+id_kode_gambar).html('Diskon '+data['diskon']+'%');
    
        }
      });
}

function save()
{
  $(this).find("button[type='submit']").prop('disabled',true);
  // POST DATA
  $.ajax({
    type: "POST",
    url: "<?=site_url('klg/quotation/insertQuotation')?>",
    dataType:'json',
    data: {
      kode_aplikator        : $("#kode_aplikator").val(),
      no_quotation          : $("#no_quotation").val(),
      currency              : $("#currency").val(),
      nama_proyek           : $("#nama_proyek").val(),
      owner                 : $("#owner").val(),
      kontak                : $("#kontak").val(),
      no_quotation_cus      : $("#no_quotation_cus").val(),
      alamat                : $("#alamat").val(),
      keterangan            : CKEDITOR.instances.keterangan.getData(),
    }
  })
  .success(function(data)
  {
    $.growl.notice({ title: 'Sukses', message: "Berhasil menyimpan quotation"});
    $('#no_quotation_input').val($('#no_quotation').val());
    $('#id_quotation').val(data['id']);
    $('#proses').attr('disabled','disabled');
    $('#tutup').click();
    $('#form_pembelian').show(100);
  });
  return false
};


$("#lokasi").blur(function(){

    cekLokasi();
  });
function cekLokasi() {
  $.ajax({
    url      : "<?= site_url('klg/quotation/cekLokasi/')?>",
    dataType : "json",
    type     : "POST",
    data     : { 
      "id_quotation" : $("#id_quotation").val(),
      "lokasi" : $("#lokasi").val(),
    },
    success  : function(img){
        if (img['id_lokasi'] != 'empty') {
          $("#id_lokasi").val(img['id_lokasi']);
          $("#status_lokasi").html('<b>Lokasi Disimpan!</b><br>');
        };
      }
  });
}

$("select[name=jenis_item]").change(function(){
    var x = $("select[name=item]");
    if ($(this).val() == "2") { $(".fortipe").hide(); } else{ $(".fortipe").show(); };
    if($(this).val() == "") {
      x.html("<option>-- Select Item --</option>");
    }
    else {
      z = "<option>-- Select Item --</option>";
      $.ajax({
        url      : "<?=site_url('klg/quotation/getItem')?>",
        dataType : "json",
        type     : "POST",
        data     : { "jenis_item" : $(this).val() },
        success  : function(data){

          var z = "<option value=''>-- Select Item --</option>";
          for(var i = 0; i<data.length; i++){
            z += '<option value='+data[i].id+'>'+data[i].kode+' - '+data[i].item+'</option>';

          }

          
          x.html(z);
          $('#item').val('').trigger('change');

        }
      });

    }
  });

$("#item").change(function(){
  var jenis_item = $('#jenis_item').val();
    if (jenis_item == '2') { warnaitemtambahan($(this).val()); };

      $.ajax({
        url      : "<?= site_url('klg/quotation/getGambar/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "item" : $(this).val(),
        },
        success  : function(img){
            var imga = img['gambar'];
            $("#info").html('<div class="form-group"> <label class="control-label">Picture : </label> <img style="padding:10px;" src="<?php echo base_url()."'+imga+'"; ?>" class="file-preview-image"></div>');
        }
      });

  
  });


$("select[name=item]").change(function(){
    var jenis_item = $('#jenis_item').val();

    var x = $("select[name=tipe]");
    
    if($(this).val() == "" || jenis_item == 2) {
      x.html("<option>-- Select Tipe --</option>");
    }
    else {
      z = "<option>-- Select Tipe --</option>";
      $.ajax({
        url      : "<?=site_url('klg/quotation/getTipeItem')?>",
        dataType : "json",
        type     : "POST",
        data     : { "item" : $(this).val() },
        success  : function(data){

          var z = "<option value=''>-- Select Tipe --</option>";
          for(var i = 0; i<data.length; i++){
            z += '<option value='+data[i].kode_tipe+'>'+data[i].kode_item+' - '+data[i].tipe+'</option>';
          }

          
          x.html(z);
          $('#tipe').val('').trigger('change');
          $('#warna').val('').trigger('change');
         
        }
      });

    }
  });

function warnaitemtambahan(kode_item) {
  // alert(kode_item);
  var x = $("select[name=warna]");
    if(kode_item == "") {
      x.html("<option>-- Select Warna --</option>");
    }
    else {
      z = "<option>-- Select Warna --</option>";
      $.ajax({
        url      : "<?=site_url('klg/quotation/getWarnaItemTambahan')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "item" : kode_item,
        },
        success  : function(data){

          var z = "<option value=''>-- Select Warna --</option>";
          for(var i = 0; i<data.length; i++){
            z += '<option value='+data[i].kode_warna+'>'+data[i].kode_warna+' - '+data[i].warna+'</option>';
          }

          
          x.html(z);
          $('#warna').val('').trigger('change');
        }
      });

    }
}

$("select[name=tipe]").change(function(){
    var x = $("select[name=warna]");
    if($(this).val() == "") {
      x.html("<option>-- Select Warna --</option>");
    }
    else {
      z = "<option>-- Select Warna --</option>";
      $.ajax({
        url      : "<?=site_url('klg/quotation/getWarnaItem')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "item" : $('#item').val(), 
          "tipe" : $(this).val() 
        },
        success  : function(data){

          var z = "<option value=''>-- Select Warna --</option>";
          for(var i = 0; i<data.length; i++){
            z += '<option value='+data[i].kode_warna+'>'+data[i].kode_warna+' - '+data[i].warna+'</option>';
          }

          
          x.html(z);
          $('#warna').val('').trigger('change');

        }
      });

    }
  });


xi=0;
function quotation() {
  if ($('#jenis_item').val() == 2) { var tipe = ''; var tipe_sel = ''; } else{ var tipe = $('#tipe').val(); var tipe_sel = $('#tipe :selected').text(); };
$.ajax({
    type: "POST",
    url: "<?=site_url('klg/quotation/insertQuotationDetail')?>",
    dataType:'json',
    data: {
        'id_quotation'  : $('#id_quotation').val(),
        'id_kode_gambar'  : $('#id_kode_gambar').val(),
        'id_lokasi'  : $('#id_lokasi').val(),
        'jenis_item'            : $('#jenis_item').val(), 
        'item'            : $('#item').val(), 
        'tipe'            : tipe,
        'daun'           : $('#daun').val(),
        'warna'           : $('#warna').val(),
        'panjang'         : $('#panjang').val(),
        'lebar'           : $('#lebar').val(),
        'jumlah'          : $("#jumlah").val(),
    }
  })
  .success(function(datasaved){
    //code here
    xi++;
    var i = datasaved['id'];
    var jumlah = $('#jumlah').val();
    // var total = $('#jumlah').val()*replaceTitik($('#harga').val());
    // var totalq = commaSeparateNumber(total);

    var x = '<tr id="output_data_'+i+'" class="output_data">\
      <td width="5%" align="center">\
        <a href="javascript:void(0)" onClick="hapus('+i+')">\
          <i class="fa fa-trash"></i>\
        </a>\
      </td>\
      <td width="5%">\
        '+$('#kode_gambar').val()+'\
      </td>\
      <td width="8%">\
        '+$('#lokasi').val()+'\
      </td>\
      <td width="12%">\
        '+$('#item :selected').text()+'\
      </td>\
      <td width="5%">\
        '+tipe_sel+'\
      </td>\
      <td width="5%">\
        '+$('#daun').val()+'\
      </td>\
      <td width="5%">\
        '+$('#warna :selected').text()+'\
      </td>\
      <td width="5%">\
        '+$('#panjang').val()+'\
      </td>\
      <td width="5%">\
        '+$('#lebar').val()+'\
      </td>\
      <td width="5%">\
        '+$('#jumlah').val()+'\
      </td>\
    </tr>';
    $('#check_data').text('');
    $('tr.odd').remove();
    $('#dataTbl').append(x);
    $('#panjang').val('').trigger('change');
    $('#lebar').val('').trigger('change');
    $('#jumlah').val('');
    $('#harga').val('');
    $.growl.notice({ title: 'Sukses', message: "Quotation Added!"});
    // hitungJml(xi);
    
  })
  .fail(function(XHR){
    if (XHR.readyState==0) {
      $.growl.error({ title: 'Peringatan', message: 'Terjadi Kesalahan, Quotation Gagal! KONEKSI TERPUTUS' });
      $('#jumlah').val('');
    }else{
      $.growl.error({ title: 'Peringatan', message: 'Terjadi Kesalahan, Quotation Gagal! UNKNOWN ERROR' });
      $('#jumlah').val('');
    }
  });
}

function hitungJml(xi){


  var total = 0;

  var a = $('tr.output_data').length + 1;
  for(var x = 1; x<=xi; x++){
    subTotal = parseFloat($('#totalq_'+x).val());
    if($('#totalq_'+x).val() != undefined){
      total = total + subTotal;
    }
  }

  var total_real = total;
  $('#total').val(commaSeparateNumber(total_real));
}

function hapus(i)
{
  if(confirm('Lanjutkan Proses Hapus?'))
  {
    $.ajax({
      type: "POST",
      url: "<?=site_url('klg/quotation/deleteItem')?>",
      dataType:'json',
      data: {        
        'id' : i
      }
    })
    .success(function(datasaved)
    {
      $.growl.notice({ title: 'Sukses', message: datasaved.msg});
      $('#output_data_'+i).remove();
      // hitungJml(xi);
    });    
  }
}

function commaSeparateNumber (val) {
  val = val.toString();
  while (/(\d+)(\d{3})/.test(val)){
    val = val.replace(/(\d+)(\d{3})/, '$1'+'.'+'$2');
  }
  return val;
}

function replaceTitik(vale){
  var vale = vale+"";
  var sel = vale.replace(/[,.]/g,"");
  return eval(sel) > 0 ? eval(sel) : 0;
}

$('#formid').on('keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if(e.keyCode==13 || e.keyCode==9){
    e.preventDefault();
    if ($('#jenis_item').val() == 2) { var tipe = ''; var tipe_sel = ''; } else{ var tipe = $('#tipe').val(); var tipe_sel = $('#tipe :selected').text(); };
    $.ajax({
      type: "POST",
      url: "<?=site_url('klg/quotation/insertQuotationDetail')?>",
      dataType:'json',
      data: {
        'id_quotation'  : $('#id_quotation').val(),
        'id_kode_gambar'  : $('#id_kode_gambar').val(),
        'id_lokasi'  : $('#id_lokasi').val(),
        'jenis_item'            : $('#jenis_item').val(), 
        'item'            : $('#item').val(), 
        'tipe'            : tipe,
        'daun'           : $('#daun').val(),
        'warna'           : $('#warna').val(),
        'panjang'         : $('#panjang').val(),
        'lebar'           : $('#lebar').val(),
        'jumlah'          : $("#jumlah").val(),
      }
    })
    .success(function(datasaved){
      //code here
      xi++;
      var i = datasaved['id'];
      var jumlah = $('#jumlah').val();
      // var total = $('#jumlah').val()*replaceTitik($('#harga').val());
    // var totalq = commaSeparateNumber(total);

    var x = '<tr id="output_data_'+i+'" class="output_data">\
      <td width="5%" align="center">\
        <a href="javascript:void(0)" onClick="hapus('+i+')">\
          <i class="fa fa-trash"></i>\
        </a>\
      </td>\
      <td width="5%">\
        '+$('#kode_gambar').val()+'\
      </td>\
      <td width="8%">\
        '+$('#lokasi').val()+'\
      </td>\
      <td width="12%">\
        '+$('#item :selected').text()+'\
      </td>\
      <td width="5%">\
        '+tipe_sel+'\
      </td>\
      <td width="5%">\
        '+$('#daun').val()+'\
      </td>\
      <td width="5%">\
        '+$('#warna :selected').text()+'\
      </td>\
      <td width="5%">\
        '+$('#panjang').val()+'\
      </td>\
      <td width="5%">\
        '+$('#lebar').val()+'\
      </td>\
      <td width="5%">\
        '+$('#jumlah').val()+'\
      </td>\
      </tr>';
      $('#check_data').text('');
      $('tr.odd').remove();
      $('#dataTbl').append(x);
      $('#panjang').val('').trigger('change');
      $('#lebar').val('').trigger('change');
      $('#jumlah').val('');
      $('#harga').val('');
      $.growl.notice({ title: 'Sukses', message: "Quotation Added!"});
      // hitungJml(xi);
      
    })
    .fail(function(XHR){
      if (XHR.readyState==0) {
        $.growl.error({ title: 'Peringatan', message: 'Terjadi Kesalahan, Quotation Gagal! KONEKSI TERPUTUS' });
        $('#jumlah').val('');
      }else{
        $.growl.error({ title: 'Peringatan', message: 'Terjadi Kesalahan, Quotation Gagal! UNKNOWN ERROR' });
        $('#jumlah').val('');
      }
    });
  }
});

function finish() {
  if(confirm('Anda yakin ingin menyelesaikan?'))
  {
    $.growl.notice({ title: 'Berhasil', message: "Quotation selesai!"});
    load_silent("klg/quotation/","#content");
  }
}

$(document).ready(function() {
  $('.datepicker').datepicker({
    autoclose: true
  });

  $('#form_kode_gambar_baru').hide(100);

  $('#form_pembelian').hide(100);
  // $('#form_item').hide(100);

  $('#lokasi').keyup(function(){
      $("#status_lokasi").html('');
    });
});































function cetakInvoice()
  {
    var left = (screen.width/2)-(640/2);
    var top = (screen.height/2)-(480/2);
    id_pi = $('#id_invoice').val();
    var url = "<?=site_url('klg/invoice/cetak/"+id_pi+"')?>";
    load_silent("klg/invoice/","#content");
    window.open(url, "", "width=640, height=480, scrollbars=yes, left="+left+", top="+top);
  }


function saveDp (argument) {
  $.ajax({
        url      : "<?= site_url('klg/quotation/saveDp/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "id_quotation" : $('#id_quotation').val(), 
          "dp" : $('#dp').val(), 
        },
        success  : function(data){
            $.growl.notice({ title: 'Sukses', message: data['msg']});
    
        }
      });
}









$(document).ready(function() {
  
  // if($('#tableku').length > 0){

    var table = $('#tableku').DataTable( {
      "bInfo" : false,
      "searching": false,
      "ordering": false,
      "bPaginate": false,
      scrollY:        "500px",
      scrollX:        "100%",
      "fnInitComplete": function() {
          this.fnAdjustColumnSizing(true);
        }
      } );
  // }

  $("#inChecked").click(function(e){
    $('input').prop('checked',this.checked);
  });
  $('select').select2();

});


</script>

<div class="modal fade" id="myModalku" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Adjustment dan Diskon</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label" for="merk">Adjustment (%):</label>
          <input type="text" style="text-align: right;" class="form-control" id="adjustment" name="adjustment" placeholder="Adjustment (%)" autocomplete="off">
        </div>
        <div class="form-group">
          <label class="control-label" for="merk">Diskon (%):</label>
          <input type="text" style="text-align: right;" class="form-control" id="diskon" name="diskon" placeholder="Diskon (%)" autocomplete="off">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a onclick="saveDiskon()"  class="btn btn-info">Save</a>
      </div>
    </div>
  </div>
</div>