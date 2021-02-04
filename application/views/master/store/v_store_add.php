<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="box-body big">
    <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>



    <div class="form-group">
        <label class="col-sm-4 control-label">Store/Mitra</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'store', 'class' => 'form-control')); ?>
            <?php echo form_error('store'); ?>
            <span id="check_data"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Jenis Market</label>
        <div class="col-sm-8">
            <select id="id_jenis_market" name="id_jenis_market" class="form-control" style="width:100%" required>
                <option value="">-- Select Jenis Market --</option>
                <?php foreach ($jenis_market->result() as $val) : ?>
                    <option value="<?= $val->id ?>"><?= $val->jenis_market ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">No Telp</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'no_telp', 'class' => 'form-control')); ?>
            <?php echo form_error('no_telp'); ?>
            <span id="check_data"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Alamat</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'alamat', 'class' => 'form-control')); ?>
            <?php echo form_error('alamat'); ?>
            <span id="check_data"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Zona</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'zona', 'class' => 'form-control')); ?>
            <?php echo form_error('zona'); ?>
            <span id="check_data"></span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">Kategori Lokasi</label>
        <div class="col-sm-8">
            <select id="id_kategori_lokasi" name="id_kategori_lokasi" class="form-control" style="width:100%" required>
                <option value="">-- Select Kategori Lokasi --</option>
                <?php foreach ($kategori_lokasi->result() as $val) : ?>
                    <option value="<?= $val->id ?>"><?= $val->kategori_lokasi ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">Save</label>
        <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"master/store/show_addForm/","#divsubcontent")', 'Save', 'btn btn-success') . " ";
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
        $("select").select2();
    });
</script>