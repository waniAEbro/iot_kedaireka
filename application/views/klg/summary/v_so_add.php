<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="box-body big">
    <?php echo form_open('',array('name'=>'faddmenugrup','class'=>'form-horizontal','role'=>'form'));?>
        
        
        
        <div class="form-group">
            <label class="col-sm-12 control-label"><?php echo $nama_item.'-'.$nama_warna.' bukaan '.$bukaan.' '.$lebar.'x'.$tinggi; ?></label>
            
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Real Stock </label>
            <div class="col-sm-8">
            <?php 
            echo form_hidden('item', $item);
            echo form_hidden('warna', $warna);
            echo form_hidden('bukaan', $bukaan);
            echo form_hidden('lebar', $lebar);
            echo form_hidden('tinggi', $tinggi);
            echo form_hidden('id_stockopname', $id_so);
             ?>
            <?php echo form_input(array('name'=>'realstock','value'=>$realstok,'class'=>'form-control'));?>
            <?php echo form_error('realstock');?>
            <span id="check_data"></span>
            </div>
        </div>
        
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Save</label>
            <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"klg/summary/show_addForm/","#divsubcontent")','Save','btn btn-success')." ";
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