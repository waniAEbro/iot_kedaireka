<div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Form Transfer Stok</h3>

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
                <label>Store Awal</label>
                <input type="text" class="form-control" id="q1" value="<?=$row->store?>" readonly>
              </div>              
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Tipe</label>
                <input type="text" class="form-control" id="q2" value="<?=$row->tipe?>" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Item</label>
                <input type="text" class="form-control" id="q3" value="<?=$row->item.' ('.$row->lebar.'x'.$row->tinggi.')'?>" readonly>
              </div>              
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Warna</label>
                <input type="text" class="form-control" id="q4" value="<?=$row->warna?>" readonly>
              </div>              
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Bukaan</label>
                <input type="text" class="form-control" id="bukaan" value="<?=$row->bukaan?>" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Store/Mitra Tujuan</label>
                <select id="store" name="store" class="form-control" style="width:100%" required>
                  <option value="">-- Store/Mitra --</option>
                  <?php foreach ($store as $valap):?>
                    <option value="<?=$valap->id?>"><?=$valap->store?></option>
                  <?php endforeach;?>
                </select>
              </div>              
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Qty</label>
                <input type="text" class="form-control" id="qty" placeholder="Qty">
              </div>              
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Keterangan</label>
                <input type="text" class="form-control" id="keterangan" placeholder="Keterangan">
                <input type="hidden" class="form-control" id="id" value="<?=$row->id?>" >
                <input type="hidden" class="form-control" id="id_invoice" value="<?=$row->id_invoice?>" >
                <input type="hidden" class="form-control" id="id_store" value="<?=$row->id_store?>" >
                <input type="hidden" class="form-control" id="id_tipe" value="<?=$row->id_tipe?>" >
                <input type="hidden" class="form-control" id="id_item" value="<?=$row->id_item?>" >
                <input type="hidden" class="form-control" id="id_warna" value="<?=$row->id_warna?>" >
                <input type="hidden" class="form-control" id="lebar" value="<?=$row->lebar?>" >
                <input type="hidden" class="form-control" id="tinggi" value="<?=$row->tinggi?>" >
                <input type="hidden" class="form-control" id="qty_stok" value="<?=$row->qty_in-$row->qty_out?>" >
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
    $.growl.notice({ title: 'Berhasil', message: "Tambah Permintaan selesai!"});
    load_silent("klg/invoice/","#content");
  }
}
$(document).ready(function() {
  $('.datepicker').datepicker({
    autoclose: true
  });
  $("select").select2();
  $(".harga").hide();
});

function save()
{
  if(confirm('Anda yakin ingin transfer item ini?'))
  {
  $(this).find("button[type='submit']").prop('disabled',true);
     
        $.ajax({
        type: "POST",
        url:site+'warehouse/konsinyasi/saveTransfer',
        dataType:'json',
        data: {
            id          : $("#id").val(),
            id_invoice          : $("#id_invoice").val(),
            id_store          : $("#id_store").val(),
            id_tipe          : $("#id_tipe").val(),
            id_item          : $("#id_item").val(),
            id_warna          : $("#id_warna").val(),
            bukaan          : $("#bukaan").val(),
            lebar          : $("#lebar").val(),
            tinggi          : $("#tinggi").val(),
            qty_stok          : $("#qty_stok").val(),


            store          : $("#store").val(),
            qty          : $("#qty").val(),
            keterangan     : $("#keterangan").val(),
          
        },
        success   : function(data)
        {
          $.growl.notice({ title: 'Sukses', message: data['msg']});
          load_silent("warehouse/konsinyasi/","#content");
        }
      });
  }
}

</script>