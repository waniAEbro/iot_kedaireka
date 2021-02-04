<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" media="all"  href="<?=base_url();?>assets/css/bootstrap.min.cetak.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" media="all"  href="<?=base_url();?>assets/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" media="all"  href="<?=base_url();?>assets/css/ionicons.min.css">
    <!-- tdeme style -->
    <link rel="stylesheet" media="all"  href="<?=base_url();?>assets/css/AdminLTE.min.css">

    <!-- jQuery 2.1.4 -->
    <script src="<?=base_url();?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?=base_url();?>assets/js/jquery-ui.min.js"></script>  
    <script>
        $(document).ready(function(e) {
            // window.print();

        });     
    </script>
    <script type="text/javascript">
        function cetak()
        {
            window.print();
        }
    </script>
    <style type="text/css" media="print">

        @page {
            size: auto;   /* auto is the initial value */
            margin-top: 0;  /* this affects the margin in the printer settings */
            margin-bottom: 0;  /* this affects the margin in the printer settings */
        }
        .btn-cetak
        {
            display: none;
        }

        .table td {
            padding:1px;
        }

    </style>
    <style type="text/css" media="print">
        .table>tbody>tr>th,.table>tfoot>tr>th,.table>thead>tr>th {
            text-align: center;
        }
    </style>

</head>
<body style="margin: 0px;">
    <div class="wrapper" style="font-size: smaller;">
        <!-- Content Header (Page header) -->       
        <section class="content-header">
            <a onclick="cetak()" id="cetak" name="cetak" class="btn btn-success btn-cetak"> Cetak</a>           
        </section>

        <section class="content" style="padding:0px;">
            <div class="row">
                <div class="col-lg-12">     
                    <table border="0" width="100%">
                        </br>
                        <tr>
                            <td><img id="prev_4" src="<?php echo base_url();?>assets/img/logo.png" style="height: 40px;"></td>
                            <td colspan="2"><h4>Sales Invoice</h4></td>
                        </tr>                                                    
                    </table>
                </div>
            </div>
            <!-- <hr> -->
            <div class="row">
                <div class="col-lg-12">     
                    <table border="0" width="100%">
                        </br>
                        <tr>
                            <td width="15%"></td>
                            <td align="right"><?=date('d M Y')?></td>
                        </tr>
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
        </section>      
    </div>

</body>
</html>