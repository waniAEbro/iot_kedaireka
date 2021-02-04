<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="box-body big">
    <?php echo form_open('',array('name'=>'faddmenugrup','class'=>'form-horizontal','role'=>'form'));?>
        
        
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Kepada</label>
            <div class="col-sm-8">
            <?php echo form_input(array('name'=>'kepada','class'=>'form-control'));?>
            <?php echo form_error('kepada');?>
            <span id="check_data"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Perihal</label>
            <div class="col-sm-8">
            <?php echo form_input(array('name'=>'perihal','class'=>'form-control'));?>
            <?php echo form_error('perihal');?>
            <span id="check_data"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Komplain</label>
            <div class="col-sm-8">
            <?php echo form_input(array('name'=>'komplain','class'=>'form-control'));?>
            <?php echo form_error('komplain');?>
            <span id="check_data"></span>
            </div>
        </div>
        
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Save</label>
            <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"klg/komplain/show_addForm/","#divsubcontent")','Save','btn btn-success')." ";
            ?>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('.tutup').click(function(e) {  
        $('#myModal').modal('hide');
    });
});
</script>