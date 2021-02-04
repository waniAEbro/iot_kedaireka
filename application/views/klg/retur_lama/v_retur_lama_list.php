<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">List Retur Barang Lama</h3>

            <div class="box-tools pull-right">
            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                echo button('load_silent("klg/retur_lama/formAdd/","#content")','Buat Retur','btn btn-success','data-toggle="tooltip"');
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
                <th>Store</th>
                <th>Item Diretur_lama</th>
                <th>Item Pengganti</th>
                <th>Tgl</th>
                <th>Keterangan</th>
                <th>Act</th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($retur_lama->result() as $row):                           
          ?>
          <tr>
            <td><?=$i++?></td>
            <td><?=$row->store?></td>
            <td><?=$row->tipe?><br><?=$row->item.' ('.$row->lebar.'x'.$row->tinggi.')'?><br><?=$row->warna?> - <?=$row->bukaan?> - Qty: <?=$row->qty?></td>
            <td><?=$row->tipe_baru?><br><?=$row->item_baru.' ('.$row->lebar_baru.'x'.$row->tinggi_baru.')'?><br><?=$row->warna_baru?> - <?=$row->bukaan_baru?> - Qty: <?=$row->qty_baru?></td>
            
            <td align="center"><?=$row->date?></td>
            <td align="center"><?=$row->keterangan?></td>
            <td align="center">
            <a target="_blank" href="<?=base_url('klg/retur_lama/cetak');?>/<?=$row->id?>" class="btn btn-xs btn-warning">Cetak</a>
            
            <?php
            if ($row->status == '1') {
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                echo button('load_silent("klg/retur_lama/deleteretur_lama/'.$row->id.'","#content")','Hapus','btn btn-xs btn-danger','data-toggle="tooltip" title="Hapus"');
                echo button('load_silent("klg/retur_lama/setujui/'.$row->id.'","#content")','Setujui','btn btn-xs btn-info','data-toggle="tooltip" title="Setujui"');
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