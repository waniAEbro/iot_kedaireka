<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Stock In Aluminium Edit</h3>

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
                        <input type="text" class="form-control" value="<?= $row->section_ata ?>-<?= $row->section_allure ?>-<?= $row->temper ?>-<?= $row->kode_warna ?>-<?= $row->ukuran ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Warna</label>
                        <input type="text" class="form-control" value="<?= $row->warna ?>" readonly>
                    </div>
                </div>
            </div>
            <?php
            $ronly = (from_session('level') > 1) ? 'readonly' : '';
            ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Gudang</label>
                        <?php
                        if (from_session('level') > 1) { ?>
                            <div style="display:none;">
                                <select id="id_gudang" name="id_gudang" class="form-control" style="width:100%;">
                                    <option value="">-- Select --</option>
                                    <?php foreach ($gudang->result() as $valap) :
                                        $selected = ($row->id_gudang == $valap->id) ? 'selected' : ''; ?>
                                        <option value="<?= $valap->id ?>" <?= $selected ?>><?= $valap->gudang ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <input type="text" id="keranjang" class="form-control" value="<?= $row->keranjang ?>" readonly>
                        <?php } else { ?>
                            <select id="id_gudang" name="id_gudang" class="form-control" style="width:100%;">
                                <option value="">-- Select --</option>
                                <?php foreach ($gudang->result() as $valap) :
                                    $selected = ($row->id_gudang == $valap->id) ? 'selected' : ''; ?>
                                    <option value="<?= $valap->id ?>" <?= $selected ?>><?= $valap->gudang ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php }

                        ?>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Keranjang</label>
                        <input type="text" id="keranjang" class="form-control" value="<?= $row->keranjang ?>" <?= $ronly ?>>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="text" id="qty" class="form-control" value="<?= $row->qty_in ?>" <?= $ronly ?>>
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
            url: "<?= site_url('wrh/aluminium/simpan_edit/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "id": $("#id").val(),
                'id_gudang': $("#id_gudang").val(),
                'keranjang': $("#keranjang").val(),
                'qty': $("#qty").val(),
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
                load_silent("wrh/aluminium/stok_in/", "#content");
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