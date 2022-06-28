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
<script type='text/javascript'>
    $(function() {
        convert_paging('#content');
        $('#keyword').focus().setCursorPosition($('#keyword').val().length);
        nicetable();
        $('#keyword').keyup(function() {
            if ($(this).val().length > 3) {
                search_list();
            } else {
                if ($(this).val().length == 0) {
                    load_silent('wrh_h/aluminium/list/', '#content');
                }
            }
        });
    });

    function search_list() {
        send_form(document.fsearchuser, 'wrh_h/aluminium/search_list/', '#content');
    }
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Monitoring Aluminium <?= $warna ?></h3>

                <div class="box-tools pull-right">
                    <?php
                    echo form_open('', array('name' => 'fsearchuser'));
                    $key = "";
                    if (isset($search)) $key = from_session('keyword');
                    ?>
                    <div class="input-group">
                        <?php echo "<input type='text' name='keyword' id='keyword' value='$key' class='form-control' placeholder='Cari Disini...'>" ?>
                    </div>
                    <?php
                    echo form_close();
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
                    <table width="100%" id="ableku" class="table">
                        <thead>
                            <th width="5%"></th>
                            <th width="5%">No</th>
                            <th>Divisi</th>
                            <th>Section ATA</th>
                            <th>Section Allure</th>
                            <th>Temper</th>
                            <th>Kode Warna</th>
                            <th>Warna</th>
                            <th>Ukuran</th>
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
                            foreach ($aluminium->result() as $row) :
                                $ada                     = 1;
                                $stock_awal_bulan        = @$stock_awal_bulan[$row->id];
                                $tampil_stock_awal_bulan = ($stock_awal_bulan != '') ? $stock_awal_bulan : 0;

                                $tot_in_per_bulan          = @$total_in_per_bulan[$row->id];
                                $tampil_total_in_per_bulan = ($tot_in_per_bulan != '') ? $tot_in_per_bulan : 0;

                                $tot_out_per_bulan          = @$total_out_per_bulan[$row->id];
                                $tampil_total_out_per_bulan = ($tot_out_per_bulan != '') ? $tot_out_per_bulan : 0;

                                $tot_out          = @$total_out[$row->id];
                                $tampil_total_out = ($tot_out != '') ? $tot_out : 0;

                                $stock_akhir_bulan = $tampil_total_in_per_bulan - $tampil_total_out_per_bulan;
                                $ots_persiapan = @$total_bom[$row->id] - $tampil_total_out;
                                $free_stock    = $stock_akhir_bulan - $ots_persiapan;
                            ?>
                                <tr>
                                    <td class="details-control" id="<?= $i ?>"><input type="hidden" id="id_<?= $i ?>" value="<?= $row->id ?>"></td>
                                    <td align="center"><?= $i ?></td>
                                    <td align="center"><?= $row->divisi ?></td>
                                    <td align="center"><?= $row->section_ata ?></td>
                                    <td align="center"><?= $row->section_allure ?></td>
                                    <td align="center"><?= $row->temper ?></td>
                                    <td align="center"><?= $row->kode_warna ?></td>
                                    <td align="center"><?= $row->warna ?></td>
                                    <td align="center"><?= $row->ukuran ?></td>
                                    <td align="center"><?= $tampil_stock_awal_bulan ?></td>
                                    <td align="center"><?= $tampil_total_in_per_bulan ?></td>
                                    <td align="center"><?= $tampil_total_out_per_bulan ?></td>
                                    <td align="center"><?= $stock_akhir_bulan ?></td>
                                    <td align="center"><?= $free_stock ?></td>
                                    <td align="center"><?= @$total_bom[$row->id] ?> - <?= $tampil_total_out ?></td>
                                    <td align="center">
                                        <?= button('load_silent("wrh_h/aluminium/mutasi_stock_add/' . $row->id . '","#content")', 'mutasi', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Mutasi"'); ?>
                                        <?= button('load_silent("wrh_h/aluminium/mutasi_stock_history/' . $row->id . '","#content")', 'history mutasi', 'btn btn-xs btn-default', 'data-toggle="tooltip" title="History Mutasi"'); ?></td>
                                </tr>

                            <?php $i++;
                            endforeach; ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class='pull-left'>
                                <div class='dataTables_info'>
                                    <?php if (isset($datainfo)) echo $datainfo; ?>
                                </div>
                            </div>
                            <div class='pull-right'>
                                <?php echo $paging; ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
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


    // function cetak (id) {
    //   var win = window.open("<?php echo base_url('wrh_h/aluminium/cetak/'); ?>/"+id, "_blank");
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
        if (tahun != '') {
            var id_tahun = tahun;
        } else {
            var id_tahun = 'x';
        };
        var status = $('#status').val();
        var jne = $('#jne').val();
        load_silent("wrh_h/aluminium/filter/" + id_store + "/" + id_bulan + "/" + id_tahun + "/" + status + "/" + jne + "/", "#content");

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
        var url = "<?= site_url('wrh_h/aluminium/excel/"+id_store+"/"+id_bulan+"/"+id_tahun+"/"+status+"') ?>";
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
                '<th bgcolor="#bfbfbf">Divisi</th>' +
                '<th bgcolor="#bfbfbf">Gudang</th>' +
                '<th bgcolor="#bfbfbf">Keranjang</th>' +
                '<th bgcolor="#bfbfbf">Stock Awal Bulan</th>' +
                '<th bgcolor="#bfbfbf">Total In Per Bulan</th>' +
                '<th bgcolor="#bfbfbf">Total Out Per Bulan</th>' +
                '<th bgcolor="#bfbfbf">Stock Akhir Bulan</th>' +
                '<th bgcolor="#bfbfbf">Rata2 Pemakaian</th>' +
                '<th bgcolor="#bfbfbf">Min Stock</th>' +
                '</tr>';
            $.ajax({
                    url: "<?= site_url('wrh_h/aluminium/getDetailTabel') ?>",
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

                        infoTable += '<tr bgcolor="' + color + '">' +
                            '<td><font color="' + fontcolor + '">' + no + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].divisi + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].gudang + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].keranjang + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].stok_awal_bulan + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].tot_in + '</font></td>' +
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