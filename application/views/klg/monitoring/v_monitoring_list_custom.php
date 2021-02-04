<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
  <div class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <?php
        echo button('load_silent("klg/monitoring/common/","#content")', 'Common', 'btn btn-default', 'data-toggle="tooltip"');
        echo button('load_silent("klg/monitoring/custom/","#content")', 'Custom', 'btn btn-primary', 'data-toggle="tooltip"');
        ?>

        <div class="box-tools pull-right">
          <h3 class="box-title">Monitoring OTS Custom</h3>

        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Tanggal Pengiriman</label>
              <select id="tgl" name="tgl" class="form-control select2" required>
                <option value="">-- Select Tgl Pengiriman --</option>
                <?php foreach ($tgl->result() as $valap) : ?>
                  <?php if ($tglkirim == $valap->tgl_pengiriman) {
                    $selected = 'selected';
                  } else {
                    $selected = '';
                  } ?>
                  <option value="<?= $valap->tgl_pengiriman ?>" <?= $selected ?>><?= $valap->tgl_pengiriman ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Store/Mitra</label>
              <select id="store" name="store" class="form-control select2" required>
                <option value="">-- Select Store/Mitra --</option>
                <?php foreach ($store->result() as $valap) : ?>
                  <?php if ($storemitra == $valap->id_store) {
                    $selected = 'selected';
                  } else {
                    $selected = '';
                  } ?>
                  <option value="<?= $valap->id_store ?>" <?= $selected ?>><?= $valap->store ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <a class="btn btn-success" onclick="setAplikator()">Tampilkan</a>
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
          <table width="100%" id="tableku" class="table table-striped table-responsive">
            <thead>
              <th width="5%">No</th>
              <th>Tgl Permintaan</th>
              <th>No Permintaan</th>
              <th>No PO/SO</th>
              <th>Store</th>
              <th>Zona</th>
              <th>Item</th>
              <th>Jenis Item</th>
              <th>Ukuran</th>
              <th>Warna</th>
              <th>Bukaan</th>
              <th>Tgl Kirim</th>
              <th>Total Item</th>
              <th>Sudah Kirim</th>
              <th>Belum Kirim</th>
              <th>Stock Ready</th>
              <th>Free Stock</th>
              <th>Safety Stock</th>
              <th>Status Detail</th>
            </thead>
            <tbody>
              <?php
              $i = 1;
              $total_permintaan = 0;
              $total_unsent = 0;
              $total_sent = 0;
              foreach ($monitoring->result() as $row) :
                $sudah_kirim = @$get_sudah_kirim[$row->id_invoice][$row->id_tipe][$row->id_item][$row->id_warna][$row->bukaan][$row->lebar][$row->tinggi];
                if ($sudah_kirim < 1) {
                  $sdhkrm = 0;
                } else {
                  $sdhkrm = $sudah_kirim;
                }

                // $sudah_kirim = $this->m_monitoring->sudahkirim($row->id_invoice,$row->id_tipe,$row->id_item,$row->id_warna,$row->bukaan,$row->lebar,$row->tinggi);
                $belum_kirim = $row->qty - $sudah_kirim;
                $stock_ready = @$get_stock_ready[$row->id_tipe][$row->id_item][$row->id_warna][$row->bukaan][$row->lebar][$row->tinggi];
                // $stock_ready = $this->m_monitoring->stokready($row->id_tipe,$row->id_item,$row->id_warna,$row->bukaan,$row->lebar,$row->tinggi);
                $free_stok = $stock_ready - $row->qty;


                if ($stock_ready < $row->qty) {
                  $bg = "#fdff8a";
                } else {
                  $bg = "";
                }

                if ($belum_kirim > 0) {
                  $total_permintaan = $total_permintaan + $row->qty;
                  $total_unsent = $total_unsent + $belum_kirim;
                  $total_sent = $total_sent + $sudah_kirim;
              ?>
                  <tr>
                    <td bgcolor="<?= $bg ?>"><?= $i++ ?></td>
                    <td bgcolor="<?= $bg ?>"><?= $row->tgl_permintaan ?></td>
                    <td bgcolor="<?= $bg ?>"><?= $row->no_invoice ?></td>
                    <td bgcolor="<?= $bg ?>"><?= $row->no_po ?></td>
                    <td bgcolor="<?= $bg ?>"><?= $row->store ?></td>
                    <td bgcolor="<?= $bg ?>"><?= $row->zona ?></td>
                    <td bgcolor="<?= $bg ?>"><?= $row->item ?></td>
                    <td bgcolor="<?= $bg ?>"><?= $row->jenis_barang ?></td>
                    <td bgcolor="<?= $bg ?>" align="center"><?= $row->lebar . 'x' . $row->tinggi ?></td>
                    <td bgcolor="<?= $bg ?>" align="center"><?= $row->warna ?></td>
                    <td bgcolor="<?= $bg ?>" align="center"><?= $row->bukaan ?></td>
                    <td bgcolor="<?= $bg ?>" align="center"><?= $row->tgl_pengiriman ?></td>
                    <td bgcolor="<?= $bg ?>" align="right"><?= $row->qty ?></td>
                    <td bgcolor="<?= $bg ?>" align="right"><?= $sdhkrm ?></td>
                    <td bgcolor="<?= $bg ?>" align="right"><?= $belum_kirim ?></td>
                    <td bgcolor="<?= $bg ?>" align="right"><?= $stock_ready ?></td>
                    <td bgcolor="<?= $bg ?>" align="right"><?= $free_stok ?></td>
                    <td bgcolor="<?= $bg ?>" align="right"><?= $row->safety_stok ?></td>
                    <td bgcolor="<?= $bg ?>" align="right"><?= $row->status_detail ?></td>


                  </tr>

              <?php }
              endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Total Permintaan</label>
              <input type="text" style="text-align: right;" class="form-control" value="<?= $total_permintaan ?>" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Total Blm Kirim</label>
              <input type="text" style="text-align: right;" class="form-control" value="<?= $total_unsent ?>" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Total Sudah Kirim</label>
              <input type="text" style="text-align: right;" class="form-control" value="<?= $total_sent ?>" readonly>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $("select").select2();
    var table = $('#tableku').DataTable({
      // "scrollX": true,
      "paging": false,
    });
  });

  function setAplikator(argument) {
    var tgl = $('#tgl').val();
    if (tgl != '') {
      var dari = tgl;
    } else {
      var dari = 'x';
    };

    var store = $('#store').val();
    if (store != '') {
      var toko = store;
    } else {
      var toko = 'x';
    };

    load_silent("klg/monitoring/customfilter/" + dari + "/" + toko + "/", "#content");

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