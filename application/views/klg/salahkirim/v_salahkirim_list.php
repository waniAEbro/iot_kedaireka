<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">List salahkirim</h3>

            <div class="box-tools pull-right">
            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                echo button('load_silent("klg/salahkirim/formAdd/","#content")','Buat Salah Kirim','btn btn-success','data-toggle="tooltip"');
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
                <th>No Pengiriman</th>
                <th>No Permintaan</th>
                <th>No PO</th>
                <th>Item</th>
                <th>Tipe</th>
                <th>Warna</th>
                <th>Bukaan</th>
                <th>Lebar (mm)</th>
                <th>Tinggi (mm)</th>
                <th>Qty</th>
                <th>Tgl</th>
                <th>Keterangan</th>
                <th>Act</th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($salahkirim->result() as $row):                           
          ?>
          <tr>
            <td><?=$i++?></td>
            <td><?=$row->no_pengiriman?></td>
            <td><?=$row->no_invoice?></td>
            <td><?=$row->no_po?></td>
            <td><?=$row->item?></td>
            <td align="center"><?=$row->tipe?></td>
            <td align="center"><?=$row->warna?></td>
            <td align="center"><?=$row->bukaan?></td>
            <td align="center"><?=$row->lebar?></td>
            <td align="center"><?=$row->tinggi?></td>
            <td align="center"><?=$row->qty?></td>
            <td align="center"><?=$row->date?></td>
            <td align="center"><?=$row->keterangan?></td>
            <td align="center">
            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                echo button('load_silent("klg/salahkirim/setujui/'.$row->id.'","#content")','Setujui','btn btn-xs btn-info','data-toggle="tooltip" title="Setujui"');
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