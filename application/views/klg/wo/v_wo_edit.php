<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Stock In wo Edit</h3>

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
                        <label class="control-label">Tgl Order:</label>
                        <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" id="tgl_order" value="<?= $row->tgl_order ?>" placeholder="Tgl Order" autocomplete="off">
                        <input type="hidden" class="form-control" id="id" value="<?= $id ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Divisi:</label>
                        <select id="id_divisi" name="id_divisi" class="form-control" style="width:100%" required>
                            <option value="">-- Select --</option>
                            <?php foreach ($divisi->result() as $valap) : ?>
                                <?php $sel1 = ($valap->id == $row->id_divisi) ? 'selected' : ''; ?>
                                <option value="<?= $valap->id ?>" <?= $sel1 ?>><?= $valap->divisi ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">No PR / WO / PO:</label>
                        <input type="text" class="form-control" id="no_wo" value="<?= $row->no_wo ?>" placeholder="No PR">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Item:</label>
                        <select id="id_item" name="id_item" class="form-control" style="width:100%" required>
                            <option value="">-- Select --</option>
                            <?php foreach ($item->result() as $valap) : ?>
                                <?php $sel2 = ($valap->id == $row->id_item) ? 'selected' : ''; ?>
                                <option value="<?= $valap->id ?>" <?= $sel2 ?>>
                                    <?= $valap->section_ata ?>-<?= $valap->section_allure ?>-<?= $valap->temper ?>-<?= $valap->kode_warna ?>-<?= $valap->ukuran ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Qty WO:</label>
                        <input type="text" class="form-control" id="qty_wo" value="<?= $row->qty_wo ?>" placeholder="qty_wo" autocomplete="off">
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
            url: "<?= site_url('klg/wo/simpan_edit/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "id": $("#id").val(),
                'tgl_order': $('#tgl_order').val(),
                'id_divisi': $('#id_divisi').val(),
                'no_wo': $("#no_wo").val(),
                'id_item': $('#id_item').val(),
                'qty_wo': $("#qty_wo").val(),
                'keterangan': $("#keterangan").val(),
            },
            success: function(img) {
                $.growl.notice({
                    title: 'Berhasil',
                    message: "mengupdate WO"
                });
                load_silent("klg/wo/", "#content");
            }
        });

    }
    $(document).ready(function() {

        $('.datepicker').datepicker({
            autoclose: true
        });
        $("select").select2();
    });
</script>