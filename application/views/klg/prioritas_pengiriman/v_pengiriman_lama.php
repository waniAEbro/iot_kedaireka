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
                <label>No Permintaan</label>
                <input type="text" class="form-control" id="no_invoice" name="no_invoice" value="<?=$rowPermintaan->no_invoice?>" readonly required>
                <input type="hidden" class="form-control" id="id_invoice" name="id_invoice" value="<?=$rowPermintaan->id?>" readonly required>
              </div>              
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>No PO/SO</label>
                <input type="text" class="form-control" id="no_po" name="no_po" value="<?=$rowPermintaan->no_po?>" readonly required>
              </div>              
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Store</label>
                <input type="text" class="form-control" id="store" name="store" value="<?=$rowPermintaan->store?>" readonly required>
                <input type="hidden" class="form-control" id="id_store" name="id_store" value="<?=$rowPermintaan->id_store?>" readonly required>
              </div>              
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>No. Telp</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?=$rowPermintaan->no_telp?>" readonly required>
              </div>              
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Alamat Pengiriman</label>
                <input type="text" class="form-control" id="alamat" value="<?=$rowPermintaan->alamat_proyek?>" placeholder="Alamat Pengiriman">
              </div> 
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Sopir</label>
                <input type="text" class="form-control" id="sopir" placeholder="Sopir">
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
                <label>Special Intruction</label><br>
                <textarea id="keterangan" name="keterangan" rows="10" cols="150">
                </textarea>
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
          <h3>Detail Pengiriman</h3>
          <table width="100%" class="table table-bordered" style="font-size: smaller;">
            <thead>
              <tr>
                <th>No</th>
                <th>Item</th>
                <th>Warna</th>
                <th>Bukaan</th>
                <th>Blm Terkirim</th>
                <th>Stok</th>
                <th>Terkirim</th>
                <th>Tipe</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; $row=1;$totrow=0;$totstat=0;?>
              <?php foreach($detail as $val):
              $qtyIn = $this->m_prioritas_pengiriman->getQtyIn($val->id_item,$val->id_tipe,$val->id_warna,$val->bukaan,$val->lebar,$val->tinggi);
              $qtyOutAll = $this->m_prioritas_pengiriman->getQtyOutAll($val->id_item,$val->id_tipe,$val->id_warna,$val->bukaan,$val->lebar,$val->tinggi);
              $qtyOut = $this->m_prioritas_pengiriman->getQtyOut($val->id_item,$val->id_tipe,$val->id_warna,$val->bukaan,$val->lebar,$val->tinggi,$val->id_invoice);
              if ($qtyIn !='') {
                $in = $qtyIn;
              } else {
                $in = 0;
              }
              if ($qtyOut !='') {
                $send = $qtyOut;
              } else {
                $send = 0;
              }
              if ($qtyOutAll !='') {
                $out = $qtyOutAll;
              } else {
                $out = 0;
              }
              $stok = $in-$out;
              $permintaan = $val->qty-$send;
              if ($permintaan>$stok) {
                $stat = 0;
                $notif = "#ff8063";
              } else {
                $stat = 1;
                $notif = "";
              }
              
              $totrow=$totrow+$row;
              $totstat=$totstat+$stat;
              ?>
              <tr bgcolor="<?=$notif?>">
                <td align="center"><?=$i?></td>
                <td><?=$val->item.' ('.$val->lebar.'x'.$val->tinggi.')'?></td>
                <td align="center"><?=$val->warna?></td>
                <td align="center"><?=$val->bukaan?></td>
                <td align="center"><?=$permintaan?></td>
                <td align="center"><?=$stok?></td>
                <td align="center"><?=$send?></td>
                <td align="center"><?=$val->tipe?></td>
              </tr>
              <?php $i++; ?>                
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="box-footer">
          <?php
            if ($totrow==$totstat) { ?>
          <button type="submit" onclick="save()" id="proses" class="btn btn-success kirimsemua">Kirim Semua</button>
          <button type="submit" onclick="kirimParsial()" id="proses" class="btn btn-primary kirimsemua">Kirim Parsial</button>
           <?php
            } else{ ?>
              <h2 style="color:red;">Stok ada yang kurang!</h2>
          <button type="submit" onclick="kirimParsial()" id="proses" class="btn btn-primary">Kirim Parsial</button>
            <?php 
            }
          ?>
        </div>
      </form>
    </div>

    <div class="row" id="form_pembelian">
      <div class="col-lg-4">
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
                    <?php foreach ($detail as $val):?>
                      <option value="<?=$val->id?>"><?=$val->item.' ('.$val->lebar.'x'.$val->tinggi.')'?> - <?=$val->warna?> - <?=$val->bukaan?> - <?=$val->tipe?></option>
                    <?php endforeach;?>
                  </select>
                  <span id='gbritem'></span>
                </div>
                
                <div class="form-group">
                  <label class="control-label" for="merk">Quantity:</label>
                  <input type="hidden" class="form-control" id="id_pengiriman">
                  <input type="hidden" class="form-control" id="id_tipe">
                  <input type="hidden" class="form-control" id="id_item">
                  <input type="hidden" class="form-control" id="id_warna">
                  <input type="hidden" class="form-control" id="bukaan">
                  <input type="hidden" class="form-control" id="lebar">
                  <input type="hidden" class="form-control" id="tinggi">
                  <input type="hidden" class="form-control" id="harga">
                  <input type="hidden" class="form-control" id="qty_kurang">
                  <input type="text" style="text-align: right;" class="form-control" id="qty" name="qty" placeholder="Quantity" autocomplete="off">
                </div>
                <div class="form-group">
                  <a onclick="quotation()"  class="btn btn-info">Add Pengiriman</a>
                </div>
              </div>
            </form>
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
                  <th width="15%">Item</th>
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
    $.growl.notice({ title: 'Berhasil', message: "Surat Jalan Berhasil!"});
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
    CKEDITOR.replace('keterangan');
  //bootstrap WYSIHTML5 - text editor
  $(".textarea").wysihtml5();

  $(".harga").hide();

  $('#form_pembelian').hide();
});

function save()
{
  $(this).find("button[type='submit']").prop('disabled',true);
     var path = $("#lampiran").val().replace('C:\\fakepath\\', '');
    if(path == ''){
        $.ajax({
        type: "POST",
        url:site+'klg/prioritas_pengiriman/savepengiriman',
        dataType:'json',
        data: {
            id_store     : $("#id_store").val(),
            no_pengiriman     : $("#no_pengiriman").val(),
            id_invoice        : $("#id_invoice").val(),
            sopir             : $("#sopir").val(),
            no_polisi         : $("#no_polisi").val(),
            keterangan     : CKEDITOR.instances.keterangan.getData(),
          
        },
        success   : function(data)
        {
          $('#id_pengiriman').val(data['id']);
          $.growl.notice({ title: 'Sukses', message: data['msg']});
          // $('#tutup').click();
          // $('#form_pembelian').show(1000);
          load_silent("klg/pengiriman/","#content");
        }
      });
    }
     else{
        $.ajaxFileUpload
          ({
            url:site+'klg/prioritas_pengiriman/savepengirimanImage',
            secureuri:false,
            fileElementId:'lampiran',
            dataType: 'json',
            data: {
                id_store     : $("#id_store").val(),
                no_pengiriman     : $("#no_pengiriman").val(),
                id_invoice        : $("#id_invoice").val(),
                sopir             : $("#sopir").val(),
                no_polisi         : $("#no_polisi").val(),
                keterangan     : CKEDITOR.instances.keterangan.getData(),
              },
            success: function (data)
            {
              $('#id_pengiriman').val(data['id']);
              $.growl.notice({ title: 'Berhasil', message: data['msg'] });
              // $('#tutup').click();
              // $('#form_pembelian').show(1000);
              load_silent("klg/pengiriman/","#content");
            },
            error: function (data, e)
            {
              $("#info").html(e);
            }
          })
          return false;
    };
  
}

function kirimParsial()
{
  $(this).find("button[type='submit']").prop('disabled',true);
     var path = $("#lampiran").val().replace('C:\\fakepath\\', '');
     $(".kirimsemua").hide();
    if(path == ''){
        $.ajax({
        type: "POST",
        url:site+'klg/prioritas_pengiriman/savepengirimanparsial',
        dataType:'json',
        data: {
            id_store     : $("#id_store").val(),
            no_pengiriman     : $("#no_pengiriman").val(),
            id_invoice        : $("#id_invoice").val(),
            sopir             : $("#sopir").val(),
            no_polisi         : $("#no_polisi").val(),
            keterangan     : CKEDITOR.instances.keterangan.getData(),
          
        },
        success   : function(data)
        {
          $('#id_pengiriman').val(data['id']);
          $.growl.notice({ title: 'Sukses', message: data['msg']});
          // $('#tutup').click();
          $('#form_pembelian').show(1000);
          // load_silent("klg/pengiriman/","#content");
        }
      });
    }
     else{
        $.ajaxFileUpload
          ({
            url:site+'klg/prioritas_pengiriman/savepengirimanImageparsial',
            secureuri:false,
            fileElementId:'lampiran',
            dataType: 'json',
            data: {
                id_store     : $("#id_store").val(),
                no_pengiriman     : $("#no_pengiriman").val(),
                id_invoice        : $("#id_invoice").val(),
                sopir             : $("#sopir").val(),
                no_polisi         : $("#no_polisi").val(),
                keterangan     : CKEDITOR.instances.keterangan.getData(),
              },
            success: function (data)
            {
              $('#id_pengiriman').val(data['id']);
              $.growl.notice({ title: 'Berhasil', message: data['msg'] });
              // $('#tutup').click();
              $('#form_pembelian').show(1000);
              // load_silent("klg/pengiriman/","#content");
            },
            error: function (data, e)
            {
              $("#info").html(e);
            }
          })
          return false;
    };
  
}













$("#item").change(function(){
      $.ajax({
        url      : "<?= site_url('klg/prioritas_pengiriman/getInvoiceDetail/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "id" : $(this).val(),
        },
        success  : function(img){
           $('#id_tipe').val(img['id_tipe']);
            $('#id_item').val(img['id_item']);
            $('#id_warna').val(img['id_warna']);
            $('#bukaan').val(img['bukaan']);
            $('#lebar').val(img['lebar']);
            $('#tinggi').val(img['tinggi']);
            $('#harga').val(img['harga']);
            $('#qty_kurang').val(img['qty_kurang']);
          }
      });

  
  });
function quotation() {
  if ($('#item').val() !='' && $('#qty').val() !='') 
  {
    if(parseInt($('#qty').val())>parseInt($('#qty_kurang').val())){
      $.growl.error({ title: 'Peringatan', message: 'Qty melebihi kekurangan pengiriman!' });
    }else{
  


                  $.ajax({
                      type: "POST",
                      url: "<?=site_url('klg/prioritas_pengiriman/savepengirimanDetail')?>",
                      dataType:'json',
                      data: {
                        'id_store'      : $('#id_store').val(),
                        'id_pengiriman'      : $('#id_pengiriman').val(),
                        'id_invoice'    : $("#no_invoice").val(),
                        'id_invoice'        : $("#id_invoice").val(),
                        'id_tipe'         : $("#id_tipe").val(),
                        'id_item'         : $("#id_item").val(),
                        'id_warna'         : $("#id_warna").val(),
                        'bukaan'         : $("#bukaan").val(),
                        'lebar'         : $("#lebar").val(),
                        'tinggi'         : $("#tinggi").val(),
                        'harga'         : $("#harga").val(),
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
                  <td width="15%">\
                    '+$('#item :selected').text()+'\
                  </td>\
                  <td width="5%">\
                    '+$('#qty').val()+'\
                  </td>\
                </tr>';
                $('tr.odd').remove();
                $('#dataTbl').append(x);
                $('#item').val('').trigger('change');
               
                $('#qty').val('');
                $.growl.notice({ title: 'Sukses', message: "Berhasil menyimpan pengiriman"});
                
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

}

  } else{$.growl.error({ title: 'Peringatan', message: 'Lengkapi Form dulu!' });};
}
</script>