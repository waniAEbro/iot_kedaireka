<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">WO</h3>
                <div class="box-tools pull-right">
                    <?php

                    echo button('load_silent("klg/wo/add/","#content")', 'Tambah WO', 'btn btn-primary', 'data-toggle="tooltip" title="Tambah WO"');
                    ?>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Awal</label>
                            <input type="text" data-date-format="yyyy-mm-dd" value="<?= $tgl_awal ?>" class="form-control datepicker" autocomplete="off" id="tgl_awal">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Akhir</label>
                            <input type="text" data-date-format="yyyy-mm-dd" value="<?= $tgl_akhir ?>" class="form-control datepicker" autocomplete="off" id="tgl_akhir">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-tools pull-right">
                            <a class="btn btn-success" onclick="setAplikator()">Set Filter</a>
                        </div>
                    </div>
                    </>
                </div>
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Tgl Input</th>
                        <th>Tgl Order</th>
                        <th>Divisi</th>
                        <th>NO PR / WO / PO:</th>
                        <th>Item Code</th>
                        <th>Qty WO</th>
                        <th>Qty In</th>
                        <th>Qty Sisa</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th></th>

                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($wo->result() as $row) :
                            $qty_in = 0;
                            $qty_sisa = $row->qty_wo - $qty_in;
                        ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->created ?></td>
                                <td><?= $row->tgl_order ?></td>
                                <td><?= $row->divisi ?></td>
                                <td><?= $row->no_wo ?></td>
                                <td><?= $row->item_code ?></td>
                                <td align="center"><?= $row->qty_wo ?></td>
                                <td align="center"><?= $qty_in ?></td>
                                <td align="center"><?= $qty_sisa ?></td>
                                <td><?= $row->keterangan ?></td>
                                <td></td>
                                <td>

                                    <?= button('load_silent("klg/wo/stok_in_edit/' . $row->id . '","#content")', 'Edit', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Edit"'); ?>
                                    <?= button_confirm("Apakah anda yakin menghapus Stock ini?", "klg/wo/deleteIn/" . $row->id, "#content", "Hapus", "btn btn-xs btn-danger", "") ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true
    });
    $(document).ready(function() {
        var table = $('#tableku').DataTable({
            "ordering": true,
            "scrollX": true,
        });
    });

    function setAplikator(argument) {
        var tgl_awal = $('#tgl_awal').val();
        if (tgl_awal != '') {
            var tlg1 = tgl_awal;
        } else {
            var tlg1 = '<?= $tgl_awal ?>';
        };
        var tgl_akhir = $('#tgl_akhir').val();
        if (tgl_akhir != '') {
            var tgl2 = tgl_akhir;
        } else {
            var tgl2 = '<?= $tgl_akhir ?>';
        };
        load_silent("klg/wo/set/" + tlg1 + "/" + tgl2, "#content");

    }
</script>