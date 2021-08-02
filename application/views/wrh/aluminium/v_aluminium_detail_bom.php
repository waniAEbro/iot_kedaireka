<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List BOM aluminium</h3>
                <div class="box-tools pull-right">
                    <?php //echo button('load_silent("klg/fppp","#content")', 'Kembali', 'btn btn-success'); 
                    ?>
                </div>
            </div>
            <div class="box-body">
                <form method="post" class="form-vertical form_faktur" role="form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>No FPPP</label>
                                <input type="hidden" class="form-control" id="id_fppp" value="<?= $id_fppp ?>" readonly>
                                <input type="hidden" class="form-control" id="id_sj" value="<?= $id_sj ?>" readonly>
                                <input type="text" class="form-control" id="no_fppp" value="<?= $no_fppp ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>No Surat Jalan</label>
                                <input type="text" class="form-control" value="<?= $no_surat_jalan ?>" id="no_surat_jalan" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Proyek</label>
                                <input type="text" class="form-control" id="nama_proyek" value="<?= $nama_proyek ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Alamat Proyek</label>
                                <input type="text" class="form-control" id="alamat_proyek" value="<?= $alamat_proyek ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Sales</label>
                                <input type="text" class="form-control" id="sales" value="<?= $sales ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Deadline Pengiriman</label>
                                <input type="text" class="form-control" id="deadline_pengiriman" value="<?= $deadline_pengiriman ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Penerima</label>
                                <input type="text" class="form-control" value="<?= $penerima ?>" id="penerima">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Alamat Pengiriman</label>
                                <input type="text" class="form-control" value="<?= $alamat_pengiriman ?>" id="alamat_pengiriman">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sopir</label>
                                <input type="text" class="form-control" value="<?= $sopir ?>" id="sopir">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>No Kendaraan</label>
                                <input type="text" class="form-control" value="<?= $no_kendaraan ?>" id="no_kendaraan">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-footer">
                <button type="submit" id="update" onclick="update()" id="proses" class="btn btn-success">Update</button>
            </div>
            <div class="box-footer">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>Section ATA</th>
                        <th>Section Allure</th>
                        <th>Temper</th>
                        <th>Kode Warna</th>
                        <th>Ukuran</th>
                        <th>Qty BOM</th>
                        <th>Kekurangan</th>
                        <th>Qty Gudang</th>
                        <th>Out Dari Divisi</th>
                        <th>Area Gudang</th>
                        <th>Keranjang</th>
                        <th>Qty Aktual</th>
                        <th>Produksi</th>
                        <th>Lapangan</th>
                        <?php if (from_session('level') < 3) { ?>
                            <th>Act</th>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($list_bom_sj->result() as $row) :
                            $qtyTotalOut = $this->m_aluminium->getQtyOutFppp($row->id_fppp, $row->id_item);
                            $qtyBOM = $row->qty_bom;
                            $kurang = $qtyBOM - $qtyTotalOut;
                            $cekproduksi = ($row->produksi == 1) ? 'checked' : '';
                            $ceklapangan = ($row->lapangan == 1) ? 'checked' : '';
                            $qtyin           = $this->m_aluminium->getQtyInDetailTabel($row->id_item, $row->id_divisi, $row->id_gudang, $row->keranjang);
                            $qtyout          = $this->m_aluminium->getQtyOutDetailTabel($row->id_item, $row->id_divisi, $row->id_gudang, $row->keranjang);
                            // $qty_gudang = ($getqtygdg > 0) ? $getqtygdg : 0;
                            $qty_gudang = $qtyin - $qtyout;
                            $totalgudang = $qty_gudang;
                            if ($row->kunci == 1) {

                        ?>
                                <tr>
                                    <td align="center"><?= $i++ ?></td>
                                    <td><?= $row->section_ata ?>
                                        <br><?php //echo button_confirm("Anda yakin mengirim parsial item " . $row->section_ata . "?", "wrh/aluminium/kirimparsial/" . $id_fppp . "/" . $row->id_stock, "#content", 'Kirim Parsial', 'btn btn-xs btn-default', 'data-toggle="tooltip" title="Kirim Parsial"'); 
                                            ?>
                                    </td>
                                    <td><?= $row->section_allure ?></td>
                                    <td><?= $row->temper ?></td>
                                    <td><?= $row->warna_aluminium ?></td>
                                    <td><?= $row->ukuran ?></td>
                                    <td align="center"><?= $qtyBOM ?></td>
                                    <td align="center"><span id="qty_kurang_<?= $row->id_stock ?>"><?= $kurang ?></span></td>
                                    <td align="center"><span id="qty_gudang_<?= $row->id_stock ?>"><?= $totalgudang ?></span></td>
                                    <td style="background-color:#ffd45e">
                                        <select id="id_divisi_<?= $row->id_stock ?>" onchange="divisi(<?= $row->id_stock ?>)" data-id="<?= $row->id_stock ?>" data-field="id_divisi" class="form-control">
                                            <option id="">Pilih</option>
                                            <?php foreach ($divisi->result() as $key) {
                                                $selected1 = ($key->id == $row->id_divisi) ? "selected" : "";
                                            ?>
                                                <option value="<?= $key->id ?>" <?= $selected1 ?>><?= $key->divisi ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td style="background-color:#ffd45e">
                                        <select id="id_gudang_<?= $row->id_stock ?>" onchange="gudang(<?= $row->id_stock ?>)" data-id="<?= $row->id_stock ?>" data-field="id_gudang" class="form-control">
                                            <option id="">Pilih</option>
                                            <?php foreach ($gudang->result() as $key) {
                                                $selected2 = ($key->id == $row->id_gudang) ? "selected" : "";
                                            ?>
                                                <option value="<?= $key->id ?>" <?= $selected2 ?>><?= $key->gudang ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td style="background-color:#ffd45e">
                                        <select id="keranjang_<?= $row->id_stock ?>" onchange="keranjang(<?= $row->id_stock ?>)" data-id="<?= $row->id_stock ?>" data-field="keranjang" class="form-control">
                                            <option id="">Pilih</option>
                                            <?php foreach ($keranjang->result() as $key) {
                                                $selected2 = ($key->keranjang == $row->keranjang) ? "selected" : "";
                                            ?>
                                                <option value="<?= $key->keranjang ?>" <?= $selected2 ?>><?= $key->keranjang ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td style="background-color:#ffd45e" align="center"><span id="qty_bom_<?= $row->id_stock ?>" class='edit'><?= $row->qty_out ?></span>
                                        <input type='text' class='txtedit' data-id='<?= $row->id_stock ?>' data-field='qty_out' id='<?= $row->id_stock ?>' value='<?= $row->qty_out ?>'>
                                    </td>
                                    <td style="background-color:#ffd45e" align="center"><input type="checkbox" id="produksi_<?= $row->id_stock ?>" data-id='<?= $row->id_stock ?>' data-field='produksi_<?= $row->id_stock ?>' class="checkbox" <?= $cekproduksi ?>></td>
                                    <td style="background-color:#ffd45e" align="center"><input type="checkbox" id="lapangan_<?= $row->id_stock ?>" data-id='<?= $row->id_stock ?>' data-field='lapangan_<?= $row->id_stock ?>' class="checkbox" <?= $ceklapangan ?>></td>
                                    <?php if (from_session('level') < 3) { ?>
                                        <td align="center"><?php echo button_confirm("Anda yakin mengunci item " . $row->section_ata . "?", "wrh/aluminium/kuncidetailbom/" . $id_sj . "/" . $row->id_stock, "#content", 'Kunci', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Kunci"'); ?></td>
                                    <?php } else { ?>
                                        <td align="center"></td>
                                    <?php } ?>
                                </tr>
                            <?php
                            } else { ?>
                                <tr>
                                    <td align="center"><?= $i++ ?></td>
                                    <td><?= $row->section_ata ?></td>
                                    <td><?= $row->section_allure ?></td>
                                    <td><?= $row->temper ?></td>
                                    <td><?= $row->kode_warna ?></td>
                                    <td><?= $row->ukuran ?></td>
                                    <td align="center"><?= $qtyBOM ?></td>
                                    <td align="center"><?= $kurang ?></td>
                                    <td align="center"><?= $totalgudang ?></td>
                                    <td align="center"><?= $row->divisi ?></td>
                                    <td align="center"><?= $row->gudang ?></td>
                                    <td align="center"><?= $row->qty_out ?></td>
                                    <td align="center"><input type="checkbox" onclick="return false;" class="checkbox" <?= $cekproduksi ?>></td>
                                    <td align="center"><input type="checkbox" onclick="return false;" class="checkbox" <?= $ceklapangan ?>></td>
                                    <?php if (from_session('level') < 3) { ?>
                                        <td align="center">Terkunci <?php echo button_confirm("Anda yakin mengunci item " . $row->section_ata . "?", "wrh/aluminium/bukakuncidetailbom/" . $id_sj . "/" . $row->id_stock, "#content", 'Buka Kunci', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Buka Kunci"'); ?></td>
                                    <?php } else { ?>
                                        <td align="center"></td>
                                    <?php } ?>
                                </tr>
                            <?php }
                            ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php echo button_confirm("Anda yakin menambahkan item stock out?", "wrh/aluminium/additemdetailbom/" . $id_sj . "/" . $id_fppp, "#modal", 'Add Item', 'btn btn-info', 'data-toggle="tooltip" title="Add Item"'); ?>
            <?php echo button_confirm("Anda yakin menyelesaikan stock out?", "wrh/aluminium/finishdetailbom/" . $id_sj, "#content", 'Finish', 'btn btn-success', 'data-toggle="tooltip" title="Finish"'); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#tableku').DataTable({
            ordering: false,
            paging: false,
            scrollX: true,
        });
        $("select").select2();
    });

    function update() {
        $("#update").hide();
        $.ajax({
            url: "<?= site_url('wrh/aluminium/updateSuratJalan/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                "id_sj": $("#id_sj").val(),
                "penerima": $("#penerima").val(),
                "alamat_pengiriman": $("#alamat_pengiriman").val(),
                "sopir": $("#sopir").val(),
                "no_kendaraan": $("#no_kendaraan").val(),
            },
            success: function(img) {
                $.growl.notice({
                    title: 'Berhasil',
                    message: "Mengupdate Surat Jalan!"
                });
                // load_silent("wrh/aluminium/detailbom/" + img['id'] + "/", "#content");
            }
        });

    }

    function divisi(id) {
        var fieldname = 'id_divisi';
        var value = $('#id_divisi_' + id).val();
        var edit_id = id;
        var id_fppp = "<?= $id_fppp ?>";
        // Send AJAX request
        $.ajax({
            url: "<?= site_url('wrh/aluminium/getQtyRowGudang/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                field: fieldname,
                value: value,
                id: edit_id,
                id_fppp: id_fppp,
                divisi: $('#id_divisi_' + id).val(),
                gudang: $('#id_gudang_' + id).val(),
                keranjang: $('#keranjang_' + id).val(),
            },
            success: function(response) {
                console.log("divisi sukses!");
                if (response['qty_gudang'] == null) {
                    var qtygdg = 0;
                } else {
                    var qtygdg = response['qty_gudang'];
                }
                $('#qty_gudang_' + id).html(qtygdg);
                // load_silent("wrh/aluminium/detailbom/" + $("#id_fppp").val(), "#content");
            }
        })
    }

    function gudang(id) {
        var fieldname = 'id_gudang';
        var value = $('#id_gudang_' + id).val();
        var edit_id = id;
        var id_fppp = "<?= $id_fppp ?>";
        // Send AJAX request
        $.ajax({
            url: "<?= site_url('wrh/aluminium/getQtyRowGudang/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                field: fieldname,
                value: value,
                id: edit_id,
                id_fppp: id_fppp,
                divisi: $('#id_divisi_' + id).val(),
                gudang: $('#id_gudang_' + id).val(),
                keranjang: $('#keranjang_' + id).val(),
            },
            success: function(response) {
                console.log("gudang sukses!");
                if (response['qty_gudang'] == null) {
                    var qtygdg = 0;
                } else {
                    var qtygdg = response['qty_gudang'];
                }
                $('#qty_gudang_' + id).html(qtygdg);
                // load_silent("wrh/aluminium/detailbom/" + $("#id_fppp").val(), "#content");
            }
        })
    }

    function keranjang(id) {
        var fieldname = 'keranjang';
        var value = $('#keranjang_' + id).val();
        var edit_id = id;
        var id_fppp = "<?= $id_fppp ?>";
        // Send AJAX request
        $.ajax({
            url: "<?= site_url('wrh/aluminium/getQtyRowGudang/') ?>",
            dataType: "json",
            type: "POST",
            data: {
                field: fieldname,
                value: value,
                id: edit_id,
                id_fppp: id_fppp,
                divisi: $('#id_divisi_' + id).val(),
                gudang: $('#id_gudang_' + id).val(),
                keranjang: $('#keranjang_' + id).val(),
            },
            success: function(response) {

                console.log("gudang sukses!");
                if (response['qty_gudang'] == null) {
                    var qtygdg = 0;
                } else {
                    var qtygdg = response['qty_gudang'];
                }
                $('#qty_gudang_' + id).html(qtygdg);
                // load_silent("wrh/aluminium/detailbom/" + $("#id_fppp").val(), "#content");
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

        if (fieldname == 'produksi_' + edit_id) {
            $('#lapangan_' + edit_id).prop('checked', false); // Unchecks it
        } else {
            $('#produksi_' + edit_id).prop('checked', false); // Checks it
        }

        $.ajax({
            url: "<?= site_url('wrh/aluminium/saveout/') ?>",
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
                $.ajax({
                    url: "<?= site_url('wrh/aluminium/saveout/') ?>",
                    dataType: "json",
                    type: "POST",
                    data: {
                        field: fieldname,
                        value: value,
                        id: edit_id,
                        divisi: $('#id_divisi_' + edit_id).val(),
                        gudang: $('#id_gudang_' + edit_id).val(),
                        keranjang: $('#keranjang_' + edit_id).val(),
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
                        if (response['qty_gudang'] == null) {
                            var qtygdg = 0;
                        } else {
                            var qtygdg = response['qty_gudang'];
                        }
                        $('#qty_gudang_' + edit_id).html(qtygdg);
                        // gudang(edit_id);
                        // load_silent("wrh/aluminium/detailbom/" + $("#id_sj").val(), "#content");
                    }
                });
                // }
            }
        });
    });
</script>