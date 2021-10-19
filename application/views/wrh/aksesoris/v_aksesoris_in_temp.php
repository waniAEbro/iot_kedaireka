<div class="row" id="form_pembelian">
    <div class="col-lg-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Input Stock</h3>
            </div>
            <div class="div-pembelian">
                <form method="post" class="form-vertical form" role="form" id="formid">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Tgl Aktual:</label>
                            <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" id="aktual" value="<?= $row_temp->tgl_aktual ?>" placeholder="Tgl Aktual" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Supplier:</label>
                            <select id="supplier" name="supplier" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($supplier->result() as $valap) : ?>
                                    <?php $sele = ($row_temp->id_supplier == $valap->id) ? 'selected' : ''; ?>
                                    <option value="<?= $valap->id ?>" <?= $sele ?>><?= $valap->kode ?> - <?= $valap->supplier ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">No Surat Jalan:</label>
                            <input type="text" class="form-control" id="no_surat_jalan" value="<?= $row_temp->no_surat_jalan ?>" placeholder="No Surat Jalan">
                        </div>
                        <div class="form-group">
                            <label class="control-label">No PR / WO / PO:</label>
                            <input type="text" class="form-control" id="no_pr" value="<?= $row_temp->no_pr ?>" placeholder="No PR">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label">Item:</label>
                            <select id="item" name="item" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($item->result() as $valap) : ?>
                                    <option value="<?= $valap->id ?>">
                                        <?= $valap->item_code ?>-<?= $valap->deskripsi ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Qty Surat Jalan:</label>
                            <input type="text" style="text-align: right;" class="form-control" id="qty" placeholder="Qty" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Divisi:</label>
                            <select id="id_divisi" name="id_divisi" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($divisi->result() as $valap) : ?>
                                    <option value="<?= $valap->id ?>"><?= $valap->divisi ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
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
                            <th width="30%">Item</th>
                            <th width="15%">Qty</th>
                            <th width="15%">Supplier</th>
                            <th width="15%">No Surat Jalan</th>
                            <th width="15%">No PR</th>
                            <th width="15%">Divisi</th>
                            <th width="15%">Gudang</th>
                            <th width="15%">Keranjang/Rak</th>
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
                message: "Tambah Stock selesai!"
            });
            load_silent("wrh/aksesoris/finish_stok_in", "#content");
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

    function quotation() {

        if ($('#aktual').val() != '' && $('#item').val() != '' && $('#qty').val() != '' && $('#id_divisi').val() != '' && $('#id_gudang').val() != '' && $('#keranjang').val() != '') {

            $.ajax({
                    type: "POST",
                    url: "<?= site_url('wrh/aksesoris/savestokin') ?>",
                    dataType: 'json',
                    data: {
                        'aktual': $('#aktual').val(),
                        'item': $('#item').val(),
                        'qty': $("#qty").val(),
                        'supplier': $("#supplier").val(),
                        'no_surat_jalan': $("#no_surat_jalan").val(),
                        'no_pr': $("#no_pr").val(),
                        'id_divisi': $("#id_divisi").val(),
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
                  <td width = "30%">\
                    ' + $('#item :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#qty').val() + '\
                  </td>\
                  <td width = "15%">\
                  ' + $('#supplier :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#no_surat_jalan').val() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#no_pr').val() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#id_divisi :selected').text() + '\
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
                    $('#item').val('').trigger('change');
                    // $('#id_divisi').val('');
                    // $('#id_gudang').val('').trigger('change');
                    $("#qty").val('');
                    // $("#supplier").val('');
                    // $("#no_surat_jalan").val('');
                    // $("#no_pr").val('');
                    // $("#keranjang").val('');
                    // $("#keterangan").val('');
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
                        $('#jumlah').val('');
                    } else {
                        $.growl.error({
                            title: 'Peringatan',
                            message: 'Terjadi Kesalahan! UNKNOWN ERROR'
                        });
                        $('#jumlah').val('');
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
                    url: "<?= site_url('wrh/aksesoris/deleteItemIn') ?>",
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
                    hitungJml(xi);
                });
        }
    }

    $("select[name=id_gudang]").change(function() {
        $.ajax({
            url: "<?= site_url('wrh/aksesoris/inOptionGetKeranjang') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "item": $('#item').val(),
                "divisi": $('#id_divisi').val(),
                "gudang": $('#id_gudang').val(),
            },
            success: function(data) {
                $('#keranjang').val(data['keranjang']);
            }
        });
    });
</script>