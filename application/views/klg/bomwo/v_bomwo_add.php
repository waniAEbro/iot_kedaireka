<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Form BOM WO</h3>

        <div class="box-tools pull-right">
            <button type="button" id="tutup" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form method="post" class="form-vertical form_faktur" role="form">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Nama Project</label>
                        <input type="text" id="nama_project" class="form-control" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>No fppp</label>
                        <?= form_dropdown('id_fppp', $fppp, '', 'id="id_fppp" class="form-control"') ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Divisi</label>
                        <?= form_dropdown('id_divisi', $divisi, '', 'id="id_divisi" class="form-control"') ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Deadline</label>
                        <input type="text" id="tgl_deadline" data-date-format="yyyy-mm-dd" value="<?= date('Y-m-d') ?>" class="form-control datepicker" autocomplete="off">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Lampiran</label>
                        <?php echo form_upload(array('name' => 'lampiran', 'id' => 'lampiran')); ?>
                        <span style="color:red">*) Lampiran File berformat .pdf maks 2MB</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Note</label><br>
                        <textarea id="keterangan" name="keterangan" rows="10" cols="150">
                </textarea>
                    </div>
                </div>
            </div>


    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" onclick="save()" id="proses" class="btn btn-success">Process</button>
        <!-- <a id="silahkantunggu" class="btn btn-danger">Process</a> -->
        <span id="info"></span>
    </div>
    </form>
</div>

<div class="row" id="form_pembelianz">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">From Upload Excel</h3>
            </div>
            <div class="box-body">
                <h4>Ketentuan Upload excel :</h4>
                <ul>
                    <li>Upload File dengan format .xls .xlsx .csv</li>
                    <li>Ukuran Maksimal adalah 1000 kb</li>
                    <li>Usahakan data file ada di sheet 1</li>
                    <li>Baris pertama untuk judul/header</li>
                    <li>Data yang tersimpan ada di baris ke 2 dan seterusnya</li>
                    <li>Posisi Kolom harus sama dengan contoh gambar</li>
                    <li>Apabila validasi menunjukan data sudah ada maka tidak tersimpan</li>
                    <li>lihat contoh pada gambar dibawah</li>
                    <img src="<?= base_url('files/mayo.JPG') ?>" alt="">
                    <li>Download file sample ini kemudian disesuaikan dengan contoh di atas <?php echo '<a class="btn btn-xs btn-primary" target="_blank" href="' . base_url('files/iniexcel.xlsx') . '" >Download</a>'; ?></li>
                </ul>
            </div>
            <div class="box-body">
                <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="userfile">File Excel</label>
                    <div class="col-sm-8">
                        <?php echo form_upload(array('name' => 'file', 'id' => 'file')); ?>
                        <!-- <span id='info'></span></label> -->
                        <input type="hidden" id="id_bomwo" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Upload</label>
                    <div class="col-sm-8 tutup">
                        <input onclick="saveexcel()" type="submit" id="tombol" value="Save" class="btn btn-success" disabled>
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

<script language="javascript">
    function finish() {
        if (confirm('Anda yakin ingin menyelesaikan?')) {
            $.growl.notice({
                title: 'Berhasil',
                message: "Tambah Permintaan selesai!"
            });
            load_silent("klg/bomwo/finish/" + $("#id_bomwo").val() + "", "#content");
        }
    }
    $(document).ready(function() {

        $('.datepicker').datepicker({
            autoclose: true
        });

        $("#lampiran").fileinput({
            'showUpload': true
        });
        $("#file").fileinput({
            'showUpload': true
        });
        $('#loading').hide();
        $('#tombol').removeAttr('disabled', false);

        $('.fileinput-upload-button').hide();
        $("select").select2();
        // $(".harga").hide();
        $('#harga').attr('readonly', true);
        $("#silahkantunggu").hide();
        // Replace the <textarea id="editor1"> with a CKEditor files/2019/12/03cd07ae4cb5f5f8ab4f5c4cd80d81e5.png
        // instance, using default configuration.
        CKEDITOR.replace('keterangan');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();

        $('#form_pembelian').hide();
    });

    function save() {
        // $(this).find("button[type='submit']").prop('disabled', true);
        // $("#proses").hide(50);
        // $("#silahkantunggu").show(50);
        var path = $("#lampiran").val().replace('C:\\fakepath\\', '');
        if (path == '') {
            $.ajax({
                type: "POST",
                url: site + 'klg/bomwo/savebomwo',
                dataType: 'json',
                data: {
                    nama_project: $("#nama_project").val(),
                    id_fppp: $("#id_fppp").val(),
                    id_divisi: $("#id_divisi").val(),
                    tgl_deadline: $("#tgl_deadline").val(),
                    note: CKEDITOR.instances.keterangan.getData(),

                },
                success: function(data) {

                    $('#id_bomwo').val(data['id']);
                    $.growl.notice({
                        title: 'Sukses',
                        message: data['msg']
                    });
                    $('#tutup').click();
                    $('#form_pembelian').show(1000);

                },
                error: function(data, e) {
                    $("#info").html(e);
                }
            });
        } else {
            $.ajaxFileUpload({
                url: site + 'klg/bomwo/savebomwoImage',
                secureuri: false,
                fileElementId: 'lampiran',
                dataType: 'json',
                data: {
                    nama_project: $("#nama_project").val(),
                    id_fppp: $("#id_fppp").val(),
                    id_divisi: $("#id_divisi").val(),
                    tgl_deadline: $("#tgl_deadline").val(),
                    note: CKEDITOR.instances.keterangan.getData(),
                },
                success: function(data) {
                    $('#id_bomwo').val(data['id']);
                    $.growl.notice({
                        title: 'Sukses',
                        message: data['msg']
                    });
                    $('#tutup').click();
                    $('#form_pembelian').show(1000);
                },
                error: function(data, e) {
                    $("#info").html(e);
                }
            })
            return false;
        };

    }

    function saveexcel() {
        $('#tombol').attr('disabled', 'disabled');
        $('#loading').show(100);
        $.ajaxFileUpload({
            url: site + 'klg/bomwo/upload',
            secureuri: false,
            fileElementId: 'file',
            dataType: 'json',
            data: {
                id_bomwo: $("#id_bomwo").val(),
            },
            success: function(data) {
                $.growl.notice({
                    title: 'Berhasil',
                    message: data['msg']
                });
                load_silent("klg/bomwo/", "#content");
            },
            error: function(data, e) {
                $("#info").html(e);
            }
        })
        return false;
    }
</script>