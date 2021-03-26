<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List BOM Aluminium</h3>
                <div class="box-tools pull-right">
                    <?php echo button('load_silent("klg/fppp","#content")', 'Kembali', 'btn btn-success'); ?>
                </div>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama Proyek</th>
                        <th>Section ATA</th>
                        <th>Section Allure</th>
                        <th>Temper</th>
                        <th>Kode Warna</th>
                        <th>Deskripsi Warna</th>
                        <th>Ukuran</th>
                        <th>Qty</th>
                        <th>Keterangan</th>
                        <th>Lampiran</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($bom_aluminium->result() as $row) : ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td><?= $row->section_ata ?></td>
                                <td><?= $row->section_allure ?></td>
                                <td><?= $row->temper ?></td>
                                <td><?= $row->kode_warna ?></td>
                                <td><?= $row->deskripsi_warna ?></td>
                                <td><?= $row->ukuran ?></td>
                                <td><?= $row->qty ?></td>
                                <td><?= $row->keterangan ?></td>
                                <td><?= $row->lampiran ?></td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List BOM Aksesoris</h3>
                <div class="box-tools pull-right">
                    <?php echo button('load_silent("klg/fppp","#content")', 'Kembali', 'btn btn-success'); ?>
                </div>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama Proyek</th>
                        <th>Item Code</th>
                        <th>Deskripsi</th>
                        <th>Satuan</th>
                        <th>Ukuran</th>
                        <th>Qty</th>
                        <th>Keterangan</th>
                        <th>Lampiran</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($bom_aksesoris->result() as $row) : ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td><?= $row->item_code ?></td>
                                <td><?= $row->deskripsi ?></td>
                                <td><?= $row->satuan ?></td>
                                <td><?= $row->ukuran ?></td>
                                <td><?= $row->qty ?></td>
                                <td><?= $row->keterangan ?></td>
                                <td><?= $row->lampiran ?></td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List BOM Lembaran</h3>
                <div class="box-tools pull-right">
                    <?php echo button('load_silent("klg/fppp","#content")', 'Kembali', 'btn btn-success'); ?>
                </div>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama Proyek</th>
                        <th>Kode Unit</th>
                        <th>Jenis Material</th>
                        <th>Deskripsi</th>
                        <th>Qty</th>
                        <th>Panjang</th>
                        <th>Lebar</th>
                        <th>Tebal</th>
                        <th>Keterangan</th>
                        <th>Lampiran</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($bom_lembaran->result() as $row) : ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td><?= $row->kode_unit ?></td>
                                <td><?= $row->jenis_material ?></td>
                                <td><?= $row->deskripsi ?></td>
                                <td><?= $row->qty ?></td>
                                <td><?= $row->panjang ?></td>
                                <td><?= $row->lebar ?></td>
                                <td><?= $row->tebal ?></td>
                                <td><?= $row->keterangan ?></td>
                                <td><?= $row->lampiran ?></td>
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