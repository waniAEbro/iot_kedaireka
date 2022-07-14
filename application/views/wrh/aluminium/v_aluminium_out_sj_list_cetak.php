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

<h1>Cetak Stock Out List Aluminium RSD</h1>
<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr bgcolor="#ffe357">
            <th width="5%">No</th>
            <th>Tgl Sistem</th>
            <th>Tgl Aktual</th>
            <th>No Surat Jalan</th>
            <th>No FPPP</th>
            <th>Nama Proyek</th>
            <th>Deadline Sales</th>
            <th>Deadline Workshop</th>
            <th>Penerima</th>
            <th>Alamat Pengiriman</th>
            <th>Sopir</th>
            <th>No Kendaraan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($surat_jalan->result() as $row) {
            $lapangan = @$keterangan[$row->id];
            $ket = ($lapangan > 0) ? 'Lapangan' : 'Produksi';
        ?>
            <tr>
                <td align="center"><?= $i++ ?></td>
                <td align="center"><?= $row->created ?></td>
                <td align="center"><?= $row->tgl_aktual ?></td>
                <td><?= $row->no_surat_jalan ?></td>
                <td><?= $row->no_fppp ?></td>
                <td><?= $row->nama_proyek ?></td>
                <td align="center"><?= $row->deadline_pengiriman ?></td>
                <td align="center"><?= $row->deadline_workshop ?></td>
                <td><?= $row->penerima ?></td>
                <td><?= $row->alamat_pengiriman ?></td>
                <td><?= $row->sopir ?></td>
                <td><?= $row->no_kendaraan ?></td>
                <td><?= $ket ?></td>


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