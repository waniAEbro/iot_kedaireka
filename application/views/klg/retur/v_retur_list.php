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
        <h3 class="box-title">List Retur</h3>

        <div class="box-tools pull-right">
          <?php
          $sesi = from_session('level');
          if ($sesi == '1' || $sesi == '2') {
            echo button('load_silent("klg/retur/formAdd","#content")', 'Tambah retur', 'btn btn-success');
          } else {
            # code...
          }
          ?>
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
              <th width="5%"></th>
              <th width="5%">No</th>
              <th>Tgl Retur</th>
              <th>No Retur</th>
              <th>Store</th>
              <th>Jenis Retur</th>
              <th>Alasan Retur</th>
              <th>Tgl Penarikan</th>
              <th>Keterangan</th>
              <th>Status</th>
              <th>Act</th>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($retur->result() as $row) :
                if ($row->status == 1) {
                  $ket_status = "<b>Pengajuan Retur</b>";
                } elseif ($row->status == 2) {
                  $ket_status = "<b>Retur Disetujui</b>";
                } else {
                  $ket_status = "<b>Retur Ditolak</b>";
                }

                $ada = $this->m_retur->getJumDetail($row->id);
              ?>
                <tr>
                  <?php if ($ada == '1') { ?>
                    <td class="details-control" id="<?= $i ?>"></td>
                  <?php } else { ?>
                    <td></td>
                  <?php }  ?>
                  <td align="center"><?= $i ?><input type="hidden" id="id_sku_<?= $i ?>" value="<?= $row->id ?>"><input type="hidden" id="id_jr_<?= $i ?>" value="<?= $row->id_jenis_retur ?>"></td>
                  <td align="center"><?= $row->tgl ?></td>
                  <td align="center"><?= $row->no_retur ?></td>
                  <td align="center"><?= $row->store ?></td>
                  <td align="center"><?= $row->jenis_retur ?></td>
                  <td align="center"><?= $row->alasan_retur ?></td>
                  <td align="center"><?= $row->tgl_penarikan ?></td>
                  <td align="center"><?= $row->keterangan ?></td>
                  <td align="center"><?= $ket_status ?></td>
                  <td align="center">
                    <?php if ($row->lampiran != '') { ?>
                      <a target="_blank" href="<?= base_url($row->lampiran); ?>" class="btn btn-xs btn-success">Lampiran</a>
                    <?php } ?>
                    <a target="_blank" href="<?= base_url('klg/retur/cetak'); ?>/<?= $row->id ?>" class="btn btn-xs btn-warning">Cetak</a><br>
                    <?php
                    if ($row->status == '1') {
                      $sesi = from_session('level');
                      if ($sesi == '1' || $sesi == '2') {
                        echo button_confirm("Anda yakin menghapus retur " . $row->no_retur . "?", "klg/retur/deleteRetur/" . $row->id, "#content", 'Hapus', 'btn btn-xs btn-danger', 'data-toggle="tooltip"');
                        echo button_confirm("Anda yakin menyetujui retur " . $row->no_retur . "?", "klg/retur/setujui/" . $row->id . "/" . $row->id_jenis_retur, "#content", 'Setujui', 'btn btn-xs btn-info', 'data-toggle="tooltip"');
                        echo button_confirm("Anda yakin mengubah retur " . $row->no_retur . "?", "klg/retur/formEdit/" . $row->id, "#content", 'Edit', 'btn btn-xs btn-primary', 'data-toggle="tooltip"');
                      }
                    } else {
                      echo "Retur Disetujui";
                    }
                    $ses_id = from_session('id');
                    if ($ses_id < 3) {
                      echo button_confirm("Anda yakin menghapus retur " . $row->no_retur . "?", "klg/retur/deleteRetur/" . $row->id, "#content", 'Hapus admin', 'btn btn-xs btn-danger', 'data-toggle="tooltip"');
                      echo button_confirm("Anda yakin menyetujui retur " . $row->no_retur . "?", "klg/retur/setujui/" . $row->id . "/" . $row->id_jenis_retur, "#content", 'Setujui admin', 'btn btn-xs btn-info', 'data-toggle="tooltip"');
                      echo button_confirm("Anda yakin mengubah retur " . $row->no_retur . "?", "klg/retur/formEdit/" . $row->id, "#content", 'Edit admin', 'btn btn-xs btn-primary', 'data-toggle="tooltip"');
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
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tableku').DataTable({
      "ordering": true,
      // "scrollX": true,
    });


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
        '<th>Item Retur</th>' +
        '<th>Qty</th>' +
        '<th>Keterangan</th>' +
        '<th>Item Pengganti</th>' +
        '<th>Qty</th>' +
        '<th>Keterangan</th>' +
        '</tr>';

      var id_sku = $('#id_sku_' + id).val();
      var id_jr = $('#id_jr_' + id).val();

      $.ajax({
          url: "<?= site_url('klg/retur/getDetailTabel') ?>",
          type: 'POST',
          dataType: 'JSON',
          data: {
            id_sku: id_sku,
          },
        })
        .done(function(data) {
          for (var i = 0; i < data.detail.length; i++) {
            var no = i + 1;
            var color = "white";
            var fontcolor = "black";
            if (id_jr != 2 && id_jr != 4) {
              infoTable += '<tr bgcolor="' + color + '">' +
                '<td><font color="' + fontcolor + '">' + no + '</font></td>' +
                '<td><font color="' + fontcolor + '">' + data.detail[i].item + '_' + data.detail[i].tipe + '_' + data.detail[i].lebar + 'x' + data.detail[i].tinggi + '_' + data.detail[i].warna + '_' + data.detail[i].bukaan + '</font></td>' +
                '<td align="center"><font color="' + fontcolor + '">' + data.detail[i].qty + '</font></td>' +
                '<td><font color="' + fontcolor + '">' + data.detail[i].keterangan + '</font></td>' +
                '<td><font color="' + fontcolor + '">' + data.detail[i].item_baru + '_' + data.detail[i].tipe_baru + '_' + data.detail[i].lebar_baru + 'x' + data.detail[i].tinggi_baru + '_' + data.detail[i].warna_baru + '_' + data.detail[i].bukaan_baru + '</font></td>' +
                '<td align="center"><font color="' + fontcolor + '">' + data.detail[i].qty + '</font></td>' +
                '<td><font color="' + fontcolor + '">' + data.detail[i].keterangan_baru + '</font></td>' +
                '</tr>';
            } else {
              infoTable += '<tr bgcolor="' + color + '">' +
                '<td><font color="' + fontcolor + '">' + no + '</font></td>' +
                '<td><font color="' + fontcolor + '">' + data.detail[i].item + '_' + data.detail[i].tipe + '_' + data.detail[i].lebar + 'x' + data.detail[i].tinggi + '_' + data.detail[i].warna + '_' + data.detail[i].bukaan + '</font></td>' +
                '<td align="center"><font color="' + fontcolor + '">' + data.detail[i].qty + '</font></td>' +
                '<td><font color="' + fontcolor + '">' + data.detail[i].keterangan + '</font></td>' +
                '<td align="center">tdk ada</td>' +
                '<td align="center">tdk ada</td>' +
                '<td align="center">tdk ada</td>' +
                '</tr>';
            };

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