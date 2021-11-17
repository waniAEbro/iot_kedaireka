<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$row = fetch_single_row($edit);
?>

<div class="box-body big">
    <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>

    <div class="form-group">
        <label class="col-sm-4 control-label">Jenis Item</label>
        <div class="col-sm-8">
            <select name="id_jenis_item" class="form-control">
                <option>Pilih</option>
                <?php
                foreach ($jenis_item->result() as $key) {
                    $sel = ($row->id_jenis_item == $key->id) ? 'selected' : ''; ?>
                    <option value="<?= $key->id ?>" <?= $sel ?>><?= $key->jenis_item ?></option>
                <?php }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">gudang</label>
        <div class="col-sm-8">
            <?php echo form_hidden('id', $row->id); ?>
            <?php echo form_input(array('name' => 'gudang', 'value' => $row->gudang, 'class' => 'form-control')); ?>
            <?php echo form_error('gudang'); ?>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-4 control-label"></label>
    <div class="col-sm-8 tutup">
        <?php
        echo button('send_form(document.faddmenugrup,"master/gudang/show_editForm/","#divsubcontent")', 'Simpan', 'btn btn-success') . " ";
        ?>
    </div>
</div>
</form>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $(".select").select2();
        $('.tutup').click(function(e) {
            $('#myModal').modal('hide');
        });
    });
</script>