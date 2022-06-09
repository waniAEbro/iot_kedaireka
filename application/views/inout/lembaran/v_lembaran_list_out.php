<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Rekap Out lembaran</h3>
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
                                <th>User</th>
                                <th>Item Code</th>
                                <th width="25%">Deskripsi</th>
                                <th>Satuan</th>
                                <th>Qty</th>
                                <th>Brand</th>
                                <th>Divisi</th>
                                <th>Gudang</th>
                                <th>Keranjang</th>
                                <th>NO Surat Jalan</th>
                                <th>NO FPPP</th>
                                <th>Nama Proyek</th>
                                <th>Nama Penerima</th>
                                <th>Sopir</th>
                                <th>No Kendaraan</th>
                                <th>Alamat Pengiriman</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Jenis</th>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($lembaran->result() as $row) :
                                    $sts = ($row->mutasi == 0) ? "Stock" : "Mutasi";
                                    $qty = ($row->inout == 1) ? $row->qty_in : $row->qty_out;
                                    $jenis = ($row->produksi == 1) ? 'Produksi' : 'Lapangan';
                                ?>
                                    <tr>
                                        <td align="center"><?= $i++ ?></td>
                                        <td><?= $row->aktual ?></td>
                                        <td><?= $row->tgl_stok ?></td>
                                        <td><?= $row->nama ?></td>
                                        <td><?= $row->item_code ?></td>
                                        <td><?= $row->deskripsi ?></td>
                                        <td><?= $row->satuan ?></td>
                                        <td><?= $qty ?></td>
                                        <td><?= $row->brand ?></td>
                                        <td><?= $row->divisi_lembaran ?></td>
                                        <td><?= $row->gudang ?></td>
                                        <td><?= $row->keranjang ?></td>
                                        <td><?= $row->no_surat_jalan ?></td>
                                        <td><?= $row->no_fppp ?></td>
                                        <td><?= $row->nama_proyek ?></td>
                                        <td><?= $row->penerima ?></td>
                                        <td><?= $row->sopir ?></td>
                                        <td><?= $row->no_kendaraan ?></td>
                                        <td><?= $row->alamat_pengiriman ?></td>
                                        <td><?= $row->keterangan ?></td>
                                        <td><?= $sts ?></td>
                                        <td><?= $jenis ?></td>

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
        load_silent("inout/lembaran/diSetOut/" + tlg1 + "/" + tgl2, "#content");

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

        var url = "<?= site_url('inout/lembaran/diSetCetakOut/"+tlg1+"/"+tgl2+"') ?>";
        window.open(url, "_blank");
    }
</script>