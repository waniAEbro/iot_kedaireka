<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="box-body big">
    <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>


    <div class="form-group">
        <label class="col-sm-4 control-label">Item</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'item', 'value' => $row->item, 'class' => 'form-control', 'disabled' => 'disabled')); ?>
            <?php echo form_error('item'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Lebar</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'lebar', 'value' => $row->lebar, 'class' => 'form-control', 'disabled' => 'disabled')); ?>
            <?php echo form_error('lebar'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Tinggi</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'tinggi', 'value' => $row->tinggi, 'class' => 'form-control', 'disabled' => 'disabled')); ?>
            <?php echo form_error('tinggi'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Bukaan</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'bukaan', 'value' => $row->bukaan, 'class' => 'form-control', 'disabled' => 'disabled')); ?>
            <?php echo form_error('bukaan'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Warna</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'warna', 'value' => $row->warna, 'class' => 'form-control', 'disabled' => 'disabled')); ?>
            <?php echo form_error('warna'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Qty</label>
        <div class="col-sm-8">
            <?php echo form_hidden('id', $row->id); ?>
            <?php echo form_input(array('name' => 'qty', 'value' => $row->qty, 'class' => 'form-control')); ?>
            <?php echo form_error('qty'); ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">Simpan</label>
        <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"klg/custom/show_editForm/","#divsubcontent")', 'Simpan', 'btn btn-success') . " ";
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