<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="box-body big">
    <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>

    <div class="form-group">
        <label class="col-sm-4 control-label">Kode</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'kode', 'class' => 'form-control')); ?>
            <?php echo form_error('kode'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Supplier</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'supplier', 'class' => 'form-control')); ?>
            <?php echo form_error('supplier'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Alamat</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'alamat', 'class' => 'form-control')); ?>
            <?php echo form_error('alamat'); ?>
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-4 control-label">Save</label>
        <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"master/supplier/show_addForm/","#divsubcontent")', 'Save', 'btn btn-success') . " ";
            ?>
        </div>
    </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // $('.tutup').click(function(e) {
        //     $('#myModal').modal('hide');
        // });
        $("select").select2();
    });
</script>