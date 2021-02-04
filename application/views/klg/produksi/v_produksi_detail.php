<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
  <style>
    td.details-control {
      background: url("<?=base_url('assets/img/details_open.png')?>") no-repeat center center;
      cursor: pointer;
    }
    tr.shown{
      background:#FCFF43;
    }
    tr.shown td.details-control {
      background: url("<?=base_url('assets/img/details_close.png')?>") no-repeat center center;
    }
  </style>
    <div class="row">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">List Detail Produksi</h3>

            <div class="box-tools pull-right">
            <?php
                echo button('load_silent("klg/produksi/","#content")','Kembali','btn btn-success');
              ?>
            </div>
          </div>
          <div class="box-body">
            <h3>Total Produksi = <b><?=$tot_produksi?></b></h3>
            <table width="100%" id="tableku" class="table table-striped">
              <thead>
                <th width="5%">No</th>
                <th>Date</th>
                <th>Nomor</th>
                <th>Item</th>
                <th>Ukuran</th>
                <th>Warna</th>
                <th>Bukaan</th>
                <th>Qty</th>
                <th>Keterangan</th>
                <th></th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($produksi->result() as $row): 
          ?>
          <tr>
            <td align="center"><?=$i?></td>
            <td align="center"><?=$row->tgl_produksi?></td>
            <td align="center"><?=$row->no_produksi?></td>
            <td align="center"><?=$row->item?></td>
            <td align="center"><?=$row->lebar?> x <?=$row->tinggi?></td>
            <td align="center"><?=$row->warna?></td>
            <td align="center"><?=$row->bukaan?></td>
            <td align="right"><?=$row->qty?></td>
            <td align="center"><?=$row->keterangan?></td>
            <td align="center"><?=button_confirm("Anda yakin menghapus Produksi ".$row->no_produksi."?","klg/produksi/deleteProduksi/".$row->id,"#content",'Hapus','btn btn-xs btn-danger','data-toggle="tooltip"');?></td>
          </tr>

        <?php $i++; endforeach;?>
        </tbody>
            </table>
            <h3>Total Produksi = <b><?=$tot_produksi?></b></h3>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tableku').DataTable( {
      "ordering": true,
      "scrollX": true,
    } );
  });
  

</script>