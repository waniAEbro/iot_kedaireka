<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$row = fetch_single_row($edit);
?>
<div class="box-body big">
    <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>
    <div class="form-group">
        <label class="col-sm-4 control-label">Section ATA</label>
        <div class="col-sm-8">
            <?php echo form_hidden('id', $row->id); ?>
            <?php echo form_hidden('id_jenis_item', $row->id_jenis_item); ?>
            <?php echo form_input(array('name' => 'section_ata', 'value' => $row->section_ata, 'class' => 'form-control')); ?>
            <?php echo form_error('section_ata'); ?>
            <span id="check_data"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Section Allure</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'section_allure', 'value' => $row->section_allure, 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Temper</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'temper', 'value' => $row->temper, 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Kode Warna</label>
        <div class="col-sm-8">
            <select name="kode_warna" class="form-control">
                <option value="-">Pilih</option>
                <?php foreach ($warna->result() as $key) {
                    $selected = ($key->kode == $row->kode_warna) ? 'selected' : '';
                ?>
                    <option value="<?= $key->kode ?>" <?= $selected ?>><?= $key->warna_aluminium ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Ukuran</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'ukuran', 'value' => $row->ukuran, 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Satuan</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'satuan', 'value' => $row->satuan, 'class' => 'form-control')); ?>
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-4 control-label">Save</label>
        <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"master/aluminium/show_editForm/","#divsubcontent")', 'Save', 'btn btn-success') . " ";
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