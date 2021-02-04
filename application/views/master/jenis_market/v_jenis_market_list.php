<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Master Jenis Market</h3>

                <div class="box-tools pull-right">
                    <?php
                    $sesi = from_session('level');
                    if ($sesi == '1' || $sesi == '2') {
                        echo button('load_silent("master/jenis_market/form/base","#modal")', 'Add New Jenis Market', 'btn btn-success');
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
                        <th>Jenis Market</th>
                        <th>Act</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($jenis_market->result() as $row) : ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->jenis_market ?></td>
                                <td align="center">
                                    <?php
                                    $sesi = from_session('level');
                                    if ($sesi == '1' || $sesi == '2') {
                                        echo button('load_silent("master/jenis_market/form/sub/' . $row->id . '","#modal")', '', 'btn btn-info fa fa-edit', 'data-toggle="tooltip" title="Edit"');
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
            "ordering": false,
            "scrollX": true,
        });
    });
</script>