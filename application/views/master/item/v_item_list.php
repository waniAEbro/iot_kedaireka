<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row" id="form_pembelian">
  <div class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Master Item</h3>

        <div class="box-tools pull-right">
          <?php
          $sesi = from_session('level');
          if ($sesi == '1' || $sesi == '2') {
            echo button('load_silent("master/item/show_addForm/","#content")', 'Add New Item', 'btn btn-success', 'data-toggle="tooltip" title="Add New Item"');
          } else {
            # code...
          }
          ?>
        </div>
      </div>

      <div class="box-body">
        <table width="100%" id="tableku" class="table table-striped">
          <thead>
            <th width="5%">No</th>
            <th>Item</th>
            <th>Jenis Barang</th>
            <th>Gambar</th>
            <th>Lebar (mm)</th>
            <th>Tinggi (mm)</th>
            <th>Spesification</th>
            <th>Safety Stock</th>
            <th>Tgl Input</th>
            <th>Act</th>
          </thead>
          <tbody>
            <?php
            $i = 1;
            foreach ($item->result() as $row) :
            ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= $row->item ?></td>
                <td><?= $row->jenis_barang ?></td>
                <td align="center"><img src="<?= $row->gambar ?>" width="50"></td>
                <td align="right"><?= $row->lebar ?></td>
                <td align="right"><?= $row->tinggi ?></td>
                <td align="center"><?= $row->spesifikasi ?></td>
                <td align="center"><?= $row->safety_stok ?></td>
                <td align="center"><?= $row->date ?></td>
                <td align="center">
                  <?php
                  $sesi = from_session('level');
                  if ($sesi == '1' || $sesi == '2') {
                    echo button('load_silent("master/item/show_editForm/' . $row->id . '","#content")', 'Edit', 'btn btn-info', 'data-toggle="tooltip" title="Edit item"');
                  } else {
                    # code...
                  }
                  ?>
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
      "scrollX": true,
    });
  });
</script>