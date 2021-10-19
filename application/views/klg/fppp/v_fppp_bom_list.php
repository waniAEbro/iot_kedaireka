<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List BOM Aluminium</h3>
                <div class="box-tools pull-right">
                    <?php echo button('load_silent("klg/fppp/hasil_finish/' . $param . '","#content")', 'Kembali', 'btn btn-success'); ?>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No FPPP</label>
                            <input type="text" class="form-control" id="no_fppp" value="<?= $rowFppp->no_fppp ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Proyek</label>
                            <input type="text" class="form-control" id="nama_proyek" value="<?= $rowFppp->nama_proyek ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Alamat Proyek</label>
                            <input type="text" class="form-control" id="alamat_proyek" value="<?= $rowFppp->alamat_proyek ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Warna Aluminium</label>
                            <input type="text" class="form-control" id="warna" value="<?= $rowFppp->warna ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Deadline Pengiriman</label>
                            <input type="text" class="form-control" id="deadline_pengiriman" value="<?= $rowFppp->deadline_pengiriman ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
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
                                <td><?= $row->warna ?></td>
                                <td><?= $row->ukuran ?></td>
                                <td><?= $row->qty_bom ?></td>
                                <td><?= $row->keterangan ?></td>
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
                    <?php echo button('load_silent("klg/fppp/hasil_finish/' . $param . '","#content")', 'Kembali', 'btn btn-success'); ?>
                </div>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama Proyek</th>
                        <th>Item Code</th>
                        <th>Deskripsi</th>
                        <th>Qty</th>
                        <th>Keterangan</th>
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
                                <td><?= $row->qty_bom ?></td>
                                <td><?= $row->keterangan ?></td>
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
                    <?php echo button('load_silent("klg/fppp/hasil_finish/' . $param . '","#content")', 'Kembali', 'btn btn-success'); ?>
                </div>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama Proyek</th>
                        <th>Jenis Material</th>
                        <th>Nama Barang</th>
                        <th>Lebar</th>
                        <th>Tinggi</th>
                        <th>Tebal</th>
                        <th>Warna</th>
                        <th>Qty</th>
                        <th>Keterangan</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($bom_lembaran->result() as $row) : ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td><?= $row->jenis_material ?></td>
                                <td><?= $row->nama_barang ?></td>
                                <td><?= $row->lebar ?></td>
                                <td><?= $row->tinggi ?></td>
                                <td><?= $row->tebal ?></td>
                                <td><?= $row->warna ?></td>
                                <td><?= $row->qty_bom ?></td>
                                <td><?= $row->keterangan ?></td>
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