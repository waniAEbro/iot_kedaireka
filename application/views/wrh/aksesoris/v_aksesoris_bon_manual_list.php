<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">BON Manual </h3>
                <div class="box-tools pull-right">
                    <?php
                    $sesi = from_session('level');
                    if ($sesi == '1' || $sesi == '2') {
                        echo button('load_silent("wrh/aksesoris/bon_manual_add/","#content")', 'Tambah BON Manual', 'btn btn-primary', 'data-toggle="tooltip" title="Tambah BON Manual"');
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
                        <th>Tgl Proses</th>
                        <th>No FPPP</th>
                        <th>Nama Proyek</th>
                        <th>Item Code</th>
                        <th>Deskripsi</th>
                        <th>Qty BOM</th>
                        <th>Qty Aktual</th>
                        <th>Out Dari Divisi</th>
                        <th>Area Gudang</th>
                        <th>Produksi</th>
                        <th>Lapangan</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($bom_aksesoris->result() as $row) :
                            $cekproduksi = ($row->produksi == 1) ? 'checked' : '';
                            $ceklapangan = ($row->lapangan == 1) ? 'checked' : '';
                        ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->tgl_proses ?></td>
                                <td><?= $row->no_fppp ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td><?= $row->item_code ?></td>
                                <td><?= $row->deskripsi ?></td>
                                <td><?= $row->qty_bom ?></td>
                                <td><?= $row->qty ?></td>
                                <td><?= $row->divisi ?></td>
                                <td><?= $row->gudang ?></td>
                                <td><input type="checkbox" onclick="return false;" class="checkbox" <?= $cekproduksi ?>></td>
                                <td><input type="checkbox" onclick="return false;" class="checkbox" <?= $ceklapangan ?>></td>
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