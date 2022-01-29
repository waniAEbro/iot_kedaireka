<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List BON Aluminium</h3>
                <div class="box-tools pull-right">
                    <?php
                    $sesi = from_session('level');
                    if ($sesi <= 3) {
                        echo button('load_silent("wrh/aluminium/bon_manual_add/","#content")', 'Add BON Manual', 'btn btn-primary', 'data-toggle="tooltip" title="BON Manual"');
                    } else {
                        # code...
                    }
                    ?>
                </div>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Tgl</th>
                        <th>Tgl Aktual</th>
                        <th>No Surat Jalan</th>
                        <th>Penerima</th>
                        <th>Alamat Pengiriman</th>
                        <th>Sopir</th>
                        <th>No Kendaraan</th>
                        <th>Keterangan</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($surat_jalan->result() as $row) :
                            $lapangan = @$keterangan[$row->id];
                            $ket = ($lapangan > 0) ? 'Lapangan' : 'Produksi';
                        ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td align="center"><?= $row->created ?></td>
                                <td align="center"><?= $row->tgl_aktual ?></td>
                                <td><?= $row->no_surat_jalan ?></td>
                                <td><?= $row->penerima ?></td>
                                <td><?= $row->alamat_pengiriman ?></td>
                                <td><?= $row->sopir ?></td>
                                <td><?= $row->no_kendaraan ?></td>
                                <td><?= $ket ?></td>
                                <td>
                                    <?php
                                    echo button('load_silent("wrh/aluminium/edit_item_stok_out/' . $row->id . '","#content")', 'Edit', 'btn btn-xs btn-info', 'data-toggle="tooltip" title="Edit"');
                                    echo button('load_silent("wrh/aluminium/lihat_item_stok_out/' . $row->id . '","#content")', 'Lihat Item', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Lihat Item Stock OUT"');
                                    ?>
                                    <a target="_blank" href="<?= base_url('wrh/aluminium/cetakSjBon'); ?>/<?= $row->id ?>" class="btn btn-xs btn-warning">Cetak Surat Jalan</a>
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
        var table = $('#tableku').DataTable({
            "ordering": true,
            "scrollX": true,
        });
    });
</script>