<div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Form Memo</h3>

        <div class="box-tools pull-right">
          <button type="button" id="tutup" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <form method="post" class="form-vertical form_faktur" role="form">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Store</label>
                <select id="store" name="store" class="form-control" style="width:100%" required>
                  <option value="">-- Store --</option>
                  <?php foreach ($store as $valap):?>
                    <?php if($valap->id==$row->id_store){$selb="selected";}else{$selb="";}?>
                    <option value="<?=$valap->id?>" <?=$selb?>><?=$valap->store?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>No Memo</label>
                <input type="text" class="form-control" id="nomor_memo" name="nomor_memo" value="<?=$row->no_memo?>" placeholder="No Memo" readonly required>
              </div>              
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Project</label>
                <input type="text" class="form-control" id="nama_project" name="nama_project" placeholder="Nama Project" value="<?=$row->nama_project?>" required autocomplete="off">
              </div>              
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Alamat Project</label>
                <input type="text" class="form-control" id="alamat_project" name="alamat_project" value="<?=$row->alamat_project?>" placeholder="Alamat Project" required autocomplete="off">
              </div>              
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Tanggal Memo</label>
                <input type="text" data-date-format="yyyy-mm-dd" value="<?=$row->tgl_memo?>" class="form-control datepicker" id="tgl_memo" placeholder="Tanggal Memo" required>
              </div>             
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Deadline Pengambilan</label>
                <input type="text" data-date-format="yyyy-mm-dd" value="<?=$row->deadline_pengambilan?>" class="form-control datepicker" id="deadline_pengambilan" placeholder="Deadline Pengambilan" required>
              </div>             
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>No FPPP</label>
                <input type="text" class="form-control" id="no_fppp" name="no_fppp" placeholder="No FPPP" value="<?=$row->no_fppp?>" required autocomplete="off">
              </div>             
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Charge</label>
                <select id="charge" name="charge" class="form-control" style="width:100%" required>
                  <?php
                  if ($row->charge == 'Ya') {
                    $yae = "selected";
                    $tdke = "";
                  } elseif ($row->charge == 'Tidak') {
                    $yae = "";
                    $tdke = "selected";
                  } else {
                    $yae = "";
                    $tdke = "";
                  }
                  
                  ?>
                  <option value="">-- Charge --</option>
                    <option value="Ya" <?=$yae?>>Ya</option>
                    <option value="Tidak" <?=$tdke?>>Tidak</option>
                </select>
              </div>             
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label>Alasan</label>
                <input type="text" class="form-control" id="alasan" name="alasan" placeholder="Alasan Memo" value="<?=$row->alasan?>" required autocomplete="off">
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
                  <label>Tipe Item</label>
                  <select id="tipe_memo" name="tipe_memo" class="form-control" style="width:100%" required>
                    <option value="">-- Tipe Item --</option>
                    <?php foreach ($tipe_memo as $valap):?>
                      <?php if($valap->id=='1'){$sel = "selected";}else{$sel = "";}?>
                      <option value="<?=$valap->id?>" <?=$sel?>><?=$valap->tipe?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Item</label>
                  <select id="item" name="item" class="form-control" style="width:100%" required>
                    <option value="">-- Select Item --</option>
                    <?php foreach ($item as $val):?>
                      <option value="<?=$val->id?>"><?=$val->item?></option>
                    <?php endforeach;?>
                  </select>
                  <span id='gbritem'></span>
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
                  <input type="hidden" class="form-control" value="<?=$row->id?>" id="id_memo" name="id_memo" readonly>
                  <input type="text" style="text-align: right;" class="form-control" id="lebar" value="0" name="lebar" placeholder="Lebar" autocomplete="off">
                  <span id="infolebar"></span>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Tinggi (mm):</label>
                  <input type="text" style="text-align: right;" class="form-control" id="tinggi" value="0" name="tinggi" placeholder="Tinggi" autocomplete="off">
                  <span id="infotinggi"></span>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Ada di WO:</label>
                  <select id="ada_di_wo" name="ada_di_wo" class="form-control" style="width:100%" required>
                    <option value="">-- Select Ada di WO --</option>
                      <option value="ya">Ya</option>
                      <option value="tidak">Tidak</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Alasan:</label>
                  <select id="alasan" name="alasan" class="form-control" style="width:100%" required>
                    <option value="">-- Alasan --</option>
                    <?php foreach ($alasan as $valap):?>
                      <option value="<?=$valap->id?>"><?=$valap->alasan?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Charge:</label>
                  <select id="charge" name="charge" class="form-control" style="width:100%" required>
                    <option value="">-- Select Charge --</option>
                      <option value="ya">Ya</option>
                      <option value="tidak">Tidak</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label" for="merk">Barang dikembalikan:</label>
                  <select id="brg_dikembalikan" name="brg_dikembalikan" class="form-control" style="width:100%" required>
                    <option value="">-- Select Charge --</option>
                      <option value="ya">Ya</option>
                      <option value="tidak">Tidak</option>
                  </select>
                </div>

                <div class="form-group">
                  <label class="control-label" for="merk">Keterangan:</label>
                  <input type="text" class="form-control" id="ket_detail" name="ket_detail" autocomplete="off">
                </div>
                
                <div class="form-group">
                  <a onclick="quotation()"  class="btn btn-info">Add Memo</a>
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
                  <th width="35%">Item</th>
                  <th width="5%">Ada di WO</th>
                  <th width="10%">Alasan</th>
                  <th width="5%">Charge</th>
                  <th width="5%">Brg dikembalikan</th>
                </tr>
              </thead>
              <tbody id="dataTbl">
                <?php $i = 1; ?>
                <?php foreach($detail as $val):
                ?>
                <tr id="output_data_<?=$val->id?>" class="output_data">
                  <td align="center">
                    <a href="javascript:void(0)" onClick="hapus(<?=$val->id?>)">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                  <td><?=$val->tipe?> - <?=$val->item?>( <?=$val->lebar.'x'.$val->tinggi?> ) - <?=$val->warna?> - <?=$val->bukaan?></td>
                  <td><?=$val->ada_di_wo?></td>
                  <td><?=$val->alasan?></td>
                  <td><?=$val->charge?></td>
                  <td><?=$val->brg_dikembalikan?></td>
                </tr>
                <?php $i++; ?>                
                <?php endforeach; ?>
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
    $.growl.notice({ title: 'Berhasil', message: "Tambah Memo selesai!"});
    load_silent("klg/memo/","#content");
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

  
  
  $('.form_pembelian').hide();
});

function save()
{
  $(this).find("button[type='submit']").prop('disabled',true);
     var path = $("#lampiran").val().replace('C:\\fakepath\\', '');
    if(path == ''){
        $.ajax({
        type: "POST",
        url:site+'klg/memo/updatememo',
        dataType:'json',
        data: {
            id_memo              : $('#id_memo').val(),
            id_store              : $("#store").val(),
            no_memo               : $("#nomor_memo").val(),
            nama_project          : $("#nama_project").val(),
            alamat_project        : $("#alamat_project").val(),
            tgl_memo              : $("#tgl_memo").val(),
            deadline_pengambilan  : $("#deadline_pengambilan").val(),
            no_fppp               : $("#no_fppp").val(),
            charge               : $("#charge").val(),
            alasan               : $("#alasan").val(),
          
        },
        success   : function(data)
        {
          // $('#id_memo').val(data['id']);
          $.growl.notice({ title: 'Sukses', message: data['msg']});
          $('#tutup').click();
          $('#form_pembelian').show(1000);
        }
      });
    }
     else{
        $.ajaxFileUpload
          ({
            url:site+'klg/memo/updatememoImage',
            secureuri:false,
            fileElementId:'lampiran',
            dataType: 'json',
            data: {
                id_memo              : $('#id_memo').val(),
                id_store              : $("#store").val(),
                no_memo               : $("#nomor_memo").val(),
                nama_project          : $("#nama_project").val(),
                alamat_project        : $("#alamat_project").val(),
                tgl_memo              : $("#tgl_memo").val(),
                deadline_pengambilan  : $("#deadline_pengambilan").val(),
                no_fppp               : $("#no_fppp").val(),
                charge               : $("#charge").val(),
                alasan               : $("#alasan").val(),
              },
            success: function (data)
            {
              // $('#id_memo').val(data['id']);
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
  if ($('#id_memo').val() !='' && $('#item').val() !='' ) 
  {

                  $.ajax({
                      type: "POST",
                      url: "<?=site_url('klg/memo/savememoDetail')?>",
                      dataType:'json',
                      data: {
                        'id_memo'      : $('#id_memo').val(),
                        'tipe_memo'    : $("#tipe_memo").val(),
                        'item'            : $("#item").val(),
                        'warna'           : $("#warna").val(),
                        'bukaan'          : $("#bukaan").val(),
                        'lebar'           : $("#lebar").val(),
                        'tinggi'          : $("#tinggi").val(),
                        'ada_di_wo'          : $("#ada_di_wo").val(),
                        'id_alasan'          : $("#alasan").val(),
                        'charge'          : $("#charge").val(),
                        'brg_dikembalikan'          : $("#brg_dikembalikan").val(),
                        'keterangan'      : $("#ket_detail").val(),
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
                    '+$('#tipe_memo :selected').text()+'-'+$('#item :selected').text()+' ('+$('#lebar').val()+'x'+$('#tinggi').val()+') '+$('#warna :selected').text()+'-'+$('#bukaan').val()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#ada_di_wo :selected').text()+'\
                  </td>\
                  <td width="10%">\
                    '+$('#alasan :selected').text()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#charge :selected').text()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#brg_dikembalikan :selected').text()+'\
                  </td>\
                </tr>';
                $('tr.odd').remove();
                $('#dataTbl').append(x);
                $('#item').val('').trigger('change');
                $('#warna').val('').trigger('change');
                $('#bukaan').val('').trigger('change');
                $('#lebar').val('');
                $('#tinggi').val('');
                $.growl.notice({ title: 'Sukses', message: "Berhasil menyimpan Memo"});
                
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
      url: "<?=site_url('klg/memo/deleteItem')?>",
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
        url      : "<?= site_url('klg/memo/getDetailStore/')?>",
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

$("#tipe_memo").change(function(){
    if ($(this).val()==2) {
      // $('#lebar').attr('readonly', false);
      // $('#tinggi').attr('readonly', false);
      $('#lebar').val(0);
      $('#tinggi').val(0);
    }else{
      // $('#lebar').attr('readonly', true);
      // $('#tinggi').attr('readonly', true);
    }
});



$("#item").change(function(){
      $.ajax({
        url      : "<?= site_url('klg/memo/getDetailItem/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "item" : $(this).val(),
        },
        success  : function(img){
           $("#gbritem").html('<div class="form-group"> <label class="control-label">Picture : </label> <img style="padding:10px;" src="<?php echo base_url()."'+img['gambar']+'"; ?>" class="file-preview-image"></div>');
            if ($("#tipe_memo").val()==1) {
              $('#lebar').val(img['lebar']);
              $('#tinggi').val(img['tinggi']);
            } 
          }
      });

  
  });
</script>