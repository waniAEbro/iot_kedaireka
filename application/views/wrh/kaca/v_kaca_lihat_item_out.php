<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List Item Stock Out kaca</h3>
                <div class="box-tools pull-right">
                    <?php //echo button('load_silent("wrh/kaca/bon_manual","#content")', 'Kembali', 'btn btn-success');
                    ?>
                </div>
            </div>
            <div class="box-body">
                <form method="post" class="form-vertical form_faktur" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>No Surat Jalan</label>
                                <input type="hidden" class="form-control" id="id_fppp" value="<?= $id_fppp ?>" readonly>

                                <input type="text" class="form-control" value="<?= $no_surat_jalan ?>" id="no_surat_jalan" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Penerima</label>
                                <input type="text" class="form-control" id="penerima" value="<?= $penerima ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Alamat Pengiriman</label>
                                <input type="text" class="form-control" id="alamat_pengiriman" value="<?= $alamat_pengiriman ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sopir</label>
                                <input type="text" class="form-control" id="sopir" value="<?= $sopir ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>No Kendaraan</label>
                                <input type="text" class="form-control" id="no_kendaraan" value="<?= $no_kendaraan ?>" readonly>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-body">
                <table width="100%" id="tablekuz" class="table table-bordered table-striped" style="font-size: smaller;">
                    <thead>
                        <tr>
                            <th width="15%">FPPP</th>
                            <th width="15%">Brand</th>
                            <th width="30%">Item</th>
                            <th width="15%">Divisi</th>
                            <th width="15%">Gudang</th>
                            <th width="15%">Area</th>
                            <th width="7%">Qty</th>
                            <th width="10%">Warna Awal</th>
                            <th width="10%">Warna Akhir</th>
                            <th width="7%">Produksi</th>
                            <th width="7%">Lapangan</th>
                        </tr>
                    </thead>
                    <tbody id="dataTbl">
                        <?php
                        foreach ($list_sj->result() as $row) {
                            $cekproduksi = ($row->produksi == 1) ? 'checked' : '';
                            $ceklapangan = ($row->lapangan == 1) ? 'checked' : '';
                        ?>

                            <tr id="output_data_<?= $row->id_stock ?>" class="output_data">
                                <td align="center"><?= $row->no_fppp ?>-<?= $row->nama_proyek ?></td>
                                <td align="center"><?= $row->brand ?></td>
                                <td><?= $row->item_code ?>-<?= $row->deskripsi ?></td>
                                <td align="center"><?= $row->divisi_stock ?></td>
                                <td align="center"><?= $row->gudang ?></td>
                                <td align="center"><?= $row->keranjang ?></td>
                                <td align="center"><?= $row->qty_out ?></td>
                                <td align="center"><?= $row->warna_awal ?></td>
                                <td align="center"><?= $row->warna_akhir ?></td>
                                <td align="center"><input type="checkbox" onclick="return false;" class="checkbox" <?= $cekproduksi ?>></td>
                                <td align="center"><input type="checkbox" onclick="return false;" class="checkbox" <?= $ceklapangan ?>></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#tablekuz').DataTable({
            ordering: false,
            paging: false,
            scrollX: true,
        });
        $("select").select2();
    });
</script>