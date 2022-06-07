<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Stock OUT BON Surat Jalan pvc</h3>

        <div class="box-tools pull-right">
            <button type="button" id="tutup" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form method="post" class="form-vertical form_faktur" role="form">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>No FPPP</label>
                        <input type="hidden" class="form-control" id="id_fppp" value="<?= $id_fppp ?>" readonly>
                        <input type="text" class="form-control" id="no_fppp" value="<?= $row_fppp->no_fppp ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>No Surat Jalan</label>
                        <input type="text" class="form-control" value="<?= $no_surat_jalan ?>" id="no_surat_jalan" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nama Proyek</label>
                        <input type="text" class="form-control" id="nama_proyek" value="<?= $row_fppp->nama_proyek ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Alamat Proyek</label>
                        <input type="text" class="form-control" id="alamat_proyek" value="<?= $row_fppp->alamat_proyek ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nama Sales</label>
                        <input type="text" class="form-control" id="sales" value="<?= $row_fppp->sales ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Deadline Pengiriman</label>
                        <input type="text" class="form-control" id="deadline_pengiriman" value="<?= $row_fppp->deadline_pengiriman ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Penerima</label>
                        <input type="text" class="form-control" id="penerima">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Alamat Pengiriman</label>
                        <input type="text" class="form-control" id="alamat_pengiriman">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Sopir</label>
                        <input type="text" class="form-control" id="sopir">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>No Kendaraan</label>
                        <input type="text" class="form-control" id="no_kendaraan">
                    </div>
                </div>
            </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" id="finish" onclick="finish()" id="proses" class="btn btn-success">Process</button>
    </div>
    </form>
</div>

<script language="javascript">
    function finish() {
        $("#finish").hide();
        $.ajax({
            url: "<?= site_url('wrh/pvc/simpanSuratJalan/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "id_fppp": $("#id_fppp").val(),
                "no_surat_jalan": $("#no_surat_jalan").val(),
                "penerima": $("#penerima").val(),
                "alamat_pengiriman": $("#alamat_pengiriman").val(),
                "sopir": $("#sopir").val(),
                "no_kendaraan": $("#no_kendaraan").val(),
            },
            success: function(img) {
                $.growl.notice({
                    title: 'Berhasil',
                    message: "Menyimpan Surat Jalan!"
                });
                load_silent("wrh/pvc/list_surat_jalan/", "#content");
            }
        });
        // if (confirm('Anda yakin ingin melanjutkan?')) {
        //     $.growl.notice({
        //         title: 'Berhasil',
        //         message: "Tambah Stock selesai!"
        //     });
        // }

    }
    $(document).ready(function() {

        $('.datepicker').datepicker({
            autoclose: true
        });
        $("select").select2();
        $('#form_pembelian').hide();
    });

    $("#no_fppp").change(function() {
        $.ajax({
            url: "<?= site_url('wrh/pvc/getDetailFppp/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "no_fppp": $(this).val(),
            },
            success: function(img) {
                $('#nama_proyek').val(img['nama_proyek']);
                $('#alamat_proyek').val(img['alamat_proyek']);
                $('#sales').val(img['sales']);
                $('#deadline_pengiriman').val(img['deadline_pengiriman']);
            }
        });


    });
</script>