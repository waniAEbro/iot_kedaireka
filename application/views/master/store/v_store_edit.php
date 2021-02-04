<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$row = fetch_single_row($edit);
?>

<div class="box-body big">
    <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>


    <div class="form-group">
        <label class="col-sm-4 control-label">Store/Mitra</label>
        <div class="col-sm-8">
            <?php echo form_hidden('id', $row->id); ?>
            <?php echo form_input(array('name' => 'store', 'value' => $row->store, 'class' => 'form-control')); ?>
            <?php echo form_error('store'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Jenis Market</label>
        <div class="col-sm-8">
            <select id="id_jenis_market" name="id_jenis_market" class="form-control" style="width:100%" required>
                <option value="">-- Select Jenis Market --</option>
                <?php foreach ($jenis_market->result() as $val) : ?>
                    <?php $sel = ($row->id_jenis_market == $val->id) ? 'selected' : ''; ?>
                    <option value="<?= $val->id ?>" <?= $sel ?>><?= $val->jenis_market ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">No Telp</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'no_telp', 'value' => $row->no_telp, 'class' => 'form-control')); ?>
            <?php echo form_error('no_telp'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Alamat</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'alamat', 'value' => $row->alamat, 'class' => 'form-control')); ?>
            <?php echo form_error('alamat'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Zona</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'zona', 'value' => $row->zona, 'class' => 'form-control')); ?>
            <?php echo form_error('zona'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Kategori Lokasi</label>
        <div class="col-sm-8">
            <select id="id_kategori_lokasi" name="id_kategori_lokasi" class="form-control" style="width:100%" required>
                <option value="">-- Select Kategori Lokasi --</option>
                <?php foreach ($kategori_lokasi->result() as $val) : ?>
                    <?php $sel = ($row->id_kategori_lokasi == $val->id) ? 'selected' : ''; ?>
                    <option value="<?= $val->id ?>" <?= $sel ?>><?= $val->kategori_lokasi ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">Simpan</label>
        <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"master/store/show_editForm/","#divsubcontent")', 'Simpan', 'btn btn-success') . " ";
            ?>
        </div>
    </div>
    </form>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $("select").select2();
        $('.tutup').click(function(e) {
            $('#myModal').modal('hide');
        });
    });
</script>