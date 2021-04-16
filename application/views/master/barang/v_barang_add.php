<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">From Add barang</h3>

                <div class="box-tools pull-right">
                    <?php echo button('load_silent("master/barang/show_addForm/","#content")', 'Reload Page', 'btn btn-danger', 'data-toggle="tooltip" title="Add New barang"'); ?>
                </div>
            </div>
            <div class="box-body">
                <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Brand</label>
                    <div class="col-sm-8">
                        <select id="brand" name="brand" class="form-control" style="width:100%" required>
                            <option value="">-- Select --</option>
                            <?php foreach ($brand->result() as $val) : ?>
                                <option value="<?= $val->brand ?>"><?= $val->brand ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Barang</label>
                    <div class="col-sm-8">
                        <?php echo form_input(array('name' => 'barang', 'id' => 'barang', 'class' => 'form-control')); ?>
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
                        <?php echo form_input(array('name' => 'keterangan', 'id' => 'keterangan', 'class' => 'form-control')); ?>
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
            'showUpload': true
        });
        $("select").select2();
        $('#tombol').removeAttr('disabled', false);
    });

    function save() {
        $('#tombol').attr('disabled', 'disabled');
        var path = $("#ufile").val().replace('C:\\fakepath\\', '');
        if (path == '') {
            $.ajax({
                type: "POST",
                url: "<?= site_url('master/barang/insert') ?>",
                dataType: 'json',
                data: {
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
                url: "<?= site_url('master/barang/insertFile') ?>",
                secureuri: false,
                fileElementId: 'ufile',
                dataType: 'json',
                data: {
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