<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Stock In Aksesoris Edit</h3>

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
                        <label>Item Code</label>
                        <input type="hidden" class="form-control" id="id" value="<?= $id ?>" readonly>
                        <input type="text" class="form-control" value="<?= $row->item_code ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" class="form-control" value="<?= $row->deskripsi ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Divisi</label>
                        <input type="text" class="form-control" value="<?= $row->divisi ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Gudang</label>
                        <input type="text" class="form-control" value="<?= $row->gudang ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Keranjang</label>
                        <input type="text" class="form-control" value="<?= $row->keranjang ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="text" class="form-control" value="<?= $row->qty_in ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Supplier:</label>
                        <select id="supplier" name="supplier" class="form-control" style="width:100%" required>
                            <option value="">-- Select --</option>
                            <?php foreach ($supplier->result() as $valap) :
                                $selected = ($row->id_supplier == $valap->id) ? 'selected' : '';
                            ?>
                                <option value="<?= $valap->id ?>" <?= $selected ?>><?= $valap->kode ?> - <?= $valap->supplier ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>No Surat Jalan</label>
                        <input type="text" class="form-control" id="no_surat_jalan" value="<?= $row->no_surat_jalan ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>No PR</label>
                        <input type="text" class="form-control" id="no_pr" value="<?= $row->no_pr ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" value="<?= $row->keterangan ?>">
                    </div>
                </div>
            </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" id="simpan" onclick="simpan()" id="proses" class="btn btn-success">Process</button>
    </div>
    </form>
</div>

<script language="javascript">
    function simpan() {
        $("#simpan").hide();
        $.ajax({
            url: "<?= site_url('wrh/aksesoris/simpan_edit/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "id": $("#id").val(),
                'supplier': $("#supplier").val(),
                'no_surat_jalan': $("#no_surat_jalan").val(),
                'no_pr': $("#no_pr").val(),
                'keterangan': $("#keterangan").val(),
            },
            success: function(img) {
                $.growl.notice({
                    title: 'Berhasil',
                    message: "mengupdate stok in"
                });
                load_silent("wrh/aksesoris/stok_in/", "#content");
            }
        });

    }
    $(document).ready(function() {

        $('.datepicker').datepicker({
            autoclose: true
        });
        $("select").select2();
        $('#form_pembelian').hide();
    });
</script>