<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Data Stock</h3>

            <div class="box-tools pull-right">
            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                echo button('load_silent("klg/stock/formAdd/","#content")','Add New Stock','btn btn-success','data-toggle="tooltip" title="Add New Item"');
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
                <th>Produk dari</th>
                <th>Item</th>
                <th>Warna</th>
                <th>Bukaan</th>
                <th>Lebar</th>
                <th>Tinggi</th>
                <th>Qty</th>
                <th>Lokasi</th>
                <th>Act</th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($stock->result() as $row):                            
          ?>
          <tr>
            <td><?=$i++?></td>
            <td><?=$row->produk_dari?></td>
            <td><?=$row->item?></td>
            <td><?=$row->warna?></td>
            <td><?=$row->bukaan?></td>
            <td><?=$row->lebar?></td>
            <td><?=$row->tinggi?></td>
            <td><?=$row->qty?></td>
            <td><?=$row->lokasi?></td>
            <td align="center">
            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                echo button('load_silent("klg/stock/show_editForm/'.$row->id.'","#content")','Edit','btn btn-info','data-toggle="tooltip" title="Edit item"');
              } else {
                # code...
              }
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
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tableku').DataTable( {
      "scrollX": true,
    } );
  });
</script>