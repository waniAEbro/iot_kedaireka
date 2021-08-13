<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Stok IN </h3>
                <div class="box-tools pull-right">
                    <?php
                    $sesi = from_session('level');
                    if ($sesi == '1' || $sesi == '2') {
                        echo button('load_silent("wrh/aksesoris/stok_in_add/","#content")', 'Tambah Stock', 'btn btn-primary', 'data-toggle="tooltip" title="Tambah Stock"');
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
                        <th>Item</th>
                        <th>Divisi</th>
                        <th>Gudang</th>
                        <th>Keranjang</th>
                        <th>Qty</th>
                        <th>Supplier</th>
                        <th>No Surat Jalan</th>
                        <th>No PR</th>

                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($aksesoris->result() as $row) :
                            $qty = ($row->inout == 1) ? $row->qty_in : $row->qty_out;
                        ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->created ?></td>
                                <td><?= $row->item_code ?></td>
                                <td><?= $row->divisi ?></td>
                                <td><?= $row->gudang ?></td>
                                <td><?= $row->keranjang ?></td>
                                <td><?= $qty ?></td>
                                <td><?= $row->supplier ?></td>
                                <td><?= $row->no_surat_jalan ?></td>
                                <td><?= $row->no_pr ?></td>

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