<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">FPPP</h3>

            <div class="box-tools pull-right">
            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                echo button('load_silent("master/warna/form/base","#modal")','Add FPPP','btn btn-success');
              } else {
                # code...
              }
              ?>
            </div>
          </div>
          <div class="box-body">

<table class="table">
<thead>
  <tr>
    <th class="tg-uzvj" rowspan="2">NO.</th>
    <th class="tg-uzvj" rowspan="2">TGL FPPP</th>
    <th class="tg-uzvj" rowspan="2">DEADLINE</th>
    <th class="tg-uzvj" rowspan="2">NO. FPPP</th>
    <th class="tg-uzvj" rowspan="2">NAMA PROYEK</th>
    <th class="tg-wa1i" rowspan="2">WARNA</th>
    <th class="tg-wa1i" rowspan="2">KOTA</th>
    <th class="tg-wa1i" rowspan="2">JUMLAH GAMBAR</th>
    <th class="tg-wa1i" rowspan="2">JUMLAH UNIT</th>
  </tr>
  <tr>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg-8d8j">1</td>
    <td class="tg-8d8j">1 JANUARI 2020</td>
    <td class="tg-8d8j">5 FEBRUARI 2020</td>
    <td class="tg-nrix">080/PP/I/2020</td>
    <td class="tg-nrix">BAPAK THOMAS</td>
    <td class="tg-8d8j">PUTIH &amp; HITAM</td>
    <td class="tg-8d8j">JAKARTA</td>
    <td class="tg-8d8j">5</td>
    <td class="tg-8d8j">5</td>
  </tr>
  <tr>
    <td class="tg-8d8j">2</td>
    <td class="tg-8d8j">1 JULI 2020</td>
    <td class="tg-8d8j">15 AGUSTUS 2020</td>
    <td class="tg-8d8j">099/PP/VII/2020</td>
    <td class="tg-8d8j">IBU JULLY</td>
    <td class="tg-8d8j">CREAM</td>
    <td class="tg-8d8j">SURABAYA</td>
    <td class="tg-8d8j">2</td>
    <td class="tg-8d8j">5</td>
  </tr>
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