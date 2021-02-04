<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Master mapping</h3>

            <div class="box-tools pull-right">
            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2' || $sesi == '3' || $sesi == '6') {
                echo button('load_silent("klg/mapping/form/base","#modal")','Tambah Master mapping','btn btn-success');
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
                <th>Warna</th>
                <th>Harga Jabotabek</th>
                <th>Harga Dalam Pulau</th>
                <th>Harga Luar Pulau</th>
                <th width="10%">Act</th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($mapping->result() as $row): ?>
          <tr>
            <td><?=$i++?></td>
            <td><?=$row->item?></td>
            <td><?=$row->warna?></td>
            <td align="right">Rp. <?=number_format($row->harga_jabotabek,2,',','.')?></td>
            <td align="right">Rp. <?=number_format($row->harga_dalam_pulau,2,',','.')?></td>
            <td align="right">Rp. <?=number_format($row->harga_luar_pulau,2,',','.')?></td>
            <td>
            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2' || $sesi == '3' || $sesi == '6') {
                echo button('load_silent("klg/mapping/form/sub/'.$row->id.'","#modal")','','btn btn-info fa fa-edit','data-toggle="tooltip" title="Edit"');
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
      "ordering": false,
    } );
  });
</script>