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

<h1>Cetak <?=$is_memo?></h1>
<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr bgcolor="#ffe357">
            <th width="5%">No</th>
            <th>DIVISI</th>
            <th>KODE PROJECT</th>
            <th>BRAND</th>
            <th>NO. FPPP</th>
            <th>NAMA PROJECT</th>
            <th>SALES</th>
            <th>SM</th>
            <th>PENGIRIMAN</th>
            <th>WARNA</th>
            <th>JUMLAH GAMBAR / OP</th>
            <th>TOTAL UNIT</th>
            <th>TOTAL UNIT YANG DI HOLD / CANCEL</th>
            <th>KACA</th>
            <th>TGL FPPP</th>
            <th>DEADLINE SALES</th>
            <th>DEADLINE WORKSHOP</th>
            <th>STATUS ORDER</th>
            <th>NOTE</th>
            <th>ACC PROJECT</th>
            <th>ACC FINANCE (PRODUKSI)</th>
            <th>WH ALUMINIUM</th>
            <th>WH AKSESORIS</th>
            <th>WH KACA</th>
            <th>TOTAL UNIT FG</th>
            <th>ACC FINANCE (PENGIRIMAN)</th>
            <th>TOTAL KIRIM</th>
            <th>WS UPDATE</th>
            <th>SITE UPDATE (PEMASANGAN)</th>
            <th>SITE UPDATE (BST)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($fppp->result() as $row) {
            $ada = 1;
            $dw = ($row->deadline_workshop != '') ? $row->deadline_workshop : '-';
            $acc_project = ($row->acc_project != '') ? $row->acc_project : '-';
            $acc_fa = ($row->acc_fa != '') ? $row->acc_fa : '-';
            $acc_fa_pengiriman = ($row->acc_fa_pengiriman != '') ? $row->acc_fa_pengiriman : '-';
            $status_project_finance = ($row->status_project_finance != '') ? $row->status_project_finance : '-';
            if ($row->wh_aluminium == 1) {
                $wh_aluminium = "PROSES";
            } elseif ($row->wh_aluminium == 2) {
                $wh_aluminium = "PARSIAL";
            } else {
                $wh_aluminium = "LUNAS";
            }
            if ($row->wh_aksesoris == 3) {
                $wh_aksesoris = "LUNAS";
            } elseif ($row->wh_aksesoris == 2) {
                $wh_aksesoris = "PARSIAL";
            } else {
                $wh_aksesoris = "PROSES";
            }
            if ($row->wh_kaca == 3) {
                $wh_kaca = "LUNAS";
            } elseif ($row->wh_kaca == 2) {
                $wh_kaca = "PARSIAL";
            } else {
                $wh_kaca = "PROSES";
            }

            if ($row->ws_update == 3) {
                $ws_update = "LUNAS";
            } elseif ($row->ws_update == 2) {
                $ws_update = "PARSIAL";
            } else {
                $ws_update = "PROSES";
            }

            if ($row->site_update == 3) {
                $site_update = "LUNAS";
            } elseif ($row->site_update == 2) {
                $site_update = "PARSIAL";
            } else {
                $site_update = "PROSES";
            }

            if ($row->site_update_bst == 3) {
                $site_update_bst = "LUNAS";
            } elseif ($row->site_update_bst == 2) {
                $site_update_bst = "PARSIAL";
            } else {
                $site_update_bst = "PROSES";
            }

            $total_hold = @$get_total_hold[$row->id];
            $total_unit_fg = 0;
            $total_kirim = 0;
        ?>
            <tr>
                <td align="center"><?= $i ?></td>
                <td><?= $row->divisi ?><input type="hidden" id="id_fppp_<?= $i ?>" value="<?= $row->id ?>"></td>
                <td><?= $row->kode_proyek ?></td>
                <td>
                    <?php
                    echo $row->multi_brand_string;
                    ?>
                </td>
                <td><?= $row->no_fppp ?></td>
                <td><?= $row->nama_proyek ?></td>
                <td><?= $row->sales ?></td>
                <td><?= $row->pic_project ?></td>
                <td><?= $row->pengiriman ?><br><?= $row->alamat_proyek ?></td>
                <td><?= $row->warna ?></td>
                <td><?= $row->jumlah_gambar ?></td>
                <td><?= $row->jumlah_unit ?></td>
                <td><?= $total_hold ?></td>
                <td><?= $row->kaca ?></td>
                <td align="center"><?= $row->tgl_pembuatan ?></td>
                <td align="center"><?= $row->deadline_pengiriman ?></td>
                <td align="center"><?= $dw ?></td>
                <td><?= $row->status_order ?></td>
                <td><?= $row->note ?></td>
                <td><?= $acc_project ?></td>
                <td><?= $acc_fa ?></td>
                <td align="center"><?= $wh_aluminium ?></td>
                <td align="center"><?= $wh_aksesoris ?></td>
                <td align="center"><?= $wh_kaca ?></td>
                <td align="center"><?= $total_unit_fg ?></td>
                <td align="center"><?= $acc_fa_pengiriman ?></td>
                <td align="center"><?= $total_kirim ?></td>
                <td><span id="ws_update_<?= $row->id ?>"><?= $ws_update ?></span></td>
                <td><span id="site_update_<?= $row->id ?>"><?= $site_update ?></span></td>
                <td><span id="site_update_bst_<?= $row->id ?>"><?= $site_update_bst ?></span></td>

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