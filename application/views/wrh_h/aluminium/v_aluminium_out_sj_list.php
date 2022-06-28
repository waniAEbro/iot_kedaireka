<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Stock Out List Aluminium</h3>
                <div class="box-tools pull-right">
                    <?php
                    $sesi = from_session('level');
                    if ($sesi <= 3) {
                        //echo button('load_silent("wrh_h/aluminium/stok_out_add/","#content")', 'Add Stock OUT', 'btn btn-primary', 'data-toggle="tooltip" title="Stock OUT"');
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
                        <th>No Surat Jalan</th>
                        <th>No FPPP</th>
                        <th>Nama Proyek</th>
                        <th>Deadline Sales</th>
                        <th>Deadline Workshop</th>
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
                                <td><?= $row->no_surat_jalan ?></td>
                                <td><?= $row->no_fppp ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td align="center"><?= $row->deadline_pengiriman ?></td>
                                <td align="center"><?= $row->deadline_workshop ?></td>
                                <td><?= $row->penerima ?></td>
                                <td><?= $row->alamat_pengiriman ?></td>
                                <td><?= $row->sopir ?></td>
                                <td><?= $row->no_kendaraan ?></td>
                                <td><?= $ket ?></td>
                                <td>
                                    <?php echo button('load_silent("wrh_h/aluminium/lihat_item_stok_out/' . $row->id . '","#content")', 'Lihat Item', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Lihat Item Stock OUT"');
                                    ?>
                                    <a target="_blank" href="<?= base_url('wrh_h/aluminium/cetakSj'); ?>/<?= $row->id ?>" class="btn btn-xs btn-warning">Cetak Surat Jalan</a>
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