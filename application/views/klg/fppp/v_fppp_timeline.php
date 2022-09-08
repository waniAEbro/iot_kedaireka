<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
    .container {
        /* width: 30em; */
        overflow-x: auto;
        white-space: nowrap;
    }
</style>

<div class="container">
    <table width="100%" border="1" ; id="tabeku" class="table">
        <thead>
            <th>NO FPPP</th>
            <th>Nama Project</th>
            <th>Warna</th>
            <th>Alamat</th>
            <th>Submit FPPP</th>
            <th>Deadline FPPP</th>
            <th>Durasi (Bulan)</th>
            <th>Jumlah Opening</th>
            <th>Jumlah Unit</th>
            <th>OTS Unit</th>
            <th>Tipe Kaca</th>
            <th>Proses Unit</th>
            <th>Task</th>
        </thead>
        <tbody>
            <tr>
                <td><?= $row->no_fppp ?></td>
                <td><?= $row->nama_proyek ?></td>
                <td><?= $row->warna ?></td>
                <td><?= $row->alamat_proyek ?></td>
                <td><?= $row->tgl_pembuatan ?></td>
                <td><?= $row->deadline_pengiriman ?></td>
                <td><?php
                    $tgl1 = new DateTime($row->tgl_pembuatan);
                    $tgl2 = new DateTime($row->deadline_pengiriman);
                    $jarak = $tgl2->diff($tgl1);

                    echo $jarak->d; ?>
                </td>
                <td><?= $row->jumlah_gambar ?></td>
                <td><?= $row->jumlah_unit ?></td>
                <td><?= $row->total_kirim; ?></td>
                <td><?= $row->kaca ?></td>
                <td>Proses Unit</td>
                <td>:</td>
            </tr>
            <tr>
                <td colspan="12"></td>
                <td>Proses BOM aluminium</td>
            </tr>
            <tr>
                <td colspan="12"></td>
                <td>Proses WO produksi</td>
            </tr>
            <tr>
                <td colspan="12"></td>
                <td>Persiapan Gudang</td>
            </tr>
            <tr>
                <td colspan="12"></td>
                <td>Proses WO/PR kaca</td>
            </tr>
            <tr>
                <td colspan="12"></td>
                <td>Proses Cutting & Machining</td>
            </tr>
            <tr>
                <td colspan="12"></td>
                <td>Proses Assembling</td>
            </tr>
            <tr>
                <td colspan="12"></td>
                <td>Proses Cek QC</td>
            </tr>
            <tr>
                <td colspan="12"></td>
                <td>Delivery</td>
            </tr>
        </tbody>
    </table>
</div>