<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Prioritas Pengiriman</h3>
        <div class="box-tools pull-right">
          <input type="button" target="_blank" class="btn btn-default" onclick="printDiv('printableArea')" value="Print Page" />
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
      <div class="box-body" id="printableArea">
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
          <table width="100%" id="tableku" class="table">
            <thead>
              <th width="5%">No</th>
              <th>Brand</th>
              <th>Tgl Permintaan</th>
              <th>No Permintaan</th>
              <th>No PO/SO</th>
              <th>Special Instruction</th>
              <th>Store/Mitra</th>
              <th>Zona</th>
              <th>Tgl Kirim</th>
              <th>Tgl Modified</th>
              <th>Total Item</th>
              <th>Sudah Kirim</th>
              <th>Belum Kirim</th>
              <th>Keterangan</th>
              <th>Act</th>
            </thead>
            <tbody>
              <?php
              $i = 1;
              $total_permintaan = 0;
              foreach ($prioritas->result() as $row) :
                // $ada = $this->m_invoice->getJumDetail($row->id);
                $ada = 1;
                $hari_ini = date('Y-m-d');
                $tgl2 = date('Y-m-d', strtotime('+1 days', strtotime($hari_ini)));
                $tgl3 = date('Y-m-d', strtotime('+2 days', strtotime($hari_ini)));
                $tgl4 = date('Y-m-d', strtotime('+3 days', strtotime($hari_ini)));
                $tgl5 = date('Y-m-d', strtotime('+4 days', strtotime($hari_ini)));

                if (strtotime($hari_ini) > strtotime($row->tgl_pengiriman)) {
                  $warnabg = '#ff8d85';
                  $tanggal = $row->tgl_pengiriman;
                  $tanggal = new DateTime($tanggal);
                  $sekarang = new DateTime();
                  $perbedaan = $tanggal->diff($sekarang);
                  $keterangan = 'Terlambat ' . $perbedaan->d . ' hari';
                } elseif ($hari_ini == $row->tgl_pengiriman) {
                  $warnabg = '#ffbd08';
                  $keterangan = 'Pengiriman hari ini';
                } elseif ($tgl2 == $row->tgl_pengiriman) {
                  $warnabg = '#fffb08';
                  $keterangan = 'Pengiriman 1 hari lagi';
                } elseif ($tgl3 == $row->tgl_pengiriman) {
                  $warnabg = '#08ffc9';
                  $keterangan = 'Pengiriman 2 hari lagi';
                } elseif ($tgl4 == $row->tgl_pengiriman) {
                  $warnabg = '#08c5ff';
                  $keterangan = 'Pengiriman 3 hari lagi';
                } elseif ($tgl5 == $row->tgl_pengiriman) {
                  $warnabg = '#87ff66';
                  $keterangan = 'Pengiriman 4 hari lagi';
                } else {
                  $warnabg = '#f0fff9';
                  $keterangan = 'Pengiriman lebih dari 4 hari lagi';
                }

                if ($row->id_status == 2) {
                  $wrnbg = '#26ff60';
                  $ktt = 'Sudah Terkirim';
                } else {
                  $wrnbg = $warnabg;
                  $ktt = $keterangan;
                }




                $totPermintaan = $this->m_prioritas_pengiriman->getTotPermintaan($row->id);
                $total_permintaan = $total_permintaan + $totPermintaan;

                $totKir = $this->m_prioritas_pengiriman->getTotKirim($row->id);
                if ($totKir != '') {
                  $totKirim = $totKir;
                } else {
                  $totKirim = 0;
                }

                if ($totPermintaan == $totKirim && $totKirim != 0) {
                  $updt = array('id_status' => 2,);
                  $this->m_prioritas_pengiriman->updateStatusInvoice($row->id, $updt);
                }


              ?>
                <?php if ($ada > 0) { ?>
                  <tr bgcolor="<?= $wrnbg ?>">
                    <td align="center"><?= $i ?></td>
                    <td><?= $row->brand ?></td>
                    <td><?= $row->date ?></td>
                    <td><?= $row->no_invoice ?></td>
                    <td><?= $row->no_po ?></td>
                    <td><?= $row->intruction ?></td>
                    <td><?= $row->store ?></td>
                    <td><?= $row->zona ?></td>
                    <td><b><?= $row->tgl_pengiriman ?></b></td>
                    <td><b><?= $row->timestamp ?></b></td>
                    <td align="right"><b><?= $totPermintaan ?></b></td>
                    <td align="right"><b><?= $totKirim ?></b></td>
                    <td align="right"><b><?= $totPermintaan - $totKirim ?></b></td>
                    <td><b><?= $ktt ?></b></td>
                    <td align="center">
                      <?php
                      $sesi = from_session('level');
                      if ($row->id_status == 1) {
                        echo button('load_silent("klg/prioritas_pengiriman/form/' . $row->id . '","#modal")', 'Ubah tgl Pengiriman', 'btn btn-xs btn-info', 'data-toggle="tooltip" title="Edit"');
                        echo button('load_silent("klg/prioritas_pengiriman/kirim/' . $row->id . '","#content")', 'Kirim', 'btn btn-xs btn-success', 'data-toggle="tooltip" title="Kirim"');
                      }
                      ?>
                    </td>
                  </tr>

                <?php $i++;
                } ?>

              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Total Permintaan</label>
              <input type="text" style="text-align: right;" class="form-control" value="<?= $total_permintaan ?>" readonly>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function printDiv(divName) {

    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title + '</h1>');
    mywindow.document.write(document.getElementById(divName).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
  }
  $(document).ready(function() {
    $("select").select2();
    var table = $('#tableku').DataTable({
      // "scrollX": true,
      "ordering": true,
      "paging": false
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

    load_silent("klg/prioritas_pengiriman/diSet/" + dari + "/" + toko + "/", "#content");

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