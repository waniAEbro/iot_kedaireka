<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Stok IN Bulan Ini</h3>
                <div class="box-tools pull-right">
                    <?php
                    $sesi = from_session('level');
                    if ($sesi <= 3) {
                        echo button('load_silent("wrh/aluminium/stok_in_add/","#content")', 'Tambah Stock', 'btn btn-primary', 'data-toggle="tooltip" title="Tambah Stock"');
                    } else {
                        # code...
                    }
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
                        <th>Tgl Aktual</th>
                        <th>User</th>
                        <th>Item</th>
                        <th>Warna</th>
                        <th>Divisi</th>
                        <th>Gudang</th>
                        <th>Keranjang</th>
                        <th>Qty</th>
                        <th>Supplier</th>
                        <th>No Surat Jalan</th>
                        <th>No PR</th>
                        <th>Keterangan</th>
                        <th>Edit</th>

                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($aluminium->result() as $row) :
                            $qty = ($row->inout == 1) ? $row->qty_in : $row->qty_out;
                        ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->created ?></td>
                                <td><?= $row->aktual ?></td>
                                <td><?= $row->nama ?></td>
                                <td><?= $row->section_ata ?>-<?= $row->section_allure ?>-<?= $row->temper ?>-<?= $row->kode_warna ?>-<?= $row->ukuran ?></td>
                                <td><?= $row->warna ?></td>
                                <td><?= $row->divisi ?></td>
                                <td><?= $row->gudang ?></td>
                                <td><?= $row->keranjang ?></td>
                                <td><?= $qty ?></td>
                                <td><?= $row->supplier ?></td>
                                <td><?= $row->no_surat_jalan ?></td>
                                <td><?= $row->no_pr ?></td>
                                <td><?= $row->keterangan ?></td>
                                <td>
                                    <?php if ($tbl_del == 1) { ?>
                                        <?= button('load_silent("wrh/aluminium/stok_in_edit/' . $row->id . '","#content")', 'Edit', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Edit"'); ?>
                                        <?= button_confirm("Apakah anda yakin menghapus Stock ini?", "wrh/aluminium/deleteIn/" . $row->id, "#content", "Hapus", "btn btn-xs btn-danger", "") ?>
                                    <?php } ?>
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
    $(document).ready(function() {
        $('.datepicker').datepicker({
            autoclose: true
        });
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
        load_silent("wrh/aluminium/stok_in_set/" + tlg1 + "/" + tgl2, "#content");

    }
</script>