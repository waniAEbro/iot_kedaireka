<div class="row" id="form_pembelian">
    <div class="col-lg-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Input Mutasi lembaran</h3>
            </div>
            <div class="div-pembelian">
                <form method="post" class="form-vertical form" role="form" id="formid">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Tgl Aktual:</label>
                            <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" id="tgl_aktual" value="<?= date('Y-m-d') ?>" placeholder="Tgl Aktual" autocomplete="off">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label">Item:</label>
                            <select id="item" name="item" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($item->result() as $valap) : ?>
                                    <option value="<?= $valap->id ?>">
                                        <?= $valap->item_code ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Divisi:</label>
                            <select id="id_divisi" name="id_divisi" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php
                                foreach ($divisi->result() as $valap) : ?>
                                    <option value="<?= $valap->id ?>"><?= $valap->divisi ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Gudang:</label>
                            <select id="id_gudang" name="id_gudang" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Keranjang:</label>
                            <select id="keranjang" name="keranjang" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Qty</label>
                            <input type="text" class="form-control" id="qty" readonly>
                        </div>
                        <div class="form-group">
                            <label>Keterangan Out</label>
                            <input type="text" class="form-control" id="keterangan_out">
                        </div>
                        <br>
                        <hr>
                        <b>Mutasi Ke:</b>
                        <br>
                        <div class="form-group">
                            <label>Divisi</label>
                            <select id="id_divisi2" name="id_divisi2" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($divisi2->result() as $valap) : ?>
                                    <option value="<?= $valap->id ?>"><?= $valap->divisi ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Gudang</label>
                            <select id="id_gudang2" name="id_gudang2" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($gudang->result() as $valap) : ?>
                                    <option value="<?= $valap->id ?>"><?= $valap->gudang ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Keranjang</label>
                            <input type="text" class="form-control" id="keranjang2">
                        </div>
                        <div class="form-group">
                            <label>Qty</label>
                            <input type="text" class="form-control" id="qty2">
                        </div>
                        <div class="form-group">
                            <label>Keterangan In</label>
                            <input type="text" class="form-control" id="keterangan_in">
                        </div>

                        <div class="form-group">
                            <a onclick="quotation()" class="btn btn-info">Add Stock</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Saved Item</h3>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-bordered table-striped" style="font-size: smaller;">
                    <thead>
                        <tr>
                            <th width="5%">Act</th>
                            <th width="30%">Item</th>
                            <th width="10%">Gudang</th>
                            <th width="10%">Keranjang</th>
                            <th width="10%">Qty</th>
                            <th width="10%">Keterangan Out</th>
                            <th width="10%">Gudang</th>
                            <th width="10%">Keranjang</th>
                            <th width="10%">Qty</th>
                            <th width="10%">Keterangan In</th>
                        </tr>
                    </thead>
                    <tbody id="dataTbl">
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <a onclick="finish()" class="btn btn-success pull-right"> Finish</a>
            </div>
        </div>
    </div>
</div>

<script language="javascript">
    function finish() {
        if (confirm('Anda yakin ingin menyelesaikan?')) {
            $.growl.notice({
                title: 'Berhasil',
                message: "Tambah Stock selesai!"
            });
            load_silent("wrh/lembaran/mutasi_list", "#content");
        }
    }
    $(document).ready(function() {

        $('.datepicker').datepicker({
            autoclose: true
        });
        $("select").select2();
    });

    $("select[name=id_divisi]").change(function() {
        $('#id_gudang').val('').trigger('change');
        $('#keranjang').val('').trigger('change');
        $("#qty").val('');
        $("#keterangan_out").val('');
        var x = $("select[name=id_gudang]");
        if ($(this).val() == "") {
            x.html("<option>-- Select --</option>");
        } else {
            z = "<option>-- Select --</option>";
            $.ajax({
                url: "<?= site_url('wrh/lembaran/optionGetGudangDivisi') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "item": $('#item').val(),
                    "divisi": $(this).val()
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
    });

    $("select[name=id_gudang]").change(function() {
        var x = $("select[name=keranjang]");
        if ($(this).val() == "") {
            x.html("<option>-- Select --</option>");
        } else {
            z = "<option>-- Select --</option>";
            $.ajax({
                url: "<?= site_url('wrh/lembaran/optionGetKeranjangGudang') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "item": $('#item').val(),
                    "divisi": $('#id_divisi').val(),
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
            url: "<?= site_url('wrh/lembaran/optionGetQtyKeranjang') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "item": $('#item').val(),
                "divisi": $('#id_divisi').val(),
                "gudang": $('#id_gudang').val(),
                "keranjang": $(this).val()
            },
            success: function(data) {
                $('#qty').val(data['qty']);
            }
        });
    });

    $("select[name=id_gudang2]").change(function() {
        $.ajax({
            url: "<?= site_url('wrh/lembaran/inOptionGetKeranjang') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "item": $('#item').val(),
                "divisi": $('#id_divisi2').val(),
                "gudang": $('#id_gudang2').val(),
            },
            success: function(data) {
                $('#keranjang2').val(data['keranjang']);
            }
        });
    });

    var xi = 0;
    $('#formid').on('keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (e.keyCode == 13 || e.keyCode == 9) {
            e.preventDefault();
            quotation();
        }
    });

    function quotation() {
        var qty1 = parseInt($('#qty').val());
        var qty2 = parseInt($('#qty2').val());
        if (qty1 >= qty2) {
            $('#mutasi').hide();
            if ($('#id_gudang').val() != '' && $('#keranjang').val() != '' && $('#id_gudang2').val() != '' && $('#qty').val() != '' && $('#keranjang2').val() != '' && $('#qty2').val() != '') {
                $.ajax({
                    url: "<?= site_url('wrh/lembaran/simpanMutasi') ?>",
                    dataType: "json",
                    type: "POST",
                    data: {
                        "tgl_aktual": $('#tgl_aktual').val(),
                        "id_item": $('#item').val(),
                        "id_divisi": $('#id_divisi').val(),
                        "id_gudang": $('#id_gudang').val(),
                        "keranjang": $('#keranjang').val(),
                        "qty": $('#qty').val(),
                        "keterangan_out": $('#keterangan_out').val(),

                        "id_divisi2": $('#id_divisi2').val(),
                        "id_gudang2": $('#id_gudang2').val(),
                        "keranjang2": $('#keranjang2').val(),
                        "qty2": $('#qty2').val(),
                        "keterangan_in": $('#keterangan_in').val(),
                    },
                    success: function(datasaved) {
                        xi++;
                        var i = datasaved['id2'];


                        var x = '<tr id="output_data_' + i + '" class="output_data">\
                        <td width = "10%" align= "center">\
                        <a  class = "btn btn-xs btn-danger" href = "javascript:void(0)" onClick = "hapus(' + i + ')">\
                        <i  class = "fa fa-trash"></i></a>\
                        </td>\
                        <td width = "30%">\
                            ' + $('#item :selected').text() + '\
                        </td>\
                        <td width = "10%">\
                            ' + $('#id_gudang :selected').text() + '\
                        </td>\
                        <td width = "10%">\
                            ' + $('#keranjang :selected').text() + '\
                        </td>\
                        <td width = "10%">\
                            ' + $('#qty').val() + '\
                        </td>\
                        <td width = "10%">\
                            ' + $('#keterangan_out').val() + '\
                        </td>\
                        <td width = "10%">\
                            ' + $('#id_gudang2 :selected').text() + '\
                        </td>\
                        <td width = "10%">\
                            ' + $('#keranjang2').val() + '\
                        </td>\
                        <td width = "10%">\
                            ' + $('#qty2').val() + '\
                        </td>\
                        <td width = "10%">\
                            ' + $('#keterangan_in').val() + '\
                        </td>\
                        </tr>';
                        $('tr.odd').remove();
                        $('#dataTbl').append(x);
                        $('#id_gudang2').val('').trigger('change');
                        $("#keranjang2").val('');
                        $("#qty2").val('');
                        $.growl.notice({
                            title: 'Sukses',
                            message: "Berhasil menyimpan mutasi"
                        });
                    }
                });
            }

        } else {
            alert("Jangan melebihi qty awal!");
        }


    }

    function hapus(i) {
        if (confirm('Lanjutkan Proses Hapus?')) {
            $.ajax({
                    type: "POST",
                    url: "<?= site_url('wrh/lembaran/deleteMutasiIn') ?>",
                    dataType: 'json',
                    data: {
                        'id': i
                    }
                })
                .success(function(datasaved) {
                    $.growl.notice({
                        title: 'Sukses',
                        message: datasaved.msg
                    });
                    $('#output_data_' + i).remove();

                });
        }
    }
</script>