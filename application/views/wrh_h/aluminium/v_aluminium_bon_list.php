<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List BON Aluminium</h3>
                <div class="box-tools pull-right">
                    <?php
                    

                    echo button('load_silent("wrh_h/aluminium/bon_manual_add/","#content")', 'Add BON Manual MF', 'btn btn-info', 'data-toggle="tooltip" title="BON Manual"');
                        echo button('load_silent("wrh_h/aluminium/bon_manual_add_warna/","#content")', 'Add BON Manual Warna', 'btn btn-primary', 'data-toggle="tooltip" title="BON Manual"');
                    ?>
                </div>
            </div>
            <div class="box-body">
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
                            <a class="btn btn-success" onclick="setFilter()">Set Filter</a>
                            <a class="btn btn-success" onclick="setCetakAlu()">Cetak</a>
                        </div>
                    </div>
                    </>
                </div>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Tgl</th>
                        <th>Tgl Aktual</th>
                        <th>No Surat Jalan</th>
                        <th>Penerima</th>
                        <th>Alamat Pengiriman</th>
                        <th>Sopir</th>
                        <th>No Kendaraan</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($surat_jalan->result() as $row) :
                            $lapangan = @$keterangan[$row->id];
                            $ket = ($lapangan > 0) ? 'Lapangan' : 'Produksi';
                        ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td align="center"><?= $row->created ?></td>
                                <td align="center"><?= $row->tgl_aktual ?></td>
                                <td><?= $row->no_surat_jalan ?></td>
                                <td><?= $row->penerima ?></td>
                                <td><?= $row->alamat_pengiriman ?></td>
                                <td><?= $row->sopir ?></td>
                                <td><?= $row->no_kendaraan ?></td>
                                <td><?= $row->keterangan_sj ?></td>
                                <td><?= $ket ?></td>
                                <td>
                                    <?php
                                    echo button('load_silent("wrh_h/aluminium/edit_item_stok_out/' . $row->id . '","#content")', 'Edit', 'btn btn-xs btn-info', 'data-toggle="tooltip" title="Edit"');
                                    echo button('load_silent("wrh_h/aluminium/lihat_item_stok_out/' . $row->id . '","#modal")', 'Lihat Item', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Lihat Item Stock OUT"');
                                    echo button_confirm("Apakah anda yakin menghapus SJ BON " . $row->no_surat_jalan . "?", "wrh_h/aluminium/deleteSJBon/" . $row->id, "#content", "Hapus", "btn btn-xs btn-danger", "");
                                    ?>
                                    <a target="_blank" href="<?= base_url('wrh_h/aluminium/cetakSjBon'); ?>/<?= $row->id ?>" class="btn btn-xs btn-warning">Cetak Surat Jalan</a>
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
        $('.datepicker').datepicker({
            autoclose: true
        });
    });

    function setFilter(argument) {
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
        load_silent("wrh_h/aluminium/bon_manual_diSet/" + tlg1 + "/" + tgl2, "#content");


        
    }

    function setCetakAlu() {
        var tgl_awal = $('#tgl_awal').val();

        var tgl_akhir = $('#tgl_akhir').val();

        var url = "<?= site_url('wrh_h/aluminium/bon_manual_diSet_cetak/"+tgl_awal+"/"+tgl_akhir+"') ?>";
        window.open(url, "_blank");
    }
</script>