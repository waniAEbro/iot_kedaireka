<div class="row" id="form_pembelian">
    <div class="col-lg-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Input WO Aluminium</h3>
            </div>
            <div class="div-pembelian">
                <form method="post" class="form-vertical form" role="form" id="formid">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Tgl Order:</label>
                            <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" id="tgl_order" value="<?= date('Y-m-d') ?>" placeholder="Tgl Order" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Divisi:</label>
                            <select id="id_divisi" name="id_divisi" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($divisi->result() as $valap) : ?>
                                    <option value="<?= $valap->id ?>"><?= $valap->divisi ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">No PR / WO / PO:</label>
                            <input type="text" class="form-control" id="no_wo" placeholder="No PR">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label">Item:</label>
                            <select id="id_item" name="id_item" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($item->result() as $valap) : ?>
                                    <option value="<?= $valap->id ?>">
                                        <?= $valap->section_ata ?>-<?= $valap->section_allure ?>-<?= $valap->temper ?>-<?= $valap->kode_warna ?>-<?= $valap->ukuran ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Qty WO:</label>
                            <input type="text" style="text-align: right;" class="form-control" id="qty_wo" placeholder="qty_wo" autocomplete="off">
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
                            <th width="15%">Tgl Order</th>
                            <th width="15%">Divisi</th>
                            <th width="15%">No PR / WO / PO:</th>
                            <th width="30%">Item</th>
                            <th width="15%">Qty WO</th>
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
                message: "Tambah WO selesai!"
            });
            load_silent("klg/wo/finish", "#content");
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

        if ($('#no_wo').val() != '' && $('#tgl_order').val() != '' && $('#id_item').val() != '' && $('#qty_wo').val() != '' && $('#id_divisi').val() != '') {

            $.ajax({
                    type: "POST",
                    url: "<?= site_url('klg/wo/savestokin') ?>",
                    dataType: 'json',
                    data: {
                        'tgl_order': $('#tgl_order').val(),
                        'id_divisi': $('#id_divisi').val(),
                        'no_wo': $("#no_wo").val(),
                        'id_item': $('#id_item').val(),
                        'qty_wo': $("#qty_wo").val(),
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
                    ' + $('#tgl_order').val() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#id_divisi :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#no_wo').val() + '\
                  </td>\
                  <td width = "30%">\
                  ' + $('#id_item :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#qty_wo').val() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#keterangan').val() + '\
                  </td>\
                </tr>';
                    $('tr.odd').remove();
                    $('#dataTbl').append(x);
                    $('#id_item').val('').trigger('change');
                    $("#qty_wo").val('');
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
                        $('#jumlah').val('');
                    } else {
                        $.growl.error({
                            title: 'Peringatan',
                            message: 'Terjadi Kesalahan! UNKNOWN ERROR'
                        });
                        $('#qty_wo').val('');
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
                    url: "<?= site_url('klg/wo/deleteWoIn') ?>",
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