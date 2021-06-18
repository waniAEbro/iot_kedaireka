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
                            <label class="control-label">Tgl Proses:</label>
                            <input type="text" value="<?= date('Y-m-d') ?>" class="form-control" id="tgl_proses" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Section ATA:</label>
                            <select id="section_ata" name="section_ata" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($section_ata->result() as $valap) : ?>
                                    <option value="<?= $valap->section_ata ?>">[<?= $valap->section_ata ?>] -
                                        <?= $valap->section_allure ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Section Allure:</label>
                            <select id="section_allure" name="section_allure" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($section_ata->result() as $valap) : ?>
                                    <option value="<?= $valap->section_allure ?>">[<?= $valap->section_allure ?>] -
                                        <?= $valap->section_allure ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Temper:</label>
                            <select id="temper" name="temper" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Kode Warna:</label>
                            <select id="kode_warna" name="kode_warna" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Ukuran:</label>
                            <select id="ukuran" name="ukuran" class="form-control" style="width:100%" required>
                                <option value="">-- Select --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Qty Surat Jalan:</label>
                            <input type="text" style="text-align: right;" class="form-control" id="qty" placeholder="Qty" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Supplier:</label>
                            <input type="text" class="form-control" id="supplier" placeholder="Supplier">
                        </div>
                        <div class="form-group">
                            <label class="control-label">No Surat Jalan:</label>
                            <input type="text" class="form-control" id="no_surat_jalan" placeholder="No Surat Jalan">
                        </div>
                        <div class="form-group">
                            <label class="control-label">No PR:</label>
                            <input type="text" class="form-control" id="no_pr" placeholder="No PR">
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
                            <label class="control-label">Keranjang:</label>
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
                            <th width="15%">Section ATA</th>
                            <th width="15%">Section Allure</th>
                            <th width="15%">Temper</th>
                            <th width="15%">Kode Warna</th>
                            <th width="15%">Ukuran</th>
                            <th width="15%">Qty</th>
                            <th width="15%">Supplier</th>
                            <th width="15%">No Surat Jalan</th>
                            <th width="15%">Divisi</th>
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
                message: "Tambah Stock selesai!"
            });
            load_silent("wrh/aluminium", "#content");
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

    $("select[name=section_ata]").change(function() {
        var x = $("select[name=section_allure]");
        if ($(this).val() == "") {
            x.html("<option>-- Select --</option>");
        } else {
            z = "<option>-- Select --</option>";
            $.ajax({
                url: "<?= site_url('wrh/aluminium/optionGetSectionAllure') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "section_ata": $(this).val()
                },
                success: function(data) {

                    var z = "<option value=''>-- Select --</option>";
                    for (var i = 0; i < data.length; i++) {
                        z += '<option value=' + data[i].section_allure + '>' + data[i].section_allure + '</option>';
                    }
                    x.html(z);
                }
            });

        }
    });

    $("select[name=section_allure]").change(function() {
        var x = $("select[name=section_ata]");
        if ($(this).val() == "") {
            x.html("<option>-- Select --</option>");
        } else {
            z = "<option>-- Select --</option>";
            $.ajax({
                url: "<?= site_url('wrh/aluminium/optionGetSectionAta') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "section_allure": $(this).val()
                },
                success: function(data) {

                    var z = "<option value=''>-- Select --</option>";
                    for (var i = 0; i < data.length; i++) {
                        z += '<option value=' + data[i].section_ata + '>' + data[i].section_ata + '</option>';
                    }
                    x.html(z);
                }
            });

        }
    });

    $("#section_allure").change(function() {
        var x = $("select[name=temper]");
        if ($(this).val() == "") {
            x.html("<option>-- Select --</option>");
        } else {
            z = "<option>-- Select --</option>";
            $.ajax({
                url: "<?= site_url('wrh/aluminium/optionGetTemper') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "section_ata": $('#section_ata').val(),
                    "section_allure": $(this).val()
                },
                success: function(data) {

                    var z = "<option value=''>-- Select --</option>";
                    for (var i = 0; i < data.length; i++) {
                        z += '<option value=' + data[i].temper + '>' + data[i].temper + '</option>';
                    }
                    x.html(z);
                }
            });

        }
    });

    $("#temper").change(function() {
        var x = $("select[name=kode_warna]");
        if ($(this).val() == "") {
            x.html("<option>-- Select --</option>");
        } else {
            z = "<option>-- Select --</option>";
            $.ajax({
                url: "<?= site_url('wrh/aluminium/optionGetKodeWarna') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "section_ata": $('#section_ata').val(),
                    "section_allure": $('#section_allure').val(),
                    "temper": $(this).val()
                },
                success: function(data) {

                    var z = "<option value=''>-- Select --</option>";
                    for (var i = 0; i < data.length; i++) {
                        z += '<option value=' + data[i].kode_warna + '>' + data[i].kode_warna + '</option>';
                    }
                    x.html(z);
                }
            });

        }
    });

    $("#kode_warna").change(function() {
        var x = $("select[name=ukuran]");
        if ($(this).val() == "") {
            x.html("<option>-- Select --</option>");
        } else {
            z = "<option>-- Select --</option>";
            $.ajax({
                url: "<?= site_url('wrh/aluminium/optionGetUkuran') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "section_ata": $('#section_ata').val(),
                    "section_allure": $('#section_allure').val(),
                    "temper": $('#temper').val(),
                    "ukuran": $(this).val()
                },
                success: function(data) {

                    var z = "<option value=''>-- Select --</option>";
                    for (var i = 0; i < data.length; i++) {
                        z += '<option value=' + data[i].ukuran + '>' + data[i].ukuran + '</option>';
                    }
                    x.html(z);
                }
            });

        }
    });

    function quotation() {

        if ($('#section_ata').val() != '' && $('#divisi').val() != '' && $('#area').val() != '' && $('#rak').val() != '') {

            $.ajax({
                    type: "POST",
                    url: "<?= site_url('wrh/aluminium/savestokin') ?>",
                    dataType: 'json',
                    data: {
                        'tgl_proses': $('#tgl_proses').val(),
                        'section_ata': $('#section_ata').val(),
                        'section_allure': $('#section_allure').val(),
                        'temper': $('#temper').val(),
                        'kode_warna': $('#kode_warna').val(),
                        'ukuran': $('#ukuran').val(),
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
                  <td width = "15%">\
                    ' + $('#section_ata :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#section_allure :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#temper :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#kode_warna :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#ukuran :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#qty').val() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#supplier').val() + '\
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
                    $('#section_ata').val('').trigger('change');
                    $('#id_divisi').val('').trigger('change');
                    $('#id_gudang').val('').trigger('change');
                    $("#qty").val('');
                    $("#supplier").val('');
                    $("#no_surat_jalan").val('');
                    $("#no_pr").val('');
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
                    url: "<?= site_url('wrh/aluminium/deleteItemIn') ?>",
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