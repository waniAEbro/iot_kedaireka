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
                                <label>Alamat Proyek</label>
                                <input type="text" class="form-control" id="nama_proyek" value="<?= $alamat_proyek ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sales</label>
                                <input type="text" class="form-control" id="sales" value="<?= $sales ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Deadline Pengiriman</label>
                                <input type="text" class="form-control" id="deadline_pengiriman" value="<?= $deadline_pengiriman ?>" readonly>
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
                        <th>Kekurangan</th>
                        <th>Qty Gudang</th>
                        <th>Qty Aktual</th>
                        <th>Out Dari Divisi</th>
                        <th>Area Gudang</th>
                        <th>Produksi</th>
                        <th>Lapangan</th>
                        <th>Act</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($bom_aksesoris->result() as $row) :
                            $qtyTotalOut = @$total_out[$row->item_code][$row->id_fppp];
                            $kurang = $row->qty_bom - $qtyTotalOut;
                            $cekproduksi = ($row->produksi == 1) ? 'checked' : '';
                            $ceklapangan = ($row->lapangan == 1) ? 'checked' : '';
                            $getqtygdg = $this->m_aksesoris->getQtyGudang($row->item_code, $row->id_divisi, $row->id_gudang);
                            $qty_gudang = ($getqtygdg > 0) ? $getqtygdg : 0;
                            if ($row->kunci == 1) {

                        ?>
                                <tr>
                                    <td align="center"><?= $i++ ?></td>
                                    <td><?= $row->tgl_proses ?></td>
                                    <td><?= $row->item_code ?><br><?php echo button_confirm("Anda yakin mengirim parsial item " . $row->item_code . "?", "wrh/aksesoris/kirimparsial/" . $id_fppp . "/" . $row->id, "#content", 'Kirim Parsial', 'btn btn-xs btn-default', 'data-toggle="tooltip" title="Kirim Parsial"'); ?></td>
                                    <td><?= $row->deskripsi ?></td>
                                    <td><?= $row->qty_bom ?></td>
                                    <td><span id="qty_kurang_<?= $row->id ?>"><?= $kurang ?></span></td>
                                    <td><span id="qty_gudang_<?= $row->id ?>"><?= $qty_gudang ?></span></td>
                                    <td align="center"><span id="qty_bom_<?= $row->id ?>" class='edit'><?= $row->qty ?></span>
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
                                    <td><?php echo button_confirm("Anda yakin mengunci item " . $row->item_code . "?", "wrh/aksesoris/kuncidetailbom/" . $id_fppp . "/" . $row->id, "#content", 'Kunci', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Kunci"'); ?></td>
                                </tr>
                            <?php
                            } else { ?>
                                <tr>
                                    <td align="center"><?= $i++ ?></td>
                                    <td><?= $row->tgl_proses ?></td>
                                    <td><?= $row->item_code ?></td>
                                    <td><?= $row->deskripsi ?></td>
                                    <td><?= $row->qty_bom ?></td>
                                    <td><?= $kurang ?></td>
                                    <td><?= $qty_gudang ?></td>
                                    <td><?= $row->qty ?></td>
                                    <td><?= $row->divisi ?></td>
                                    <td><?= $row->gudang ?></td>
                                    <td><input type="checkbox" onclick="return false;" class="checkbox" <?= $cekproduksi ?>></td>
                                    <td><input type="checkbox" onclick="return false;" class="checkbox" <?= $ceklapangan ?>></td>
                                    <td>Terkunci</td>
                                </tr>
                            <?php }
                            ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php echo button_confirm("Anda yakin menyelesaikan stock out?", "wrh/aksesoris/finishdetailbom/" . $id_fppp, "#content", 'Finish', 'btn btn-success', 'data-toggle="tooltip" title="Finish"'); ?>
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
                console.log("divisi sukses!");
                if (response['qty_gudang'] == null) {
                    var qtygdg = 0;
                } else {
                    var qtygdg = response['qty_gudang'];
                }
                $('#qty_gudang_' + $id).html(qtygdg);
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
                console.log("gudang sukses!");
                if (response['qty_gudang'] == null) {
                    var qtygdg = 0;
                } else {
                    var qtygdg = response['qty_gudang'];
                }
                $('#qty_gudang_' + $id).html(qtygdg);
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

        if (fieldname == 'produksi') {
            $('#lapangan').prop('checked', false); // Unchecks it
        } else {
            $('#produksi').prop('checked', false); // Checks it
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
                console.log("cek list sukses!");
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

            var qtybom = $('#qty_bom_' + edit_id).html();
            var qty_gudang = $('#qty_gudang_' + edit_id).html();
            var qty_kurang = $('#qty_kurang_' + edit_id).html();
            if (parseInt(qty_gudang) < parseInt(value)) {
                alert("Tidak boleh melebihi Qty Gudang!");
                $(element).hide();
                $(element).prev('.edit').show();
                $(element).prev('.edit').text(qtybom);
            } else {
                if (parseInt(qty_kurang) < parseInt(value)) {
                    alert("Qty Terkirim sudah terpenuhi!");
                    $(element).hide();
                    $(element).prev('.edit').show();
                    $(element).prev('.edit').text(qtybom);
                } else {
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
                }
            }
        });
    });
</script>