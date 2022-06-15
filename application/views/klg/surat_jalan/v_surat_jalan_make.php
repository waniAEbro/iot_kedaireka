<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List BOM aksesoris</h3>
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

                                <input type="text" class="form-control" value="<?= $no_surat_jalan ?>" id="no_surat_jalan" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Penerima</label>
                                <input type="text" class="form-control" id="penerima">
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
                            <th width="35%">FPPP</th>
                            <th width="50%">FPPP Detail</th>
                            <th width="10%">Qty</th>
                            <th width="5%">Act</th>
                        </tr>
                    </thead>
                    <tbody id="dataTbl">
                        <?php
                        foreach ($list_sj->result() as $row) {
                            $detail_fppp = $this->m_surat_jalan->getRowDetailFppp($row->id_fppp_detail);
                        ?>

                            <tr id="output_data_<?= $row->id ?>" class="output_data">
                                <td align="center"><?= $row->no_fppp ?></td>
                                <td align="center"><?= $detail_fppp ?></td>
                                <td align="center"><?= $row->qty ?></td>
                                <td align="center"><a class="btn btn-xs btn-danger" href="javascript:void(0)" onClick="hapus(<?= $row->id ?>)"><i class="fa fa-trash"></i></a></td>
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

    function simpan() {
        $("#simpan").hide();
        $.ajax({
            url: "<?= site_url('klg/surat_jalan/insert_sj/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "no_surat_jalan": $("#no_surat_jalan").val(),
                "penerima": $("#penerima").val(),
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
                load_silent("klg/surat_jalan", "#content");
            }
        });

    }
</script>