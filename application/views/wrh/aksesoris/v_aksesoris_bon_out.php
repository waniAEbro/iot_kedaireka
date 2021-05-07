<div class="row" id="form_pembelian">
    <div class="col-lg-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Input Bon Manual</h3>
            </div>
            <div class="div-pembelian">
                <form method="post" class="form-vertical form" role="form" id="formid">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Tgl Proses:</label>
                            <input type="text" value="<?= date('Y-m-d') ?>" class="form-control" id="tgl_proses" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">No Fppp:</label>
                            <select id="id_fppp" name="id_fppp" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($fppp->result() as $valap) : ?>
                                    <option value="<?= $valap->id ?>"><?= $valap->no_fppp ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Item:</label>
                            <select id="item_code" name="item_code" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Qty:</label>
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
                            <label class="control-label">Stock Gudang:</label>
                            <input type="text" style="text-align: right;" class="form-control" id="stock" placeholder="Stock" readonly>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="produksi" data-field='produksi' class="checkbox">
                            <label for="produksi">Produksi</label><br>
                            <input type="checkbox" id="lapangan" data-field='lapangan' class="checkbox">
                            <label for="lapangan">Lapangan</label><br>
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
                            <th width="15%">FPPP</th>
                            <th width="15%">Item</th>
                            <th width="15%">Qty</th>
                            <th width="15%">Divisi</th>
                            <th width="15%">Gudang</th>
                            <th width="15%">Produksi</th>
                            <th width="15%">Lapangan</th>
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
            load_silent("wrh/aksesoris", "#content");
        }
    }
    $(document).ready(function() {

        $('.datepicker').datepicker({
            autoclose: true
        });
        $("select").select2();
        $("#stock").val(0);
    });

    $(".checkbox").change(function() {
        var fieldname = $(this).data('field');
        if (fieldname == 'produksi') {
            $('#lapangan').prop('checked', false); // Unchecks it
            $('#lapangan').val('0');
            $('#produksi').val('1');
        } else {
            $('#produksi').prop('checked', false); // Checks it
            $('#lapangan').val('1');
            $('#produksi').val('0');
        }
    });

    $("#id_gudang").change(function() {
        $.ajax({
            url: "<?= site_url('wrh/aksesoris/getQtyDivisiGudang') ?>",
            dataType: "json",
            type: "POST",
            data: {
                'item_code': $("#item_code").val(),
                'id_divisi': $("#id_divisi").val(),
                'id_gudang': $("#id_gudang").val(),
            },
            success: function(data) {
                $('#stock').val(data['stock']);
            }
        });
    });

    $("select[name=id_fppp]").change(function() {
        var x = $("select[name=item_code]");
        if ($(this).val() == "") {
            x.html("<option>-- Select --</option>");
        } else {
            z = "<option>-- Select --</option>";
            $.ajax({
                url: "<?= site_url('wrh/aksesoris/optionAksesoris') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "fppp": $(this).val()
                },
                success: function(data) {

                    var z = "<option value=''>-- Select --</option>";
                    for (var i = 0; i < data.length; i++) {
                        z += '<option value=' + data[i].item_code + '>' + data[i].item_code + ' - ' + data[i].deskripsi + '</option>';
                    }
                    x.html(z);
                    // $('#tipe').val('').trigger('change');
                }
            });

        }
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
        if (parseInt($('#qty').val()) > parseInt($('#stock').val())) {
            alert("melebihi Qty Gudang!");
        } else {
            quotation2();
        }
    };

    function quotation2() {

        if ($('#item_code').val() != '' && $('#id_divisi').val() != '' && $('#id_gudang').val() != '' && $('#qty').val() != '') {

            $.ajax({
                    type: "POST",
                    url: "<?= site_url('wrh/aksesoris/savebonmanual') ?>",
                    dataType: 'json',
                    data: {
                        'tgl_proses': $('#tgl_proses').val(),
                        'id_fppp': $('#id_fppp').val(),
                        'item_code': $('#item_code').val(),
                        'qty': $("#qty").val(),
                        'id_divisi': $("#id_divisi").val(),
                        'id_gudang': $("#id_gudang").val(),
                        'produksi': $("#produksi").val(),
                        'lapangan': $("#lapangan").val(),
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
                    ' + $('#id_fppp :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#item_code :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#qty').val() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#id_divisi :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#id_gudang :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#produksi').val() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#lapangan').val() + '\
                  </td>\
                </tr>';
                    $('tr.odd').remove();
                    $('#dataTbl').append(x);
                    $('#item_code').val('').trigger('change');
                    $('#id_divisi').val('').trigger('change');
                    $('#id_gudang').val('').trigger('change');
                    $("#qty").val('');
                    $('#produksi').prop('checked', false);
                    $('#lapangan').prop('checked', false);
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
                    } else {
                        $.growl.error({
                            title: 'Peringatan',
                            message: 'Terjadi Kesalahan! UNKNOWN ERROR'
                        });
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
                    url: "<?= site_url('wrh/aksesoris/deleteItemBonManual') ?>",
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
</script>