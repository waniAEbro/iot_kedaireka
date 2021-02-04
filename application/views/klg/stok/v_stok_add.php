<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">From Add Item</h3>

                <div class="box-tools pull-right">
                  <?php echo button('load_silent("master/stock/formAdd/","#content")','Reload Page','btn btn-danger','data-toggle="tooltip" title="Add New Stok"');?> 
                </div>
            </div>
          <div class="box-body">
            <?php echo form_open('',array('name'=>'faddmenugrup','class'=>'form-horizontal','role'=>'form'));?>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">Produk dari</label>
                <div class="col-sm-8">
                <?php echo form_dropdown('produk_dari',$produk_dari,set_value('id'),'id="produk_dari" class="form-control"');?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Item</label>
                <div class="col-sm-8">
                <?php echo form_dropdown('item',$item,set_value('id'),'id="item" class="form-control"');?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Warna</label>
                <div class="col-sm-8">
                <?php echo form_dropdown('warna',$warna,set_value('id'),'id="warna" class="form-control"');?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Bukaan</label>
                <div class="col-sm-8">
                <?php echo form_dropdown('bukaan',$bukaan,set_value('bukaan'),'id="bukaan" class="form-control"');?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Lebar</label>
                <div class="col-sm-8">
                <?php echo form_input(array('name'=>'lebar','id'=>'lebar','class'=>'form-control'));?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Tinggi</label>
                <div class="col-sm-8">
                <?php echo form_input(array('name'=>'tinggi','id'=>'tinggi','class'=>'form-control'));?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Qty</label>
                <div class="col-sm-8">
                <?php echo form_input(array('name'=>'qty','id'=>'qty','class'=>'form-control'));?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Lokasi</label>
                <div class="col-sm-8">
                <?php echo form_dropdown('lokasi',$lokasi,set_value('id'),'id="lokasi" class="form-control"');?>
                </div>
            </div>
                       

            <div class="form-group">
                <label class="col-sm-2 control-label" >Save</label>
                <div class="col-sm-8 tutup">
                <input onclick="save()" type="submit" id="tombol" value="Save" class="btn btn-success" disabled>
                </div>
            </div>
        </form>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript">
$(document).ready(function() {
    
    $("select").select2();
    $('#tombol').removeAttr('disabled',false);
});

function save()
{
    $('#tombol').attr('disabled','disabled');
    // var ida = $('#id').val();
        $.ajax({
        type: "POST",
        url: "<?= site_url('klg/stock/insert')?>",
        dataType:'json',
        data: {
            id_produk_dari       : $("#produk_dari").val(),
            id_item       : $("#item").val(),
            id_warna : $("#warna").val(),
            bukaan : $("#bukaan").val(),
            lebar : $("#lebar").val(),
            tinggi : $("#tinggi").val(),
            qty : $("#qty").val(),
            id_lokasi : $("#lokasi").val(),
          
        },
        success   : function(data)
        {
          $.growl.notice({ title: 'Sukses', message: data['msg']});      
          load_silent("klg/stock/","#content");
        }
      });

    
  
  return false;
}

</script>