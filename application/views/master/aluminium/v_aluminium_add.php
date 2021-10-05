<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="box-body big">
    <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>
    <div class="form-group">
        <label class="col-sm-4 control-label">Section ATA</label>
        <div class="col-sm-8">
            <?php echo form_hidden('id_jenis_item', '1'); ?>
            <?php echo form_input(array('name' => 'section_ata', 'class' => 'form-control')); ?>
            <?php echo form_error('section_ata'); ?>
            <span id="check_data"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Section Allure</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'section_allure', 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Temper</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'temper', 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Kode Warna</label>
        <div class="col-sm-8">
            <select name="kode_warna" class="form-control">
                <option value="-">Pilih</option>
                <?php foreach ($warna->result() as $key) { ?>
                    <option value="<?= $key->kode ?>"><?= $key->warna ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Ukuran</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'ukuran', 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Satuan</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'satuan', 'class' => 'form-control')); ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">Divisi</label>
        <div class="col-sm-8">
            <select name="id_divisi" class="form-control">
                <option value="-">Pilih</option>
                <?php foreach ($divisi->result() as $key) {
                ?>
                    <option value="<?= $key->id ?>"><?= $key->divisi ?></option>
                <?php } ?>
            </select>
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-4 control-label">Save</label>
        <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"master/aluminium/show_addForm/","#divsubcontent")', 'Save', 'btn btn-success') . " ";
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