<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List Item Stock Out Aluminium</h3>
                <div class="box-tools pull-right">
                    <?php //echo button('load_silent("wrh/aluminium/bon_manual","#content")', 'Kembali', 'btn btn-success');
                    ?>
                </div>
            </div>
            <div class="box-body">
                <form method="post" class="form-vertical form_faktur" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>No Surat Jalan</label>
                                <input type="hidden" class="form-control" id="id_sj" value="<?= $id_sj ?>" readonly>
                                <input type="text" class="form-control" value="<?= $no_surat_jalan ?>" id="no_surat_jalan" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Penerima</label>
                                <input type="text" class="form-control" id="penerima" value="<?= $penerima ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tgl Aktual</label>
                                <input type="text" data-date-format="yyyy-mm-dd" value="<?= $tgl_aktual ?>" class="form-control datepicker" id="tgl_aktual" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Alamat Pengiriman</label>
                                <input type="text" class="form-control" id="alamat_pengiriman" value="<?= $alamat_pengiriman ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sopir</label>
                                <input type="text" class="form-control" id="sopir" value="<?= $sopir ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>No Kendaraan</label>
                                <input type="text" class="form-control" id="no_kendaraan" value="<?= $no_kendaraan ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" value="<?= $keterangan_sj ?>">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-footer">
                <button type="submit" id="update" onclick="update()" class="btn btn-success">Update</button>
            </div>
            <?php
            if (from_session('level') == 1 || from_session('level') == 3) { ?>
                <div class="box-body" style="overflow-x:auto;">
                    <table width="100%" id="ableku" class="table table-bordered table-striped table-responsive" style="font-size: smaller;">
                        <thead>
                            <tr>
                                <th width="20%">FPPP</th>
                                <th width="30%">Item</th>
                                <th width="15%">Brand</th>
                                <th width="15%">Gudang</th>
                                <th width="15%">Keranjang</th>
                                <th width="7%">Qty</th>
                                <th width="10%">Warna Akhir</th>
                                <th width="7%">Produksi</th>
                                <th width="7%">Lapangan</th>
                                <th width="5%">Act</th>
                            </tr>
                        </thead>
                        <tbody id="dataTbl">
                            <?php
                            foreach ($list_sj->result() as $row) {
                                $cekproduksi = ($row->produksi == 1) ? 'checked' : '';
                                $ceklapangan = ($row->lapangan == 1) ? 'checked' : '';
                            ?>

                                <tr id="output_data_<?= $row->id_stock ?>" class="output_data">
                                    <td align="center"><?= $row->no_fppp ?>-<?= $row->nama_proyek ?></td>
                                    <td align="center"><?= $row->brand ?></td>
                                    <td><?= $row->section_ata ?>-<?= $row->section_allure ?>-<?= $row->temper ?>-<?= $row->warna ?>-<?= $row->ukuran ?></td>
                                    <td align="center"><?= $row->gudang ?></td>
                                    <td align="center"><?= $row->keranjang ?></td>
                                    <td align="center"><?= $row->qty_out ?></td>
                                    <td align="center"><?= $row->warna_akhir ?></td>
                                    <td align="center"><input type="checkbox" onclick="return false;" class="checkbox" <?= $cekproduksi ?>></td>
                                    <td align="center"><input type="checkbox" onclick="return false;" class="checkbox" <?= $ceklapangan ?>></td>
                                    <td align="center"><a class="btn btn-xs btn-danger" href="javascript:void(0)" onClick="hapus(<?= $row->id_stock ?>)"><i class="fa fa-trash"></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <hr>
                        <tbody>
                            <tr>
                                <td><select style="width: 130px;" id="id_fppp" name="id_fppp" class="form-control" style="width:100%" required>
                                        <option value="">-- Select --</option>
                                        <?php foreach ($fppp->result() as $valap) : ?>
                                            <option value="<?= $valap->id ?>"><?= $valap->no_fppp ?> - <?= $valap->nama_proyek ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><select style="width: 100px;" id="id_multi_brand" name="id_multi_brand" class="form-control" style="width:100%" required>
                                        <option value="">-- Select --</option>
                                    </select></td>
                                <td><select style="width: 200px;" id="item" name="item" class="form-control" style="width:100%" required>
                                        <option value="">-- Select --</option>
                                        <?php foreach ($item->result() as $valap) : ?>
                                            <option value="<?= $valap->id ?>">
                                                <?= $valap->section_ata ?>-<?= $valap->section_allure ?>-<?= $valap->temper ?>-<?= $valap->kode_warna ?>-<?= $valap->ukuran ?>-<?= $valap->warna ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select></td>
                                <td><select style="width: 120px;" id="id_gudang" name="id_gudang" class="form-control" style="width:100%" required>
                                        <option value="">-- Select --</option>
                                    </select>
                                </td>
                                <td><select style="width: 120px;" id="keranjang" name="keranjang" class="form-control" style="width:100%" required>
                                        <option value="">-- Select --</option>
                                    </select>
                                    <br>Qty Gudang :<span id="txt_qty_gudang">0</span>
                                </td>
                                <td><input style="width: 50px;" type="text" style="text-align: right;" class="form-control" id="qty" placeholder="Qty" autocomplete="off"></td>
                                <td><select style="width: 120px;" id="warna_akhir" name="warna_akhir" class="form-control" style="width:100%" required>
                                        <option value="">-- Select --</option>
                                        <?php foreach ($warna_akhir->result() as $valap) : ?>
                                            <option value="<?= $valap->id ?>">
                                                <?= $valap->kode ?>-<?= $valap->warna ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select></td>
                                <td align="center"><input type="checkbox" id="produksi" data-field='produksi' class="checkbox"></td>
                                <td align="center"><input type="checkbox" id="lapangan" data-field='lapangan' class="checkbox"></td>

                                <td><a onclick="quotation()" class="btn btn-xs btn-info">Add</a></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group">
                        <input type="hidden" style="text-align: right;" class="form-control" id="stock" placeholder="Stock" readonly>
                    </div>
                </div>
            <?php } else {
            ?>
                <div class="box-body">
                    <table width="100%" id="tableku" class="table table-bordered table-striped" style="font-size: smaller;">
                        <thead>
                            <tr>
                                <th width="15%">FPPP</th>
                                <th width="15%">Brand</th>
                                <th width="15%">Item</th>
                                <th width="15%">Gudang</th>
                                <th width="15%">Keranjang</th>
                                <th width="7%">Qty</th>
                                <th width="10%">Warna Akhir</th>
                                <th width="7%">Produksi</th>
                                <th width="7%">Lapangan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="dataTbl">
                            <?php
                            foreach ($list_sj->result() as $row) {
                                $cekproduksi = ($row->produksi == 1) ? 'checked' : '';
                                $ceklapangan = ($row->lapangan == 1) ? 'checked' : '';
                            ?>

                                <tr id="output_data_<?= $row->id_stock ?>" class="output_data">
                                    <td align="center"><?= $row->no_fppp ?>-<?= $row->nama_proyek ?></td>
                                    <td align="center"><?= $row->brand ?></td>
                                    <td><?= $row->section_ata ?>-<?= $row->section_allure ?>-<?= $row->temper ?>-<?= $row->warna ?>-<?= $row->ukuran ?></td>
                                    <td align="center"><?= $row->gudang ?></td>
                                    <td align="center"><?= $row->keranjang ?></td>
                                    <td align="center"><?= $row->qty_out ?></td>
                                    <td align="center"><?= $row->warna_akhir ?></td>
                                    <td align="center"><input type="checkbox" onclick="return false;" class="checkbox" <?= $cekproduksi ?>></td>
                                    <td align="center"><input type="checkbox" onclick="return false;" class="checkbox" <?= $ceklapangan ?>></td>
                                    <td align="center"></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#tableku').DataTable({
            ordering: false,
            paging: false,
            scrollX: true,
        });
        $("select").select2();
    });

    function update() {
        $.ajax({
            url: "<?= site_url('wrh/aluminium/ /') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "id_sj": $("#id_sj").val(),
                "penerima": $("#penerima").val(),
                "tgl_aktual": $("#tgl_aktual").val(),
                "alamat_pengiriman": $("#alamat_pengiriman").val(),
                "sopir": $("#sopir").val(),
                "no_kendaraan": $("#no_kendaraan").val(),
                "keterangan": $("#keterangan").val(),
            },
            success: function(img) {
                $.growl.notice({
                    title: 'Berhasil',
                    message: "Mengupdate Surat Jalan!"
                });
                // load_silent("wrh/aluminium/bon_manual/", "#content");
            }
        });

    }

    $("select[name=id_fppp]").change(function() {
        $('#id_multi_brand').val('').trigger('change');
        var x = $("select[name=id_multi_brand]");
        if ($(this).val() == "") {
            x.html("<option>-- Select --</option>");
        } else {
            z = "<option>-- Select --</option>";
            $.ajax({
                url: "<?= site_url('wrh/aksesoris/optionGetMultibrandFppp') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "id_fppp": $(this).val()
                },
                success: function(data) {

                    var z = "<option value=''>-- Select --</option>";
                    for (var i = 0; i < data.length; i++) {
                        z += '<option value=' + data[i].id + '>' + data[i].brand + '</option>';
                    }
                    x.html(z);
                }
            });

        }
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
    $("select[name=item]").change(function() {
        var x = $("select[name=id_gudang]");
        if ($(this).val() == "") {
            x.html("<option>-- Select --</option>");
        } else {
            z = "<option>-- Select --</option>";
            $.ajax({
                url: "<?= site_url('wrh/aluminium/optionGetGudangItem') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "item": $(this).val(),
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
        $('#keranjang').val('').trigger('change');
        // $('#warna_akhir').val('').trigger('change');
        $('#stock').val(0);
        $('#qty').val('');
        $('#txt_qty_gudang').html("<b> " + 0 + "</b>");
        $('#produksi').prop('checked', false);
        $('#lapangan').prop('checked', false);
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
        // $('#warna_akhir').val('').trigger('change');
        $('#stock').val(0);
        $('#qty').val('');
        $('#txt_qty_gudang').html("<b> " + 0 + "</b>");
        $('#produksi').prop('checked', false);
        $('#lapangan').prop('checked', false);
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
                $('#stock').val(data['qty']);
                $('#txt_qty_gudang').html("<b> " + data['qty'] + "</b>");
            }
        });
    });


    function quotation() {
        if (parseInt($('#qty').val()) > parseInt($('#stock').val())) {
            alert("melebihi Qty Gudang!");
        } else {
            quotation2();
        }
    };

    function quotation2() {

        if ($('#id_fppp').val() != '' && $('#item').val() != '' && $('#id_gudang').val() != '' && $('#qty').val() != '') {

            $.ajax({
                    type: "POST",
                    url: "<?= site_url('wrh/aluminium/savebonmanual') ?>",
                    dataType: 'json',
                    data: {
                        'id_sj': $('#id_sj').val(),
                        'id_fppp': $('#id_fppp').val(),
                        'item': $('#item').val(),
                        'id_multi_brand': $('#id_multi_brand').val(),
                        'id_gudang': $("#id_gudang").val(),
                        'keranjang': $("#keranjang").val(),
                        'qty': $("#qty").val(),
                        'produksi': $("#produksi").val(),
                        'lapangan': $("#lapangan").val(),
                        'warna_akhir': $("#warna_akhir").val(),
                        'tgl_aktual': $("#tgl_aktual").val(),
                    },
                })
                .success(function(datasaved) {
                    //code here
                    if (datasaved['sts'] == 'gagal') {
                        $.growl.warning({
                            title: 'gagal',
                            message: "gagal menyimpan, qty gudang tidak cukup!"
                        });
                    } else {
                        x++;
                        var i = datasaved['id'];


                        var x = '<tr id="output_data_' + i + '" class="output_data">\
                  <td width = "15%">\
                    ' + $('#id_fppp :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#id_multi_brand :selected').text() + '\
                  </td>\
                  <td width = "30%">\
                    ' + $('#item :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#id_gudang :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#keranjang :selected').text() + '\
                  </td>\
                  <td align="center" width = "7%">\
                    ' + $('#qty').val() + '\
                  </td>\
                  <td width = "10%">\
                    ' + $('#warna_akhir :selected').text() + '\
                  </td>\
                  <td align="center" width = "7%">\
                    ' + $('#produksi').val() + '\
                  </td>\
                  <td align="center" width = "7%">\
                    ' + $('#lapangan').val() + '\
                  </td>\
                  <td width = "15%" align= "center">\
                  <a  class = "btn btn-xs btn-danger" href = "javascript:void(0)" onClick = "hapus(' + i + ')">\
                  <i  class = "fa fa-trash"></i></a>\
                  </td>\
                </tr>';
                        // $('tr.odd').remove();
                        $('#dataTbl').append(x);

                        $.growl.notice({
                            title: 'Sukses',
                            message: "Berhasil menyimpan"
                        });
                    }

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
                    url: "<?= site_url('wrh/aluminium/deleteItemBonManual') ?>",
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