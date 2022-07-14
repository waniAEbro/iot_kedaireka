<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Surat Jalan BOM Aluminium</h3>
                <div class="box-tools pull-right">
                    
                </div>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Tgl Upload BOM</th>
                        <th>No FPPP</th>
                        <th>Nama Proyek</th>
                        <th>Deadline Sales</th>
                        <th>Deadline Workshop</th>
                        <th>Status</th>
                        <th>Qty BOM</th>
                        <th>Qty OUT</th>
                        <th>Qty Process Out</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($dataFpppOut->result() as $row) :
                            $qtybom           = @$qty_bom[$row->id];
                            $qtyout           = @$qty_out[$row->id];
                            $qtyoutproses           = @$qty_out_proses[$row->id];
                            if ($row->id_status == 1) {
                                $status = "PROSES";
                            } else if ($row->id_status == 2) {
                                $status = "PARSIAL";
                            } else {
                                $status = "LUNAS";
                                // $this->m_aluminium->updateStatusLunasFppp($row->id);
                            }

                        ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td align="center"><?= $row->tgl_upload_bom_aluminium ?></td>
                                <td><?= $row->no_fppp ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td align="center"><?= $row->deadline_pengiriman ?></td>
                                <td align="center"><?= $row->deadline_workshop ?></td>
                                <td><b><?= $status ?></b></td>
                                <td align="center"><?= $qtybom ?></td>
                                <td align="center"><?= $qtyout ?></td>
                                <td align="center"><?= $qtyoutproses ?></td>
                                <td>

                                    <?php
                                    echo button('load_silent("wrh/aluminium/stok_out_make/' . $row->id . '","#content")', 'Stock OUT', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Stock OUT"');
                                    echo button_confirm("Apakah anda yakin mengubah status menjadi lunas pada no FPPP: " . $row->no_fppp . "?", "wrh/aluminium/make_lunas/" . $row->id, "#content", "Lunas", "btn btn-xs btn-success", "");
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
            "ordering": true,
            "scrollX": true,
        });
    });
</script>