<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
  <div class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Summary Item Belum Stock Opname</h3><br>
        <h4 class="box-title">Stock Opname nomor <?php echo $cek_aktif->row()->no_so; ?></h4>
        <div class="box-tools pull-right">

          <?php echo button('load_silent("klg/summary/akiriSO/' . $cek_aktif->row()->id . '","#content")', 'Akhiri Stock Opname', 'btn btn-xs btn-danger', 'data-toggle="tooltip" title="akhiri SO"'); ?>
        </div>
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Item</label>
              <select id="item" name="item" class="form-control">
                <option value="">-- Select Item --</option>
                <?php foreach ($item->result() as $valap) : ?>
                  <?php if ($id_item == $valap->id) {
                    $selected = 'selected';
                  } else {
                    $selected = '';
                  } ?>
                  <option value="<?= $valap->id ?>" <?= $selected ?>><?= $valap->item ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Warna</label>
              <select id="warna" name="warna" class="form-control">
                <option value="">-- Select Warna --</option>
                <?php foreach ($warna->result() as $valap) : ?>
                  <?php if ($id_warna == $valap->id) {
                    $selected = 'selected';
                  } else {
                    $selected = '';
                  } ?>
                  <option value="<?= $valap->id ?>" <?= $selected ?>><?= $valap->warna ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Bukaan</label>
              <select id="bukaan" name="bukaan" class="form-control">
                <option value="">-- Select Bukaan --</option>
                <?php foreach ($bukaan->result() as $valap) : ?>
                  <?php if ($id_bukaan == $valap->bukaan) {
                    $selected = 'selected';
                  } else {
                    $selected = '';
                  } ?>
                  <option value="<?= $valap->bukaan ?>" <?= $selected ?>><?= $valap->bukaan ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box-tools pull-right">
              <a class="btn btn-success" onclick="setFilter()">Set Filter </a>
            </div>
          </div>
        </div>
      </div>

      <div class="box-body">
        <table width="100%" id="tableku" class="table table-striped">
          <thead>
            <th width="5%">No</th>
            <th>Item</th>
            <th>Ukuran</th>
            <th>Warna</th>
            <th>Bukaan</th>
            <th>Real Stock</th>
            <th>Jml Permintaan</th>
            <th>Free Stock</th>
            <th>Safety Stock</th>
            <th></th>
          </thead>
          <tbody>
            <?php
            $i = 1;
            foreach ($summary->result() as $row) :
              $qtyPermintaan = @$permintaan[$row->id_item][$row->id_tipe][$row->id_warna][$row->bukaan][$row->lebar][$row->tinggi];
              $real_stok = @$realstock[$row->id_item][$row->id_tipe][$row->id_warna][$row->bukaan][$row->lebar][$row->tinggi];
              // $real_stok = 0;
              $free_stok = $real_stok - $qtyPermintaan;
              // $free_stok = 0;
              if ($free_stok < 1) {
                $colbg = "#fdff8a";
              } else {
                $colbg = "";
              }

            ?>
              <tr>
                <td bgcolor="<?= $colbg ?>"><?= $i++ ?></td>
                <td bgcolor="<?= $colbg ?>"><?= $row->item ?></td>
                <td bgcolor="<?= $colbg ?>" align="center"><?= $row->lebar . 'x' . $row->tinggi ?></td>
                <td bgcolor="<?= $colbg ?>" align="center"><?= $row->warna ?></td>
                <td bgcolor="<?= $colbg ?>" align="center"><?= $row->bukaan ?></td>
                <td bgcolor="<?= $colbg ?>" align="right"><?= $real_stok ?></td>
                <td bgcolor="<?= $colbg ?>" align="right"><?= $qtyPermintaan ?></td>
                <td bgcolor="<?= $colbg ?>" align="right"><?= $free_stok ?></td>
                <td bgcolor="<?= $colbg ?>" align="right"><?= $row->safety_stok ?></td>
                <td bgcolor="<?= $colbg ?>" align="center"><?php echo button('load_silent("klg/summary/form/sub/' . $row->id_item . '/' . $row->id_warna . '/' . $row->bukaan . '/' . $row->lebar . '/' . $row->tinggi . '/' . $real_stok . '/' . $cek_aktif->row()->id . '","#modal")', '', 'btn btn-info fa fa-edit', 'data-toggle="tooltip" title="Edit"'); ?></td>
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
      "scrollX": true,
    });
    $("select").select2();
  });

  function setFilter() {
    var item = $('#item').val();
    if (item != '') {
      var id_item = item;
    } else {
      var id_item = 'x';
    };
    var warna = $('#warna').val();
    if (warna != '') {
      var id_warna = warna;
    } else {
      var id_warna = 'x';
    };
    var bukaan = $('#bukaan').val();
    if (bukaan != '') {
      var kode = bukaan;
    } else {
      var kode = 'x';
    };
    load_silent("klg/summary/filter/" + id_item + "/" + id_warna + "/" + kode + "/", "#content");

  }
</script>