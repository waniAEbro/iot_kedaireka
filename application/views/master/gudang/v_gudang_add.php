<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="box-body big">
    <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>

    <div class="form-group">
        <label class="col-sm-4 control-label">Jenis Item</label>
        <div class="col-sm-8">
            <select name="id_jenis_item" class="form-control">
                <option>Pilih</option>
                <?php
                foreach ($jenis_item->result() as $key) { ?>
                    <option value="<?= $key->id ?>"><?= $key->jenis_item ?></option>
                <?php }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Jenis Aluminium (kosongi jika bukan gudang aluminium)</label>
        <div class="col-sm-8">
            <select name="jenis_aluminium" class="form-control">
                <option>Pilih</option>
                <option value="1">RSD</option>
                <option value="2">HRB</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">gudang</label>
        <div class="col-sm-8">
            <?php echo form_input(array('name' => 'gudang', 'class' => 'form-control')); ?>
            <?php echo form_error('gudang'); ?>
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-4 control-label"></label>
        <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"master/gudang/show_addForm/","#divsubcontent")', 'Save', 'btn btn-success') . " ";
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