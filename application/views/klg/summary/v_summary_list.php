<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
  <div class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Summary Item</h3>

        <div class="box-tools pull-right">
          <a target="_blank" href="<?= base_url('klg/summary/excel/1'); ?>" class="btn btn-xs btn-danger">Cetak Pivot Excel</a>
        </div>
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Jenis Item</label>
              <select id="jenis_barang" name="jenis_barang" class="form-control">
                <option value="">-- Select Jenis Item --</option>
                <?php foreach ($jenis_barang->result() as $valap) : ?>
                  <?php if ($id_jenis_barang == $valap->id) {
                    $selected = 'selected';
                  } else {
                    $selected = '';
                  } ?>
                  <option value="<?= $valap->id ?>" <?= $selected ?>><?= $valap->jenis_barang ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
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
          <div class="col-md-3">
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
          <div class="col-md-3">
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
              <a class="btn btn-success" onclick="setFilter()">Set Filter</a>
            </div>
          </div>
        </div>
      </div>

      <div class="box-body">
        <style type="text/css" media="screen">
          .large-table-container-3 {
            /*max-width: 800px;*/
            overflow-x: scroll;
            overflow-y: auto;
          }

          .large-table-container-3 table {}

          .large-table-fake-top-scroll-container-3 {
            /*max-width: 800px;*/
            overflow-x: scroll;
            overflow-y: auto;
          }

          .large-table-fake-top-scroll-container-3 div {
            background-color: red;
            font-size: 1px;
            line-height: 1px;
          }

          /*misc*/
          td {
            border: 1px solid gray;
          }
        </style>
        <div class="large-table-fake-top-scroll-container-3">
          <div>&nbsp;</div>
        </div>
        <div class="large-table-container-3">
          <table width="100%" id="tableku" class="table table-striped">
            <thead>
              <th width="5%">No</th>
              <th>Jenis Item</th>
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
              $total_permintaan = 0;
              $total_real_stock = 0;
              $total_free_stock = 0;
              foreach ($summary->result() as $row) :
                $qtyPermintaan = @$permintaan[$row->id_item][$row->id_tipe][$row->id_warna][$row->bukaan];
                $real_stok = @$realstock[$row->id_item][$row->id_tipe][$row->id_warna][$row->bukaan];
                // $real_stok = 0;
                $free_stok = $real_stok - $qtyPermintaan;
                // $free_stok = 0;
                if ($free_stok < 1) {
                  $colbg = "#fdff8a";
                } else {
                  $colbg = "";
                }
                $total_permintaan = $total_permintaan + $qtyPermintaan;
                $total_real_stock = $total_real_stock + $real_stok;
              ?>
                <tr>
                  <td bgcolor="<?= $colbg ?>"><?= $i++ ?></td>
                  <td bgcolor="<?= $colbg ?>"><?= $row->jenis_barang ?></td>
                  <td bgcolor="<?= $colbg ?>"><?= $row->item ?></td>
                  <td bgcolor="<?= $colbg ?>" align="center"><?= $row->lebar . 'x' . $row->tinggi ?></td>
                  <td bgcolor="<?= $colbg ?>" align="center"><?= $row->warna ?></td>
                  <td bgcolor="<?= $colbg ?>" align="center"><?= $row->bukaan ?></td>
                  <td bgcolor="<?= $colbg ?>" align="right"><?= $real_stok ?></td>
                  <td bgcolor="<?= $colbg ?>" align="right"><?= $qtyPermintaan ?></td>
                  <td bgcolor="<?= $colbg ?>" align="right"><?= $free_stok ?></td>
                  <td bgcolor="<?= $colbg ?>" align="right"><?= $row->safety_stok ?></td>
                  <td bgcolor="<?= $colbg ?>" align="center">
                    <?= button('load_silent("klg/summary/detail/' . $row->id_item . '/' . $row->id_warna . '/' . $row->bukaan . '","#content")', 'Detail', 'btn btn-xs btn-danger', 'data-toggle="tooltip" title="Detail"'); ?>
                    <?= button('load_silent("klg/summary/repro/' . $row->id_item . '/' . $row->id_warna . '/' . $row->bukaan . '","#modal")', 'REPRO', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="REPRO"'); ?>
                  </td>
                </tr>

              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Total Stock</label>
              <input type="text" style="text-align: right;" class="form-control" value="<?= $total_real_stock ?>" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Total Permintaan</label>
              <input type="text" style="text-align: right;" class="form-control" value="<?= $total_permintaan ?>" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Total Free Stock</label>
              <input type="text" style="text-align: right;" class="form-control" value="<?= $total_real_stock - $total_permintaan ?>" readonly>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tableku').DataTable({
      // "scrollX": true,
      "bPaginate": false,
    });
    $("select").select2();
  });

  function setFilter() {
    var jenis_barang = $('#jenis_barang').val();
    if (jenis_barang != '') {
      var id_jenis_barang = jenis_barang;
    } else {
      var id_jenis_barang = 'x';
    };
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
    load_silent("klg/summary/filter/" + id_jenis_barang + "/" + id_item + "/" + id_warna + "/" + kode + "/", "#content");

  }

  $(function() {
    var tableContainer = $(".large-table-container-3");
    var table = $(".large-table-container-3 table");
    var fakeContainer = $(".large-table-fake-top-scroll-container-3");
    var fakeDiv = $(".large-table-fake-top-scroll-container-3 div");

    var tableWidth = table.width();
    fakeDiv.width(tableWidth);

    fakeContainer.scroll(function() {
      tableContainer.scrollLeft(fakeContainer.scrollLeft());
    });
    tableContainer.scroll(function() {
      fakeContainer.scrollLeft(tableContainer.scrollLeft());
    });
  })
</script>