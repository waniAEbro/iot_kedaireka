<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Laporan Penjualan</h3>
                <div class="box-tools pull-right">
                    <input type="button" target="_blank" class="btn btn-default" onclick="printDiv('printableArea')" value="Print Page" />
                </div>
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
                                <input type="text" data-date-format="yyyy-mm-dd" value="<?= $tgl_awal ?>" class="form-control datepicker" id="tgl_awal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Akhir</label>
                                <input type="text" data-date-format="yyyy-mm-dd" value="<?= $tgl_akhir ?>" class="form-control datepicker" id="tgl_akhir">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-tools pull-right">
                                <a class="btn btn-success" onclick="setAplikator()">Set Filter</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="box-body" id="printableArea">
                <table width="100%" id="" class="table table-striped" border="1">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Total Qty Pembelian Produk</th>
                        <th>Nilai Tagihan</th>
                        <th>Presentase /Unit</th>
                        <th>Presentase /Rupiah</th>
                    </thead>
                    <tbody>
                        <?php
                        $total_item = 0;
                        $total_nilai = 0;
                        foreach ($jenis_barang->result() as $val) : ?>
                            <tr>
                                <td bgcolor="#f0fff9" colspan="6"><b><?= $val->jenis_barang ?></b></td>
                            </tr>
                            <?php foreach ($jenis_market->result() as $jm) : ?>
                                <tr>
                                    <td bgcolor="#c7ffd6"></td>
                                    <td bgcolor="#c7ffd6" colspan="5"><b><?= $jm->jenis_market ?></b></td>
                                </tr>
                                <?php
                                $store = $this->m_laporan_keuangan->getStore($val->id, $jm->id, $tgl_awal, $tgl_akhir);
                                $i = 1;
                                foreach ($store->result() as $row) {
                                    // $totInv = @$totalPermintaan[$row->id][$val->id];
                                    // $NilaiInv = @$nilaiPermintaan[$row->id][$val->id];
                                    $totInv = $row->tot_qty;
                                    $NilaiInv = $row->tot_harga;
                                    $total_item = $total_item + $totInv;
                                    $total_nilai = $total_nilai + $NilaiInv;
                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= button('load_silent("klg/laporan_keuangan/detail/' . $row->id . '/' . $tgl_awal . '/' . $tgl_akhir . '","#content")', 'detail', 'btn btn-xs btn-danger', 'data-toggle="tooltip" title="Detail"'); ?><?= $row->store ?></td>
                                        <td align="center"><?= $totInv ?></td>
                                        <td align="right"><?= number_format($NilaiInv, 2, ',', '.') ?></td>
                                        <td align="center"><?= number_format($totInv / $alltotInv * 100, 2) ?> %</td>
                                        <td align="center"><?= number_format($NilaiInv / $allNilaiInv * 100, 2) ?> %</td>
                                    </tr>
                                <?php } ?>

                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td bgcolor="#08c5ff" colspan="2"><b>Total</b></td>
                            <td bgcolor="#08c5ff" align="center"><b><?= $total_item ?></b></td>
                            <td bgcolor="#08c5ff" align="right"><b><?= number_format($total_nilai, 2, ',', '.') ?></b></td>
                            <td bgcolor="#08c5ff" align="center"><b><?= '100%' ?></b></td>
                            <td bgcolor="#08c5ff" align="center"><b><?= '100%' ?></b></td>
                        </tr>
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
    });

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
        load_silent("klg/laporan_keuangan/diSet/" + tlg1 + "/" + tgl2 + "/", "#content");

    }
</script>