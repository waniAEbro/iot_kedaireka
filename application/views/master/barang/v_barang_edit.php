<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$row = fetch_single_row($edit);
?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">From Edit barang</h3>
            </div>
            <div class="box-body">
                <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Brand</label>
                    <div class="col-sm-8">
                        <?php echo form_input(array('name' => 'id', 'value' => $row->id, 'id' => 'id', 'class' => 'form-control', 'style' => 'display:none;')); ?>
                        <select id="brand" name="brand" class="form-control" style="width:100%" required>
                            <option value="">-- Select --</option>
                            <?php foreach ($brand->result() as $val) : ?>
                                <?php $selected = ($val->brand == $row->brand) ? 'selected' : ''; ?>
                                <option value="<?= $val->brand ?>" <?= $selected ?>><?= $val->brand ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Barang</label>
                    <div class="col-sm-8">
                        <?php echo form_input(array('name' => 'barang', 'id' => 'barang', 'value' => $row->barang, 'class' => 'form-control')); ?>
                        <?php echo form_error('barang'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="userfile">Gambar</label>
                    <div class="col-sm-8">
                        <?php echo form_upload(array('name' => 'ufile', 'id' => 'ufile')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Keterangan</label>
                    <div class="col-sm-8">
                        <?php echo form_input(array('name' => 'keterangan', 'id' => 'keterangan', 'value' => $row->keterangan, 'class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Save</label>
                    <div class="col-sm-8 tutup">
                        <input onclick="save()" type="submit" id="tombol" value="Save" class="btn btn-success" disabled>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#ufile").fileinput({
            'showUpload': true,
            initialPreview: '<img src="<?php echo base_url() . $row->gambar; ?>" class="file-preview-image">'
        });
        $("select").select2();
        $('#tombol').removeAttr('disabled', false);
    });

    function save() {
        $('#tombol').attr('disabled', 'disabled');
        var path = $("#ufile").val().replace('C:\\fakepath\\', '');
        var ida = $('#id').val();
        if (path == '') {
            $.ajax({
                type: "POST",
                url: "<?= site_url('master/barang/show_editForm/"+ida+"') ?>",
                dataType: 'json',
                data: {
                    id: $("#id").val(),
                    brand: $("#brand").val(),
                    barang: $("#barang").val(),
                    keterangan: $("#keterangan").val(),

                },
                success: function(data) {
                    $.growl.notice({
                        title: 'Sukses',
                        message: data['msg']
                    });
                    load_silent("master/barang/", "#content");
                }
            });

        } else {
            $.ajaxFileUpload({
                url: "<?= site_url('master/barang/show_editForm_file/"+ida+"') ?>",
                secureuri: false,
                fileElementId: 'ufile',
                dataType: 'json',
                data: {
                    id: $("#id").val(),
                    brand: $("#brand").val(),
                    barang: $("#barang").val(),
                    keterangan: $("#keterangan").val(),
                },
                success: function(data) {
                    $.growl.notice({
                        title: 'Berhasil',
                        message: data['msg']
                    });
                    load_silent("master/barang/", "#content");
                },
                error: function(data, e) {
                    $("#info").html(e);
                }
            })

        };

        return false;
    }
</script>