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

<h1>List Master Aluminium</h1>
<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr bgcolor="#ffe357">
            <th width="5%">No</th>
            <th>Section ATA</th>
            <th>Section Allure</th>
            <th>Temper</th>
            <th>Warna</th>
            <th width="25%">Deskripsi Warna</th>
            <th>Ukuran</th>
            <th>Perimeter Berat</th>
            <th>Perimeter MF</th>
            <th>Perimeter Coating</th>
            <th>Satuan</th>
            <th>Rata Pemakaian</th>
            <th>Min Stock</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        $all_item = 0;
        foreach ($aluminium->result() as $row) {
        ?>
            <tr>
                <td align="center"><?= $i++ ?></td>
                <td><?= $row->section_ata ?></td>
                <td><?= $row->section_allure ?></td>
                <td><?= $row->temper ?></td>
                <td><?= $row->kode_warna ?></td>
                <td><?= $row->warna ?></td>
                <td><?= $row->ukuran ?></td>
                <td><?= $row->perimeter_berat ?></td>
                <td><?= $row->perimeter_mf ?></td>
                <td><?= $row->perimeter_coating ?></td>
                <td><?= $row->satuan ?></td>
                <td><?= $row->rata_pemakaian ?></td>
                <td><?= $row->min_stock ?></td>
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