<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">From Upload BOM</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No FPPP</label>
                            <input type="text" class="form-control" id="no_fppp" value="<?= $rowFppp->no_fppp ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Proyek</label>
                            <input type="text" class="form-control" id="nama_proyek" value="<?= $rowFppp->nama_proyek ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Alamat Proyek</label>
                            <input type="text" class="form-control" id="alamat_proyek" value="<?= $rowFppp->alamat_proyek ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Warna Aluminium</label>
                            <input type="text" class="form-control" id="warna" value="<?= $rowFppp->warna ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Deadline Pengiriman</label>
                            <input type="text" class="form-control" id="deadline_pengiriman" value="<?= $rowFppp->deadline_pengiriman ?>" readonly>
                        </div>
                    </div>
                </div>
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
                        <input type="hidden" id="id_divisi" value="<?= $id_divisi ?>">
                        <input type="hidden" id="id" value="<?= $id ?>">
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
                <?php if (from_session('id') == 2) { ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Upload Stock</label>
                        <div class="col-sm-8 ">
                            <input onclick="save_stock()" type="submit" value="Save stock 2" class="btn btn-success">
                            <input onclick="save_master()" type="submit" value="Save master" class="btn btn-success">

                        </div>
                    </div>
                <?php } ?>
                </form>
            </div>
            <div class="box-body">
                <span id="item_salah"></span>
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
        infoTable = '<h3>Item Tidak Tersimpan</h3><br><table id="infoTable" class="table table-striped" border="1px">' +
            '<tr>' +
            '<th bgcolor="#ff8482" width="5%">No</th>' +
            '<th bgcolor="#ff8482">Item Code</th>' +
            '</tr>';
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
                $('#loading').hide(100);
                var jml_data = data.detail.length;
                for (var i = 0; i < data.detail.length; i++) {
                    var no = i + 1;
                    infoTable += '<tr>' +
                        '<td>' + no + '</td>' +
                        '<td>' + data.detail[i].item_code + '</td>' +
                        '</tr>';
                }
                infoTable += '</table>';
                if (jml_data > 0) {
                    $('#item_salah').html(infoTable);
                } else {
                    load_silent("klg/fppp/hasil_finish/" + $('#id_divisi').val() + "", "#content");
                }
                $('#loading').hide();
                // load_silent("klg/fppp/", "#content");
            },
            error: function(data, e) {
                $("#info").html(e);
            }
        })
        return false;
    }

    function save_stock() {
        $('#tombol').attr('disabled', 'disabled');
        $('#loading').show(100);
        $.ajaxFileUpload({
            url: site + 'klg/fppp/uploadStock',
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
                // load_silent("klg/fppp/", "#content");
                $('#loading').hide();

            },
            error: function(data, e) {
                $("#info").html(e);
            }
        })
        return false;
    }

    function save_master() {
        $('#tombol').attr('disabled', 'disabled');
        $('#loading').show(100);
        $.ajaxFileUpload({
            url: site + 'klg/fppp/uploadMaster',
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
                // load_silent("klg/fppp/", "#content");
                $('#loading').hide();

            },
            error: function(data, e) {
                $("#info").html(e);
            }
        })
        return false;
    }
</script>