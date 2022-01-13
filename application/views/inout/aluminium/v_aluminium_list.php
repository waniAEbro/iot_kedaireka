<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Rekap In Aluminium</h3>
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
                                <th>Status</th>
                                <th>Stok Awal Bulan</th>
                                <th>Tgl</th>
                                <th>Section ATA</th>
                                <th>Section Allure</th>
                                <th>Temper</th>
                                <th>Warna</th>
                                <th width="25%">Deskripsi Warna</th>
                                <th>Ukuran</th>
                                <th>Satuan</th>
                                <th>Qty</th>
                                <th>Divisi</th>
                                <th>Gudang</th>
                                <th>Keranjang</th>
                                <th>Supplier</th>
                                <th>NO Surat Jalan</th>
                                <th>NO PR/WO</th>
                                <th>Keterangan</th>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($aluminium->result() as $row) :
                                    $qty = ($row->inout == 1) ? $row->qty_in : $row->qty_out;
                                    $status = ($row->inout == 1) ? 'MASUK' : 'KELUAR';
                                    $awal_bulan = ($row->awal_bulan == 1) ? 'YA' : 'TIDAK';
                                ?>
                                    <tr>
                                        <td align="center"><?= $i++ ?></td>
                                        <td><?= $row->aktual ?></td>
                                        <td><?= $status ?></td>
                                        <td><?= $awal_bulan ?></td>
                                        <td><?= $row->tgl_stok ?></td>
                                        <td><?= $row->section_ata ?></td>
                                        <td><?= $row->section_allure ?></td>
                                        <td><?= $row->temper ?></td>
                                        <td><?= $row->kode_warna ?></td>
                                        <td><?= $row->warna ?></td>
                                        <td><?= $row->ukuran ?></td>
                                        <td><?= $row->satuan ?></td>
                                        <td><?= $qty ?></td>
                                        <td><?= $row->divisi ?></td>
                                        <td><?= $row->gudang ?></td>
                                        <td><?= $row->keranjang ?></td>
                                        <td><?= $row->supplier ?></td>
                                        <td><?= $row->no_surat_jalan ?></td>
                                        <td><?= $row->no_pr ?></td>
                                        <td><?= $row->keterangan ?></td>

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
        load_silent("inout/aluminium/diSet/" + tlg1 + "/" + tgl2, "#content");

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

        var url = "<?= site_url('inout/aluminium/diSetCetak/"+tlg1+"/"+tgl2+"') ?>";
        window.open(url, "_blank");
    }
</script>