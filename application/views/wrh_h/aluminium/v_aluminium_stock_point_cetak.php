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

<h1>Cetak Stok Point Aluminium Tanggal <?= $tgl ?></h1>
<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr bgcolor="#ffe357">
            <th width="5%">No</th>
            <th>Item Code</th>
            <th>Warna</th>
            <th>Gudang</th>
            <th>Keranjang/Rak</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($list_data->result() as $row) :
            $stok_awal_bulan = @$qty_awal_bulan[$row->id_item][$row->id_gudang][$row->keranjang];
            $stok_masuk = @$qty_masuk[$row->id_item][$row->id_gudang][$row->keranjang];
            $stok_keluar = @$qty_keluar[$row->id_item][$row->id_gudang][$row->keranjang];
            $qty_total = $stok_awal_bulan + $stok_masuk - $stok_keluar;
        ?>
            <tr>
                <td align="center"><?= $i++ ?></td>
                <td><?= $row->item_code ?></td>
                <td><?= $row->warna ?></td>
                <td><?= $row->gudang ?></td>
                <td align="center"><?= $row->keranjang ?></td>
                <td align="center">
                    <?= $qty_total ?>
                </td>
            </tr>

        <?php endforeach; ?>
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