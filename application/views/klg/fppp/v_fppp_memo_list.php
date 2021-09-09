<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
    td.details-control {
        background: url("<?= base_url('assets/img/details_open.png') ?>") no-repeat center center;
        cursor: pointer;
    }

    tr.shown {
        background: #FCFF43;
    }

    tr.shown td.details-control {
        background: url("<?= base_url('assets/img/details_close.png') ?>") no-repeat center center;
    }
</style>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Memo List</h3>
                <div class="box-tools pull-right">
                    <?php
                    $sesi = from_session('level');
                    if ($sesi <= '3') {
                        echo button('load_silent("klg/fppp/memoAdd/","#content")', 'Memo Add', 'btn btn-primary', 'data-toggle="tooltip" title="Memo Add"');
                    } else {
                        # code...
                    }
                    ?>
                </div>
            </div>
            <div class="box-body" id="printableArea">
                <style type="text/css" media="screen">
                    .large-table-container-3 {
                        /*max-width: 800px;*/
                        overflow-x: scroll;
                        overflow-y: auto;
                    }

                    .large-table-container-3 table {}

                    .large-table-fake-top-scroll-container-3 {
                        /*max-width: 800px;*/
                        overflow-x: scroll;
                        overflow-y: auto;
                    }

                    .large-table-fake-top-scroll-container-3 div {
                        background-color: red;
                        font-size: 1px;
                        line-height: 1px;
                    }

                    /*misc*/
                    td {
                        border: 1px solid gray;
                    }
                </style>
                <div class="large-table-fake-top-scroll-container-3">
                    <div>&nbsp;</div>
                </div>
                <div class="large-table-container-3">
                    <table width="100%" id="tableku" class="table table-striped">
                        <thead>
                            <th width="5%"></th>
                            <th width="5%">No</th>
                            <th>DIVISI</th>
                            <th>NO. FPPP</th>
                            <th>NAMA PROYEK</th>
                            <th>NAMA SALES MARKETING</th>
                            <th>NAMA SM / PIC PROJECT</th>
                            <th>PENGIRIMAN</th>
                            <th>WARNA ALUMINIUM</th>
                            <th>JUMLAH GAMBAR / OPENING</th>
                            <th>TGL PEMBUATAN</th>
                            <th>DEADLINE SALES</th>
                            <th>DEADLINE WORKSHOP</th>
                            <th>ALAMAT PROYEK</th>
                            <th>STATUS ORDER</th>

                            <th>ACC/FA</th>
                            <th>WH aluminium</th>
                            <th>WH AKSESORIS</th>
                            <th>WH KACA</th>
                            <th>WS UPDATE</th>
                            <th>SITE UPDATE</th>

                            <th>Act</th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($fppp->result() as $row) :
                                $ada = 1;
                                $dw = ($row->deadline_workshop != '') ? $row->deadline_workshop : 'tentukan tgl';
                            ?>
                                <tr>
                                    <?php if ($ada > 0) { ?>
                                        <td class="details-control" id="<?= $i ?>"></td>
                                    <?php } else { ?>
                                        <td></td>
                                    <?php }  ?>
                                    <td align="center"><?= $i ?></td>
                                    <td><?= $row->divisi ?><input type="hidden" id="id_fppp_<?= $i ?>" value="<?= $row->id ?>"></td>
                                    <td><?= $row->no_fppp ?></td>
                                    <td><?= $row->nama_proyek ?></td>
                                    <td><?= $row->sales ?></td>
                                    <td><?= $row->pic_project ?></td>
                                    <td><?= $row->pengiriman ?></td>
                                    <td><?= $row->warna ?></td>
                                    <td><?= $row->jumlah_gambar ?></td>
                                    <td><?= $row->tgl_pembuatan ?></td>
                                    <td><?= $row->deadline_pengiriman ?></td>
                                    <td align="center"><span id="wrk_<?= $row->id ?>" class='edit'><?= $dw ?></span>
                                        <input type='date' class='txtedit' data-id='<?= $row->id ?>' data-field='deadline_workshop' id='<?= $row->id ?>' value='<?= $row->deadline_workshop ?>'>
                                    </td>
                                    <td><?= $row->alamat_proyek ?></td>
                                    <td><?= $row->status_order ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?= $row->status ?></td>
                                    <td align="center">
                                        <?php if ($row->lampiran != '') { ?>
                                            <a target="_blank" href="<?= base_url($row->lampiran); ?>" class="btn btn-xs btn-danger">Lampiran</a>
                                        <?php } ?>

                                        <?php
                                        if (from_session('level') < 4) {
                                            echo button('load_silent("klg/fppp/formEdit/' . $row->id . '","#content")', 'Edit', 'btn btn-xs btn-info', 'data-toggle="tooltip" title="Edit"');
                                            echo button('load_silent("klg/fppp/uploadbom/' . $row->id . '","#content")', 'Upload BOM', 'btn btn-xs btn-success', 'data-toggle="tooltip" title="Upload"');
                                            echo button('load_silent("klg/fppp/lihatbom/' . $row->id . '","#content")', 'Lihat BOM', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Upload"');
                                        }
                                        ?>
                                    </td>
                                </tr>

                            <?php $i++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#tableku').DataTable({
            "ordering": false,
            "scrollX": true,
        });
    });
</script>