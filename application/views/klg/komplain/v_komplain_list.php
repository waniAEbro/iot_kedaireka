<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Master Komplain</h3>

            <div class="box-tools pull-right">
            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                echo button('load_silent("klg/komplain/form/base","#modal")','Add New komplain','btn btn-success');
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
          .large-table-container-3 table {
            
          }
          .large-table-fake-top-scroll-container-3 {
            /*max-width: 800px;*/
            overflow-x: scroll;
            overflow-y: auto;
          }
          .large-table-fake-top-scroll-container-3 div {
            background-color: red;
            font-size:1px;
            line-height:1px;
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
                <th>Kepada</th>
                <th>Perihal</th>
                <th>Komplain</th>
                <th>Act</th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($komplain->result() as $row): ?>
          <tr>
            <td align="center"><?=$i++?></td>
            <td><?=$row->kepada?></td>
            <td><?=$row->perihal?></td>
            <td><?=$row->komplain?></td>
            <td align="center">
            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                echo button('load_silent("klg/komplain/form/sub/'.$row->id.'","#modal")','edit','btn btn-info','data-toggle="tooltip" title="Edit"');
              } else {
                # code...
              }
                echo button('load_silent("klg/komplain/form/sub/'.$row->id.'","#modal")','Cetak','btn btn-warning','data-toggle="tooltip" title="Edit"');
              ?>
            </td>
          </tr>

        <?php endforeach;?>
        </tbody>
            </table>
          </div>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tableku').DataTable( {
      // "scrollX": true,
      "ordering": false,
    } );
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