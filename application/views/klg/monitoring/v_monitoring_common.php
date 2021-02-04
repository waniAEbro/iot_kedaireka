<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

            <table width="100%" id="tableku" class="table table-striped table-responsive">
              <thead>
                <th width="5%">No</th>
                <th>Tgl Permintaan</th>
                <th>No Permintaan</th>
                <th>No PO</th>
                <th>Store</th>
                <th>Zona</th>
                <th>Item</th>
                <th>Jenis Item</th>
                <th>Ukuran</th>
                <th>Warna</th>
                <th>Bukaan</th>
                <th>Tgl Kirim</th>
                <th>Jml Permintaan</th>
                <th>Stock Ready</th>
                <th>Free Stok</th>
                <th>Safety Stok</th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($monitoring->result() as $row):
            $stok_in = $this->m_monitoring->getstokin($row->id_tipe,$row->id_item,$row->id_warna,$row->bukaan,$row->lebar,$row->tinggi);
            $stok_out = $this->m_monitoring->getstokout($row->id_tipe,$row->id_item,$row->id_warna,$row->bukaan,$row->lebar,$row->tinggi);
            $stok_real = $stok_in - $stok_out;

            if ($stok_real < $row->qty) {
              $bg = "#fdff8a";
            } else {
              $bg = "";
            }

            if ($row->id_tipe ==1) {
              $safetystok = $row->safety_stok;
            } else {
              $safetystok = '-';
            }
            
            
          ?>
          <tr>
            <td bgcolor="<?=$bg?>"><?=$i++?></td>
            <td bgcolor="<?=$bg?>"><?=$row->tgl_permintaan?></td>
            <td bgcolor="<?=$bg?>"><?=$row->no_invoice?></td>
            <td bgcolor="<?=$bg?>"><?=$row->no_po?></td>
            <td bgcolor="<?=$bg?>"><?=$row->store?></td>
            <td bgcolor="<?=$bg?>"><?=$row->zona?></td>
            <td bgcolor="<?=$bg?>"><?=$row->item?></td>
            <td bgcolor="<?=$bg?>"><?=$row->jenis_barang?></td>
            <td bgcolor="<?=$bg?>" align="center"><?=$row->lebar.'x'.$row->tinggi?></td>
            <td bgcolor="<?=$bg?>" align="center"><?=$row->warna?></td>
            <td bgcolor="<?=$bg?>" align="center"><?=$row->bukaan?></td>
            <td bgcolor="<?=$bg?>" align="center"><?=$row->tgl_pengiriman?></td>
            <td bgcolor="<?=$bg?>" align="center"><?=$row->qty?></td>
            <td bgcolor="<?=$bg?>" align="center"><?=$stok_real?></td>
            <td bgcolor="<?=$bg?>" align="center"><?=$stok_real-$row->qty?></td>
            <td bgcolor="<?=$bg?>" align="center"><?=$safetystok?></td>
            
          </tr>

        <?php endforeach;?>
        </tbody>
            </table>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tableku').DataTable( {
      "scrollX": true,
    } );
  });
</script>