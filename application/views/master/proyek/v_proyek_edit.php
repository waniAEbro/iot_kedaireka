<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$row = fetch_single_row($edit);
?>

<div class="box-body big">
    <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>
    <div class="form-group">
        <label class="col-sm-4 control-label">Kode proyek</label>
        <div class="col-sm-8">
            <?php echo form_hidden('id', $row->id); ?>
            <?php echo form_input(array('name' => 'kode_proyek', 'value' => $row->kode_proyek, 'class' => 'form-control')); ?>
            <?php echo form_error('kode_proyek'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Nama proyek</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'nama_proyek', 'value' => $row->nama_proyek, 'class' => 'form-control')); ?>
            <?php echo form_error('nama_proyek'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Nama Customer</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'nama_customer', 'value' => $row->nama_customer, 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Alamat</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'alamat', 'value' => $row->alamat, 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Keterangan</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'keterangan', 'value' => $row->keterangan, 'class' => 'form-control')); ?>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-4 control-label"></label>
    <div class="col-sm-8 tutup">
        <?php
        echo button('send_form(document.faddmenugrup,"master/proyek/show_editForm/","#divsubcontent")', 'Simpan', 'btn btn-success') . " ";
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