<div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Form Pengiriman</h3>

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
                <label>No Surat Jalan</label>
                <input type="text" class="form-control" id="no_pengiriman" name="no_pengiriman" value="<?=$nomor_pengiriman?>" placeholder="No pengiriman" readonly required>
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
                <label>No Telp.</label>
                <input type="text" class="form-control" id="no_telp" placeholder="No Telp.">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Alamat Pengiriman</label>
                <input type="text" class="form-control" id="alamat" placeholder="Alamat Pengiriman">
              </div> 
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Sopir</label>
                <input type="text" class="form-control" id="Sopir" placeholder="Sopir">
              </div> 
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>No Polisi</label>
                <input type="text" class="form-control" id="no_polisi" placeholder="No Polisi">
              </div> 
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Upload Lampiran</label>
                <?php echo form_upload(array('name'=>'lampiran','id'=>'lampiran'));?>
                <span style="color:red">*) Lampiran File berformat .pdf maks 2MB</span>
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

<script language="javascript">
function finish() {
  if(confirm('Anda yakin ingin menyelesaikan?'))
  {
    $.growl.notice({ title: 'Berhasil', message: "Quotation selesai!"});
    load_silent("klg/pengiriman/","#content");
  }
}
$(document).ready(function() {
  $('.datepicker').datepicker({
    autoclose: true
  });

  $("#lampiran").fileinput({
    'showUpload'            :true
    });
  $('.fileinput-upload-button').hide();
  $("select").select2();
  $(".harga").hide();

  $('.form_pembelian').hide();
});

function save()
{
  $(this).find("button[type='submit']").prop('disabled',true);
     var path = $("#lampiran").val().replace('C:\\fakepath\\', '');
    if(path == ''){
        $.ajax({
        type: "POST",
        url:site+'klg/pengiriman/savepengiriman',
        dataType:'json',
        data: {
            no_pengiriman     : $("#no_pengiriman").val(),
            id_store     : $("#store").val(),
            no_telp        : $("#no_telp").val(),
            alamat_proyek  : $("#alamat").val(),
            sopir  : $("#sopir").val(),
            no_polisi  : $("#no_polisi").val(),
          
        },
        success   : function(data)
        {
          $('#id_pengiriman').val(data['id']);
          $.growl.notice({ title: 'Sukses', message: data['msg']});
          $('#tutup').click();
          $('#form_pembelian').show(1000);
        }
      });
    }
     else{
        $.ajaxFileUpload
          ({
            url:site+'klg/pengiriman/savepengirimanImage',
            secureuri:false,
            fileElementId:'lampiran',
            dataType: 'json',
            data: {
                no_pengiriman     : $("#no_pengiriman").val(),
                id_store     : $("#store").val(),
                no_telp        : $("#no_telp").val(),
                alamat_proyek  : $("#alamat").val(),
              },
            success: function (data)
            {
              $('#id_pengiriman').val(data['id']);
              $.growl.notice({ title: 'Berhasil', message: data['msg'] });
              $('#tutup').click();
              $('#form_pembelian').show(1000);
            },
            error: function (data, e)
            {
              $("#info").html(e);
            }
          })
          return false;
    };
  
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
  if ($('#id_pengiriman').val() !='' && $('#item').val() !='' && $('#warna').val() != '' && $('#qty').val() !='' && $("#tipe_custom").val()!='' ) 
  {

                  $.ajax({
                      type: "POST",
                      url: "<?=site_url('klg/pengiriman/savepengirimanDetail')?>",
                      dataType:'json',
                      data: {
                        'id_pengiriman'      : $('#id_pengiriman').val(),
                        'id_invoice'    : $("#no_invoice").val(),
                        'id_invoice_detail'    : $("#item").val(),
                        'keterangan'        : $("#ket_detail").val(),
                        'qty'        : $("#qty").val(),
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
                    '+$('#no_invoice :selected').text()+'\
                  </td>\
                  <td width="10%">\
                    '+$('#item :selected').text()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#tipe').val()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#warna').val()+'\
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
                $('#tipe').val('');
                $('#warna').val('');
                $('#lebar').val('');
                $('#tinggi').val('');
                $('#qty').val('');
                $.growl.notice({ title: 'Sukses', message: "Berhasil menyimpan produk pengiriman"});
                
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
      url: "<?=site_url('klg/pengiriman/deleteItem')?>",
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

$("#store").change(function(){
      $.ajax({
        url      : "<?= site_url('klg/pengiriman/getDetailStore/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "store" : $(this).val(),
        },
        success  : function(img){
            $('#no_telp').val(img['no_telp']);
            $('#alamat').val(img['alamat']);
          }
      });

  
  });

$("#tipe_pengiriman").change(function(){
    if ($(this).val()==2) {
      $('#lebar').attr('readonly', false);
      $('#tinggi').attr('readonly', false);
      $('.harga').show(50);
      $('#lebar').val(0);
      $('#tinggi').val(0);
      $('#harga').val(0);
    }else{
      $('#lebar').attr('readonly', true);
      $('#tinggi').attr('readonly', true);
      $('#harga').val('0');
      $('.harga').hide(50);
    }
});

$("select[name=store]").change(function(){
    var x = $("select[name=no_invoice]");
    if($(this).val() == "") {
      x.html("<option>-- Select No Permintaan --</option>");
    }
    else {
      z = "<option>-- Select No Permintaan --</option>";
      $.ajax({
        url      : "<?=site_url('klg/pengiriman/getInvoiceMitra')?>",
        dataType : "json",
        type     : "POST",
        data     : { "id" : $(this).val() },
        success  : function(data){

          var z = "<option value=''>-- Select No Permintaan --</option>";
          for(var i = 0; i<data.length; i++){
            z += '<option value='+data[i].id+'>'+data[i].no_invoice+'</option>';
          }

          
          x.html(z);
          $('#no_invoice').val('').trigger('change');

         
        }
      });

    }
  });

$("select[name=no_invoice]").change(function(){
    var x = $("select[name=item]");
    if($(this).val() == "") {
      x.html("<option>-- Select Item --</option>");
    }
    else {
      z = "<option>-- Select Item --</option>";
      $.ajax({
        url      : "<?=site_url('klg/pengiriman/getItemInvoice')?>",
        dataType : "json",
        type     : "POST",
        data     : { "id" : $(this).val() },
        success  : function(data){

          var z = "<option value=''>-- Select Item --</option>";
          for(var i = 0; i<data.length; i++){
            z += '<option value='+data[i].id+'>'+data[i].item+'-'+data[i].tipe+'</option>';
          }

          
          x.html(z);
          $('#item').val('').trigger('change');

         
        }
      });

    }
  });


$("#item").change(function(){
      $.ajax({
        url      : "<?= site_url('klg/pengiriman/getDetailItemInvoice/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "id" : $(this).val(),
        },
        success  : function(img){
           $("#gbritem").html('<div class="form-group"> <label class="control-label">Picture : </label> <img style="padding:10px;" src="<?php echo base_url()."'+img['gambar']+'"; ?>" class="file-preview-image"></div>');
            $('#tipe').val(img['tipe']);
            $('#warna').val(img['warna']);
            $('#lebar').val(img['lebar']);
            $('#tinggi').val(img['tinggi']);
          }
      });

  
  });
</script>