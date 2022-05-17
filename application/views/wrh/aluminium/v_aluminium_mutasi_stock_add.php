<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Mutasi</h3>

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
                        <label>Tgl Aktual</label>
                        <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" id="tgl_aktual" value="<?= date('Y-m-d') ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Item</label>
                        <input type="hidden" class="form-control" id="item" value="<?= $id_item ?>" readonly>
                        <input type="text" class="form-control" id="itemx" value="<?= $row->section_ata ?>-<?= $row->section_allure ?>-<?= $row->temper ?>-<?= $row->kode_warna ?>-<?= $row->ukuran ?>-<?= $row->warna ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Gudang:</label>
                        <select id="id_gudang" name="id_gudang" class="form-control" style="width:100%" required>
                            <option value="">-- Select --</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Keranjang:</label>
                        <select id="keranjang" name="keranjang" class="form-control" style="width:100%" required>
                            <option value="">-- Select --</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="text" class="form-control" id="qty" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Keterangan Out</label>
                        <input type="text" class="form-control" id="keterangan_out">
                    </div>
                </div>
            </div>
            <h3 class="box-title">Mutasi Ke:</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Gudang</label>
                        <select id="id_gudang2" name="id_gudang2" class="form-control" style="width:100%" required>
                            <option value="">-- Select --</option>
                            <?php foreach ($gudang->result() as $valap) : ?>
                                <option value="<?= $valap->id ?>"><?= $valap->gudang ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Keranjang</label>
                        <input type="text" class="form-control" id="keranjang2">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="text" class="form-control" id="qty2">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Keterangan In</label>
                        <input type="text" class="form-control" id="keterangan_in">
                    </div>
                </div>
            </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" onclick="mutasi()" id="mutasi" class="btn btn-success">Simpan Mutasi</button>
    </div>
    </form>
</div>

<script language="javascript">
    function mutasi() {
        var qty1 = parseInt($('#qty').val());
        var qty2 = parseInt($('#qty2').val());
        if (qty1 >= qty2) {
            $('#mutasi').hide();
            if ($('#id_gudang').val() != '' && $('#keranjang').val() != '' && $('#id_gudang2').val() != '' && $('#qty').val() != '' && $('#keranjang2').val() != '' && $('#qty2').val() != '') {
                $.ajax({
                    url: "<?= site_url('wrh/aluminium/simpanMutasi') ?>",
                    dataType: "json",
                    type: "POST",
                    data: {
                        "tgl_aktual": $('#tgl_aktual').val(),
                        "id_item": $('#item').val(),
                        "id_gudang": $('#id_gudang').val(),
                        "keranjang": $('#keranjang').val(),
                        "qty": $('#qty').val(),
                        "keterangan_out": $('#keterangan_out').val(),

                        "id_gudang2": $('#id_gudang2').val(),
                        "keranjang2": $('#keranjang2').val(),
                        "qty2": $('#qty2').val(),
                        "keterangan_in": $('#keterangan_in').val(),
                    },
                    success: function(data) {
                        $.growl.notice({
                            title: 'Sukses',
                            message: "Berhasil mutasi"
                        });
                        load_silent("wrh/aluminium/mutasi_stock_history/" + $('#item').val(), "#content");
                    }
                });
            }

        } else {
            alert("Jangan melebihi qty awal!");
        }


    }
    $(document).ready(function() {

        $('.datepicker').datepicker({
            autoclose: true
        });
        $("select").select2();
        getGudang();
    });


    function getGudang() {
        var x = $("select[name=id_gudang]");
        z = "<option>-- Select --</option>";
        $.ajax({
            url: "<?= site_url('wrh/aluminium/optionGetGudangDivisi') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "item": $('#item').val(),
            },
            success: function(data) {

                var z = "<option value=''>-- Select --</option>";
                for (var i = 0; i < data.length; i++) {
                    z += '<option value=' + data[i].id + '>' + data[i].gudang + '</option>';
                }
                x.html(z);
            }
        });
    }

    $("select[name=id_gudang]").change(function() {
        var x = $("select[name=keranjang]");
        if ($(this).val() == "") {
            x.html("<option>-- Select --</option>");
        } else {
            z = "<option>-- Select --</option>";
            $.ajax({
                url: "<?= site_url('wrh/aluminium/optionGetKeranjangGudang') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "item": $('#item').val(),
                    "gudang": $(this).val()
                },
                success: function(data) {

                    var z = "<option value=''>-- Select --</option>";
                    for (var i = 0; i < data.length; i++) {
                        z += '<option value=' + data[i].keranjang + '>' + data[i].keranjang + '</option>';
                    }
                    x.html(z);
                }
            });

        }
    });

    $("select[name=keranjang]").change(function() {
        $.ajax({
            url: "<?= site_url('wrh/aluminium/optionGetQtyKeranjang') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "item": $('#item').val(),
                "gudang": $('#id_gudang').val(),
                "keranjang": $(this).val()
            },
            success: function(data) {
                $('#qty').val(data['qty']);
            }
        });
    });
</script>