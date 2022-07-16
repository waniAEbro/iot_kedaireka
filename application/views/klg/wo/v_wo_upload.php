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
                    <li>Data file ada di sheet 1</li>
                    <li>Baris pertama untuk judul/header</li>
                    <li>Data yang tersimpan ada di baris ke 2 dan seterusnya</li>
                    <li>Posisi Kolom harus sama dengan contoh file</li>
                    <li>Apabila validasi menunjukan data sudah ada maka tidak tersimpan</li>
                    <li>Download format upload untuk <b>WO Aluminium</b> <?php echo '<a class="btn btn-xs btn-primary" target="_blank" href="' . base_url('files/wo_aluminium.xlsx') . '" >Download</a>'; ?></li>
                </ul>
            </div>
            <div class="box-body">
                <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>
                
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
        infoTable = '<h3>Item Tidak Tersimpan karena tidak ketemu di master</h3><br><table id="infoTable" class="table table-striped" border="1px">' +
            '<tr>' +
            '<th bgcolor="#ff8482" width="5%">No</th>' +
            '<th bgcolor="#ff8482">Item Code</th>' +
            '</tr>';
        $.ajaxFileUpload({
            url: site + 'klg/wo/saveupload',
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
                        '<td>' + data.detail[i].id_item + '</td>' +
                        '</tr>';
                }
                infoTable += '</table>';
                if (jml_data > 0) {
                    $('#item_salah').html(infoTable);
                } else {
                    load_silent("klg/wo", "#content");
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

    
</script>