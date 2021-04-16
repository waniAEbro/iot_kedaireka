<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Stock OUT</h3>

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
                        <label>No FPPP</label>
                        <select id="no_fppp" name="no_fppp" class="form-control" style="width:100%" required>
                            <option value="">-- Select --</option>
                            <?php foreach ($no_fppp->result() as $valap) : ?>
                                <option value="<?= $valap->id ?>"><?= $valap->no_fppp ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Nama Proyek</label>
                        <input type="text" class="form-control" id="nama_proyek" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Pengiriman</label>
                        <input type="text" class="form-control" id="alamat_pengiriman" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Warna</label>
                        <input type="text" class="form-control" id="warna" readonly>
                    </div>
                </div>
            </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" onclick="finish()" id="proses" class="btn btn-success">Process</button>
    </div>
    </form>
</div>

<script language="javascript">
    function finish() {
        // if (confirm('Anda yakin ingin melanjutkan?')) {
        //     $.growl.notice({
        //         title: 'Berhasil',
        //         message: "Tambah Stock selesai!"
        //     });
        // }
        load_silent("wrh/aksesoris/detailbom/" + $("#no_fppp").val() + "/", "#content");
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
            url: "<?= site_url('wrh/aksesoris/getDetailFppp/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "no_fppp": $(this).val(),
            },
            success: function(img) {
                $('#nama_proyek').val(img['nama_proyek']);
                $('#alamat_pengiriman').val(img['alamat_pengiriman']);
                $('#warna').val(img['warna']);
            }
        });


    });
</script>