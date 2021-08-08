<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List BOM aluminium</h3>
                <div class="box-tools pull-right">
                    <?php //echo button('load_silent("klg/fppp","#content")', 'Kembali', 'btn btn-success'); 
                    ?>
                </div>
            </div>
            <div class="box-body">
                <form method="post" class="form-vertical form_faktur" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>No Surat Jalan</label>
                                <input type="text" class="form-control" value="<?= $no_surat_jalan ?>" id="no_surat_jalan" readonly>
                                <input type="hidden" class="form-control" value="<?= $id_sj ?>" id="id_sj" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Penerima</label>
                                <input type="text" class="form-control" value="<?= $penerima ?>" id="penerima">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Alamat Pengiriman</label>
                                <input type="text" class="form-control" value="<?= $alamat_pengiriman ?>" id="alamat_pengiriman">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sopir</label>
                                <input type="text" class="form-control" value="<?= $sopir ?>" id="sopir">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>No Kendaraan</label>
                                <input type="text" class="form-control" value="<?= $no_kendaraan ?>" id="no_kendaraan">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-footer">
                <button type="submit" id="update" onclick="update()" id="proses" class="btn btn-success">Update</button>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-bordered table-striped" style="font-size: smaller;">
                    <thead>
                        <tr>
                            <th width="15%">FPPP</th>
                            <th width="30%">Item</th>
                            <th width="15%">Divisi</th>
                            <th width="15%">Gudang</th>
                            <th width="15%">Keranjang</th>
                            <th width="7%">Qty</th>
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
                                <td><?= $row->section_ata ?>-<?= $row->section_allure ?>-<?= $row->temper ?>-<?= $row->warna_aluminium ?>-<?= $row->ukuran ?></td>
                                <td align="center"><?= $row->divisi_stock ?></td>
                                <td align="center"><?= $row->gudang ?></td>
                                <td align="center"><?= $row->keranjang ?></td>
                                <td align="center"><?= $row->qty_out ?></td>
                                <td align="center"><input type="checkbox" onclick="return false;" class="checkbox" <?= $cekproduksi ?>></td>
                                <td align="center"><input type="checkbox" onclick="return false;" class="checkbox" <?= $ceklapangan ?>></td>
                                <td align="center"><a class="btn btn-xs btn-danger" href="javascript:void(0)" onClick="hapus(<?= $row->id_stock ?>)"><i class="fa fa-trash"></i></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <hr>
                    <tbody>
                        <tr>
                            <td><select id="id_fppp" name="id_fppp" class="form-control" style="width:100%" required>
                                    <option value="">-- Select --</option>
                                    <?php foreach ($fppp->result() as $valap) : ?>
                                        <option value="<?= $valap->id ?>"><?= $valap->no_fppp ?> - <?= $valap->nama_proyek ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><select id="item" name="item" class="form-control" style="width:100%" required>
                                    <option value="">-- Select --</option>
                                    <?php foreach ($item->result() as $valap) : ?>
                                        <option value="<?= $valap->id ?>">
                                            <?= $valap->section_ata ?> -
                                            <?= $valap->section_allure ?> -
                                            <?= $valap->temper ?> -
                                            <?= $valap->warna_aluminium ?> -
                                            <?= $valap->ukuran ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select></td>
                            <td><select id="id_divisi" name="id_divisi" class="form-control" style="width:100%" required>
                                    <option value="">-- Select --</option>
                                    <?php foreach ($divisi->result() as $valap) : ?>
                                        <option value="<?= $valap->id ?>"><?= $valap->divisi ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select></td>
                            <td><select id="id_gudang" name="id_gudang" class="form-control" style="width:100%" required>
                                    <option value="">-- Select --</option>
                                    <?php foreach ($gudang->result() as $valap) : ?>
                                        <option value="<?= $valap->id ?>"><?= $valap->gudang ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><select id="keranjang" name="keranjang" class="form-control" style="width:100%" required>
                                    <option value="">-- Select --</option>
                                    <?php foreach ($keranjang->result() as $valap) : ?>
                                        <option value="<?= $valap->keranjang ?>"><?= $valap->keranjang ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                Qty Gudang :<span id="txt_qty_gudang">0</span>
                            </td>
                            <td><input type="text" style="text-align: right;" class="form-control" id="qty" placeholder="Qty" autocomplete="off"></td>
                            <td align="center"><input type="checkbox" id="produksi" data-field='produksi' class="checkbox"></td>
                            <td align="center"><input type="checkbox" id="lapangan" data-field='lapangan' class="checkbox"></td>
                            <td><a onclick="quotation()" class="btn btn-info">Add Stock</a></td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <input type="hidden" style="text-align: right;" class="form-control" id="stock" placeholder="Stock" readonly>
                </div>
            </div>
            <?php echo button_confirm("Anda yakin menyelesaikan stock out?", "wrh/aluminium/finishdetailbon/" . $id_sj, "#content", 'Finish', 'btn btn-success', 'data-toggle="tooltip" title="Finish"'); ?>
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

    function update() {
        $("#update").hide();
        $.ajax({
            url: "<?= site_url('wrh/aluminium/updateSuratJalan/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "id_sj": $("#id_sj").val(),
                "penerima": $("#penerima").val(),
                "alamat_pengiriman": $("#alamat_pengiriman").val(),
                "sopir": $("#sopir").val(),
                "no_kendaraan": $("#no_kendaraan").val(),
            },
            success: function(img) {
                $.growl.notice({
                    title: 'Berhasil',
                    message: "Mengupdate Surat Jalan!"
                });
                // load_silent("wrh/aluminium/detailbom/" + img['id'] + "/", "#content");
            }
        });

    }

    $("#item").change(function() {
        $('#id_divisi').val('').trigger('change');
        $('#id_gudang').val('').trigger('change');
        $('#keranjang').val('').trigger('change');
    });

    $("#id_divisi").change(function() {
        $.ajax({
            url: "<?= site_url('wrh/aluminium/getQtyRowGudangBon') ?>",
            dataType: "json",
            type: "POST",
            data: {
                item: $('#item').val(),
                divisi: $('#id_divisi').val(),
                gudang: $('#id_gudang').val(),
                keranjang: $('#keranjang').val(),
            },
            success: function(data) {
                if (data['qty_gudang'] == null) {
                    var qtygdg = 0;
                } else {
                    var qtygdg = data['qty_gudang'];
                }
                $('#stock').val(qtygdg);
                $('#txt_qty_gudang').html("<b> " + qtygdg + "</b>");
            }
        });
    });

    $("#id_gudang").change(function() {
        $.ajax({
            url: "<?= site_url('wrh/aluminium/getQtyRowGudangBon') ?>",
            dataType: "json",
            type: "POST",
            data: {
                item: $('#item').val(),
                divisi: $('#id_divisi').val(),
                gudang: $('#id_gudang').val(),
                keranjang: $('#keranjang').val(),
            },
            success: function(data) {
                if (data['qty_gudang'] == null) {
                    var qtygdg = 0;
                } else {
                    var qtygdg = data['qty_gudang'];
                }
                $('#stock').val(qtygdg);
                $('#txt_qty_gudang').html("<b> " + qtygdg + "</b>");
            }
        });
    });

    $("#keranjang").change(function() {
        $.ajax({
            url: "<?= site_url('wrh/aluminium/getQtyRowGudangBon') ?>",
            dataType: "json",
            type: "POST",
            data: {
                item: $('#item').val(),
                divisi: $('#id_divisi').val(),
                gudang: $('#id_gudang').val(),
                keranjang: $('#keranjang').val(),
            },
            success: function(data) {
                if (data['qty_gudang'] == null) {
                    var qtygdg = 0;
                } else {
                    var qtygdg = data['qty_gudang'];
                }
                $('#stock').val(qtygdg);
                $('#txt_qty_gudang').html("<b> " + qtygdg + "</b>");
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

        if ($('#item').val() != '' && $('#id_divisi').val() != '' && $('#id_gudang').val() != '' && $('#qty').val() != '') {

            $.ajax({
                    type: "POST",
                    url: "<?= site_url('wrh/aluminium/savebonmanual') ?>",
                    dataType: 'json',
                    data: {
                        'id_sj': $('#id_sj').val(),
                        'id_fppp': $('#id_fppp').val(),
                        'item': $('#item').val(),
                        'id_divisi': $("#id_divisi").val(),
                        'id_gudang': $("#id_gudang").val(),
                        'keranjang': $("#keranjang").val(),
                        'qty': $("#qty").val(),
                        'produksi': $("#produksi").val(),
                        'lapangan': $("#lapangan").val(),
                    },
                })
                .success(function(datasaved) {
                    //code here
                    x++;
                    var i = datasaved['id'];


                    var x = '<tr id="output_data_' + i + '" class="output_data">\
                  <td width = "15%">\
                    ' + $('#id_fppp :selected').text() + '\
                  </td>\
                  <td width = "30%">\
                    ' + $('#item :selected').text() + '\
                  </td>\
                  <td width = "15%">\
                    ' + $('#id_divisi :selected').text() + '\
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
                    $('#item').val('').trigger('change');
                    $('#id_divisi').val('').trigger('change');
                    $('#id_gudang').val('').trigger('change');
                    $('#keranjang').val('').trigger('change');
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
                    hitungJml(xi);
                });
        }
    }
</script>