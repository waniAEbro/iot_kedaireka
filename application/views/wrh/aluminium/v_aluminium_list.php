<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
    td.details-control {
        background: url("<?= base_url('assets/img/details_open.png') ?>") no-repeat center center;
        cursor: pointer;
    }

    tr.shown {
        background: #edffb3;
    }

    tr.shown td.details-control {
        background: url("<?= base_url('assets/img/details_close.png') ?>") no-repeat center center;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Monitoring aluminium <?= $warna ?></h3>

                <div class="box-tools pull-right">

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
                    <table width="100%" id="tableku" class="table">
                        <thead>
                            <th width="5%"></th>
                            <th width="5%">No</th>
                            <th>Divisi</th>
                            <th>Item Code</th>
                            <th>Deskripsi</th>
                            <th>Satuan</th>
                            <th>Stock Awal Bulan</th>
                            <th>Total In Per Bulan</th>
                            <th>Total Out Per Bulan</th>
                            <th>Stock Akhir Bulan</th>
                            <th>Free Stock</th>
                            <th>OTS Persiapan</th>
                            <th>Fitur</th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($aluminium_list as $row) {
                                $ada                     = 1;
                                $stock_awal_bulan        = @$s_awal_bulan[$row->id];
                                $tampil_stock_awal_bulan = ($stock_awal_bulan != '') ? $stock_awal_bulan : 0;

                                $tot_in_per_bulan          = @$total_in_per_bulan[$row->id];
                                $tampil_total_in_per_bulan = ($tot_in_per_bulan != '') ? $tot_in_per_bulan : 0;

                                $tot_out_per_bulan          = @$total_out_per_bulan[$row->id];
                                $tampil_total_out_per_bulan = ($tot_out_per_bulan != '') ? $tot_out_per_bulan : 0;

                                $stock_akhir_bulan = ($tampil_stock_awal_bulan + $tampil_total_in_per_bulan) - $tampil_total_out_per_bulan;
                                $ots_persiapan = 0;
                                $free_stock    = $stock_akhir_bulan - $ots_persiapan;
                            ?>
                                <tr>
                                    <td class="details-control" id="<?= $i ?>"><input type="hidden" id="id_<?= $i ?>" value="<?= $row->id ?>"></td>
                                    <td align="center"><?= $i ?></td>
                                    <td align="center"><?= $row->divisi ?></td>
                                    <td align="center"><?= $row->item_code ?></td>
                                    <td align="center"><?= $row->deskripsi ?></td>
                                    <td align="center"><?= $row->satuan ?></td>
                                    <td align="center"><?= $tampil_stock_awal_bulan ?></td>
                                    <td align="center"><?= $tampil_total_in_per_bulan ?></td>
                                    <td align="center"><?= $tampil_total_out_per_bulan ?></td>
                                    <td align="center"><?= $stock_akhir_bulan ?></td>
                                    <td align="center"><?= $free_stock ?></td>
                                    <td align="center"></td>
                                    <td align="center">
                                        <?= button('load_silent("wrh/aluminium/mutasi_stock_add/' . $row->id . '","#content")', 'mutasi', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Mutasi"'); ?>
                                        <?= button('load_silent("wrh/aluminium/mutasi_stock_history/' . $row->id . '","#content")', 'history mutasi', 'btn btn-xs btn-default', 'data-toggle="tooltip" title="History Mutasi"'); ?></td>
                                </tr>

                            <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
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

    function printDiv(divName) {
        // var printContents = document.getElementById(divName).innerHTML;
        // var originalContents = document.body.innerHTML;

        // document.body.innerHTML = printContents;
        // window.print();

        // document.body.innerHTML = originalContents;

        var mywindow = window.open('', 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head><title>' + document.title + '</title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<h1>' + document.title + '</h1>');
        mywindow.document.write(document.getElementById(divName).innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;
    }


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
        if (tahun != '') {
            var id_tahun = tahun;
        } else {
            var id_tahun = 'x';
        };
        var status = $('#status').val();
        var jne = $('#jne').val();
        load_silent("wrh/aluminium/filter/" + id_store + "/" + id_bulan + "/" + id_tahun + "/" + status + "/" + jne + "/", "#content");

    }

    function cetakExcel() {
        var left = (screen.width / 2) - (640 / 2);
        var top = (screen.height / 2) - (480 / 2);
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
        if (tahun != '') {
            var id_tahun = tahun;
        } else {
            var id_tahun = 'x';
        };
        var status = $('#status').val();
        var url = "<?= site_url('wrh/aluminium/excel/"+id_store+"/"+id_bulan+"/"+id_tahun+"/"+status+"') ?>";
        window.open(url, "", "width=640, height=480, scrollbars=yes, left=" + left + ", top=" + top);
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
                '<th bgcolor="#bfbfbf">Gudang</th>' +
                '<th bgcolor="#bfbfbf">Keranjang/Rak</th>' +
                '<th bgcolor="#bfbfbf">Stock Awal Bulan</th>' +
                '<th bgcolor="#bfbfbf">Total In Per Bulan</th>' +
                '<th bgcolor="#bfbfbf">Total Out Per Bulan</th>' +
                '<th bgcolor="#bfbfbf">Stock Akhir Bulan</th>' +
                '<th bgcolor="#bfbfbf">Rata2 Pemakaian</th>' +
                '<th bgcolor="#bfbfbf">Min Stock</th>' +
                '</tr>';
            $.ajax({
                    url: "<?= site_url('wrh/aluminium/getDetailTabel') ?>",
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        id: $('#id_' + id).val(),
                    },
                })
                .done(function(data) {
                    for (var i = 0; i < data.detail.length; i++) {
                        var no = i + 1;
                        var color = "white";
                        var fontcolor = "black";
                        if (data.detail[i].tot_out == null) {
                            var qty_out = 0;
                        } else {
                            var qty_out = data.detail[i].tot_out;
                        }

                        if (data.detail[i].tot_in == null) {
                            var stok_t_i = 0;
                        } else {
                            var stok_t_i = data.detail[i].tot_in;
                        }

                        if (data.detail[i].stok_awal_bulan == null) {
                            var stok_a_b = 0;
                        } else {
                            var stok_a_b = data.detail[i].stok_awal_bulan;
                        }

                        infoTable += '<tr bgcolor="' + color + '">' +
                            '<td><font color="' + fontcolor + '">' + no + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].gudang + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].keranjang + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + stok_a_b + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + stok_t_i + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + qty_out + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].stok_akhir_bulan + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].rata_pemakaian + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].min_stock + '</font></td>' +
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
</script>