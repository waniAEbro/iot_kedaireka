<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Finance</h3>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>DIVISI</th>
                        <th>KODE PROJECT</th>
                        <th>NAMA CUSTOMER</th>
                        <th>NAMA PROJECT</th>
                        <th>ALAMAT PROJECT</th>
                        <th>SALES</th>
                        <th>STATUS PROJECT</th>
                        <th>TOTAL UNIT</th>
                        <th>TOP</th>
                        <th>TANGGAL CO AWAL</th>
                        <th>CO AWAL</th>
                        <th>TAMBAHAN / PENGURANGAN</th>
                        <th>CO FINAL</th>
                        <th>DP AWAL</th>
                        <th>PEMBAYARAN TAHAP 1</th>
                        <th>PEMBAYARAN TAHAP 2</th>
                        <th>PEMBAYARAN TAHAP 3</th>
                        <th>PEMBAYARAN TAHAP 4</th>
                        <th>PELUNASAN</th>
                        <th>PEMASANGAN</th>
                        <th>TANGGAL BST</th>
                        <th>KETERANGAN</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($finance->result() as $row) : ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->divisi ?></td>
                                <td><?= $row->kode_proyek ?></td>
                                <td><?= $row->applicant ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td><?= $row->alamat_proyek ?></td>
                                <td><?= $row->sales ?></td>
                                <td></td>
                                <td></td>
                                <td>top</td>
                                <td>top</td>
                                <td>top</td>
                                <td>top</td>
                                <td>top</td>
                                <td>top</td>
                                <td>top</td>
                                <td>top</td>
                                <td>top</td>
                                <td>top</td>
                                <td>top</td>
                                <td>top</td>
                                <td>top</td>
                                <td>top</td>
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
            "ordering": false,
            "scrollX": true,
        });
    });
</script>