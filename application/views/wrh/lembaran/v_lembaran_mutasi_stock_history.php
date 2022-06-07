<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">History Mutasi lembaran : <?= $item->item_code ?> - <?= $item->deskripsi ?></h3>
                <div class="box-tools pull-right">
                    <?php
                    echo button('load_silent("wrh/lembaran/","#content")', 'Kembali', 'btn btn-warning', 'data-toggle="tooltip" title="Mutasi"');
                    ?>
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
                    <table width="100%" id="tableku" class="table table-striped">
                        <thead>
                            <th width="5%">No</th>
                            <th>Waktu</th>
                            <th>Divisi</th>
                            <th>Gudang</th>
                            <th>Keranjang/Rak</th>
                            <th>Qty In</th>
                            <th>Qty OUT</th>
                            <th>Keterangan</th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($mutasi->result() as $row) :
                            ?>
                                <tr>
                                    <td align="center"><?= $i++ ?></td>
                                    <td><?= $row->waktu ?></td>
                                    <td><?= $row->divisi ?></td>
                                    <td><?= $row->gudang ?></td>
                                    <td><?= $row->keranjang ?></td>
                                    <td><?= $row->qty_in ?></td>
                                    <td><?= $row->qty_out ?></td>
                                    <td><?= $row->keterangan ?></td>
                                </tr>
                            <?php endforeach; ?>
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
    $(document).ready(function() {
        var table = $('#tableku').DataTable({
            "ordering": true,
            // "scrollX": true,
        });
    });
</script>