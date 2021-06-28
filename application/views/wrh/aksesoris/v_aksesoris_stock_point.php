<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">

                <div class="box-tools pull-right">
                    <h3 class="box-title">Stock Point Aksesoris</h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="text" data-date-format="yyyy-mm-dd" value="<?= $tgl ?>" class="form-control datepicker" id="tgl">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <a class="btn btn-primary" onclick="setAplikator()">Tampilkan</a>
                            <a class="btn btn-default" onclick="saveStockPoint()">Simpan</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
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
                    <table width="100%" id="tableku" class="table table-striped table-responsive">
                        <thead>
                            <th width="5%">No</th>
                            <th>Item Code</th>
                            <th>Qty</th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($stock_point->result() as $row) :
                            ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $row->item_code ?></td>
                                    <td align="center"><?= $row->qty ?></td>


                                </tr>

                            <?php
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("select").select2();
        var table = $('#tableku').DataTable({
            // "scrollX": true,
            // "paging": false,
        });
        $('.datepicker').datepicker({
            autoclose: true
        });
    });

    function setAplikator(argument) {

        var tgl = $('#tgl').val();
        if (tgl != '') {
            var tanggal = tgl;
        } else {
            var tanggal = '';
        };

        load_silent("wrh/aksesoris/stock_point/" + tanggal + "/", "#content");

    }

    function saveStockPoint(argument) {
        var tgl = $('#tgl').val();
        if (tgl != '') {
            var tanggal = tgl;
        } else {
            var tanggal = '';
        };
        var r = confirm("Apakah anda yakin menyimpan stok point?");
        if (r == true) {
            load_silent("wrh/aksesoris/saveStockPoint/" + tanggal + "/", "#content");
        }


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
</script>