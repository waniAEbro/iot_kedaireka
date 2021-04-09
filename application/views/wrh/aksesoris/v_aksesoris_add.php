<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Form Stock</h3>

        <div class="box-tools pull-right">
            <button type="button" id="tutup" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form method="post" class="form-vertical form_faktur" role="form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <select id="item_code" name="item_code" class="form-control" style="width:100%" required>
                            <option value="">-- Select --</option>
                            <?php foreach ($item_code->result() as $valap) : ?>
                                <option value="<?= $valap->item_code ?>">[<?= $valap->item_code ?>] -
                                    <?= $valap->deskripsi ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Supplier</label>
                        <select id="supplier" name="supplier" class="form-control" style="width:100%" required>
                            <option value="">-- Select --</option>
                            <?php foreach ($supplier->result() as $valap) : ?>
                                <option value="<?= $valap->id ?>">
                                    <?= $valap->supplier ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Kode Bravo</label>
                        <input type="text" class="form-control" id="kode_bravo" placeholder="Kode Bravo">
                    </div>
                </div>
            </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" onclick="save()" id="proses" class="btn btn-success">Process</button>
    </div>
    </form>
</div>

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
                            <label class="control-label">Divisi:</label>
                            <input type="text" class="form-control" id="divisi" placeholder="Divisi">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Area:</label>
                            <input type="text" class="form-control" id="area" placeholder="Area">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Rak:</label>
                            <input type="text" class="form-control" id="rak" placeholder="Rak">
                            <input type="hidden" class="form-control" id="id_aksesoris" name="id_aksesoris" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Stock Awal Bulan:</label>
                            <input type="text" style="text-align: right;" class="form-control" id="stock_awal_bulan" name="stock_awal_bulan" placeholder="Stock Awal Bulan" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Stock Akhir Bulan:</label>
                            <input type="text" style="text-align: right;" class="form-control" id="stock_akhir_bulan" name="stock_akhir_bulan" placeholder="Stock Akhir Bulan" autocomplete="off">
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
                            <th width="25%">Divisi</th>
                            <th width="10%">Area</th>
                            <th width="10%">Rak</th>
                            <th width="10%">Stock Awal Bulan</th>
                            <th width="10%">Stock Akhir Bulan</th>
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
        $('#form_pembelian').hide();
    });

    function save() {
        // $(this).find("button[type='submit']").prop('disabled', true);
        // $("#proses").hide(50);
        // $("#silahkantunggu").show(50);
        $.ajax({
            type: "POST",
            url: site + 'wrh/aksesoris/saveaksesoris',
            dataType: 'json',
            data: {
                item_code: $("#item_code").val(),
                supplier: $("#supplier").val(),
                kode_bravo: $("#kode_bravo").val(),

            },
            success: function(data) {
                if (data['id'] == 'x') {
                    $.growl.error({
                        title: 'Gagal',
                        message: data['msg']
                    });
                } else {
                    $('#id_aksesoris').val(data['id']);
                    $.growl.notice({
                        title: 'Sukses',
                        message: data['msg']
                    });
                    // $('#tutup').click();
                    // $('#form_pembelian').show(1000);
                    load_silent("wrh/aksesoris", "#content");
                }

            }
        });


    }

    var xi = 0;


    $('#formid').on('keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (e.keyCode == 13 || e.keyCode == 9) {
            e.preventDefault();
            quotation();
        }
    });

    function quotation() {

        if ($('#id_aksesoris').val() != '' && $('#divisi').val() != '' && $('#area').val() != '' && $('#rak').val() != '') {

            $.ajax({
                    type: "POST",
                    url: "<?= site_url('wrh/aksesoris/saveaksesorisDetail') ?>",
                    dataType: 'json',
                    data: {
                        'id_aksesoris': $('#id_aksesoris').val(),
                        'divisi': $("#divisi").val(),
                        'area': $("#area").val(),
                        'rak': $("#rak").val(),
                        'stock_awal_bulan': $("#stock_awal_bulan").val(),
                        'stock_akhir_bulan': $("#stock_akhir_bulan").val(),
                    },
                })
                .success(function(datasaved) {
                    //code here
                    xi++;
                    var i = datasaved['id'];


                    var x = '<tr id="output_data_' + i + '" class="output_data">\
                  <td width = "10%" align= "center">\
                  <a  class = "btn btn-xs btn-danger" href = "javascript:void(0)" onClick = "hapus(' + i + ')">\
                  <i  class = "fa fa-trash"></i></a>\
                  </td>\
                  <td width = "25%">\
                    ' + $('#divisi').val() + '\
                  </td>\
                  <td width = "10%">\
                    ' + $('#area').val() + '\
                  </td>\
                  <td width = "10%">\
                    ' + $('#rak').val() + '\
                  </td>\
                  <td width = "10%">\
                    ' + $('#stock_awal_bulan').val() + '\
                  </td>\
                  <td width = "10%">\
                    ' + $('#stock_akhir_bulan').val() + '\
                  </td>\
                </tr>';
                    $('tr.odd').remove();
                    $('#dataTbl').append(x);
                    $("#divisi").val(''),
                        $("#area").val(''),
                        $("#rak").val(''),
                        $("#stock_awal_bulan").val(''),
                        $("#stock_akhir_bulan").val(''),
                        $.growl.notice({
                            title: 'Sukses',
                            message: "Berhasil menyimpan Permintaan"
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
                    url: "<?= site_url('wrh/aksesoris/deleteItem') ?>",
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