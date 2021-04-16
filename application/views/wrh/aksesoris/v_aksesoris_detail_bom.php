<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List BOM Aksesoris</h3>
                <div class="box-tools pull-right">
                    <?php //echo button('load_silent("klg/fppp","#content")', 'Kembali', 'btn btn-success'); 
                    ?>
                </div>
            </div>
            <div class="box-body">
                <form method="post" class="form-vertical form_faktur" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>No FPPP</label>
                                <input type="hidden" class="form-control" id="id_fppp" value="<?= $id_fppp ?>" readonly>
                                <input type="text" class="form-control" id="no_fppp" value="<?= $no_fppp ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Proyek</label>
                                <input type="text" class="form-control" id="nama_proyek" value="<?= $nama_proyek ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pengiriman</label>
                                <input type="text" class="form-control" id="alamat_pengiriman" value="<?= $alamat_pengiriman ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Warna</label>
                                <input type="text" class="form-control" id="warna" value="<?= $warna ?>" readonly>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-footer">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Tgl Proses</th>
                        <th>Item Code</th>
                        <th>Deskripsi</th>
                        <th>Qty BOM</th>
                        <th>Qty Aktual</th>
                        <th>Out Dari Divisi</th>
                        <th>Area Gudang</th>
                        <th>Produksi</th>
                        <th>Lapangan</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($bom_aksesoris->result() as $row) :
                            $cekproduksi = ($row->produksi == 1) ? 'checked' : '';
                            $ceklapangan = ($row->lapangan == 1) ? 'checked' : '';
                        ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->tgl_proses ?></td>
                                <td><?= $row->item_code ?></td>
                                <td><?= $row->deskripsi ?></td>
                                <td><?= $row->qty_bom ?></td>
                                <td align="center"><span class='edit'><?= $row->qty ?></span>
                                    <input type='text' class='txtedit' data-id='<?= $row->id ?>' data-field='qty' id='<?= $row->id ?>' value='<?= $row->qty ?>'>
                                </td>
                                <td>
                                    <?= form_dropdown('id_divisi', $divisi,  $row->id_divisi, 'id="id_divisi_' . $row->id . '" onchange="divisi(' . $row->id . ')" data-id="' . $row->id . '" data-field="id_divisi" class="form-control"') ?>
                                </td>
                                <td>
                                    <?= form_dropdown('id_gudang', $gudang,  $row->id_gudang, 'id="id_gudang_' . $row->id . '" onchange="gudang(' . $row->id . ')" data-id="' . $row->id . '" data-field="id_gudang" class="form-control"') ?>
                                </td>
                                <td><input type="checkbox" id="produksi" data-id='<?= $row->id ?>' data-field='produksi' class="checkbox" <?= $cekproduksi ?>></td>
                                <td><input type="checkbox" id="lapangan" data-id='<?= $row->id ?>' data-field='lapangan' class="checkbox" <?= $ceklapangan ?>></td>
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
            "paging": false,
            "scrollX": true,
        });
    });

    function divisi($id) {
        var fieldname = 'id_divisi';
        var value = $('#id_divisi_' + $id).val();
        var edit_id = $id;
        // Send AJAX request
        $.ajax({
            url: "<?= site_url('wrh/aksesoris/saveout/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                field: fieldname,
                value: value,
                id: edit_id,
            },
            success: function(response) {
                $.growl.notice({
                    title: 'Sukses',
                    message: "Data Updated!"
                });
                // load_silent("klg/pendapatan", "#content");
            }
        })
    }

    function gudang($id) {
        var fieldname = 'id_gudang';
        var value = $('#id_gudang_' + $id).val();
        var edit_id = $id;
        // Send AJAX request
        $.ajax({
            url: "<?= site_url('wrh/aksesoris/saveout/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                field: fieldname,
                value: value,
                id: edit_id,
            },
            success: function(response) {
                $.growl.notice({
                    title: 'Sukses',
                    message: "Data Updated!"
                });
                // load_silent("klg/pendapatan", "#content");
            }
        })
    }

    $(".checkbox").change(function() {
        if (this.checked) {
            var fieldname = $(this).data('field');
            var value = 1;
            var edit_id = $(this).data('id');
            // Send AJAX request
        } else {
            var fieldname = $(this).data('field');
            var value = 0;
            var edit_id = $(this).data('id');
        }

        $.ajax({
            url: "<?= site_url('wrh/aksesoris/saveout/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                field: fieldname,
                value: value,
                id: edit_id,
            },
            success: function(response) {
                $.growl.notice({
                    title: 'Sukses',
                    message: "Data Updated!"
                });
                // load_silent("klg/pendapatan", "#content");
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.txtedit').hide();
        // On text click
        $('.edit').click(function() {
            // Hide input element
            $('.txtedit').hide();

            // Show next input element
            $(this).next('.txtedit').show().focus();

            // Hide clicked element
            $(this).hide();
        });

        // Focus out from a textbox
        $('.txtedit').focusout(function() {
            // Get edit id, field name and value
            var fieldname = $(this).data('field');
            var value = $(this).val();
            var edit_id = $(this).data('id');

            // assign instance to element variable
            var element = this;

            // Send AJAX request
            $.ajax({
                url: "<?= site_url('wrh/aksesoris/saveout/') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    field: fieldname,
                    value: value,
                    id: edit_id,
                },
                success: function(response) {

                    // Hide Input element
                    $(element).hide();

                    // Update viewing value and display it
                    $(element).prev('.edit').show();
                    $(element).prev('.edit').text(value);
                    $.growl.notice({
                        title: 'Sukses',
                        message: "Data Updated!"
                    });
                    // load_silent("klg/pendapatan", "#content");
                }
            });
        });
    });
</script>