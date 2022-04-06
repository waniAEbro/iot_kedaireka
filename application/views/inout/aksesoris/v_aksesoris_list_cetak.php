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

<h1>Rekap In Aksesoris</h1>
<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr bgcolor="#ffe357">
            <th width="5%">No</th>
            <th>Tgl Aktual</th>
            <th>Tgl Input</th>
            <th>Stok Awal Bulan</th>
            <th>Item Code</th>
            <th width="25%">Deskripsi</th>
            <th>Satuan</th>
            <th>Qty</th>
            <th>Divisi</th>
            <th>Gudang</th>
            <th>Keranjang</th>
            <th>Supplier</th>
            <th>NO Surat Jalan</th>
            <th>NO PR/WO</th>
            <th>Keterangan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($aksesoris->result() as $row) {
            $sts = ($row->mutasi == 0) ? "Stock" : "Mutasi";
            $qty = ($row->inout == 1) ? $row->qty_in : $row->qty_out;
            $awal_bulan = ($row->awal_bulan == 1) ? 'YA' : 'TIDAK';
        ?>
            <tr>
                <td align="center"><?= $i++ ?></td>
                <td><?= $row->aktual ?></td>
                <td><?= $row->tgl_stok ?></td>
                <td><?= $awal_bulan ?></td>
                <td><?= $row->item_code ?></td>
                <td><?= $row->deskripsi ?></td>
                <td><?= $row->satuan ?></td>
                <td><?= $qty ?></td>
                <td><?= $row->divisi_aksesoris ?></td>
                <td><?= $row->gudang ?></td>
                <td><?= $row->keranjang ?></td>
                <td><?= $row->supplier ?></td>
                <td><?= $row->no_surat_jalan ?></td>
                <td><?= $row->no_pr ?></td>
                <td><?= $row->keterangan ?></td>
                <td><?= $sts ?></td>
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