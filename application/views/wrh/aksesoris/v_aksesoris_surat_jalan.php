<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Surat Jalan</h3>

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
                        <label>Nama Surat Jalan</label>
                        <input type="text" class="form-control" id="no_sj" value="<?= $no_sj ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No FPPP</label>
                        <input type="hidden" class="form-control" id="id_fppp" value="<?= $fppp->id ?>" readonly>
                        <input type="hidden" class="form-control" id="id_divisi" value="<?= $fppp->id_divisi ?>" readonly>
                        <input type="text" class="form-control" id="fppp" value="<?= $fppp->no_fppp ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Divisi</label>
                        <input type="text" class="form-control" id="divisi" value="<?= $fppp->divisi ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Nama Proyek</label>
                        <input type="text" class="form-control" id="nama_proyek" value="<?= $fppp->nama_proyek ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Alamat Proyek</label>
                        <input type="text" class="form-control" id="alamat_proyek" value="<?= $fppp->alamat_proyek ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tgl Kirim</label>
                        <input type="text" data-date-format="yyyy-mm-dd" class="form-control datepicker" id="tgl_kirim">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Sopir</label>
                        <input type="text" class="form-control" id="sopir">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>No Polisi</label>
                        <input type="text" class="form-control" id="no_polisi">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Special Instruction</label>
                        <input type="text" class="form-control" id="si">
                    </div>
                </div>
            </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" onclick="simpan()" id="proses" class="btn btn-success">Process</button>
    </div>
    </form>
</div>

<script language="javascript">
    function finish() {
        load_silent("wrh/aksesoris/detailbom/" + $("#no_fppp").val() + "/", "#content");
    }
    $(document).ready(function() {

        $('.datepicker').datepicker({
            autoclose: true
        });
        $("select").select2();
        $('#form_pembelian').hide();
    });

    function simpan() {
        $.ajax({
                type: "POST",
                url: "<?= site_url('wrh/aksesoris/simpanSj') ?>",
                dataType: 'json',
                data: {
                    'no_sj': $('#no_sj').val(),
                    'id_fppp': $('#id_fppp').val(),
                    'id_divisi': $('#id_divisi').val(),
                    'tgl_kirim': $('#tgl_kirim').val(),
                    'sopir': $('#sopir').val(),
                    'no_polisi': $('#no_polisi').val(),
                    'si': $('#si').val(),
                }
            })
            .success(function(datasaved) {
                $.growl.notice({
                    title: 'Sukses',
                    message: 'Surat Jalan Berhasil dibuat'
                });
                load_silent("wrh/aksesoris/stok_out/", "#content");
            });
    }
</script>