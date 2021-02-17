<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
    td.details-control {
        background: url("<?= base_url('assets/img/details_open.png') ?>") no-repeat center center;
        cursor: pointer;
    }

    tr.shown {
        background: #FCFF43;
    }

    tr.shown td.details-control {
        background: url("<?= base_url('assets/img/details_close.png') ?>") no-repeat center center;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="box-header with-border">
            <h3 class="box-title">List FPPP</h3>

            <div class="box-tools pull-right">
                <?php
                $sesi = from_session('level');
                if ($sesi == '1' || $sesi == '2') {
                    echo button('load_silent("klg/fppp/formAdd/' . $param . '","#content")', 'Tambah FPPP', 'btn btn-success');
                }
                ?>
            </div>
        </div>
        <div class="box-body" id="printableArea">
            <style type="text/css" media="screen">
                .large-table-container-3 {
                    /*max-width: 800px;*/
                    overflow-x: scroll;
                    overflow-y: auto;
                }

                .large-table-container-3 table {}

                .large-table-fake-top-scroll-container-3 {
                    /*max-width: 800px;*/
                    overflow-x: scroll;
                    overflow-y: auto;
                }

                .large-table-fake-top-scroll-container-3 div {
                    background-color: red;
                    font-size: 1px;
                    line-height: 1px;
                }

                /*misc*/
                td {
                    border: 1px solid gray;
                }
            </style>
            <div class="large-table-fake-top-scroll-container-3">
                <div>&nbsp;</div>
            </div>
            <div class="large-table-container-3">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%"></th>
                        <th width="5%">No</th>
                        <th>DIVISI</th>
                        <th>NO. FPPP</th>
                        <th>NAMA PROYEK</th>
                        <th>NAMA SALES MARKETING</th>
                        <th>NAMA SM / PIC PROJECT</th>
                        <th>PENGIRIMAN</th>
                        <th>WARNA ALUMINIUM</th>
                        <th>JUMLAH GAMBAR / OPENING</th>
                        <th>TGL PEMBUATAN</th>
                        <th>DEADLINE PENGIRIMAN</th>

                        <th>ACC/FA</th>
                        <th>WH aluminium</th>
                        <th>WH AKSESORIS</th>
                        <th>WH KACA</th>

                        <th>WS UPDATE</th>

                        <th>SITE UPDATE</th>

                        <th>Act</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($fppp->result() as $row) :
                            $ada = 1;
                        ?>
                            <tr>
                                <?php if ($ada > 0) { ?>
                                    <td class="details-control" id="<?= $i ?>"></td>
                                <?php } else { ?>
                                    <td></td>
                                <?php }  ?>
                                <td align="center"><?= $i ?></td>
                                <td><?= $row->divisi ?><input type="hidden" id="id_fppp_<?= $i ?>" value="<?= $row->id ?>"></td>
                                <td><?= $row->no_fppp ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td><?= $row->sales ?></td>
                                <td><?= $row->pic_project ?></td>
                                <td><?= $row->pengiriman ?></td>
                                <td><?= $row->warna_aluminium ?></td>
                                <td><?= $row->jumlah_gambar ?></td>
                                <td><?= $row->tgl_pembuatan ?></td>
                                <td><?= $row->deadline_pengiriman ?></td>

                                <td><?= $row->tahap ?></td>
                                <td><?= $row->alamat_proyek ?></td>
                                <td><?= $row->status_order ?></td>
                                <td><?= $row->note ?></td>


                                <td><?= $row->metode_pengiriman ?></td>
                                <td><?= $row->metode_pengiriman ?></td>
                                <td align="center">
                                    <?php if ($row->attachment != '') { ?>
                                        <a target="_blank" href="<?= base_url($row->attachment); ?>" class="btn btn-xs btn-danger">Attachment</a>
                                    <?php } ?>

                                    <?php
                                    if (from_session('id') < 3) {
                                        echo button('load_silent("klg/fppp/formEdit/' . $row->id . '","#content")', 'Edit khusus', 'btn btn-xs btn-info', 'data-toggle="tooltip" title="Edit"');
                                    }
                                    ?>
                                </td>
                            </tr>

                        <?php $i++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var tableContainer = $(".large-table-container-3");
        var table = $(".large-table-container-3 table");
        var fakeContainer = $(".large-table-fake-top-scroll-container-3");
        var fakeDiv = $(".large-table-fake-top-scroll-container-3 div");

        var tableWidth = table.width();
        fakeDiv.width(tableWidth);

        fakeContainer.scroll(function() {
            tableContainer.scrollLeft(fakeContainer.scrollLeft());
        });
        tableContainer.scroll(function() {
            fakeContainer.scrollLeft(tableContainer.scrollLeft());
        });
    })


    // function cetak (id) {
    //   var win = window.open("<?php echo base_url('klg/fppp/cetak/'); ?>/"+id, "_blank");
    //             if (win) {
    //                 //Browser has allowed it to be opened
    //                 win.focus();
    //             } else {
    //                 //Browser has blocked it
    //                 alert('Please allow popups for this website');
    //             }
    // }

    function setFilter() {
        var store = $('#store').val();
        if (store != '') {
            var id_store = store;
        } else {
            var id_store = 'x';
        };
        var bulan = $('#bulan').val();
        if (bulan != '') {
            var id_bulan = bulan;
        } else {
            var id_bulan = 'x';
        };
        var tahun = $('#tahun').val();
        load_silent("klg/fppp/filter/" + id_store + "/" + id_bulan + "/" + tahun + "/", "#content");

    }

    $(document).ready(function() {
        $("select").select2();
        var table = $('#tableku').DataTable({
            "ordering": true,
            // "scrollX": true,
        });


        $('#tableku tbody').on('click', 'td.details-control', function(e) {
            var tr = $(this).closest('tr');
            var td = $(this).closest('td');
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                dataRow = format(td[0].id, row, tr);
            }
        });

        function format(id, row, tr) {

            infoTable = '<table id="infoTable" class="table table-striped" border="1px" style="font-size: smaller;">' +
                '<tr>' +
                '<th bgcolor="#bfbfbf">No</th>' +
                '<th bgcolor="#bfbfbf">Brand</th>' +
                '<th bgcolor="#bfbfbf">Finish Coating</th>' +
                '<th bgcolor="#bfbfbf">Kode Opening</th>' +
                '<th bgcolor="#bfbfbf">Kode Unit</th>' +
                '<th bgcolor="#bfbfbf">Item</th>' +
                '<th bgcolor="#bfbfbf">Glass Thick</th>' +
                '<th bgcolor="#bfbfbf">Qty</th>' +
                '<th bgcolor="#bfbfbf">Produksi Aluminium</th>' +
                '<th bgcolor="#bfbfbf">QC Cek</th>' +
                '<th bgcolor="#bfbfbf">Pengiriman</th>' +
                '<th bgcolor="#bfbfbf">Pasang</th>' +
                '<th bgcolor="#bfbfbf">BST</th>' +
                '</tr>';

            var id_fppp = $('#id_fppp_' + id).val();

            $.ajax({
                    url: "<?= site_url('klg/fppp/getDetailTabel') ?>",
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        id_fppp: id_fppp,
                    },
                })
                .done(function(data) {
                    // console.log(data.detail);
                    var total_semua = 0;
                    var total_cbm = 0;
                    for (var i = 0; i < data.detail.length; i++) {
                        var no = i + 1;
                        var color = "white";
                        var fontcolor = "black";
                        if (data.detail[i].produksi_aluminium == null) {
                            var produksi_aluminium = '';
                        } else {
                            var produksi_aluminium = data.detail[i].produksi_aluminium;
                        }

                        if (data.detail[i].qc_cek == null) {
                            var qc_cek = '';
                        } else {
                            var qc_cek = data.detail[i].qc_cek;
                        }

                        if (data.detail[i].pengiriman == null) {
                            var pengiriman = '';
                        } else {
                            var qc_cek = data.detail[i].pengiriman;
                        }

                        infoTable += '<tr bgcolor="' + color + '">' +
                            '<td><font color="' + fontcolor + '">' + no + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].brand + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].finish_coating + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].kode_opening + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].kode_unit + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].item + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].glass_thick + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].qty + '</font></td>' +
                            '<td style="background-color:#9cc2ff" onclick="pa_tdclick(' + data.detail[i].id + ');"><input type="date" style="display:none;" id="pa_input_' + data.detail[i].id + '" value="' + produksi_aluminium + '"><a style="display:none;" id="pa_bt_' + data.detail[i].id + '" onclick="pa_saveclick(' + data.detail[i].id + ');" class="btn btn-xs btn-default">save</a><font id="pa_ft_' + data.detail[i].id + '" color="' + fontcolor + '">' + produksi_aluminium + '</font></td>' +
                            '<td style="background-color:#9cc2ff" onclick="qc_tdclick(' + data.detail[i].id + ');"><input type="date" style="display:none;" id="qc_input_' + data.detail[i].id + '" value="' + qc_cek + '"><a style="display:none;" id="qc_bt_' + data.detail[i].id + '" onclick="qc_saveclick(' + data.detail[i].id + ');" class="btn btn-xs btn-default">save</a><font id="qc_ft_' + data.detail[i].id + '" color="' + fontcolor + '">' + qc_cek + '</font></td>' +
                            '<td style="background-color:#9cc2ff" onclick="p_tdclick(' + data.detail[i].id + ');"><input type="date" style="display:none;" id="p_input_' + data.detail[i].id + '" value="' + pengiriman + '"><a style="display:none;" id="p_bt_' + data.detail[i].id + '" onclick="p_saveclick(' + data.detail[i].id + ');" class="btn btn-xs btn-default">save</a><font id="p_ft_' + data.detail[i].id + '" color="' + fontcolor + '">' + pengiriman + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].pasang + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].bst + '</font></td>' +
                            '</tr>';

                    };

                    infoTable += '</table>';
                    row.child(infoTable).show();
                    tr.addClass('shown');
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    // console.log("complete");
                });

            return infoTable;
        }
    });

    function pa_tdclick(id) {
        $("#pa_input_" + id + "").removeAttr("style");
        $("#pa_bt_" + id + "").removeAttr("style");
        $("#pa_ft_" + id + "").hide();
    }

    function pa_saveclick(id) {
        $.ajax({
                type: "POST",
                url: "<?= site_url('klg/fppp/updateDetail') ?>",
                dataType: 'json',
                data: {
                    'id': id,
                    'kolom': 1,
                    'nilai': $("#pa_input_" + id + "").val(),
                }
            })
            .success(function(datasaved) {
                $.growl.notice({
                    title: 'Sukses',
                    message: datasaved.msg
                });
                $("#pa_input_" + id + "").hide();
                $("#pa_bt_" + id + "").hide();
                $("#pa_ft_" + id + "").show();
                $("#pa_ft_" + id + "").html(datasaved.nilai);
            });
    }

    function qc_tdclick(id) {
        $("#qc_input_" + id + "").removeAttr("style");
        $("#qc_bt_" + id + "").removeAttr("style");
        $("#qc_ft_" + id + "").hide();
    }

    function qc_saveclick(id) {
        $.ajax({
                type: "POST",
                url: "<?= site_url('klg/fppp/updateDetail') ?>",
                dataType: 'json',
                data: {
                    'id': id,
                    'kolom': 2,
                    'nilai': $("#qc_input_" + id + "").val(),
                }
            })
            .success(function(datasaved) {
                $.growl.notice({
                    title: 'Sukses',
                    message: datasaved.msg
                });
                $("#qc_input_" + id + "").hide();
                $("#qc_bt_" + id + "").hide();
                $("#qc_ft_" + id + "").show();
                $("#qc_ft_" + id + "").html(datasaved.nilai);
            });
    }

    function p_tdclick(id) {
        $("#p_input_" + id + "").removeAttr("style");
        $("#p_bt_" + id + "").removeAttr("style");
        $("#p_ft_" + id + "").hide();
    }

    function p_saveclick(id) {
        $.ajax({
                type: "POST",
                url: "<?= site_url('klg/fppp/updateDetail') ?>",
                dataType: 'json',
                data: {
                    'id': id,
                    'kolom': 3,
                    'nilai': $("#p_input_" + id + "").val(),
                }
            })
            .success(function(datasaved) {
                $.growl.notice({
                    title: 'Sukses',
                    message: datasaved.msg
                });
                $("#p_input_" + id + "").hide();
                $("#p_bt_" + id + "").hide();
                $("#p_ft_" + id + "").show();
                $("#p_ft_" + id + "").html(datasaved.nilai);
            });
    }
</script>