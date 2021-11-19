<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row" id="form_pembelian">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Finance</h3>
            </div>
            <div class="box-body">
                <table width="100%" id="tableku" class="table table-striped">
                    <thead>
                        <th width="5%">No</th>
                        <th>DIVISI</th>
                        <th>KODE PROJECT</th>
                        <th>NAMA CUSTOMER</th>
                        <th>NAMA PROJECT</th>
                        <th>ALAMAT PROJECT</th>
                        <th>SALES</th>
                        <th>STATUS PROJECT</th>
                        <th>TOTAL UNIT</th>
                        <th>TOP</th>
                        <th>TANGGAL CO AWAL</th>
                        <th>CO AWAL</th>
                        <th>TAMBAHAN / PENGURANGAN</th>
                        <th>CO FINAL</th>
                        <th>DP AWAL</th>
                        <th>PEMBAYARAN TAHAP 1</th>
                        <th>PEMBAYARAN TAHAP 2</th>
                        <th>PEMBAYARAN TAHAP 3</th>
                        <th>PEMBAYARAN TAHAP 4</th>
                        <th>PELUNASAN</th>
                        <th>PEMASANGAN</th>
                        <th>TANGGAL BST</th>
                        <th>KETERANGAN</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($finance->result() as $row) : ?>
                            <tr>
                                <td align="center"><?= $i++ ?></td>
                                <td><?= $row->divisi ?></td>
                                <td><?= $row->kode_proyek ?></td>
                                <td><?= $row->applicant ?></td>
                                <td><?= $row->nama_proyek ?></td>
                                <td><?= $row->alamat_proyek ?></td>
                                <td><?= $row->sales ?></td>
                                <td></td>
                                <td></td>
                                <td style="background-color:#ffd45e" align="center"><span id="top_<?= $row->id ?>" class='edit'><?= $row->top ?></span>
                                    <input type='text' class='txtedit' data-id='<?= $row->id ?>' data-field='top' id='<?= $row->id ?>' value='<?= $row->top ?>'>
                                </td>
                                <td style="background-color:#ffd45e" align="center"><span id="tgl_co_awal_<?= $row->id ?>" class='edit'><?= $row->tgl_co_awal ?></span>
                                    <input type='date' class='txtedit' data-id='<?= $row->id ?>' data-field='tgl_co_awal' id='<?= $row->id ?>' value='<?= $row->tgl_co_awal ?>'>
                                </td>
                                <td style="background-color:#ffd45e" align="center"><span id="co_awal_<?= $row->id ?>" class='edit'><?= $row->co_awal ?></span>
                                    <input type='text' class='txtedit' data-id='<?= $row->id ?>' data-field='co_awal' id='<?= $row->id ?>' value='<?= $row->co_awal ?>'>
                                </td>
                                <td style="background-color:#ffd45e" align="center"><span id="penambahan_<?= $row->id ?>" class='edit'><?= $row->penambahan ?></span>
                                    <input type='text' class='txtedit' data-id='<?= $row->id ?>' data-field='penambahan' id='<?= $row->id ?>' value='<?= $row->penambahan ?>'>
                                </td>
                                <td style="background-color:#ffd45e" align="center"><span id="co_final_<?= $row->id ?>" class='edit'><?= $row->co_final ?></span>
                                    <input type='text' class='txtedit' data-id='<?= $row->id ?>' data-field='co_final' id='<?= $row->id ?>' value='<?= $row->co_final ?>'>
                                </td>
                                <td style="background-color:#ffd45e" align="center"><span id="dp_awal_<?= $row->id ?>" class='edit'><?= $row->dp_awal ?></span>
                                    <input type='text' class='txtedit' data-id='<?= $row->id ?>' data-field='dp_awal' id='<?= $row->id ?>' value='<?= $row->dp_awal ?>'>
                                </td>
                                <td style="background-color:#ffd45e" align="center"><span id="pembayaran_tahap_1_<?= $row->id ?>" class='edit'><?= $row->pembayaran_tahap_1 ?></span>
                                    <input type='text' class='txtedit' data-id='<?= $row->id ?>' data-field='pembayaran_tahap_1' id='<?= $row->id ?>' value='<?= $row->pembayaran_tahap_1 ?>'>
                                </td>
                                <td style="background-color:#ffd45e" align="center"><span id="pembayaran_tahap_2_<?= $row->id ?>" class='edit'><?= $row->pembayaran_tahap_2 ?></span>
                                    <input type='text' class='txtedit' data-id='<?= $row->id ?>' data-field='pembayaran_tahap_2' id='<?= $row->id ?>' value='<?= $row->pembayaran_tahap_2 ?>'>
                                </td>
                                <td style="background-color:#ffd45e" align="center"><span id="pembayaran_tahap_3_<?= $row->id ?>" class='edit'><?= $row->pembayaran_tahap_3 ?></span>
                                    <input type='text' class='txtedit' data-id='<?= $row->id ?>' data-field='pembayaran_tahap_3' id='<?= $row->id ?>' value='<?= $row->pembayaran_tahap_3 ?>'>
                                </td>
                                <td style="background-color:#ffd45e" align="center"><span id="pembayaran_tahap_4_<?= $row->id ?>" class='edit'><?= $row->pembayaran_tahap_4 ?></span>
                                    <input type='text' class='txtedit' data-id='<?= $row->id ?>' data-field='pembayaran_tahap_4' id='<?= $row->id ?>' value='<?= $row->pembayaran_tahap_4 ?>'>
                                </td>
                                <td style="background-color:#ffd45e" align="center"><span id="pelunasan_<?= $row->id ?>" class='edit'><?= $row->pelunasan ?></span>
                                    <input type='text' class='txtedit' data-id='<?= $row->id ?>' data-field='pelunasan' id='<?= $row->id ?>' value='<?= $row->pelunasan ?>'>
                                </td>
                                <td></td>
                                <td></td>
                                <td style="background-color:#ffd45e" align="center"><span id="keterangan_<?= $row->id ?>" class='edit'><?= $row->keterangan ?></span>
                                    <input type='text' class='txtedit' data-id='<?= $row->id ?>' data-field='keterangan' id='<?= $row->id ?>' value='<?= $row->keterangan ?>'>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.txtedit').hide();
        $('.edit').click(function() {
            $('.txtedit').hide();
            $(this).next('.txtedit').show().focus();
            $(this).hide();
        });

        $('.txtedit').focusout(function() {
            var fieldname = $(this).data('field');
            var value = $(this).val();
            var edit_id = $(this).data('id');
            var element = this;

            $.ajax({
                url: "<?= site_url('klg/finance/savechange/') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    field: fieldname,
                    value: value,
                    id: edit_id,
                },
                success: function(response) {

                    $(element).hide();

                    $(element).prev('.edit').show();
                    $(element).prev('.edit').text(value);
                    $.growl.notice({
                        title: 'Sukses',
                        message: "Change Saved!"
                    });
                }
            });
        });
    });
</script>