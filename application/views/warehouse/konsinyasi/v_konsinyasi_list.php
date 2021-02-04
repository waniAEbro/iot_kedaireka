<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Warehouse Konsinyasi</h3>

            <div class="box-tools pull-right">
            
            </div>
          </div>

          <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Store</label>
                    <select id="store" name="store" class="form-control">
                      <option value="">-- Select Store --</option>
                      <?php foreach ($store->result() as $valap):?>
                        <?php if($id_store==$valap->id){$selected='selected';}else{$selected='';}?>
                        <option value="<?=$valap->id?>" <?=$selected?> ><?=$valap->store?></option>
                      <?php endforeach;?>
                    </select>
                  </div>              
                </div>

            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="box-tools pull-right">
                  <a class="btn btn-success" onclick="setFilter()">Set Filter</a>
                </div>
               </div>
            </div>
          </div>

          <div class="box-body">
            <table width="100%" id="tableku" class="table table-striped">
              <thead>
                <th width="5%">No</th>
                <th>Store</th>
                <th>Item</th>
                <th>Tipe</th>
                <th>Warna</th>
                <th>Bukaan</th>
                <th>Stok</th>
                <th></th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($konsinyasi->result() as $row):  
          $stok = $row->qty_in-$row->qty_out;             
          ?>
          <tr>
            <td><?=$i++?></td>
            <td><?=$row->store?></td>
            <td><?=$row->item.' ('.$row->lebar.'x'.$row->tinggi.')'?></td>
            <td align="center"><?=$row->tipe?></td>
            <td align="center"><?=$row->warna?></td>
            <td align="center"><?=$row->bukaan?></td>
            <td align="center"><?=$stok?></td>
            <td align="center"><?=button('load_silent("warehouse/konsinyasi/transfer/'.$row->id.'","#content")','Transfer Stok','btn btn-xs btn-info','data-toggle="tooltip" title="Transfer"');?></td>
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
    $("select").select2();
  });

  function setFilter () {
    var store   = $('#store').val();
    if (store != '') { var id_store = store; } else{ var id_store = 'x'; };
    load_silent("warehouse/konsinyasi/filter/"+id_store+"/","#content");
    
  }
</script>