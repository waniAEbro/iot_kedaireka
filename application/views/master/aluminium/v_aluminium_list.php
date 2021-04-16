<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Master Aluminium</h3>
                <div class="box-tools pull-right">
                    <?php
                    $sesi = from_session('level');
                    if ($sesi == '1' || $sesi == '2') {
                        echo button('load_silent("master/aluminium/import/","#content")', 'Import Excel', 'btn btn-primary', 'data-toggle="tooltip" title="Import Excel"');
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
                        <th>Section ATA</th>
                        <th>Section Allure</th>
                        <th>Temper</th>
                        <th>Kode Warna</th>
                        <th>Deskripsi Warna</th>
                        <th>Ukuran</th>
                        <th>Satuan</th>
                        <th>Act</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($aluminium->result() as $row) : ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->section_ata ?></td>
                                <td><?= $row->section_allure ?></td>
                                <td><?= $row->temper ?></td>
                                <td><?= $row->kode_warna ?></td>
                                <td><?= $row->deskripsi_warna ?></td>
                                <td><?= $row->ukuran ?></td>
                                <td><?= $row->satuan ?></td>
                                <td align="center">
                                    <?php
                                    $sesi = from_session('level');
                                    if ($sesi == '1' || $sesi == '2') {
                                        echo button('load_silent("master/aluminium/form/sub/' . $row->id . '","#modal")', '', 'btn btn-info fa fa-edit', 'data-toggle="tooltip" title="Edit"');
                                    } else {
                                        # code...
                                    }
                                    ?>
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
            "ordering": false,
            "scrollX": true,
        });
    });
</script>