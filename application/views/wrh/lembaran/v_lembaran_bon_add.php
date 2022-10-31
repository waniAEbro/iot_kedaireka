<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List BOM lembaran</h3>
                <div class="box-tools pull-right">
                    <?php //echo button('load_silent("klg/fppp","#content")', 'Kembali', 'btn btn-success'); 
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Penerima</label>
                                <input type="text" class="form-control" id="penerima">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tgl Aktual</label>
                                <input type="text" data-date-format="yyyy-mm-dd" class="form-control datepicker" value="<?= $tgl_aktual ?>" id="tgl_aktual" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Alamat Pengiriman</label>
                                <input type="text" class="form-control" id="alamat_pengiriman">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sopir</label>
                                <input type="text" class="form-control" id="sopir">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>No Kendaraan</label>
                                <input type="text" class="form-control" id="no_kendaraan">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" id="keterangan">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-footer">
                <button type="submit" id="simpan" onclick="simpan()" class="btn btn-success">Simpan</button>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-bordered table-striped" style="font-size: smaller;">
                    <thead>
                        <tr>
                            <th width="15%">FPPP</th>
                            <th width="15%">Brand</th>
                            <th width="30%">Item</th>
                            <th width="15%">Divisi</th>
                            <th width="15%">Gudang</th>
                            <th width="15%">Keranjang/Rak</th>
                            <th width="7%">Qty</th>
                            <th width="7%">Warna Awal</th>
                            <th width="7%">Warna Akhir</th>
                            <th width="7%">Produksi</th>
                            <th width="7%">Lapangan</th>
                            <th width="5%">Act</th>
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
                                <td align="center"><a class="btn btn-xs btn-danger" href="javascript:void(0)" onClick="hapus(<?= $row->id_stock ?>)"><i class="fa fa-trash"></i></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="form-group">
                    <input type="hidden" style="text-align: right;" class="form-control" id="stock" placeholder="Stock" readonly>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#tableku').DataTable({
            ordering: false,
            paging: false,
            scrollX: true,
        });
        $("select").select2();
        $('.datepicker').datepicker({
            autoclose: true
        });
    });

    $(".checkbox").change(function() {
        var fieldname = $(this).data('field');
        if (fieldname == 'produksi') {
            $('#lapangan').prop('checked', false); // Unchecks it
            $('#lapangan').val('0');
            $('#produksi').val('1');
        } else {
            $('#produksi').prop('checked', false); // Checks it
            $('#lapangan').val('1');
            $('#produksi').val('0');
        }
    });

    function simpan() {
        $("#simpan").hide();
        $.ajax({
            url: "<?= site_url('wrh/lembaran/simpanSuratJalanBon/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "id_fppp": $("#id_fppp").val(),
                "no_surat_jalan": $("#no_surat_jalan").val(),
                "penerima": $("#penerima").val(),
                "tgl_aktual": $("#tgl_aktual").val(),
                "alamat_pengiriman": $("#alamat_pengiriman").val(),
                "sopir": $("#sopir").val(),
                "no_kendaraan": $("#no_kendaraan").val(),
                "keterangan": $("#keterangan").val(),
            },
            success: function(img) {
                $.growl.notice({
                    title: 'Berhasil',
                    message: "Menyimpan Surat Jalan!"
                });
                load_silent("wrh/lembaran/bon_manual/", "#content");
            }
        });

    }
</script>