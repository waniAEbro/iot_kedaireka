<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">BOM tidak tersimpan</h3>
            </div>

            <div class="box-body">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Jenis Item</th>
                        <th>Item Code</th>
                        <th>FPPP</th>
                        <th>Nama Proyek</th>
                        <th>Act</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($bomtemp->result() as $row) :
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $row->jenis_item ?></td>
                                <td><?= $row->item_code ?></td>
                                <td><?= $row->no_fppp ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td><?php echo button_confirm("Anda yakin menghapus " . $row->item_code . "?", "klg/bom_temp/hapus/" . $row->id, "#content", 'Delete', 'btn btn-danger btn-block', 'data-toggle="tooltip" title="Delete"'); ?></td>
                            </tr>

                        <?php endforeach; ?>
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
    });
</script>