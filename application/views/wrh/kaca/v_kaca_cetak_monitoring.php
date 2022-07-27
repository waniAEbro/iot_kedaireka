<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" media="all" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" media="all" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

<h1>Cetak Monitoring <?= $jenis_barang ?></h1>
<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr bgcolor="#ffe357">
            <th width="5%">No</th>
            <th>Item Code</th>
            <th>Deskripsi</th>
            <th>Lebar</th>
            <th>Tinggi</th>
            <th>Area</th>
            <th>Satuan</th>
            <th>Divisi</th>
            <th>Gudang</th>
            <th>Area</th>
            <th>Stock Awal Bulan</th>
            <th>Total In</th>
            <th>Total Out</th>
            <th>Rata-rata</th>
            <th>Qty</th>
            <?php if (from_session('id') == 2) { ?>
            <th>Qty Counter</th>
            <th>beda</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($kaca->result() as $row) {
            $stok_awal_bulan = @$qty_awal_bulan[$row->id_item][$row->id_divisi][$row->id_gudang][$row->keranjang];
            $stok_masuk = @$qty_masuk[$row->id_item][$row->id_divisi][$row->id_gudang][$row->keranjang];
            $stok_keluar = @$qty_keluar[$row->id_item][$row->id_divisi][$row->id_gudang][$row->keranjang];
            // $stock_awal_bulan = $stok_awal_bulan + $stok_masuk - $stok_keluar;
            // $stock_awal_bulan = @$s_awal_bulan[$row->id_item][$row->id_divisi][$row->id_gudang][$row->keranjang];
            $total_in = @$s_total_in[$row->id_item][$row->id_divisi][$row->id_gudang][$row->keranjang];
            $total_out = @$s_total_out[$row->id_item][$row->id_divisi][$row->id_gudang][$row->keranjang];
            $total_akhir = $stock_awal_bulan + $total_in - $total_out;
            if ($total_akhir != $row->qty) {
                $beda = 1;
            } else {
                $beda = 0;
            }
        ?>
            <tr>
                <td align="center"><?= $i++ ?></td>
                <td><?= $row->item_code ?></td>
                    <td><?= $row->deskripsi ?></td>
                <td><?= $row->lebar ?></td>
                <td><?= $row->tinggi ?></td>
                <td><?= $row->area ?></td>
                <td><?= $row->satuan ?></td>
                <td><?= $row->divisi ?></td>
                <td><?= $row->gudang ?></td>
                <td><?= $row->keranjang ?></td>
                <td><?= $stok_awal_bulan ?></td>
                <td><?= $total_in ?></td>
                <td><?= $total_out ?></td>
                <td><?= $row->rata_pemakaian ?></td>
                <td align="center"><?= $total_akhir ?></td>
                <?php if (from_session('id') == 2) { ?>
                <td align="center"><?= $row->qty ?></td>
                <td align="center"><?= $beda ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>


<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>