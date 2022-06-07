<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="box-body big">
    <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>



    <div class="form-group">
        <label class="col-sm-4 control-label">Item code</label>
        <div class="col-sm-8">
        <?php echo form_hidden('id_jenis_item', 3); ?>
            <?php echo form_input(array('name' => 'item_code', 'class' => 'form-control')); ?>
            <?php echo form_error('item_code'); ?>
            <span id="check_data"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Deskripsi</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'deskripsi', 'class' => 'form-control')); ?>
            <?php echo form_error('deskripsi'); ?>
            <span id="check_data"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Lebar</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'lebar', 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Tinggi</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'tinggi', 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Area</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'area', 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Satuan</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'satuan', 'class' => 'form-control')); ?>
            <?php echo form_error('satuan'); ?>
            <span id="check_data"></span>
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-4 control-label">Save</label>
        <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"master/kaca/show_addForm/","#divsubcontent")', 'Save', 'btn btn-success') . " ";
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