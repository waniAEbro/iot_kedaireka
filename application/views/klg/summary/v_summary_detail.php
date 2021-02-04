<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Kartu Stok Per Item</h3>
            <div class="pull-right"><?=button('load_silent("klg/summary","#content")','Kembali','btn btn-primary','data-toggle="tooltip" title="Kembali"');?></div>
          </div>
          <div class="box-body">
            <table width="100%" id="tableku" class="table">
              <thead>
                <th width="5%">No</th>
                <th>Item</th>
                <th>Warna</th>
                <th>Bukaan</th>
                <th>Qty In</th>
                <th>Qty Out</th>
                <th>Sisa</th>
                <th>Keterangan</th>
                <th>Jenis Stok</th>
                <th>Tgl</th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($data->result() as $row):
            
            
            $sisa= $this->m_summary->getSisaStok($row->id,$row->id_item,$row->id_warna,$row->bukaan); 

           $io = $row->inout;
          if ($io=='1') {
             $ket = "Masuk";
             $bgcol="#deffd6";
           } else {
             $ket = "Keluar";
             $bgcol="#ffd6d6";
           }

           if ($row->is_retur =='0' && $io=='1') {
             $jenis_stok = "produksi";
           } elseif($row->is_retur !='0' && $io=='1') {
             $jenis_stok = "retur";
           } else{
              $jenis_stok = "-";
           }
           
                                   
          ?>
          <tr bgcolor="<?=$bgcol;?>">
            <td><?=$i++?></td>
            <td><?=$row->item?></td>
            <td align="center"><?=$row->warna?></td>
            <td align="center"><?=$row->bukaan?></td>
            <td align="center"><?=$row->qty?></td>
            <td align="center"><?=$row->qty_out?></td>
            <td align="center"><b><?=$sisa?></b></td>
            <td align="center"><?=$ket?></td>
            <td align="center"><?=$jenis_stok?></td>
            <td align="center"><?=$row->date?></td>
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