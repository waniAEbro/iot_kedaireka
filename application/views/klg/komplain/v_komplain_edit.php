<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
    $row = fetch_single_row($edit);
?>

<div class="box-body big">
    <?php echo form_open('',array('name'=>'faddmenugrup','class'=>'form-horizontal','role'=>'form'));?>
        
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Kepada</label>
            <div class="col-sm-8">
            <?php echo form_input(array('name'=>'kepada','value'=>$row->kepada,'class'=>'form-control'));?>
            <?php echo form_error('kepada');?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Perihal</label>
            <div class="col-sm-8">
            <?php echo form_input(array('name'=>'perihal','value'=>$row->perihal,'class'=>'form-control'));?>
            <?php echo form_error('perihal');?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Komplain</label>
            <div class="col-sm-8">
            <?php echo form_input(array('name'=>'komplain','value'=>$row->komplain,'class'=>'form-control'));?>
            <?php echo form_error('komplain');?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Simpan</label>
            <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"klg/komplain/show_editForm/","#divsubcontent")','Simpan','btn btn-success')." ";
            ?>
            </div>
        </div>
    </form>
</div>


<script type="text/javascript">
$(document).ready(function() {
    $(".select2").select2();
    $('.tutup').click(function(e) {  
        $('#myModal').modal('hide');
    });
});
</script>