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

<h1>Cetak WO list</h1>
<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr bgcolor="#ffe357">
            <th width="5%">No</th>
            <th>Tgl Input</th>
            <th>Tgl Order</th>
            <th>Divisi</th>
            <th>NO PR / WO / PO:</th>
            <th>Item Code</th>
            <th>Qty WO</th>
            <th>Qty In</th>
            <th>Qty Sisa</th>
            <th>Keterangan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($wo->result() as $row) {
            $qty_in = @$total_in[$row->id_item][$row->no_wo];
            $qty_sisa = $row->qty_wo - $qty_in;

            if ($qty_sisa == 0) {
                $status = 'Lunas';
            } elseif ($qty_sisa > 0) {
                $status = 'Kurang';
            } else {
                $status = 'Lebih';
            }
        ?>
            <tr>
                <td align="center"><?= $i++ ?></td>
                <td><?= $row->created ?></td>
                <td><?= $row->tgl_order ?></td>
                <td><?= $row->divisi ?></td>
                <td><?= $row->no_wo ?></td>
                <td><?= $row->item_code ?></td>
                <td align="center"><?= $row->qty_wo ?></td>
                <td align="center"><?= $qty_in ?></td>
                <td align="center"><?= $qty_sisa ?></td>
                <td><?= $row->keterangan ?></td>
                <td><?= $status ?></td>

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