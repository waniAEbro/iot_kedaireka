<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
  td.details-control {
    background: url("<?= base_url('assets/img/details_open.png') ?>") no-repeat center center;
    cursor: pointer;
  }

  tr.shown {
    background: #FCFF43;
  }

  tr.shown td.details-control {
    background: url("<?= base_url('assets/img/details_close.png') ?>") no-repeat center center;
  }
</style>
<div class="row">
  <div class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Pengiriman</h3>

        <div class="box-tools pull-right">
          <input type="button" target="_blank" class="btn btn-default" onclick="printDiv('printableArea')" value="Print Page" />
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Store</label>
              <select id="store" name="store" class="form-control">
                <option value="">-- Select Store --</option>
                <?php foreach ($store->result() as $valap) : ?>
                  <?php if ($id_store == $valap->id) {
                    $selected = 'selected';
                  } else {
                    $selected = '';
                  } ?>
                  <option value="<?= $valap->id ?>" <?= $selected ?>><?= $valap->store ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Bulan</label>
              <select id="bulan" name="bulan" class="form-control">
                <option value="">-- Select Bulan --</option>
                <option value="x">Semua Bulan</option>
                <?php foreach ($bulan->result() as $valap) : ?>
                  <?php if ($id_bulan == $valap->bulan) {
                    $selected = 'selected';
                  } else {
                    $selected = '';
                  } ?>
                  <option value="<?= $valap->bulan ?>" <?= $selected ?>><?= $valap->nama_bulan ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Tahun</label>
              <input type="text" class="form-control" id="tahun" name="tahun" value="<?= $id_tahun ?>" autocomplete="off">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Tanggal</label>
              <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" id="tgl" name="tgl" value="<?= $id_tgl ?>" autocomplete="off">
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
          <table width="100%" id="tableku" class="table table-striped">
            <thead>
              <th width="5%"></th>
              <th width="5%">No</th>
              <th>No Surat Jalan</th>
              <th>No Permintaan</th>
              <th>No PO/SO</th>
              <th>Store/Mitra</th>
              <th>Zona</th>
              <th>Total Item</th>
              <th>Sopir</th>
              <th>No Polisi</th>
              <th>Tgl Input</th>
              <th>Tgl Cetak</th>
              <th>Status</th>
              <th>Act</th>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($pengiriman->result() as $row) :
                $totOut = @$totalTerkirim[$row->id];
                if ($row->id_status == 1) {
                  $ket_status = "Terkirim";
                  $bgcolor = "";
                  $obj = array('tgl_pengiriman' => $row->date,);
                  $this->db->where('id', $row->id_invoice);
                  $this->db->update('data_invoice', $obj);
                } else {
                  $ket_status = "Batal";
                  $bgcolor = "#ff9d96";
                }
              ?>
                <tr>
                  <?php if ($totOut > 0) { ?>
                    <td bgcolor="<?= $bgcolor ?>" class="details-control" id="<?= $i ?>"></td>
                  <?php } else { ?>
                    <td bgcolor="<?= $bgcolor ?>"></td>
                  <?php }  ?>
                  <td bgcolor="<?= $bgcolor ?>" align="center"><?= $i ?></td>
                  <td bgcolor="<?= $bgcolor ?>"><?= $row->no_pengiriman ?><input type="hidden" id="id_sku_<?= $i ?>" value="<?= $row->id_invoice ?>"><input type="hidden" id="id_kirim_<?= $i ?>" value="<?= $row->id ?>"></td>
                  <td bgcolor="<?= $bgcolor ?>"><?= $row->no_invoice ?></td>
                  <td bgcolor="<?= $bgcolor ?>"><?= $row->no_po ?></td>
                  <td bgcolor="<?= $bgcolor ?>"><?= $row->store ?></td>
                  <td bgcolor="<?= $bgcolor ?>"><?= $row->zona ?></td>
                  <td bgcolor="<?= $bgcolor ?>" align="right"><?= $totOut ?></td>
                  <td bgcolor="<?= $bgcolor ?>"><?= $row->sopir ?></td>
                  <td bgcolor="<?= $bgcolor ?>"><?= $row->no_polisi ?></td>
                  <td bgcolor="<?= $bgcolor ?>"><?= $row->date ?></td>
                  <td bgcolor="<?= $bgcolor ?>"><?= $row->tgl_cetak ?></td>
                  <td bgcolor="<?= $bgcolor ?>"><?= $ket_status ?></td>
                  <td bgcolor="<?= $bgcolor ?>">
                    <?php
                    if ($row->is_retur == 2) { ?>
                      <a target="_blank" href="<?= base_url('klg/pengiriman/cetak_tarik'); ?>/<?= $row->id_retur ?>" class="btn btn-xs btn-primary">Cetak Tarik</a>
                    <?php }

                    ?>
                    <a target="_blank" href="<?= base_url('klg/pengiriman/cetak'); ?>/<?= $row->id ?>" onclick="simpantgl(<?= $row->id ?>)" class="btn btn-xs btn-warning">Cetak</a>
                    <?= button_confirm("Anda yakin Membatalkan pengiriman " . $row->no_pengiriman . "?", "klg/pengiriman/batalKirim/" . $row->id . "/" . $row->id_invoice, "#content", 'Batalkan', 'btn btn-xs btn-danger', 'data-toggle="tooltip"'); ?>

                    <?php
                    $sesi = from_session('level');
                    $time = strtotime($row->date);
                    $newformat = date('Y-m-d', $time);
                    $tglnow = date('Y-m-d');
                    if ($sesi == 1 && $tglnow == $newformat) {
                      echo button_confirm("Anda yakin mengubah pengiriman " . $row->no_pengiriman . "?", "klg/pengiriman/edit/" . $row->id . "/" . $row->id_invoice, "#content", 'Edit', 'btn btn-xs btn-primary', 'data-toggle="tooltip"');
                    }
                    ?>
                  </td>
                </tr>

              <?php $i++;
              endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="box-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Total Item Terkirim</label>
            <input type="text" style="text-align: right;" class="form-control" value="<?= $total_sent ?>" readonly>
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

  function setFilter() {
    var store = $('#store').val();
    if (store != '') {
      var id_store = store;
    } else {
      var id_store = 'x';
    };
    var bulan = $('#bulan').val();
    if (bulan != '') {
      var id_bulan = bulan;
    } else {
      var id_bulan = 'x';
    };
    var tahun = $('#tahun').val();
    var tgl = $('#tgl').val();
    if (tgl != '') {
      var id_tgl = tgl;
    } else {
      var id_tgl = 'x';
    };
    load_silent("klg/pengiriman/filter/" + id_store + "/" + id_bulan + "/" + tahun + "/" + id_tgl + "/", "#content");

  }
  $(document).ready(function() {
    $('.datepicker').datepicker({
      autoclose: true
    });
    var table = $('#tableku').DataTable({
      // "scrollX": true,
      "ordering": true,
    });
    $("select").select2();

    $('#tableku tbody').on('click', 'td.details-control', function(e) {
      var tr = $(this).closest('tr');
      var td = $(this).closest('td');
      var row = table.row(tr);
      if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
      } else {
        dataRow = format(td[0].id, row, tr);
      }
    });

    function format(id, row, tr) {

      infoTable = '<table id="infoTable" class="table table-bordered" border="0" style="font-size: smaller;">' +
        '<tr bgcolor="#c7c4ff">' +
        '<th>No</th>' +
        '<th>Item</th>' +
        '<th>Ukuran</th>' +
        '<th>Gambar</th>' +
        '<th>Warna</th>' +
        '<th>Bukaan</th>' +
        '<th>Qty</th>' +
        '<th>Tipe</th>' +
        '<th>Status Detail</th>' +
        '<th>Keterangan</th>' +
        '</tr>';

      var id_sku = $('#id_sku_' + id).val();
      var id_kirim = $('#id_kirim_' + id).val();

      $.ajax({
          url: "<?= site_url('klg/pengiriman/getDetailTabel') ?>",
          type: 'POST',
          dataType: 'JSON',
          data: {
            id_sku: id_sku,
            id_kirim: id_kirim,
          },
        })
        .done(function(data) {
          // console.log(data.detail);
          var total_semua = 0;
          var total_cbm = 0;
          for (var i = 0; i < data.detail.length; i++) {
            var no = i + 1;
            var color = "white";
            var fontcolor = "black";

            infoTable += '<tr bgcolor="' + color + '">' +
              '<td><font color="' + fontcolor + '">' + no + '</font></td>' +
              '<td><font color="' + fontcolor + '">' + data.detail[i].item + '</font></td>' +
              '<td align="center"><font color="' + fontcolor + '">' + data.detail[i].lebar + 'x' + data.detail[i].tinggi + '</font></td>' +
              '<td align="center"><font color="' + fontcolor + '"><img src="<?= base_url("'+data.detail[i].gambar+'") ?>" height="30px"></font></td>' +
              '<td><font color="' + fontcolor + '">' + data.detail[i].warna + '</font></td>' +
              '<td><font color="' + fontcolor + '">' + data.detail[i].bukaan + '</font></td>' +
              '<td align="center"><font color="' + fontcolor + '">' + data.detail[i].qty_out + '</font></td>' +
              '<td><font color="' + fontcolor + '">' + data.detail[i].tipe + '</font></td>' +
              '<td><font color="' + fontcolor + '">' + data.detail[i].status_detail + '</font></td>' +
              '<td><font color="' + fontcolor + '">' + data.detail[i].keterangan + '</font></td>' +
              '</tr>';

          };

          infoTable += '</table>';
          row.child(infoTable).show();
          tr.addClass('shown');
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          // console.log("complete");
        });

      return infoTable;
    }
  });

  function simpantgl(id) {
    $.ajax({
      type: "POST",
      url: site + 'klg/pengiriman/simpantgl',
      dataType: 'json',
      data: {
        id: id,

      },
      success: function(data) {
        // $('#id_pengiriman').val(data['id']);
        // $.growl.notice({ title: 'Sukses', message: data['msg']});
        // $('#tutup').click();
        // $('#form_pembelian').show(1000);
        console.log("Tgl tersimpan!");
      }
    });
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