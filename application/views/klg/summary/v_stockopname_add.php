<?php if($cek_aktif->num_rows()<1){ ?>
<div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Form Stock Opname</h3>

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
                <label>Nomor Stock Opname</label>
                <input type="text" value="<?=$no_so?>" class="form-control datepicker" id="no_so" readonly>
              </div>             
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Tanggal Stock Opname</label>
                <input type="text" data-date-format="yyyy-mm-dd" value="<?=date('Y-m-d')?>" class="form-control datepicker" id="tgl" placeholder="Tanggal Stock Opname" required>
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
<?php } ?>
    <div class="row" id="form_pembelian">
      <div id="kontenso"></div>
    </div>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tableku').DataTable( {
      "scrollX": true,
    } );
    $("select").select2();
    $('.datepicker').datepicker({
      autoclose: true
    });
    <?php
    if($cek_aktif->num_rows()<1){
      echo "$('#form_pembelian').hide();";
    }else{
      echo "load_silent('klg/summary/summary_so','#kontenso');";
    }
    ?>
   
  });


function save()
{
  $(this).find("button[type='submit']").prop('disabled',true);
      $.ajax({
        type: "POST",
        url:site+'klg/summary/saveso',
        dataType:'json',
        data: {
            no_so          : $("#no_so").val(),
            tgl          : $("#tgl").val(),
          
        },
        success   : function(data)
        {
          $('#id').val(data['id']);
          $.growl.notice({ title: 'Sukses', message: data['msg']});
          $('#tutup').click();
          $('#form_pembelian').show();
          load_silent("klg/summary/summary_so","#kontenso");
        }
      });
          return false;
  
}

var xi = 0;


$('#formid').on('keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if(e.keyCode==13 || e.keyCode==9){
    e.preventDefault();    
    quotation();
  }
});


$("#item").change(function(){
      $('#bukaan').val('').trigger('change');
      $.ajax({
        url      : "<?= site_url('klg/produksi/getDetailItem/')?>",
        dataType : "json",
        type     : "POST",
        data     : { 
          "item" : $(this).val(),
        },
        success  : function(img){
           $("#gbritem").html('<div class="form-group"> <label class="control-label">Picture : </label> <img style="padding:10px;" src="<?php echo base_url()."'+img['gambar']+'"; ?>" class="file-preview-image"></div>');
            
              $('#lebar').val(img['lebar']);
              $('#tinggi').val(img['tinggi']);
              $('#harga').val(img['harga']);
              $('#jenis_barang').html('Jenis Barang : '+img['jenis_barang']);
              
             
          }
      });

  
  });
</script>