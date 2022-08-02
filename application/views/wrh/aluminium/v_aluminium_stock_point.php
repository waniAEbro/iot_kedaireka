<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Stok Point Aluminium</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tanggal Stock Point</label>
                            <input type="text" data-date-format="yyyy-mm-dd" value="<?= $tgl ?>" class="form-control datepicker" autocomplete="off" id="tgl">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-tools pull-right">
                            <a class="btn btn-success" onclick="setAplikator()">Set Filter</a>
                        </div>
                    </div>
                    </>
                </div>
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Item Code</th>
                        <th>Warna</th>
                        <th>Gudang</th>
                        <th>Keranjang/Rak</th>
                        <th>Qty</th>

                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($list_data->result() as $row) :
                            $stok_awal_bulan = @$qty_awal_bulan[$row->id_item][$row->id_gudang][$row->keranjang];
                            $stok_masuk = @$qty_masuk[$row->id_item][$row->id_gudang][$row->keranjang];
                            $stok_keluar = @$qty_keluar[$row->id_item][$row->id_gudang][$row->keranjang];
                            $qty_total = $stok_awal_bulan + $stok_masuk - $stok_keluar;
                        ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->item_code ?></td>
                                <td><?= $row->warna ?></td>
                                <td><?= $row->gudang ?></td>
                                <td align="center"><?= $row->keranjang ?></td>
                                <td align="center">
                                    <?= $qty_total ?>
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
    $('.datepicker').datepicker({
        autoclose: true
    });
    $(document).ready(function() {
        var table = $('#tableku').DataTable({
            "ordering": true,
            "scrollX": true,
        });
    });

    function setAplikator(argument) {
        var tgl = $('#tgl').val();
        if (tgl != '') {
            var tgl = tgl;
        } else {
            var tgl = '<?= $tgl ?>';
        };
        load_silent("wrh/aluminium/stockPointList/" + tgl, "#content");

    }
</script>