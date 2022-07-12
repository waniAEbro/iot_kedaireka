<div class="row" id="form_pembelian">
    <div class="col-lg-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Input Stock Aluminium HRB</h3>
            </div>
            <div class="div-pembelian">
                <form method="post" class="form-vertical form" role="form" id="formid">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Tgl Aktual:</label>
                            <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" id="tgl_aktual" value="<?= date('Y-m-d') ?>" placeholder="Tgl Aktual" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Supplier:</label>
                            <select id="id_supplier" name="id_supplier" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($supplier->result() as $valap) : ?>
                                    <option value="<?= $valap->id ?>"><?= $valap->kode ?> - <?= $valap->supplier ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">No Surat Jalan:</label>
                            <input type="text" class="form-control" id="no_surat_jalan" placeholder="No Surat Jalan">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label">No PR/WO/PO:</label>
                            <select id="id_wo" name="id_wo" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($wo->result() as $valap) : ?>
                                    <option value="<?= $valap->id ?>"><?= $valap->no_wo ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Item:</label>
                            <select id="id_item" name="id_item" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Qty Surat Jalan:</label>
                            <input type="text" style="text-align: right;" class="form-control" id="qty" placeholder="Qty" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Gudang:</label>
                            <select id="id_gudang" name="id_gudang" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($gudang->result() as $valap) : ?>
                                    <option value="<?= $valap->id ?>"><?= $valap->gudang ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Keranjang / Rak:</label>
                            <input type="text" class="form-control" id="keranjang" placeholder="Keranjang">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Keterangan:</label>
                            <input type="text" class="form-control" id="keterangan" placeholder="keterangan">
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
                            <th width="15%">Tgl Aktual</th>
                            <th width="15%">Supplier</th>
                            <th width="15%">No Surat Jalan</th>
                            <th width="15%">No WO/PR/WO</th>
                            <th width="30%">Item</th>
                            <th width="15%">Qty</th>
                            <th width="15%">Gudang</th>
                            <th width="15%">Keranjang</th>
                            <th width="15%">Keterangan</th>
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
                message: "Tambah Stock WO selesai!"
            });
            load_silent("wrh_h/aluminium/finish_stok_in_wo", "#content");
        }
    }
    $(document).ready(function() {

        $('.datepicker').datepicker({
            autoclose: true
        });
        $("select").select2();
    });

    var xi = 0;
    $('#formid').on('keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (e.keyCode == 13 || e.keyCode == 9) {
            e.preventDefault();
            quotation();
        }
    });

    $("select[name=id_wo]").change(function() {
        $('#id_item').val('').trigger('change');
        var x = $("select[name=id_item]");
        if ($(this).val() == "") {
            x.html("<option>-- Select --</option>");
        } else {
            z = "<option>-- Select --</option>";
            $.ajax({
                url: "<?= site_url('wrh_h/aluminium/optionGetItemWo') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "id_wo": $(this).val()
                },
                success: function(data) {

                    var z = "<option value=''>-- Select --</option>";
                    for (var i = 0; i < data.length; i++) {
                        z += '<option value=' + data[i].id + '>' + data[i].item_code + '</option>';
                    }
                    x.html(z);
                }
            });

        }
    });

    function quotation() {

        if ($('#tgl_aktual').val() != '' && $('#id_wo').val() != '' && $('#id_item').val() != '' && $('#qty').val() != '' && $('#id_gudang').val() != '' && $('#keranjang').val() != '') {

            $.ajax({
                    type: "POST",
                    url: "<?= site_url('wrh_h/aluminium/savestokin_wo') ?>",
                    dataType: 'json',
                    data: {
                        'tgl_aktual': $('#tgl_aktual').val(),
                        'id_supplier': $("#id_supplier").val(),
                        'no_surat_jalan': $("#no_surat_jalan").val(),
                        'id_wo': $("#id_wo").val(),
                        'id_item': $('#id_item').val(),
                        'qty': $("#qty").val(),
                        'id_gudang': $("#id_gudang").val(),
                        'keranjang': $("#keranjang").val(),
                        'keterangan': $("#keterangan").val(),
                    },
                })
                .success(function(datasaved) {
                    //code here
                    xi++;
                    var i = datasaved['id'];


                    var x = '<tr id="output_data_' + i + '" class="output_data">\
                  <td width = "15%" align= "center">\
                  <a  class = "btn btn-xs btn-danger" href = "javascript:void(0)" onClick = "hapus(' + i + ')">\
                  <i  class = "fa fa-trash"></i></a>\
                  </td>\
                  <td width = "15%">\
                    ' + $('#tgl_aktual').val() + '\
                  </td>\
                  <td width = "15%">\
                  ' + $('#id_supplier :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#no_surat_jalan').val() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#id_wo :selected').text() + '\
                  </td>\
                  <td width = "30%">\
                    ' + $('#id_item :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#qty').val() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#id_gudang :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#keranjang').val() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#keterangan').val() + '\
                  </td>\
                </tr>';
                    $('tr.odd').remove();
                    $('#dataTbl').append(x);
                    $('#id_gudang').val('').trigger('change');
                    $("#qty").val('');
                    $("#keranjang").val('');
                    $("#keterangan").val('');
                    $.growl.notice({
                        title: 'Sukses',
                        message: "Berhasil menyimpan"
                    });

                })
                .fail(function(XHR) {
                    if (XHR.readyState == 0) {
                        $.growl.error({
                            title: 'Peringatan',
                            message: 'Terjadi Kesalahan! KONEKSI TERPUTUS'
                        });
                        $('#qty').val('');
                    } else {
                        $.growl.error({
                            title: 'Peringatan',
                            message: 'Terjadi Kesalahan! UNKNOWN ERROR'
                        });
                        $('#qty').val('');
                    }
                });



        } else {
            $.growl.error({
                title: 'Peringatan',
                message: 'Lengkapi Form dulu!'
            });
        };
    }

    function hapus(i) {
        if (confirm('Lanjutkan Proses Hapus?')) {
            $.ajax({
                    type: "POST",
                    url: "<?= site_url('wrh_h/aluminium/deleteItemIn_wo') ?>",
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