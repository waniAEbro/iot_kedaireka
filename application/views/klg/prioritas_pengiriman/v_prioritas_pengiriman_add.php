<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">From Add Prioritas Pengiriman</h3>

                <div class="box-tools pull-right">
                  <?php echo button('load_silent("master/stock/formAdd/","#content")','Reload Page','btn btn-danger','data-toggle="tooltip" title="Add New Stok"');?> 
                </div>
            </div>
          <div class="box-body">
            <?php echo form_open('',array('name'=>'faddmenugrup','class'=>'form-horizontal','role'=>'form'));?>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">No Invoice</label>
                <div class="col-sm-8">
                <?php echo form_dropdown('no_invoice',$no_invoice,set_value('id'),'id="no_invoice" class="form-control select2"');?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">Tgl Prioritas</label>
                <div class="col-sm-8">
                <input type="text" data-date-format="yyyy-mm-dd" value="<?=date('Y-m-d')?>" class="form-control datepicker" id="tgl_prioritas">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Alasan</label>
                <div class="col-sm-8">
                <?php echo form_input(array('name'=>'alasan','id'=>'alasan','class'=>'form-control'));?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Keterangan</label>
                <div class="col-sm-8">
                <?php echo form_input(array('name'=>'keterangan','id'=>'keterangan','class'=>'form-control'));?>
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
    $('.datepicker').datepicker({
    autoclose: true
  });
    $(".select2").select2();
    $('#tombol').removeAttr('disabled',false);
    $('.tutup').click(function(e) {  
        $('#myModal').modal('hide');
    });
});

function save()
{
    $('#tombol').attr('disabled','disabled');
    // var ida = $('#id').val();
        $.ajax({
        type: "POST",
        url: "<?= site_url('klg/prioritas_pengiriman/insert')?>",
        dataType:'json',
        data: {
            id_invoice       : $("#no_invoice").val(),
            tgl_prioritas       : $("#tgl_prioritas").val(),
            alasan : $("#alasan").val(),
            keterangan : $("#keterangan").val(),
          
        },
        success   : function(data)
        {
          $.growl.notice({ title: 'Sukses', message: data['msg']});      
          load_silent("klg/prioritas_pengiriman/","#content");
        }
      });

    
  
  return false;
}

</script>