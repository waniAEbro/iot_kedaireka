<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Rekap In Aksesoris</h3>
            </div>
            <div class="box-body">
                <?php
                $level = from_session('level');
                if ($level != '4') {

                ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Awal</label>
                                <input type="text" data-date-format="yyyy-mm-dd" value="<?= $tgl_awal ?>" class="form-control datepicker" autocomplete="off" id="tgl_awal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Akhir</label>
                                <input type="text" data-date-format="yyyy-mm-dd" value="<?= $tgl_akhir ?>" class="form-control datepicker" autocomplete="off" id="tgl_akhir">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-tools pull-right">
                                <a class="btn btn-primary" onclick="cetakExcel()">Cetak</a>
                                <a class="btn btn-success" onclick="setAplikator()">Set Filter</a>
                            </div>
                        </div>
                        </>
                    <?php } ?>
                    </div>
                    <div class="box-body">
                        <table width="100%" id="tableku" class="table table-striped">
                            <thead>
                                <th width="5%">No</th>
                                <th>Tgl Aktual</th>
                                <th>Tgl Input</th>
                                <th>Stok Awal Bulan</th>
                                <th>Item Code</th>
                                <th width="25%">Deskripsi</th>
                                <th>Satuan</th>
                                <th>Qty</th>
                                <th>Divisi</th>
                                <th>Gudang</th>
                                <th>Keranjang</th>
                                <th>Supplier</th>
                                <th>NO Surat Jalan</th>
                                <th>NO PR/WO</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($aksesoris->result() as $row) :
                                    $sts = ($row->mutasi == 0) ? "Stock" : "Mutasi";
                                    $qty = ($row->inout == 1) ? $row->qty_in : $row->qty_out;
                                    $awal_bulan = ($row->awal_bulan == 1) ? 'YA' : 'TIDAK';
                                ?>
                                    <tr>
                                        <td align="center"><?= $i++ ?></td>
                                        <td><?= $row->aktual ?></td>
                                        <td><?= $row->tgl_stok ?></td>
                                        <td><?= $awal_bulan ?></td>
                                        <td><?= $row->item_code ?></td>
                                        <td><?= $row->deskripsi ?></td>
                                        <td><?= $row->satuan ?></td>
                                        <td><?= $qty ?></td>
                                        <td><?= $row->divisi_aksesoris ?></td>
                                        <td><?= $row->gudang ?></td>
                                        <td><?= $row->keranjang ?></td>
                                        <td><?= $row->supplier ?></td>
                                        <td><?= $row->no_surat_jalan ?></td>
                                        <td><?= $row->no_pr ?></td>
                                        <td><?= $row->keterangan ?></td>
                                        <td><?= $row->keterangan ?></td>
                                        <td><?= $sts ?></td>

                                    </tr>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>
<script language="javascript">
    $(document).ready(function() {
        $('select').select2();
        $('.datepicker').datepicker({
            autoclose: true
        });
        var table = $('#tableku').DataTable({
            "ordering": true,
            "scrollX": true,
        });
    });

    function setAplikator(argument) {
        var tgl_awal = $('#tgl_awal').val();
        if (tgl_awal != '') {
            var tlg1 = tgl_awal;
        } else {
            var tlg1 = '<?= $tgl_awal ?>';
        };
        var tgl_akhir = $('#tgl_akhir').val();
        if (tgl_akhir != '') {
            var tgl2 = tgl_akhir;
        } else {
            var tgl2 = '<?= $tgl_akhir ?>';
        };
        load_silent("inout/aksesoris/diSet/" + tlg1 + "/" + tgl2, "#content");

    }

    function cetakExcel() {
        var tgl_awal = $('#tgl_awal').val();
        if (tgl_awal != '') {
            var tlg1 = tgl_awal;
        } else {
            var tlg1 = '<?= $tgl_awal ?>';
        };
        var tgl_akhir = $('#tgl_akhir').val();
        if (tgl_akhir != '') {
            var tgl2 = tgl_akhir;
        } else {
            var tgl2 = '<?= $tgl_akhir ?>';
        };

        var url = "<?= site_url('inout/aksesoris/diSetCetak/"+tlg1+"/"+tgl2+"') ?>";
        window.open(url, "_blank");
    }
</script>