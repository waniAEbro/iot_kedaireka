<div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Form Pembulanan Invoice</h3>

        <div class="box-tools pull-right">
          <button type="button" id="tutup" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
                <div class="col-lg-12">     
                    <table border="0" width="100%">
                        </br>
                        <tr>
                            <td width="15%">Nama Store</td>
                            <td>: <?=$header->store?></td>
                        </tr>
                        <tr>
                            <td>Pembeli</td>
                            <td>: <?=$header->pembeli?></td>
                        </tr>
                        <tr>
                            <td>No. telp</td>
                            <td>: <?=$header->no_telp?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: <?=$header->alamat?></td>
                        </tr>
                        <tr>
                            <td>Tgl Pengiriman</td>
                            <td>: <?=$header->tgl_pengiriman?></td>
                        </tr>                                                      
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <table width="100%" class="table table-bordered">
                            <tdead>
                                <th width="1%">No</th>
                                <th width="5%">Tipe</th>
                                <th width="10%">Item</th>
                                <th width="10%">Warna</th>
                                <th width="5%">Bukaan</th>
                                <th width="10%">Harga Per Unit</th>
                                <th width="5%">Qty</th>
                                <th width="10%">Total</th>
                                <?php 
                                if ($header->id_case < 3) { ?>
                                <th width="5%">Promo Bulanan</th>
                                <?php } ?>
                            </tdead>
                            <tbody>
                                <?php $i = 1; $subtotal=0; $subtotal_promo=0; $jumlah=0; ?>
                                <?php foreach($produk as $val):
                                $harga = $val->harga / 1.1; // ppn 10%

                                if ($header->id_case == 3) {
                                    $harga_promo = $val->promo/1.1;
                                    $tulis_promo = number_format($val->promo,2,',','.');
                                } elseif ($header->id_case == 2) {
                                    $harga_promo = $val->promo/100 * ($harga-($harga*$header->diskon/100));
                                    $tulis_promo = '';
                                } else {
                                    $harga_promo = $val->promo/100 * $harga;
                                    $tulis_promo = '';
                                }
                                
                                // $harga_promo = $harga - ($harga * $val->promo/100);

                                $total_row = $harga * $val->qty;
                                $total_row_promo = $harga_promo * $val->qty;

                                $subtotal = $subtotal + $total_row;
                                $subtotal_promo = $subtotal_promo + $total_row_promo;

                                $jumlah = $jumlah + $val->qty;
                                 
                                ?>
                                    <tr>
                                        <td align="center"><?=$i?></td>
                                        <td align="center"><?=$val->tipe?></td>
                                        <td><?=$val->item?></td>
                                        <td align="center"><?=$val->warna?></td>
                                        <td align="center"><?=$val->bukaan?></td>
                                        <td align="center"><?=number_format($harga,2,',','.')?></td>
                                        <td align="right"><?=$val->qty?></td>
                                        <td align="right"><?=number_format($total_row,2,',','.')?></td>
                                        <?php 
                                        if ($header->id_case < 3) { ?>
                                        <td align="right"><?=$val->promo?>%</td>
                                        <?php } ?>
                                    </tr>
                                <?php $i++; endforeach;  ?>
                            </tbody>
                            <tr>
                                <td width="80%" colspan="6"><b>Sub Total I</b></td>
                                <td width="10%" align="right"><?=$jumlah?></td>
                                <?php 
                                if ($header->id_case < 3) { ?>
                                <td colspan="2" width="10%" align="right"><?=number_format($subtotal,2,',','.')?></td>
                                <?php } else{ ?>
                                <td width="10%" align="right"><?=number_format($subtotal,2,',','.')?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td width="80%" colspan="6">Diskon Margin</td>
                                <td width="10%" align="right"><?=$header->diskon."%"?></td>
                                <?php $subotal_diskon = $subtotal * $header->diskon/100; ?>
                                <?php 
                                if ($header->id_case < 3) { ?>
                                <td colspan="2" width="10%" align="right"><?=number_format($subotal_diskon,2,',','.')?></td>
                                <?php } else{ ?>
                                <td width="10%" align="right"><?=number_format($subotal_diskon,2,',','.')?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td width="80%" colspan="6"><b>Sub Total II</b></td>
                                <td width="10%" align="right"></td>
                                <?php $subtotal2 = $subtotal - $subotal_diskon; ?>
                                <?php 
                                if ($header->id_case < 3) { ?>
                                <td colspan="2" width="10%" align="right"><?=number_format($subtotal2,2,',','.')?></td>
                                <?php } else{ ?>
                                <td width="10%" align="right"><?=number_format($subtotal2,2,',','.')?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td width="80%" colspan="6">Promo Bulanan</td>
                                <td width="10%" align="right"><?=$tulis_promo?></td>
                                <?php
                                    if ($header->id_case < 3) {
                                        $promo = $subtotal_promo;
                                    } else {
                                        $promo = $harga_promo;
                                    }
                                ?>
                                <?php 
                                if ($header->id_case < 3) { ?>
                                <td colspan="2" width="10%" align="right"><?=number_format($promo,2,',','.')?></td>
                                <?php } else{ ?>
                                <td width="10%" align="right"><?=number_format($promo,2,',','.')?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td width="80%" colspan="6"><b>Sub Total III</b></td>
                                <td width="10%" align="right"></td>
                                <?php $subtotal3 = $subtotal2 - $promo; ?>
                                <?php 
                                if ($header->id_case < 3) { ?>
                                <td colspan="2" width="10%" align="right"><?=number_format($subtotal3,2,',','.')?></td>
                                <?php } else{ ?>
                                <td width="10%" align="right"><?=number_format($subtotal3,2,',','.')?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td width="80%" colspan="6">PPN</td>
                                <td width="10%" align="right"><?=$header->ppn."%"?></td>
                                <?php $ppn = $subtotal3 * $header->ppn/100;?>
                                <?php 
                                if ($header->id_case < 3) { ?>
                                <td colspan="2" width="10%" align="right"><?=number_format($ppn,2,',','.')?></td>
                                <?php } else{ ?>
                                <td width="10%" align="right"><?=number_format($ppn,2,',','.')?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td width="80%" colspan="6"><b>Sub Total IV</b></td>
                                <td width="10%" align="right"></td>
                                <?php $subtotal4 = $subtotal3 + $ppn; ?>
                                <?php
                                if ($header->id_case < 3) { ?>
                                <td colspan="2" width="10%" align="right"><?=number_format($subtotal4,2,',','.')?></td>
                                <?php } else{ ?>
                                <td width="10%" align="right"><?=number_format($subtotal4,2,',','.')?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td width="80%" colspan="6">Biaya Pengiriman</td>
                                <td width="10%" align="right"></td>
                                <?php
                                if ($header->id_case < 3) { ?>
                                <td colspan="2" width="10%" align="right"><?=number_format($header->biaya_kirim,2,',','.')?></td>
                                <?php } else{ ?>
                                <td width="10%" align="right"><?=number_format($header->biaya_kirim,2,',','.')?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td width="80%" colspan="6"><b>Total Penjualan</b></td>
                                <td width="10%" align="right"></td>
                                <?php
                                if ($header->id_case < 3) { ?>
                                <td colspan="2" width="10%" align="right"><?=number_format($subtotal4 + $header->biaya_kirim,2,',','.')?></td>
                                <?php } else{ ?>
                                <td width="10%" align="right"><?=number_format($subtotal4 + $header->biaya_kirim,2,',','.')?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td width="80%" colspan="6"><b>Pembulatan</b></td>
                                <td width="10%" align="right"></td>
                                <?php
                                if ($header->id_case < 3) { ?>
                                <td colspan="2" width="10%" align="right"><?=number_format($header->pembulatan_gt,2,',','.')?></td>
                                <?php } else{ ?>
                                <td width="10%" align="right"><?=number_format($header->pembulatan_gt,2,',','.')?></td>
                                <?php } ?>
                            </tr>
                        </table>
                        
                    </div>
                </div>
            </div>
      </div>

      <div class="box-body">
        <form method="post" class="form-vertical form_faktur" role="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Pembulatan Grand Total</label>
                <input type="hidden" class="form-control" id="id_invoice" value="<?=$id?>" name="id_invoice" readonly>
                <?php $gt = $subtotal4 + $header->biaya_kirim; ?>
                <input type="text" class="form-control" id="gt" value="<?=$gt?>" placeholder="Grand Total">
              </div>
            </div>
          </div>
      </div>
        <div class="box-footer">
          <button type="submit" onclick="save()" id="proses" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>

<script language="javascript">

function save()
{
  $(this).find("button[type='submit']").prop('disabled',true);
    
        $.ajax({
        type: "POST",
        url:site+'warehouse/invoice/updatePembulatan',
        dataType:'json',
        data: {
            id_invoice     : $('#id_invoice').val(),
            pembulatan_gt         : $("#gt").val(),          
        },
        success   : function(data)
        {
          $.growl.notice({ title: 'Sukses', message: data['msg']});
          load_silent("warehouse/invoice/","#content");
        }
      });
    
  
}

</script>