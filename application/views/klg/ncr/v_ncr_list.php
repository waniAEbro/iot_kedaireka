<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">List NCR (Non Conformity Record)</h3>

        <div class="box-tools pull-right">
          <?php
          $sesi = from_session('level');
          if ($sesi == '1' || $sesi == '2') {
            echo button('load_silent("klg/ncr/formAdd","#content")', 'Tambah NCR', 'btn btn-success');
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
              <th width="5%">No</th>
              <th>Store</th>
              <th>Nama Project</th>
              <th>No NCR</th>
              <th>No WO/SPK</th>
              <th>Tanggal</th>
              <th>No FPPP</th>
              <th>Kepada</th>
              <th>Item</th>
              <th>Status</th>
              <th>Act</th>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($ncr->result() as $row) :
                if ($row->status == 1) {
                  $sts = "Open";
                } else {
                  $sts = "Close";
                }

              ?>
                <tr>
                  <td align="center"><?= $i ?></td>
                  <td><?= $row->store ?></td>
                  <td><?= $row->nama_project ?></td>
                  <td><?= $row->no_ncr ?></td>
                  <td><?= $row->no_wo ?></td>
                  <td><?= $row->tanggal ?></td>
                  <td><?= $row->no_fppp ?></td>
                  <td><?= $row->kepada ?></td>
                  <td><?= $row->item ?></td>
                  <td><?= $sts ?></td>
                  <td align="center">
                    <a target="_blank" href="<?= base_url('klg/ncr/cetak'); ?>/<?= $row->id ?>" class="btn btn-xs btn-warning">Cetak</a>
                    <?php if ($row->lampiran != '') { ?>
                      <a target="_blank" href="<?= base_url($row->lampiran); ?>" class="btn btn-xs btn-danger">Lampiran</a>
                    <?php } ?>

                    <?php if ($row->feedback != '') { ?>
                      <a target="_blank" href="<?= base_url($row->feedback); ?>" class="btn btn-xs btn-default">Lihat Feedback</a>
                    <?php } ?>

                    <?php
                    $sesi = from_session('level');
                    if ($sesi < 3 && $row->status == 1) {
                      echo button('load_silent("klg/ncr/feedback/' . $row->id . '","#content")', 'Feedback', 'btn btn-xs btn-primary', 'data-toggle="tooltip" title="Feedback"');
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


  $(document).ready(function() {
    var table = $('#tableku').DataTable({
      "ordering": true,
      // "scrollX": true,
    });
  });
</script>