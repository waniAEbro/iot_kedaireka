<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Master barang</h3>

                <div class="box-tools pull-right">
                    <?php
                    $sesi = from_session('level');
                    if ($sesi <= '3') {
                        echo button('load_silent("master/barang/import/","#content")', 'Import Excel', 'btn btn-primary', 'data-toggle="tooltip" title="Import Excel"');
                        echo button('load_silent("master/barang/show_addForm/","#content")', 'Add New Barang', 'btn btn-success', 'data-toggle="tooltip" title="Add New Barang"');
                    } else {
                        # code...
                    }
                    ?>
                </div>
            </div>

            <div class="box-body">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Brand</th>
                        <th>Nama Barang</th>
                        <th>Gambar</th>
                        <th>Keterangan</th>
                        <th>Act</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($barang->result() as $row) :
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $row->brand ?></td>
                                <td><?= $row->barang ?></td>
                                <td align="center">
                                    <?php
                                    if ($row->gambar != '') { ?>
                                        <img src="<?= $row->gambar ?>" width="50">
                                    <?php } ?>
                                </td>
                                <td align="right"><?= $row->keterangan ?></td>
                                <td align="center">
                                    <?php
                                    $sesi = from_session('level');
                                    if ($sesi <= '3') {
                                        echo button('load_silent("master/barang/show_editForm/' . $row->id . '","#content")', 'Edit', 'btn btn-info', 'data-toggle="tooltip" title="Edit barang"');
                                        echo button_confirm('Apakah Anda Yakin menghapus barang ini?', 'master/barang/delete/' . $row->id, '#content', 'Delete', 'btn btn-danger', 'data-toggle="tooltip" title="Delete barang"');
                                    } else {
                                        # code...
                                    }
                                    ?>
                                </td>
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