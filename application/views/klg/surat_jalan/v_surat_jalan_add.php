<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add Item Surat Jalan</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body" style="overflow-x:auto;">
                <table width="100%" id="ableku" class="table table-bordered table-striped table-responsive" style="font-size: smaller;">
                    <thead>
                        <tr>
                            <th width="35%">FPPP</th>
                            <th width="50%">FPPP Detail</th>
                            <th width="10%">Qty</th>
                            <th width="5%">Act</th>
                        </tr>
                    </thead>
                    <tbody id="dataTbl">
                        <?php
                        foreach ($list_sj->result() as $row) {
                            $detail_fppp = $this->m_surat_jalan->getRowDetailFppp($row->id_fppp_detail);
                        ?>

                            <tr id="output_data_<?= $row->id ?>" class="output_data">
                                <td align="center"><?= $row->no_fppp ?></td>
                                <td align="center"><?= $detail_fppp ?></td>
                                <td align="center"><?= $row->qty ?></td>
                                <td align="center"><a class="btn btn-xs btn-danger" href="javascript:void(0)" onClick="hapus(<?= $row->id ?>)"><i class="fa fa-trash"></i></a></td>
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
                            <td><select id="id_fppp_detail" name="id_fppp_detail" class="form-control" style="width:100%" required>
                                    <option value="">-- Select --</option>
                                </select>
                            </td>

                            <td><input style="width: 50px;" type="text" style="text-align: right;" class="form-control" id="qty" placeholder="Qty" autocomplete="off"></td>
                            <td><a onclick="quotation()" class="btn btn-xs btn-info">Add</a></td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <input type="hidden" style="text-align: right;" class="form-control" id="stock" placeholder="Stock" readonly>
                </div>
            </div>
            <?php echo button_confirm("Anda yakin memproses Surat Jalan?", "klg/surat_jalan/buat_surat_jalan/", "#content", 'Finish Buat Surat Jalan', 'btn btn-success', 'data-toggle="tooltip" title="Finish Buat Surat Jalan"'); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#tableku').DataTable({
            ordering: false,
            paging: false,
            scrollX: false,
        });
        $("select").select2();
        $("#stock").val(0);
    });

    function update() {
        $("#update").hide();
        $.ajax({
            url: "<?= site_url('klg/surat_jalan/updateSuratJalan/') ?>",
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
                // load_silent("klg/surat_jalan/detailbom/" + img['id'] + "/", "#content");
            }
        });

    }

    $("select[name=id_fppp]").change(function() {
        $('#id_fppp_detail').val('').trigger('change');
        var x = $("select[name=id_fppp_detail]");
        if ($(this).val() == "") {
            x.html("<option>-- Select --</option>");
        } else {
            z = "<option>-- Select --</option>";
            $.ajax({
                url: "<?= site_url('klg/surat_jalan/optionDetailFppp') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    "id_fppp": $(this).val()
                },
                success: function(data) {

                    var z = "<option value=''>-- Select --</option>";
                    for (var i = 0; i < data.length; i++) {
                        z += '<option value=' + data[i].id + '>' + data[i].brand + '-' + data[i].kode_opening + '-' + data[i].kode_unit + '-' + data[i].barang + '-' + data[i].glass_thick + '</option>';
                    }
                    x.html(z);
                }
            });

        }
    });

    function quotation() {
        // if (parseInt($('#qty').val()) > parseInt($('#stock').val())) {
        //     alert("melebihi Qty Gudang!");
        // } else {
        quotation2();
        // }
    };

    function quotation2() {

        if ($('#id_fppp').val() != '' && $('#id_fppp_detail').val() != '' && $('#qty').val() != '') {

            $.ajax({
                    type: "POST",
                    url: "<?= site_url('klg/surat_jalan/insert') ?>",
                    dataType: 'json',
                    data: {
                        'id_sj': 0,
                        'id_fppp': $('#id_fppp').val(),
                        'id_fppp_detail': $('#id_fppp_detail').val(),
                        'qty': $("#qty").val(),
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
                  <td width = "35%">\
                    ' + $('#id_fppp :selected').text() + '\
                  </td>\
                  <td width = "50%">\
                    ' + $('#id_fppp_detail :selected').text() + '\
                  </td>\
                  <td align="center" width = "10%">\
                    ' + $('#qty').val() + '\
                  </td>\
                  <td width = "5%" align= "center">\
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
                    url: "<?= site_url('klg/surat_jalan/delete') ?>",
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