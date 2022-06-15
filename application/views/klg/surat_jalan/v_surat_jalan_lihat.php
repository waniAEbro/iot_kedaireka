<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List Item </h3>
                <div class="box-tools pull-right">
                    <?php //echo button('load_silent("wrh/aksesoris/bon_manual","#content")', 'Kembali', 'btn btn-success');
                    ?>
                </div>
            </div>
            <div class="box-body">
                <form method="post" class="form-vertical form_faktur" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>No Surat Jalan</label>
                                <input type="text" class="form-control" value="<?= $row->no_sj ?>" id="no_surat_jalan" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Penerima</label>
                                <input type="text" class="form-control" id="penerima" value="<?= $row->penerima ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Alamat Pengiriman</label>
                                <input type="text" class="form-control" id="alamat_pengiriman" value="<?= $row->alamat ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sopir</label>
                                <input type="text" class="form-control" id="sopir" value="<?= $row->sopir ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>No Kendaraan</label>
                                <input type="text" class="form-control" id="no_kendaraan" value="<?= $row->no_kendaraan ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" value="<?= $row->keterangan ?>" id="no_surat_jalan" readonly>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-body">
                <table width="100%" id="tablekuz" class="table table-bordered table-striped" style="font-size: smaller;">
                    <thead>
                        <tr>
                            <th width="35%">FPPP</th>
                            <th width="50%">FPPP Detail</th>
                            <th width="10%">Qty</th>
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