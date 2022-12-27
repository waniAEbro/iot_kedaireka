<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php ini_set('memory_limit', '1024M'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3>
                    <?= $judul ?>
                </h3>
                <div class="box-tools pull-right">
                    <?php $sesi = from_session('level'); ?>
                    <?= button('load_silent("wrh/aluminium/index_lama","#content")', 'Monitoring Lama', 'btn btn-danger', 'data-toggle="tooltip" title="Monitoring"'); ?>
                    <a class="btn btn-primary" onclick="cetakExcel()">Cetak</a>

                </div>
            </div>

            <div class="box-body" id="printableArea">
                <style type="text/css" media="screen">
                    .large-table-container-3 {
                        /*max-width: 800px;*/
                        overflow-x: scroll;
                        overflow-y: auto;
                    }

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
                    <table width="100%" id="memListTable" class="table table-striped" style="width:100%">
                        <thead>
                            <th width="5%">#</th>
                            <th width="5%">No</th>
                            <th>Item Code</th>
                            <th>Warna</th>
                            <th>Satuan</th>
                            <th>Supplier</th>
                            <th>Lead Time</th>
                            <th>Stock Awal Bulan</th>
                            <th>Rata Pemakaian</th>
                            <th>Min Stok</th>
                            <th>Total In Per Bulan</th>
                            <th>Total Out Per Bulan</th>
                            <th>Stock Akhir Bulan</th>
                            <th>Act</th>
                        </thead>
                    </table>
                </div>
            </div>




        </div>
    </div>
</div>

<script type="text/javascript">
    function cetakExcel() {
        var url = "<?= site_url('wrh/aluminium/cetakExcelMonitoring') ?>";
        window.open(url, "_blank");
    }

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

    $(document).ready(function() {
        var table = $('#memListTable').DataTable({
            // Processing indicator
            "processing": true,
            // DataTables server-side processing mode
            "serverSide": true,
            // Initial no order.
            "ordering": false,
            "order": [],
            // Load data from an Ajax source
            "ajax": {
                "url": "<?php echo base_url('wrh/aluminium/getLists/'); ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties
            'columnDefs': [
                // {
                //     "targets": [1], // your case first column
                //     "visible": false,
                //     "searchable": false
                // },
                // {
                //     "targets": [6],
                //     "searchable": false
                // },
                // {
                //     "targets": [0], // your case first column
                //     "orderable": false,
                //     "width": "4%"
                // },
                {
                    "targets": [0, 13],
                    "className": "text-center",
                },
                {
                    "targets": -1,
                    "data": null,
                    "className": "text-center",
                    "defaultContent": "<button class='mutasi btn btn-primary btn-xs'>Mutasi</button><button class='history_mutasi btn btn-default btn-xs'>History Mutasi</button>"
                },
                {
                    "targets": 0,
                    "data": null,
                    "className": "text-center",
                    "defaultContent": "<button class='detail btn btn-info btn-xs'>Detail</button>"
                }
            ]

        });


        $('#memListTable tbody').on('click', 'button.mutasi', function() {
            var data = table.row($(this).parents('tr')).data();
            load_silent("wrh/aluminium/mutasi_stock_add/" + data[0] + "", "#content");
        });
        $('#memListTable tbody').on('click', 'button.history_mutasi', function() {
            var data = table.row($(this).parents('tr')).data();
            load_silent("wrh/aluminium/mutasi_stock_history/" + data[0] + "", "#modal");
        });
        $('#memListTable tbody').on('click', 'button.detail', function() {
            var data = table.row($(this).parents('tr')).data();
            var tr = $(this).closest('tr');
            var td = $(this).closest('td');
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                dataRow = format(data[0], row, tr);
            }
        });

    });

    function format(id, row, tr) {

        infoTable = '<table id="infoTable" class="table table-striped" border="1px" style="font-size: smaller;">' +
            '<tr>' +
            '<th bgcolor="#bfbfbf">No</th>' +
            '<th bgcolor="#bfbfbf">Divisi</th>' +
            '<th bgcolor="#bfbfbf">Gudang</th>' +
            '<th bgcolor="#bfbfbf">Keranjang/Rak</th>' +
            '<th bgcolor="#bfbfbf">Stock Awal Bulan</th>' +
            '<th bgcolor="#bfbfbf">Total In</th>' +
            '<th bgcolor="#bfbfbf">Total Out</th>' +
            '<th bgcolor="#bfbfbf">Mutasi In</th>' +
            '<th bgcolor="#bfbfbf">Mutasi Out</th>' +
            '<th bgcolor="#bfbfbf">Stock Akhir Bulan</th>' +
            '<th bgcolor="#bfbfbf">Rata2 Pemakaian</th>' +
            '<th bgcolor="#bfbfbf">Min Stock</th>' +
            '</tr>';
        $.ajax({
                url: "<?= site_url('wrh/aluminium/getDetailTabel') ?>",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    id: id,
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

                    if (data.detail[i].mutasi_in == null) {
                        var mutasi_in = 0;
                    } else {
                        var mutasi_in = data.detail[i].mutasi_in;
                    }

                    if (data.detail[i].mutasi_out == null) {
                        var mutasi_out = 0;
                    } else {
                        var mutasi_out = data.detail[i].mutasi_out;
                    }

                    infoTable += '<tr bgcolor="' + color + '">' +
                        '<td><font color="' + fontcolor + '">' + no + '</font></td>' +
                        '<td><font color="' + fontcolor + '">' + data.detail[i].divisi + '</font></td>' +
                        '<td><font color="' + fontcolor + '">' + data.detail[i].gudang + '</font></td>' +
                        '<td><font color="' + fontcolor + '">' + data.detail[i].keranjang + '</font></td>' +
                        '<td><font color="' + fontcolor + '">' + stok_a_b + '</font></td>' +
                        '<td><font color="' + fontcolor + '">' + stok_t_i + '</font></td>' +
                        '<td><font color="' + fontcolor + '">' + qty_out + '</font></td>' +
                        '<td><font color="' + fontcolor + '">' + mutasi_in + '</font></td>' +
                        '<td><font color="' + fontcolor + '">' + mutasi_out + '</font></td>' +
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
</script>