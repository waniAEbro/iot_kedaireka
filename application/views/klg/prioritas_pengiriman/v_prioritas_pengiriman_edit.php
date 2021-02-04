<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
    $row = fetch_single_row($edit);
?>

<div class="box-body big">
    <?php echo form_open('',array('name'=>'faddmenugrup','class'=>'form-horizontal','role'=>'form'));?>
        <div class="form-group">
            <label class="col-sm-4 control-label">No Permintaan</label>
            <div class="col-sm-8">
            <input type="text" value="<?=$row->no_invoice?>" class="form-control" id="x" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Tgl Prioritas</label>
            <div class="col-sm-8">
            <?php echo form_hidden('id',$row->id); ?>
            <input type="text" data-date-format="yyyy-mm-dd" value="<?=$row->tgl_pengiriman?>" class="form-control datepicker" name="tgl_pengiriman">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Simpan</label>
            <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"klg/prioritas_pengiriman/show_editForm/","#divsubcontent")','Simpan','btn btn-success')." ";
            ?>
            </div>
        </div>
    </form>
</div>


<script type="text/javascript">
$(document).ready(function() {
    $('.datepicker').datepicker({
    autoclose: true
  });
    $('.tutup').click(function(e) {  
        $('#myModal').modal('hide');
    });
});
</script>