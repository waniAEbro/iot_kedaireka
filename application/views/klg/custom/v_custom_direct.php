<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
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
      <th>Tgl Produksi</th>
      <th>Item</th>
      <th>Ukuran</th>
      <th>Bukaan</th>
      <th>Warna</th>
      <th>Qty</th>
      <th>Act</th>
    </thead>
    <tbody>
      <?php
      $i = 1;
      foreach ($custom->result() as $row) :
        $stok_out = $this->m_monitoring->getstokout($row->id_tipe, $row->id_item, $row->id_warna, $row->bukaan, $row->lebar, $row->tinggi);
        $stok = $row->qty - $stok_out;
      ?>
        <tr>
          <td><?= $i++ ?></td>
          <td align="center"><?= $row->tgl ?></td>
          <td><?= $row->item ?></td>
          <td align="center"><?= $row->lebar . 'x' . $row->tinggi ?></td>
          <td align="center"><?= $row->bukaan ?></td>
          <td align="center"><?= $row->warna ?></td>
          <td align="right"><?= $stok ?></td>
          <td align="right">
            <?php
            if ($stok > 0) {
              echo button_confirm("Anda yakin menghapus Stock " . $row->item . "?", "klg/custom/deleteStock/" . $row->id, "#content", 'Hapus', 'btn btn-xs btn-danger', 'data-toggle="tooltip"');
              echo button_confirm("Anda yakin mengubah Stock " . $row->item . "?", "klg/custom/formedit/" . $row->id, "#modal", 'Ubah', 'btn btn-xs btn-primary', 'data-toggle="tooltip"');
            }
            ?>
          </td>

        </tr>

      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tableku').DataTable({
      // "scrollX": true,
    });
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