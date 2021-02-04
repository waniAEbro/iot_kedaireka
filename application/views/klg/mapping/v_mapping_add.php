<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="box-body big">
    <?php echo form_open('',array('name'=>'faddmenugrup','class'=>'form-horizontal','role'=>'form'));?>
        
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Item</label>
            <div class="col-sm-8">
            <select id="item" name="item" class="form-control" style="width:100%">
              <option value="">-- Item --</option>
              <?php foreach ($item->result() as $val):?>
                <option value="<?=$val->id?>"><?=$val->item?></option>
              <?php endforeach;?>
            </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Warna</label>
            <div class="col-sm-8">
            <select id="warna" name="warna" class="form-control" style="width:100%">
              <option value="">-- Warna --</option>
              <?php foreach ($warna->result() as $val):?>
                <option value="<?=$val->id?>"><?=$val->warna?></option>
              <?php endforeach;?>
            </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Harga Jabotabek</label>
            <div class="col-sm-8">
            <?php echo form_input(array('name'=>'harga_jabotabek','class'=>'form-control'));?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Harga Dalam Pulau</label>
            <div class="col-sm-8">
            <?php echo form_input(array('name'=>'harga_dalam_pulau','class'=>'form-control'));?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Harga Luar Pulau</label>
            <div class="col-sm-8">
            <?php echo form_input(array('name'=>'harga_luar_pulau','class'=>'form-control'));?>
            </div>
        </div>
                
        <div class="form-group">
            <label class="col-sm-4 control-label">Save</label>
            <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"klg/mapping/show_addForm/","#divsubcontent")','Save','btn btn-success')." ";
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
    $('select').select2();
});

</script>