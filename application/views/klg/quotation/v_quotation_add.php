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
                  <?php if($val->id == '1') { $selected = 'selected'; } else { $selected = ''; } ?>
                    <option value="<?=$val->id?>"<?=$selected?> >[<?=$val->nama?>] - <?=$val->keterangan?></option>
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

    <div class="box box-success" id="form_kode_gambar">
      <div class="box-header with-border">
        <h3 class="box-title">Set Kode Gambar : <span id="no_quotation_input"></span></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Kode Gambar</label>
                <input type="hidden" class="form-control" id="id_quotation" name="id_quotation" readonly>
                <input type="text" class="form-control" id="kode_gambar" name="kode_gambar" placeholder="Kode Gambar" autocomplete="off">
                <input type="hidden" class="form-control" id="id_kode_gambar" name="id_kode_gambar" readonly>
              </div>              
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Quantity</label>
                <input type="text" class="form-control" id="ket_qty" name="ket_qty" placeholder="Quantity" autocomplete="off">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Dimensi</label>
                <input type="text" class="form-control" id="ket_dimensi" name="ket_dimensi" placeholder="Dimensi" autocomplete="off">
              </div>              
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Keterangan</label>
                <input type="text" class="form-control" id="ket_keterangan" name="ket_keterangan" placeholder="Keterangan" autocomplete="off">
              </div>              
            </div>
          </div>
      </div>
      <!-- <div class="box-footer">
          <div id="insert_kg"><a onclick="cekKodeGambar()"  class="btn btn-success">Tambahkan Kode Gambar</a></div>
          <div id="saved_kg"><span><font color="blue"><b>Kode Gambar Disimpan!</b></font></span></div>
      </div> -->
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
                
                <!-- <div class="form-group" id="form_kode_gambar_baru">
                  <a onclick="inputKodeGambar()"  class="btn btn-success">Tampilkan Adjusment/Diskon</a>
                </div> -->
                <div class="form-group">
                  <label>Lokasi</label>
                  <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lokasi">
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
                  <label class="control-label" for="merk">Lebar:</label>
                  <input type="text" style="text-align: right;" class="form-control" id="lebar" name="lebar" placeholder="Lebar" autocomplete="off">
                </div>
                <div class="form-group fortipe">
                  <label class="control-label" for="merk">Tinggi:</label>
                  <input type="text" style="text-align: right;" class="form-control" id="panjang" name="panjang" placeholder="Tinggi" autocomplete="off">
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
          <div class="box-body" id="dataTbl" >
          </div>
          <div class="box-footer">
                <a onclick="finish()"  class="btn btn-success pull-right"> Finish</a>
            </div>
        </div>
      </div>
    </div>


<script language="javascript">
$(document).ready(function() {
  $('.datepicker').datepicker({
    autoclose: true
  });

  $('#form_kode_gambar').hide();
  $('#form_pembelian').hide();
  $("#saved_kg").hide();
  $('select').select2();

  // Replace the <textarea id="editor1"> with a CKEditor files/2019/12/03cd07ae4cb5f5f8ab4f5c4cd80d81e5.png
  // instance, using default configuration.
  CKEDITOR.replace('keterangan');
  //bootstrap WYSIHTML5 - text editor
  $(".textarea").wysihtml5();

  
  $('#daun').keypress(function(event){
      // console.log(event.which);
  if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
      event.preventDefault();
  }});

  $('#lebar').keypress(function(event){
      // console.log(event.which);
  if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
      event.preventDefault();
  }});

  $('#panjang').keypress(function(event){
      // console.log(event.which);
  if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
      event.preventDefault();
  }});

  $('#jumlah').keypress(function(event){
      // console.log(event.which);
  if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
      event.preventDefault();
  }});

  $('#daun_edit').keypress(function(event){
      // console.log(event.which);
  if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
      event.preventDefault();
  }});

  $('#lebar_edit').keypress(function(event){
      // console.log(event.which);
  if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
      event.preventDefault();
  }});

  $('#panjang_edit').keypress(function(event){
      // console.log(event.which);
  if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
      event.preventDefault();
  }});

  $('#jumlah_edit').keypress(function(event){
      // console.log(event.which);
  if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
      event.preventDefault();
  }});

});


function save()
{
  if ($("#kode_aplikator").val()!='' && $("#no_quotation").val()!='' && $("#currency").val()!='' && $("#nama_proyek").val()!='' && $("#owner").val()!='' && $("#kontak").val()!='' ) {
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
      $("#no_quotation_input").html('<b>'+$('#no_quotation').val()+'</b>');
      $('#id_quotation').val(data['id']);
      $('#proses').attr('disabled','disabled');
      $('#tutup').click();
      $('#form_kode_gambar').show(100);
      $('#form_pembelian').show(100);
      $("#kode_gambar").focus();
    });
    return false
  } else{  $.growl.warning({ title: 'Perhatian!', message: "Lengkapi Form yang ada!"}); }
};

$("#lokasi").blur(function(){
    cekKodeGambar();
  });

$("#panjang").blur(function(){
    cekKodeGambar();
  });


function cekKodeGambar() {
  if($("#kode_gambar").val() != ''){
    $.ajax({
      url      : "<?= site_url('klg/quotation/cekKodeGambar/')?>",
      dataType : "json",
      type     : "POST",
      data     : { 
        "id_quotation"    : $("#id_quotation").val(),
        "kode_gambar"     : $("#kode_gambar").val(),
        "ket_qty"         : $("#ket_qty").val(),
        "ket_dimensi"     : $("#ket_dimensi").val(),
        "keterangan"      : $("#ket_keterangan").val(),
      },
      success  : function(img){
          if (img['status'] == 'x') {
            $("#id_kode_gambar").val(img['id_kode_gambar']);
            $("#kode_gambar").val(img['kode_gambar']);
            $("#ket_qty").val(img['ket_qty']);
            $("#ket_dimensi").val(img['ket_dimensi']);
            $("#ket_keterangan").val(img['keterangan']);
            // $.growl.error({ title: 'Peringatan', message: 'Kode Gambar Sudah Ada!' });
          }else{
            $("#id_kode_gambar").val(img['id_kode_gambar']);
            // $.growl.notice({ title: 'Sukses', message: "Menyimpan Kode Gambar"});
            // $("#insert_kg").hide(100);
            // $("#saved_kg").show(100);
            append1();
          };
        }
    });
  }else{ $.growl.error({ title: 'Peringatan', message: 'Kode Gambar Wajib Diisi!' }); $("#kode_gambar").focus();}
}

$("#item").change(function(){
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
    var x = $("select[name=tipe]");
    if($(this).val() == "") {
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

function quotation() {
  if ($('#id_kode_gambar').val() !='' && $('#item').val() !='' && $('#tipe').val() != '' && $('#daun').val() !='' && $('#warna').val() != '' && $('#panjang').val() != '' && $('#panjang').val() != '' && $('#lebar').val() !='' && $("#jumlah").val()!='' ) 
  {
    $.ajax({
        type: "POST",
        url: "<?=site_url('klg/quotation/insertQuotationDetail')?>",
        dataType:'json',
        data: {
            'id_quotation'    : $('#id_quotation').val(),
            'id_kode_gambar'  : $('#id_kode_gambar').val(),
            'lokasi'          : $('#lokasi').val(),
            'item'            : $('#item').val(), 
            'tipe'            : $('#tipe').val(),
            'daun'            : $('#daun').val(),
            'warna'           : $('#warna').val(),
            'panjang'         : $('#panjang').val(),
            'lebar'           : $('#lebar').val(),
            'jumlah'          : $("#jumlah").val(),
        }
      })
      .success(function(datasaved){
        
         append2(datasaved['id_k_gambar']);
        $( "#lokasi" ).focus();
        $('#item').val('').trigger('change');
        $('#tipe').val('').trigger('change');
        $('#warna').val('').trigger('change');
        $('#daun').val('');
        $('#panjang').val('');
        $('#lebar').val('');
        $('#jumlah').val('');
        $.growl.notice({ title: 'Sukses', message: "Quotation Added!"});
        
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

  } else{$.growl.error({ title: 'Peringatan', message: 'Lengkapi Form dulu!' });};
}

function append1() {
  var id_kode_gambar =  $("#id_kode_gambar").val();
  telo = '<div id=tabble_'+id_kode_gambar+' style="background-color: rgba(250, 254, 255);"></div>';
  $('#dataTbl').append(telo);
}

function append2(id_kode_gambar) {
  // var id_kode_gambar =  $("#id_kode_gambar").val();
  infoTable = '<table id="infoTable" class="table table-bordered" border="0" style="font-size: smaller;">'+
    '<tr>'+
      '<th colspan="2"><span id="kodegambar_'+id_kode_gambar+'">Kode Gambar: '+$('#kode_gambar').val()+'<br>Quantity: '+$('#ket_qty').val()+'</span></th>'+
      '<th colspan="2"><span id="keterangan_'+id_kode_gambar+'">Keterangan:<br>'+$('#ket_keterangan').val()+'</span></th>'+
      '<th colspan="2"><span id="dimensi_'+id_kode_gambar+'">Dimensi:<br>'+$('#ket_dimensi').val()+'</span></th>'+
      '<th><span id="adjustment_'+id_kode_gambar+'">Adjustment 0%</span></th>'+
      '<th><span id="diskon_'+id_kode_gambar+'">Diskon 0%</span></th>'+
      '<th align="center"><a class="btn btn-xs btn-success" href="javascript:void(0)" onClick="diskon('+id_kode_gambar+')">Set Adj/Dis</a></th>'+
    '</tr>'+
    '<tr bgcolor="#c7c4ff">'+
      '<th>Lokasi</th>'+
      '<th>Item</th>'+
      '<th>Tipe</th>'+
      '<th>Daun</th>'+
      '<th>Warna</th>'+
      '<th>Lebar</th>'+
      '<th>Tinggi</th>'+
      '<th>Quantity</th>'+
      '<th>Act</th>'+
    '</tr>';
  $.ajax({
      url: "<?=site_url('klg/quotation/getQuoTabel')?>",
      type: 'POST',
      dataType: 'JSON',
      data: {
        id_kode_gambar : id_kode_gambar,
      },
    })
    .done(function(data) {   
      for (var i = 0; i < data.detail.length; i++) {
          infoTable += '<tr id="output_data_'+data.detail[i].id+'">'+
          '<td align="center">'+data.detail[i].lokasi+'</td>'+
          '<td align="center">'+data.detail[i].item+'</td>'+
          '<td align="center">'+data.detail[i].tipe+'</td>'+
          '<td align="center">'+data.detail[i].daun+'</td>'+
          '<td align="center">'+data.detail[i].warna+'</td>'+
          '<td align="center">'+data.detail[i].lebar+'</td>'+
          '<td align="center">'+data.detail[i].panjang+'</td>'+
          '<td align="center">'+data.detail[i].qty+'</td>'+
          '<td align="center"><a class="btn btn-xs btn-warning" onClick="editItem('+data.detail[i].id+')"><i class="fa fa-edit"></i></a> <a class="btn btn-xs btn-danger" onClick="hapus('+data.detail[i].id+')"><i class="fa fa-trash"></i></a> <a class="btn btn-xs btn-primary" onClick="addItemTambahan('+data.detail[i].id+')"><i class="fa fa-plus-square"></i></a></td>'+
          '</tr>';
               
      };
    infoTable +='</table>'

    $('#tabble_'+id_kode_gambar+'').html(infoTable);
    });

}

function append3() {
  var id_kode_gambar =  $("#id_kode_gambar").val();
  infoTable = '<table id="infoTableTambahan" class="table" border="0" style="font-size: smaller;">'+
    '<tr bgcolor="#97c5c3">'+
      '<th>Item Tambahan</th>'+
      '<th>Kode Warna</th>'+
      '<th>Qty</th>'+
      '<th>Act</th>'+
    '</tr>';
    infoTable +='</table>'

    $('#tambahan_'+id_kode_gambar+'').html(infoTable);
}

$('#formid').on('keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if(e.keyCode==13 || e.keyCode==9){
    e.preventDefault();    
    quotation();
  }
});

function diskon(id_kode_gambar) {
  $('#idmodal').val(id_kode_gambar);
  
  $.ajax({
        url      : "<?= site_url('klg/quotation/loadKodeGambar/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "id_kode_gambar" : id_kode_gambar,
        },
        success  : function(img){
          $("#kode_gambar_mod").val(img['kode_gambar']);
          $("#ket_qty_mod").val(img['ket_qty']);
          $("#ket_dimensi_mod").val(img['ket_dimensi']);
          $("#keterangan_mod").val(img['keterangan']);
          $("#diskon").val(img['diskon']);
          $("#adjustment").val(img['adjustment']);
          $('#myModalku').modal('show');        
    
        }
      });
}

function saveDiskon() {
  var id_kode_gambar =  $("#idmodal").val();
  $.ajax({
        url      : "<?= site_url('klg/quotation/saveDiskon/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "id_kode_gambar"  : id_kode_gambar, 
          "kode_gambar"     : $("#kode_gambar_mod").val(),
          "ket_qty"         : $("#ket_qty_mod").val(),
          "ket_dimensi"     : $("#ket_dimensi_mod").val(),
          "keterangan"      : $("#keterangan_mod").val(),
          "adjustment"      : $('#adjustment').val(), 
          "diskon"          : $('#diskon').val(), 
        },
        success  : function(data){
            $.growl.notice({ title: 'Sukses', message: data['msg']});
            $("#idmodal").val('');
            $("#kodegambar_"+id_kode_gambar).html('Kode Gambar: '+data['kode_gambar']+'<br>Quantity: '+data['ket_qty']+'');
            $("#keterangan_"+id_kode_gambar).html('Keterangan:<br>'+data['keterangan']+'');
            $("#dimensi_"+id_kode_gambar).html('Dimensi:<br>'+data['ket_dimensi']+'');
            $("#adjustment_"+id_kode_gambar).html('Adjustment '+data['adjustment']+'%');
            $("#diskon_"+id_kode_gambar).html('Diskon '+data['diskon']+'%');
            $(".tmyModalku").click();
    
        }
      });
}

function addItemTambahan(idDetail) {
  // $('#kodeItemTambahan').html(idDetail);
  $('#id_quotation_detail').val(idDetail);

  appendtambahan(idDetail);
  $('#myModalTambahan').modal('show');
}


function saveItemTambahan() {
$.ajax({
    type: "POST",
    url: "<?=site_url('klg/quotation/insertQuotationDetailTambahan')?>",
    dataType:'json',
    data: {
        'id_quotation'        : $('#id_quotation').val(),
        'id_quotation_detail'  : $('#id_quotation_detail').val(),
        'kode_item_tambahan'  : $('#item_tambahan').val(),
        'qty_tambahan'        : $('#qty_tambahan').val(),
    }
  })
  .success(function(datasaved){
    
    appendtambahan($('#id_quotation_detail').val());
    $('#qty_tambahan').val('');
    $.growl.notice({ title: 'Sukses', message: "Item Tambahan Added!"});
    
  })
  .fail(function(XHR){
    if (XHR.readyState==0) {
      $.growl.error({ title: 'Peringatan', message: 'Terjadi Kesalahan, Item Tambahan Gagal! KONEKSI TERPUTUS' });
      $('#jumlah').val('');
    }else{
      $.growl.error({ title: 'Peringatan', message: 'Terjadi Kesalahan, Item Tambahan Gagal! UNKNOWN ERROR' });
      $('#jumlah').val('');
    }
  });
}

function appendtambahan(id_quotation_detail) {
  tbltmbhn = '<table id="infoTableTambahan" class="table table-bordered" border="0" style="font-size: smaller;">'+
    '<tr bgcolor="#c7c4ff">'+
      '<th>Item Tambahan</th>'+
      '<th>Warna</th>'+
      '<th>Qty</th>'+
      '<th>Act</th>'+
    '</tr>';
  $.ajax({
      url: "<?=site_url('klg/quotation/getQuoTabelTambahan/')?>",
      type: 'POST',
      dataType: 'JSON',
      data: {
        id_quotation_detail : id_quotation_detail,
      },
    })
    .done(function(data) {   
      for (var i = 0; i < data.detail.length; i++) {
          
          tbltmbhn += '<tr id="tr_tambahan_'+data.detail[i].id+'">'+
          '<td align="center">'+data.detail[i].item+'</td>'+
          '<td align="center">'+data.detail[i].warna+'</td>'+
          '<td align="center">'+data.detail[i].qty_tambahan+'</td>'+
          '<td align="center"><a class="btn btn-xs btn-danger" onClick="hapusTambahan('+data.detail[i].id+')"><i class="fa fa-trash"></i></a></td>'+
          '</tr>';
               
      };
    tbltmbhn +='</table>'

    $('#tblTambahan').html(tbltmbhn);
    });
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

function hapusTambahan(i)
{
  if(confirm('Lanjutkan Proses Hapus?'))
  {
    $.ajax({
      type: "POST",
      url: "<?=site_url('klg/quotation/deleteItemTambahan')?>",
      dataType:'json',
      data: {        
        'id' : i
      }
    })
    .success(function(datasaved)
    {
      $.growl.notice({ title: 'Sukses', message: datasaved.msg});
      $('#tr_tambahan_'+i).remove();
    });    
  }
}

function editItem(id) {
  // appendtambahan(idDetail);

  $.ajax({
      type: "POST",
      url: "<?=site_url('klg/quotation/editItem')?>",
      dataType:'json',
      data: {        
        'id' : id
      }
    })
    .success(function(datasaved)
    {
      $('#myModalEdit').modal('show');
      $("#id_quotation_edit").val(datasaved['id_quotation']);
      $("#id_kode_gambar_edit").val(datasaved['id_kode_gambar']);
      $("#id_edit").val(id);
      $("#lokasi_edit").val(datasaved['lokasi']);
      $("#item_edit").val(datasaved['item']).change();
      $("#tipe_edit").val(datasaved['tipe']).change();
      $("#daun_edit").val(datasaved['daun']);
      $("#warna_edit").val(datasaved['warna']).change();
      $("#lebar_edit").val(datasaved['lebar']);
      $("#panjang_edit").val(datasaved['panjang']);
      $("#jumlah_edit").val(datasaved['qty']);
    }); 
}

function saveEditItem() {
  if ($('#id_kode_gambar_edit').val() !='' && $('#item_edit').val() !='' && $('#tipe_edit').val() != '' && $('#daun_edit').val() !='' && $('#warna_edit').val() != '' && $('#panjang_edit').val() != '' && $('#panjang_edit').val() != '' && $('#lebar_edit').val() !='' && $("#jumlah_edit").val()!='' ) 
  {
    $.ajax({
        type: "POST",
        url: "<?=site_url('klg/quotation/updateQuotationDetail')?>",
        dataType:'json',
        data: {
            'id'    : $('#id_edit').val(),
            'id_quotation'    : $('#id_quotation_edit').val(),
            'id_kode_gambar'  : $('#id_kode_gambar_edit').val(),
            'lokasi'          : $('#lokasi_edit').val(),
            'item'            : $('#item_edit').val(), 
            'tipe'            : $('#tipe_edit').val(),
            'daun'            : $('#daun_edit').val(),
            'warna'           : $('#warna_edit').val(),
            'panjang'         : $('#panjang_edit').val(),
            'lebar'           : $('#lebar_edit').val(),
            'jumlah'          : $("#jumlah_edit").val(),
        }
      })
      .success(function(datasaved){
        
        append2(datasaved['id_k_gambar']);
        $('#id_edit').val('');
        $('#item_edit').val('').trigger('change');
        $('#tipe_edit').val('').trigger('change');
        $('#warna_edit').val('').trigger('change');
        $('#daun_edit').val('');
        $('#panjang_edit').val('');
        $('#lebar_edit').val('');
        $('#jumlah_edit').val('');
        $.growl.notice({ title: 'Sukses', message: "Quotation Updated!"});
        $('#btnEditQuo').click();

        
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

  } else{$.growl.error({ title: 'Peringatan', message: 'Lengkapi Form dulu!' });};
}






function finish() {
  if(confirm('Anda yakin ingin menyelesaikan?'))
  {
    $.growl.notice({ title: 'Berhasil', message: "Quotation selesai!"});
    load_silent("klg/quotation/","#content");
  }
}

</script>


<div class="modal fade" id="myModalku" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Adjustment dan Diskon</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Kode Gambar</label>
                <input type="text" class="form-control" id="kode_gambar_mod" name="kode_gambar_mod" placeholder="Kode Gambar" autocomplete="off">
              </div>              
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Quantity</label>
                <input type="text" class="form-control" id="ket_qty_mod" name="ket_qty_mod" placeholder="Quantity" autocomplete="off">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Dimensi</label>
                <input type="text" class="form-control" id="ket_dimensi_mod" name="ket_dimensi_mod" placeholder="Dimensi" autocomplete="off">
              </div>              
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Keterangan</label>
                <input type="text" class="form-control" id="keterangan_mod" name="keterangan_mod" placeholder="Keterangan" autocomplete="off">
              </div>              
            </div>
        </div>
        <div class="form-group">
          <label class="control-label" for="merk">Adjustment (%):</label>
          <input type="hidden" style="text-align: right;" class="form-control" id="idmodal" name="idmodal" placeholder="Adjustment (%)" autocomplete="off">
          <input type="text" style="text-align: right;" class="form-control" id="adjustment" name="adjustment" placeholder="Adjustment (%)" autocomplete="off">
        </div>
        <div class="form-group">
          <label class="control-label" for="merk">Diskon (%):</label>
          <input type="text" style="text-align: right;" class="form-control" id="diskon" name="diskon" placeholder="Diskon (%)" autocomplete="off">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default tmyModalku" data-dismiss="modal">Close</button>
        <a onclick="saveDiskon()"  class="btn btn-info">Save</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModalTambahan" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Item Tambahan</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Item Tambahan</label>
          <input type="hidden" style="text-align: right;" class="form-control" id="id_quotation_detail" name="id_quotation_detail" autocomplete="off">
          <select id="item_tambahan" name="item_tambahan" class="form-control" style="width:100%" required>
            <option value="">-- Select Item Tambahan --</option>
            <?php foreach ($item_tambahan as $val):?>
              <option value="<?=$val->kode?>">[<?=$val->kode?>] - <?=$val->item?></option>
            <?php endforeach;?>
          </select>
        </div>
        <div class="form-group">
          <label class="control-label" for="merk">Quantity:</label>
          <input type="text" style="text-align: right;" class="form-control" id="qty_tambahan" name="qty_tambahan" placeholder="Quantity" autocomplete="off">
        </div>
        <div class="form-group">
        <a onclick="saveItemTambahan()"  class="btn btn-info">Save</a>
        </div>
        <div id="tblTambahan">
        </div>  
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default tmyModalTambahan" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModalEdit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="hidden" class="form-control" id="id_quotation_edit" name="id_quotation_edit" autocomplete="off">
          <input type="hidden" class="form-control" id="id_kode_gambar_edit" name="id_kode_gambar_edit" autocomplete="off">
          <input type="hidden" class="form-control" id="id_edit" name="id_edit" autocomplete="off">
          <label>Lokasi</label>
          <input type="text" class="form-control" id="lokasi_edit" name="lokasi_edit" placeholder="Lokasi">
        </div>
        <div class="form-group">
          <label>Item</label>
          <select id="item_edit" name="item_edit" class="form-control" style="width:100%" required>
            <option value="">-- Select Item --</option>
            <?php foreach ($item as $val):?>
              <option value="<?=$val->kode?>">[<?=$val->kode?>] - <?=$val->item?></option>
            <?php endforeach;?>
          </select>
          <span id='info'></span>
        </div>
        <div class="form-group fortipe">
          <label>Tipe</label>
          <select id="tipe_edit" name="tipe_edit" class="form-control" style="width:100%" required>
            <option value="">-- Select Tipe --</option>
            <?php foreach ($tipe as $val):?>
              <option value="<?=$val->kode?>">[<?=$val->kode?>] - <?=$val->tipe?></option>
            <?php endforeach;?>
          </select>
        </div>
        <div class="form-group fortipe">
          <label class="control-label" for="merk">Daun</label>
          <input type="text" style="text-align: right;" class="form-control" id="daun_edit" name="daun_edit" placeholder="Daun" autocomplete="off">
        </div>
        <div class="form-group">
          <label>Warna</label>
          <select id="warna_edit" name="warna_edit" class="form-control" style="width:100%" required>
            <option value="">-- Select Warna --</option>
            <?php foreach ($warna as $val):?>
              <option value="<?=$val->kode?>">[<?=$val->kode?>] - <?=$val->warna?></option>
            <?php endforeach;?>
          </select>
        </div>
        <div class="form-group fortipe">
          <label class="control-label" for="merk">Lebar:</label>
          <input type="text" style="text-align: right;" class="form-control" id="lebar_edit" name="lebar_edit" placeholder="Lebar" autocomplete="off">
        </div>
        <div class="form-group fortipe">
          <label class="control-label" for="merk">Tinggi:</label>
          <input type="text" style="text-align: right;" class="form-control" id="panjang_edit" name="panjang_edit" placeholder="Tinggi" autocomplete="off">
        </div>
        
        <div class="form-group">
          <label class="control-label" for="merk">Quantity:</label>
          <input type="text" style="text-align: right;" class="form-control" id="jumlah_edit" name="jumlah_edit" placeholder="Quantity" autocomplete="off">
        </div>
        <div class="form-group">
        <a onclick="saveEditItem()"  class="btn btn-info">Save</a>
        </div> 
        
      </div>
      <div class="modal-footer">
        <button type="button" id="btnEditQuo" class="btn btn-default tmyModalTambahan" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>