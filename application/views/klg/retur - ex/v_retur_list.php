<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">List Retur</h3>

            <div class="box-tools pull-right">
            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                echo button('load_silent("klg/retur/formAdd/","#content")','Buat Retur','btn btn-success','data-toggle="tooltip"');
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
                <th>Item Diretur</th>
                <th>Item Pengganti</th>
                <th>Tgl</th>
                <th>Keterangan</th>
                <th>Act</th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($retur->result() as $row):                           
          ?>
          <tr>
            <td><?=$i++?></td>
            <td><?=$row->no_pengiriman?></td>
            <td><?=$row->no_invoice?></td>
            <td><?=$row->no_po?></td>
            <td><?=$row->tipe?><br><?=$row->item.' ('.$row->lebar.'x'.$row->tinggi.')'?><br><?=$row->warna?> - <?=$row->bukaan?> - Qty: <?=$row->qty?></td>
            <td><?=$row->tipe_baru?><br><?=$row->item_baru.' ('.$row->lebar_baru.'x'.$row->tinggi_baru.')'?><br><?=$row->warna_baru?> - <?=$row->bukaan_baru?> - Qty: <?=$row->qty_baru?></td>
            
            <td align="center"><?=$row->date?></td>
            <td align="center"><?=$row->keterangan?></td>
            <td align="center">
            <a target="_blank" href="<?=base_url('klg/retur/cetak');?>/<?=$row->id?>" class="btn btn-xs btn-warning">Cetak</a>
            
            <?php
            if ($row->status == '1') {
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                // echo button('load_silent("klg/retur/detail/'.$row->id.'","#content")','Detail','btn btn-xs btn-danger','data-toggle="tooltip" title="Hapus"');
                echo button('load_silent("klg/retur/deleteRetur/'.$row->id.'","#content")','Hapus','btn btn-xs btn-danger','data-toggle="tooltip" title="Hapus"');
                echo button('load_silent("klg/retur/formEdit/'.$row->id.'","#content")','Edit','btn btn-xs btn-primary','data-toggle="tooltip" title="Edit"');
                echo button('load_silent("klg/retur/setujui/'.$row->id.'","#content")','Setujui','btn btn-xs btn-info','data-toggle="tooltip" title="Setujui"');
              }
            } else {
              echo "Retur Disetujui";
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