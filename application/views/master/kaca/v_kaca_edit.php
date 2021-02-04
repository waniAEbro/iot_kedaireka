<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$row = fetch_single_row($edit);
?>

<div class="box-body big">
    <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>


    <div class="form-group">
        <label class="col-sm-4 control-label">kaca</label>
        <div class="col-sm-8">
            <?php echo form_hidden('id', $row->id); ?>
            <?php echo form_input(array('name' => 'kaca', 'value' => $row->kaca, 'class' => 'form-control')); ?>
            <?php echo form_error('kaca'); ?>
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