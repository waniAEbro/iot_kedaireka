<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">From Upload Master dan Stock</h3>
            </div>
            <div class="box-body">
                <h4>.Ketentuan Upload excel: </h4>
                <ul>
                    <li>Upload File dengan format .xls .xlsx .csv</li>
                    <li>Ukuran Maksimal adalah 1000 kb</li>
                    <li>Baris Maksimal 3000 row</li>
                    <li>Usahakan data file ada di sheet 1</li>
                    <li>Baris pertama untuk judul/header</li>
                    <li>Data yang tersimpan ada di baris ke 2 dan seterusnya</li>
                    <li>Posisi Kolom harus sama dengan contoh gambar</li>
                    <li>Apabila validasi menunjukan data sudah ada maka tidak tersimpan</li>
                    <li>Download format upload untuk <?php echo '<a class="btn btn-xs btn-primary" target="_blank" href="' . base_url('filepdf/uploadstockmaster.xlsx') . '" >Download</a>'; ?></li>
                </ul>
            </div>
            <div class="box-body">
                <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Jenis Item</label>
                    <div class="col-sm-8">
                        <select id="jenis_item" class="form-control">
                            <option value="">Pilih</option>
                            <?php foreach ($jenis_item->result() as $key) { ?>
                                <option value="<?= $key->id ?>"><?= $key->jenis_item ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tipe Upload</label>
                    <div class="col-sm-8">
                        <select id="tipe_upload" class="form-control">
                            <option value="1">INSERT MASTER AND UPDATE MASTER</option>
                            <option value="2">INSERT STOCK</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Awal Bulan?</label>
                    <div class="col-sm-8">
                        <select id="awal_bulan" class="form-control">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
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
                        <?php if (from_session('id') == 2) { ?>
                            <input type="text" id="id_gudang" class="form-control">
                            <input onclick="save_penyesuaian()" type="submit" id="tombol" value="Save penyesuaian" class="btn btn-success">

                        <?php } ?>
                        <span id="loading">
                            <font color="red">Mohon Tunggu Proses Upload!...</font>
                        </span>
                    </div>
                </div>
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

        $.ajaxFileUpload({
            url: site + 'klg/fppp/save_uploadmasterstock',
            secureuri: false,
            fileElementId: 'file',
            dataType: 'json',
            data: {
                jenis_item: $('#jenis_item').val(),
                tipe_upload: $('#tipe_upload').val(),
                awal_bulan: $('#awal_bulan').val(),
            },
            success: function(data) {
                $.growl.notice({
                    title: 'Berhasil',
                    message: data['msg']
                });
                load_silent("pak/dashboard/status_pak", "#content");
            },
            error: function(data, e) {
                alert('error ajax!');
            }
        })
        return false;
    }

    function save_penyesuaian() {
        $.ajax({
        type: "POST",
        url: site + 'klg/fppp/kesesuaian_stock',
        dataType: 'json',
        data: {
            id_jenis_item: $('#jenis_item').val(),
            id_gudang: $('#id_gudang').val(),
        },
        success: function(data) {

            $.growl.notice({
                    title: 'Berhasil',
                    message: data['msg']
                });
                load_silent("pak/dashboard/status_pak", "#content");

        },
        error: function(data, e) {
            alert('error ajax!');
        }
      });
        
        return false;
    }
</script>