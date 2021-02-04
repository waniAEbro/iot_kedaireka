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
        <div class="box-header with-border">
            <h3 class="box-title">List FPPP RESIDENTIAL</h3>

            <div class="box-tools pull-right">
                <?php
                $sesi = from_session('level');
                if ($sesi == '1' || $sesi == '2') {
                    echo button('load_silent("klg/fppp/formAdd/1","#content")', 'Tambah FPPP', 'btn btn-success');
                }
                ?>
                <input type="button" target="_blank" class="btn btn-default" onclick="printDiv('printableArea')" value="Print Page" />
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
                        <th>TGL PEMBUATAN</th>
                        <th>APPLICANT</th>
                        <th>APPLICANT SECTOR</th>
                        <th>AUTHORIZED DISTRIBUTOR</th>
                        <th>NO. FPPP</th>
                        <th>NAMA PROYEK</th>
                        <th>TAHAP</th>
                        <th>ALAMAT PROYEK</th>
                        <th>STATUS ORDER</th>
                        <th>NOTE DARI NO. FPPP / NCR</th>
                        <th>PENGIRIMAN</th>
                        <th>DEADLINE PENGIRIMAN</th>
                        <th>METODE PENGIRIMAN</th>
                        <th>PENGGUNAAN PETI</th>
                        <th>PENGGUNAAN SEALANT</th>
                        <th>WARNA ALUMINIUM</th>
                        <th>WARNA LAINNYA</th>
                        <th>WARNA SEALANT</th>
                        <th>DITUJUKAN KEPADA</th>
                        <th>NO. TELEPON TUJUAN</th>
                        <th>NAMA & ALAMAT EKSPEDISI</th>
                        <th>NAMA SALES MARKETING</th>
                        <th>NAMA SM / PIC PROJECT</th>
                        <th>ADMIN KOORDINATOR</th>
                        <th>KACA</th>
                        <th>JENIS KACA</th>
                        <th>LOGO KACA</th>
                        <th>JUMLAH GAMBAR / OPENING</th>
                        <th>NOTE</th>
                        <th>Act</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($fppp->result() as $row) :
                            $ada = 1;
                        ?>
                            <tr>
                                <?php if ($ada > 0) { ?>
                                    <td class="details-control" id="<?= $i ?>"></td>
                                <?php } else { ?>
                                    <td></td>
                                <?php }  ?>
                                <td align="center"><?= $i ?></td>
                                <td><?= $row->tgl_pembuatan ?><input type="hidden" id="id_fppp_<?= $i ?>" value="<?= $row->id ?>"></td>
                                <td><?= $row->applicant ?></td>
                                <td><?= $row->applicant_sector ?></td>
                                <td><?= $row->authorized_distributor ?></td>
                                <td><?= $row->no_fppp ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td><?= $row->tahap ?></td>
                                <td><?= $row->alamat_proyek ?></td>
                                <td><?= $row->status_order ?></td>
                                <td><?= $row->note_fppp ?></td>
                                <td><?= $row->pengiriman ?></td>
                                <td><?= $row->deadline_pengiriman ?></td>
                                <td><?= $row->id_metode_pengiriman ?></td>
                                <td><?= $row->id_penggunaan_peti ?></td>
                                <td><?= $row->id_penggunaan_sealant ?></td>
                                <td><?= $row->ditujukan_kepada ?></td>
                                <td><?= $row->no_telp_tujuan ?></td>
                                <td><?= $row->pengiriman_ekspedisi ?></td>
                                <td><?= $row->sales ?></td>
                                <td><?= $row->pic_project ?></td>
                                <td><?= $row->admin_koordinator ?></td>
                                <td><?= $row->id_kaca ?></td>
                                <td><?= $row->jenis_kaca ?></td>
                                <td><?= $row->jumlah_gambar ?></td>
                                <td><?= $row->note ?></td>
                                <td align="center">
                                    <?php if ($row->attachment != '') { ?>
                                        <a target="_blank" href="<?= base_url($row->attachment); ?>" class="btn btn-xs btn-danger">Attachment</a>
                                    <?php } ?>

                                    <?php
                                    if (from_session('id') < 3) {
                                        echo button('load_silent("klg/fppp/formEdit/' . $row->id . '","#content")', 'Edit khusus', 'btn btn-xs btn-info', 'data-toggle="tooltip" title="Edit"');
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
<script type="text/javascript">
    $(function() {
        var tableContainer = $(".large-table-container-3");
        var table = $(".large-table-container-3 table");
        var fakeContainer = $(".large-table-fake-top-scroll-container-3");
        var fakeDiv = $(".large-table-fake-top-scroll-container-3 div");

        var tableWidth = table.width();
        fakeDiv.width(tableWidth);

        fakeContainer.scroll(function() {
            tableContainer.scrollLeft(fakeContainer.scrollLeft());
        });
        tableContainer.scroll(function() {
            fakeContainer.scrollLeft(tableContainer.scrollLeft());
        });
    })

    function printDiv(divName) {
        // var printContents = document.getElementById(divName).innerHTML;
        // var originalContents = document.body.innerHTML;

        // document.body.innerHTML = printContents;
        // window.print();

        // document.body.innerHTML = originalContents;

        var mywindow = window.open('', 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head><title>' + document.title + '</title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<h1>' + document.title + '</h1>');
        mywindow.document.write(document.getElementById(divName).innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;
    }
    // function cetak (id) {
    //   var win = window.open("<?php echo base_url('klg/fppp/cetak/'); ?>/"+id, "_blank");
    //             if (win) {
    //                 //Browser has allowed it to be opened
    //                 win.focus();
    //             } else {
    //                 //Browser has blocked it
    //                 alert('Please allow popups for this website');
    //             }
    // }

    function setFilter() {
        var store = $('#store').val();
        if (store != '') {
            var id_store = store;
        } else {
            var id_store = 'x';
        };
        var bulan = $('#bulan').val();
        if (bulan != '') {
            var id_bulan = bulan;
        } else {
            var id_bulan = 'x';
        };
        var tahun = $('#tahun').val();
        load_silent("klg/fppp/filter/" + id_store + "/" + id_bulan + "/" + tahun + "/", "#content");

    }

    $(document).ready(function() {
        $("select").select2();
        var table = $('#tableku').DataTable({
            "ordering": true,
            // "scrollX": true,
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
                '<th bgcolor="#bfbfbf">Brand</th>' +
                '<th bgcolor="#bfbfbf">Kode Opening</th>' +
                '<th bgcolor="#bfbfbf">Kode Unit</th>' +
                '<th bgcolor="#bfbfbf">Item</th>' +
                '<th bgcolor="#bfbfbf">Glass Thick</th>' +
                '<th bgcolor="#bfbfbf">Finish Coating</th>' +
                '<th bgcolor="#bfbfbf">Qty</th>' +
                '</tr>';

            var id_fppp = $('#id_fppp_' + id).val();

            $.ajax({
                    url: "<?= site_url('klg/fppp/getDetailTabel') ?>",
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        id_fppp: id_fppp,
                    },
                })
                .done(function(data) {
                    // console.log(data.detail);
                    var total_semua = 0;
                    var total_cbm = 0;
                    for (var i = 0; i < data.detail.length; i++) {
                        var no = i + 1;
                        var color = "white";
                        var fontcolor = "black";

                        infoTable += '<tr bgcolor="' + color + '">' +
                            '<td><font color="' + fontcolor + '">' + no + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].brand + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].kode_opening + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].kode_unit + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].item + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].glass_thick + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].finish_coating + '</font></td>' +
                            '<td><font color="' + fontcolor + '">' + data.detail[i].qty + '</font></td>' +
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