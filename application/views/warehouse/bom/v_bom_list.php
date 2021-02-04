<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">BOM</h3>

            <div class="box-tools pull-right">
            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                echo button('load_silent("master/warna/form/base","#modal")','Add BOM','btn btn-success');
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
    <th class="tg-fll5">NO.</th>
    <th class="tg-fll5">CYCLE</th>
    <th class="tg-fll5">SECTION</th>
    <th class="tg-fll5">TEMP</th>
    <th class="tg-fll5">PANJANG</th>
    <th class="tg-bobw">WARNA</th>
    <th class="tg-bobw">QTY</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg-8d8j">1</td>
    <td class="tg-8d8j">61</td>
    <td class="tg-8d8j">70053</td>
    <td class="tg-8d8j">5</td>
    <td class="tg-8d8j">6000</td>
    <td class="tg-8d8j">PUTIH</td>
    <td class="tg-8d8j">20</td>
  </tr>
  <tr>
    <td class="tg-8d8j">2</td>
    <td class="tg-8d8j">61</td>
    <td class="tg-8d8j">70052</td>
    <td class="tg-8d8j">5</td>
    <td class="tg-8d8j">6000</td>
    <td class="tg-8d8j">PUTIH</td>
    <td class="tg-8d8j">30</td>
  </tr>
  <tr>
    <td class="tg-8d8j">3</td>
    <td class="tg-8d8j">61</td>
    <td class="tg-8d8j">12020</td>
    <td class="tg-8d8j">5</td>
    <td class="tg-8d8j">6000</td>
    <td class="tg-8d8j">HITAM</td>
    <td class="tg-8d8j">40</td>
  </tr>
  <tr>
    <td class="tg-8d8j">4</td>
    <td class="tg-8d8j">61</td>
    <td class="tg-8d8j">51115</td>
    <td class="tg-8d8j">5</td>
    <td class="tg-8d8j">6000</td>
    <td class="tg-8d8j">HITAM</td>
    <td class="tg-8d8j">50</td>
  </tr>
  <tr>
    <td class="tg-8d8j">5</td>
    <td class="tg-8d8j">61</td>
    <td class="tg-8d8j">51020</td>
    <td class="tg-8d8j">5</td>
    <td class="tg-8d8j">6000</td>
    <td class="tg-8d8j">HITAM</td>
    <td class="tg-8d8j">60</td>
  </tr>
  <tr>
    <td class="tg-8d8j">6</td>
    <td class="tg-8d8j">61</td>
    <td class="tg-8d8j">70053</td>
    <td class="tg-8d8j">5</td>
    <td class="tg-8d8j">6000</td>
    <td class="tg-8d8j">CREAM</td>
    <td class="tg-8d8j">15</td>
  </tr>
  <tr>
    <td class="tg-8d8j">7</td>
    <td class="tg-8d8j">61</td>
    <td class="tg-8d8j">70052</td>
    <td class="tg-8d8j">5</td>
    <td class="tg-8d8j">6000</td>
    <td class="tg-8d8j">CREAM</td>
    <td class="tg-8d8j">23</td>
  </tr>
  <tr>
    <td class="tg-8d8j">8</td>
    <td class="tg-8d8j">61</td>
    <td class="tg-8d8j">51115</td>
    <td class="tg-8d8j">5</td>
    <td class="tg-8d8j">6000</td>
    <td class="tg-8d8j">CREAM</td>
    <td class="tg-8d8j">11</td>
  </tr>
  <tr>
    <td class="tg-8d8j">9</td>
    <td class="tg-8d8j">61</td>
    <td class="tg-8d8j">51020</td>
    <td class="tg-8d8j">5</td>
    <td class="tg-8d8j">6000</td>
    <td class="tg-8d8j">CREAM</td>
    <td class="tg-8d8j">19</td>
  </tr>
  <tr>
    <td class="tg-8d8j">10</td>
    <td class="tg-8d8j">61</td>
    <td class="tg-8d8j">70047</td>
    <td class="tg-8d8j">5</td>
    <td class="tg-8d8j">6000</td>
    <td class="tg-8d8j">CREAM</td>
    <td class="tg-8d8j">47</td>
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