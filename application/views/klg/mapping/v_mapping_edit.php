<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
    $row = fetch_single_row($edit);
?>

<div class="box-body big">
    <?php echo form_open('',array('name'=>'faddmenugrup','class'=>'form-horizontal','role'=>'form'));?>

        <div class="form-group">
            <label class="col-sm-4 control-label">Item</label>
            <div class="col-sm-8">
            <select id="item" name="item" class="form-control" style="width:100%">
              <option value="">-- Item --</option>
              <?php foreach ($item->result() as $val):?>
                <?php $sel = ($val->id==$row->id_item) ? 'selected' : '' ; ?>
                <option value="<?=$val->id?>" <?=$sel?>><?=$val->item?></option>
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
                <?php $sel = ($val->id==$row->id_warna) ? 'selected' : '' ; ?>
                <option value="<?=$val->id?>" <?=$sel?>><?=$val->warna?></option>
              <?php endforeach;?>
            </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Harga Jabotabek</label>
            <div class="col-sm-8">
            <?php echo form_hidden('id',$row->id); ?>
            <?php echo form_input(array('name'=>'harga_jabotabek','value'=>$row->harga_jabotabek,'class'=>'form-control'));?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Harga Dalam Pulau</label>
            <div class="col-sm-8">
            <?php echo form_input(array('name'=>'harga_dalam_pulau','value'=>$row->harga_dalam_pulau,'class'=>'form-control'));?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Harga Luar Pulau</label>
            <div class="col-sm-8">
            <?php echo form_input(array('name'=>'harga_luar_pulau','value'=>$row->harga_luar_pulau,'class'=>'form-control'));?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Simpan</label>
            <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"klg/mapping/show_editForm/","#divsubcontent")','Simpan','btn btn-success')." ";
            ?>
            </div>
        </div>
    </form>
</div>


<script type="text/javascript">
$(document).ready(function() {
     $('select').select2();
    $('.tutup').click(function(e) {  
        $('#myModal').modal('hide');
    });
});
</script>