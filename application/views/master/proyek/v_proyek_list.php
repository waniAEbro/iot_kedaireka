<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Master proyek</h3>
                <div class="box-tools pull-right">
                    <?php
                    $sesi = from_session('level');
                    if ($sesi <= 4) {
                        echo button('load_silent("master/proyek/form/base","#modal")', 'Add proyek', 'btn btn-info', 'data-toggle="tooltip" title="Add"');
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
                        <th>Kode Proyek</th>
                        <th>Nama Proyek</th>
                        <th>Nama Customer</th>
                        <th>Alamat Proyek</th>
                        <th>Keterangan</th>
                        <th>Act</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($proyek->result() as $row) : ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->kode_proyek ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td><?= $row->nama_customer ?></td>
                                <td><?= $row->alamat ?></td>
                                <td><?= $row->keterangan ?></td>
                                <td align="center">
                                    <?php
                                    $sesi = from_session('level');
                                    if ($sesi <= 3) {
                                        echo button('load_silent("master/proyek/form/sub/' . $row->id . '","#modal")', '', 'btn btn-info fa fa-edit', 'data-toggle="tooltip" title="Edit"');
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