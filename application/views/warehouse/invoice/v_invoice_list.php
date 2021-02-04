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
        <h3 class="box-title">List Penjualan Pelanggan</h3>

        <div class="box-tools pull-right">
          <?php
          $sesi = from_session('level');
          if ($sesi == '1' || $sesi == '2') {
            echo button('load_silent("warehouse/invoice/formAdd","#content")', 'Tambah Penjualan', 'btn btn-success');
          } else {
            # code...
          }
          ?>
        </div>
      </div>
      <div class="box-body">
        <table width="100%" id="tableku" class="table table-striped">
          <thead>
            <th width="5%"></th>
            <th width="5%">No</th>
            <th>Tgl Input</th>
            <th>Store</th>
            <th>Jenis Market</th>
            <th>No Invoice</th>
            <th>Jenis Case</th>
            <th>Pembeli</th>
            <th>Alamat</th>
            <th>Telp</th>
            <th>Tgl Pengiriman</th>
            <th>Keterangan</th>
            <th>Diskon</th>
            <th>PPN</th>
            <th>Biaya Kirim</th>
            <th>Pembulatan GT</th>
            <th>Act</th>
          </thead>
          <tbody>
            <?php
            $i = 1;
            foreach ($invoice->result() as $row) :
              // $this->db->where('id', $row->id_store);
              // $jm = $this->db->get('master_store')->row()->id_jenis_market;

              // $this->db->where('id_store', $row->id_store);
              // $object = array('id_jenis_market' => $jm);
              // $this->db->update('warehouse_invoice', $object);


              $ada = $this->m_invoice->getJumDetail($row->id);
            ?>
              <tr>
                <?php if ($ada > 0) { ?>
                  <td class="details-control" id="<?= $i ?>"></td>
                <?php } else { ?>
                  <td></td>
                <?php }  ?>
                <td align="center"><?= $i ?></td>
                <td><?= $row->date ?></td>
                <td><?= $row->store ?></td>
                <td><?= $row->jenis_market ?></td>
                <td><?= $row->no_invoice ?><input type="hidden" id="id_sku_<?= $i ?>" value="<?= $row->id ?>"></td>
                <td>Case <?= $row->id_case ?></td>
                <td><?= $row->pembeli ?></td>
                <td><?= $row->alamat ?></td>
                <td><?= $row->no_telp ?></td>
                <td><?= $row->tgl_pengiriman ?></td>
                <td><?= $row->keterangan ?></td>
                <td><?= $row->diskon . '%' ?></td>
                <td><?= $row->ppn . '%' ?></td>
                <td><?= number_format($row->biaya_kirim, 2, ',', '.') ?></td>
                <td><?= number_format($row->pembulatan_gt, 2, ',', '.') ?></td>
                <td align="center">
                  <button type="button" class="btn btn-xs bg-purple" onclick="cetakInvoice('<?= $row->id ?>')" data-toggle="tooltip" title="Print">Cetak</button>

                  <?php
                  $sesi = from_session('level');
                  if ($sesi == '1' || $sesi == '2') {
                    echo button('load_silent("warehouse/invoice/formEdit/' . $row->id . '","#content")', 'Edit', 'btn btn-xs btn-info', 'data-toggle="tooltip" title="Edit"');
                    echo button('load_silent("warehouse/invoice/pembulatanEdit/' . $row->id . '","#content")', 'Pembulatan GT', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Pembulatan GT"');
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
<script type="text/javascript">
  function cetakInvoice(id_pi) {
    var left = (screen.width / 2) - (640 / 2);
    var top = (screen.height / 2) - (480 / 2);
    var url = "<?= site_url('warehouse/invoice/cetak/"+id_pi+"') ?>";
    window.open(url, "", "width=640, height=480, scrollbars=yes, left=" + left + ", top=" + top);
  }

  $(document).ready(function() {
    var table = $('#tableku').DataTable({
      "ordering": true,
      "scrollX": true,
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
        '<th>Tipe</th>' +
        '<th>Item</th>' +
        '<th>Gambar</th>' +
        '<th>Warna</th>' +
        '<th>Bukaan</th>' +
        '<th>Qty</th>' +
        '<th>Promo</th>' +
        '<th>Harga</th>' +
        '<th>Keterangan</th>' +
        '</tr>';

      var id_sku = $('#id_sku_' + id).val();

      $.ajax({
          url: "<?= site_url('warehouse/invoice/getDetailTabel') ?>",
          type: 'POST',
          dataType: 'JSON',
          data: {
            id_sku: id_sku,
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
              '<td align="center"><font color="' + fontcolor + '">' + data.detail[i].tipe + '</font></td>' +
              '<td><font color="' + fontcolor + '">' + data.detail[i].item + ' (' + data.detail[i].lebar + 'x' + data.detail[i].tinggi + ')</font></td>' +
              '<td align="center"><font color="' + fontcolor + '"><img src="<?= base_url("'+data.detail[i].gambar+'") ?>" height="30px"></font></td>' +
              '<td align="center"><font color="' + fontcolor + '">' + data.detail[i].warna + '</font></td>' +
              '<td align="center"><font color="' + fontcolor + '">' + data.detail[i].bukaan + '</font></td>' +
              '<td align="center"><font color="' + fontcolor + '">' + data.detail[i].qty + '</font></td>' +
              '<td align="center"><font color="' + fontcolor + '">' + data.detail[i].promo + '</font></td>' +
              '<td align="center"><font color="' + fontcolor + '">' + data.detail[i].harga + '</font></td>' +
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
</script>