<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">From Upload BOM</h3>
            </div>
            <div class="box-body">
                <h4>Ketentuan Upload excel: </h4>
                <ul>
                    <li>Upload File dengan format .xls .xlsx .csv</li>
                    <li>Ukuran Maksimal adalah 1000 kb</li>
                    <li>Usahakan data file ada di sheet 1</li>
                    <li>Baris pertama untuk judul/header</li>
                    <li>Data yang tersimpan ada di baris ke 2 dan seterusnya</li>
                    <li>Posisi Kolom harus sama dengan contoh gambar</li>
                    <li>Apabila validasi menunjukan data sudah ada maka tidak tersimpan</li>
                    <li>Download format upload untuk <b>BOM ALUMINIUM</b> <?php echo '<a class="btn btn-xs btn-primary" target="_blank" href="' . base_url('files/bom_aluminium.xlsx') . '" >Download</a>'; ?></li>
                    <li>Download format upload untuk <b>BOM AKSESORIS</b> <?php echo '<a class="btn btn-xs btn-primary" target="_blank" href="' . base_url('files/bom_aksesoris.xlsx') . '" >Download</a>'; ?></li>
                    <li>Download format upload untuk <b>BOM LEMBARAN</b> <?php echo '<a class="btn btn-xs btn-primary" target="_blank" href="' . base_url('files/bom_lembaran.xlsx') . '" >Download</a>'; ?></li>
                </ul>
            </div>
            <div class="box-body">
                <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Jenis BOM</label>
                    <div class="col-sm-8">
                        <select id="jenis_bom" class="form-control">
                            <option value="">Pilih</option>
                            <option value="1">Aluminium</option>
                            <option value="2">Aksesoris</option>
                            <option value="3">Lembaran</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="userfile">File Excel</label>
                    <div class="col-sm-8">
                        <input type="hidden" id="id" value="<?= $id ?>">
                        <?php echo form_upload(array('name' => 'file', 'id' => 'file')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Upload</label>
                    <div class="col-sm-8 tutup">
                        <input onclick="save()" type="submit" id="tombol" value="Save" class="btn btn-success" disabled>
                        <span id="loading">
                            <font color="red">Mohon Tunggu Proses Upload!...</font>
                        </span>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#file").fileinput({
            'showUpload': true
        });
        $(".select2").select2();
        $('#loading').hide();
        $('#tombol').removeAttr('disabled', false);
    });

    function save() {
        $('#tombol').attr('disabled', 'disabled');
        $('#loading').show(100);
        $.ajaxFileUpload({
            url: site + 'klg/fppp/upload',
            secureuri: false,
            fileElementId: 'file',
            dataType: 'json',
            data: {
                id: $('#id').val(),
                jenis_bom: $('#jenis_bom').val(),
            },
            success: function(data) {
                $.growl.notice({
                    title: 'Berhasil',
                    message: data['msg']
                });
                load_silent("klg/fppp/", "#content");
            },
            error: function(data, e) {
                $("#info").html(e);
            }
        })
        return false;
    }
</script>