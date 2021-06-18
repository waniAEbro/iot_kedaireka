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
<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">BON Manual </h3>
                <div class="box-tools pull-right">
                    <?php
                    $sesi = from_session('level');
                    if ($sesi == '1' || $sesi == '2') {
                        echo button('load_silent("wrh/aluminium/bon_manual_add/","#content")', 'Tambah BON Manual', 'btn btn-primary', 'data-toggle="tooltip" title="Tambah BON Manual"');
                    } else {
                        # code...
                    }
                    ?>
                </div>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%"></th>
                        <th width="5%">No</th>
                        <th>Tgl Proses</th>
                        <th>No FPPP</th>
                        <th>Nama Proyek</th>
                        <th>No FORM</th>
                        <th>Act</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($bom_aluminium->result() as $row) :
                        ?>
                            <tr>
                                <td class="details-control" id="<?= $i ?>"></td>
                                <td align="center"><?= $i ?><input type="hidden" id="id_bon_<?= $i ?>" value="<?= $row->id ?>"></td>
                                <td><?= $row->tgl_proses ?></td>
                                <td><?= $row->no_fppp ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td><?= $row->no_form ?></td>
                                <td><a target="_blank" href="<?= base_url('wrh/aluminium/cetakSjBon'); ?>/<?= $row->id_fppp ?>/<?= $row->id ?>" class="btn btn-xs btn-warning">Cetak Surat Jalan</a></td>
                            </tr>
                        <?php $i++;
                        endforeach; ?>
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
        $('#tableku tbody').on('click', 'td.details-control', function(e) {
            var tr = $(this).closest('tr');
            var td = $(this).closest('td');
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                dataRow = format(td[0].id, row, tr);
            }
        });

        function format(id, row, tr) {

            infoTable = '<table id="infoTable" class="table table-striped" border="1px" style="font-size: smaller;">' +
                '<tr>' +
                '<th bgcolor="#bfbfbf">No</th>' +
                '<th bgcolor="#bfbfbf">Section ATA</th>' +
                '<th bgcolor="#bfbfbf">section_allure</th>' +
                '<th bgcolor="#bfbfbf">Qty Aktual</th>' +
                '<th bgcolor="#bfbfbf">Out Dari Divisi</th>' +
                '<th bgcolor="#bfbfbf">Area Gudang</th>' +
                '<th bgcolor="#bfbfbf">Produksi</th>' +
                '<th bgcolor="#bfbfbf">Lapangan</th>' +
                '</tr>';

            var id_bon = $('#id_bon_' + id).val();

            $.ajax({
                    url: "<?= site_url('wrh/aluminium/getBonDetailTabel') ?>",
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        id_bon: id_bon,
                    },
                })
                .done(function(data) {
                    for (var i = 0; i < data.detail.length; i++) {
                        var no = i + 1;
                        var color = "white";
                        var fontcolor = "black";

                        infoTable += '<tr bgcolor="' + color + '">' +
                            '<td><font color="' + fontcolor + '">' + no + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].section_ata + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].section_allure + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].qty + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].divisi + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].gudang + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].produksi + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].lapangan + '</font></td>' +
                            '</tr>';

                    };

                    infoTable += '</table>';
                    row.child(infoTable).show();
                    tr.addClass('shown');
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    // console.log("complete");
                });

            return infoTable;
        }
    });
</script>