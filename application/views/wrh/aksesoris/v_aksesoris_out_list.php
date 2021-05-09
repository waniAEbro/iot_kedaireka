<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Stock Out List </h3>
                <div class="box-tools pull-right">
                    <?php
                    $sesi = from_session('level');
                    if ($sesi == '1' || $sesi == '2') {
                        //echo button('load_silent("wrh/aksesoris/stok_out_add/","#content")', 'Stock OUT', 'btn btn-primary', 'data-toggle="tooltip" title="Stock OUT"');
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
                        <th>Tgl Pembuatan</th>
                        <th>No FPPP</th>
                        <th>Nama Proyek</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($fppp->result() as $row) :
                        ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->tgl_pembuatan ?></td>
                                <td><?= $row->no_fppp ?><br><?= button('load_silent("wrh/aksesoris/detailbom/' . $row->id . '","#content")', 'Stock Out', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Add Stock Out"'); ?>
                                    <?php
                                    if ($row->no_sj != '') { ?>
                                        <a target="_blank" href="<?= base_url('wrh/aksesoris/cetakSj'); ?>/<?= $row->id ?>" onclick="simpantgl(<?= $row->id ?>)" class="btn btn-xs btn-warning">Cetak Surat Jalan</a>
                                    <?php
                                    } else {

                                        echo button('load_silent("wrh/aksesoris/suratjalan/' . $row->id . '","#content")', 'Surat Jalan', 'btn btn-xs btn-danger', 'data-toggle="tooltip" title="Surat Jalan"');
                                    }

                                    ?>
                                </td>
                                <td><?= $row->nama_proyek ?></td>
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