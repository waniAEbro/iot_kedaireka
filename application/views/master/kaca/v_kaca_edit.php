<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$row = fetch_single_row($edit);
?>

<div class="box-body big">
    <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>


    <div class="form-group">
        <label class="col-sm-4 control-label">Item Code</label>
        <div class="col-sm-8">
            <?php echo form_hidden('id', $row->id); ?>
            <?php echo form_input(array('name' => 'item_code', 'value' => $row->item_code, 'class' => 'form-control')); ?>
            <?php echo form_error('item_code'); ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">Deskripsi</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'deskripsi', 'value' => $row->deskripsi, 'class' => 'form-control')); ?>
            <?php echo form_error('deskripsi'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Lebar</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'lebar','value' => $row->lebar, 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Tinggi</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'tinggi','value' => $row->tinggi, 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Area</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'area','value' => $row->area, 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Satuan</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'satuan', 'value' => $row->satuan, 'class' => 'form-control')); ?>
            <?php echo form_error('satuan'); ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">Simpan</label>
        <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"master/kaca/show_editForm/","#divsubcontent")', 'Simpan', 'btn btn-success') . " ";
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