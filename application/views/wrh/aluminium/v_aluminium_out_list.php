<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List BOM</h3>
                <div class="box-tools pull-right">
                    <?php
                    $sesi = from_session('level');
                    if ($sesi == '1' || $sesi == '2') {
                        //echo button('load_silent("wrh/aluminium/stok_out_add/","#content")', 'Add Stock OUT', 'btn btn-primary', 'data-toggle="tooltip" title="Stock OUT"');
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
                        <th>No FPPP</th>
                        <th>Nama Proyek</th>
                        <th>Deadline Sales</th>
                        <th>Deadline Workshop</th>
                        <th>Status</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($dataFpppOut->result() as $row) :
                            $qtybom           = @$qty_bom[$row->id];
                            $qtyout           = @$qty_out[$row->id];
                            if ($qtyout == 0) {
                                $status = "PROSES";
                            } else if ($qtybom > $qtyout) {
                                $status = "PARSIAL";
                            } else {
                                $status = "LUNAS";
                            }

                        ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td align="center"><?= $row->created ?></td>
                                <td><?= $row->no_fppp ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td align="center"><?= $row->deadline_pengiriman ?></td>
                                <td align="center"><?= $row->deadline_workshop ?></td>
                                <td><?= $status ?></td>
                                <td>
                                    <?php echo button('load_silent("wrh/aluminium/stok_out_make/' . $row->id . '","#content")', 'Stock OUT', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Stock OUT"'); ?>
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