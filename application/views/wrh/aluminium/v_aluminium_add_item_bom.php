<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="box-body big">
    <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>
    <div class="form-group">
        <label class="col-sm-4 control-label">Brand</label>
        <div class="col-sm-8">
            <select name="id_brand" class="form-control">
                <option>Pilih</option>
                <?php foreach ($brand->result() as $valap) : ?>
                    <option value="<?= $valap->id ?>">
                        <?= $valap->brand ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Item</label>
        <div class="col-sm-8">
            <select name="id_item" class="form-control">
                <option>Pilih</option>
                <?php foreach ($item->result() as $valap) : ?>
                    <option value="<?= $valap->id ?>">
                        <?= $valap->section_ata ?> -
                        <?= $valap->section_allure ?> -
                        <?= $valap->temper ?> -
                        <?= $valap->kode_warna ?> -
                        <?= $valap->ukuran ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">Qty</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="qty">
            <input type="hidden" class="form-control" name="id_fppp" value="<?= $id_fppp ?>">
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-4 control-label">Save</label>
        <div class="col-sm-8 tutup">
            <?php
            echo button('send_form(document.faddmenugrup,"wrh/aluminium/showformitemdetailbom/","#divsubcontent")', 'Save', 'btn btn-success') . " ";
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