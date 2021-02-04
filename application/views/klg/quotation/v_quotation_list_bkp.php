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
    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Quotation</h3>

            <div class="box-tools pull-right">

              <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '3') {
                echo button('load_silent("klg/quotation/formAdd","#content")','Add New quotation','btn btn-success');
              } else {
                # code...
              }
              ?>
              
            </div>
          </div>
          <div class="box-body">
            <table width="100%" id="tableku" class="table">
              <thead>
                <th width="2%"></th>
                <th width="3%">No</th>
                <th>No Quotation</th>
                <th>Nama Proyek</th>
                <th>Owner</th>
                <th>Kontak</th>
                <th>Status</th>
                <th>Act</th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($quotation->result() as $row):
            // $ada = '';
            $ada = $this->m_quotation->getJumDetail($row->id)->num_rows();
          ?>
          <tr>
            <?php if ($ada > 0) { ?>
            <td class="details-control" id="<?=$i?>"></td>
             <?php } else { ?>
            <td></td>
            <?php }  ?>
            <td><?=$i?></td>
            <td><?=$row->no_quotation?><input type="hidden" id="id_quotation_<?=$i?>" value="<?=$row->id?>"></td>
            
            <td><?=$row->nama_proyek?></td>
            <td><?=$row->nama_owner?></td>
            <td><?=$row->kontak?></td>
            <td align="center"><b><?=$row->status_quo?></b></td>
            <td>
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Status
              <span class="caret"></span></button>
              <ul class="dropdown-menu">
                <li><?=button_confirm("Anda yakin merubah status Quotation no: ".$row->no_quotation."?","klg/quotation/validasi/1/".$row->id,"#content",'Pending','','data-toggle="tooltip" title="Pending"');?></li>
                <li><?=button_confirm("Anda yakin merubah status Quotation no: ".$row->no_quotation."?","klg/quotation/validasi/2/".$row->id,"#content",'Deal','','data-toggle="tooltip" title="Deal"');?></li>
                <li><?=button_confirm("Anda yakin merubah status Quotation no: ".$row->no_quotation."?","klg/quotation/validasi/3/".$row->id,"#content",'Lost','','data-toggle="tooltip" title="Lost"');?></li>
                <li><?=button_confirm("Anda yakin merubah status Quotation no: ".$row->no_quotation."?","klg/quotation/validasi/4/".$row->id,"#content",'Cancel','','data-toggle="tooltip" title="Cancel"');?></li>
              </ul>
            </div>
            <?php
              $sesi = from_session('level');
              if ($sesi == '1') {
                echo button('load_silent("klg/quotation/formEdit/'.$row->id.'","#content")','Edit','btn btn-info','data-toggle="tooltip" title="Edit"');
                echo button('load_silent("klg/quotation/editDP/'.$row->id.'","#modal")','Edit DP','btn btn-primary','data-toggle="tooltip" title="Edit DP"');
              } elseif ($sesi == '3') {
                echo button('load_silent("klg/quotation/formEdit/'.$row->id.'","#content")','Edit','btn btn-info','data-toggle="tooltip" title="Edit"');
              }
              ?>
              
            </td>
          </tr>
          <?php $i++;?>
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
      "ordering": false,
    } );
    // Add event listener for opening and closing details
  $('#tableku tbody').on('click', 'td.details-control', function (e) {
    // $('tr.shown').removeClass('shown');
    // $('#infoTable').hide();
    var tr = $(this).closest('tr');
    var td = $(this).closest('td');
    // console.log(td[0].id);
    var row = table.row( tr );
          if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
          }
          else {
            // Open this row
            dataRow = format(td[0].id, row, tr);            
          }
        });
  });

  function format (id, row, tr) {

    infoTable = '<table id="infoTable" class="table table-bordered" border="0" style="font-size: smaller;">'+
    '<tr bgcolor="#c7c4ff">'+
    '<th>No</th>'+
    '<th>Kode Gambar</th>'+
    '<th>Lokasi</th>'+
    '<th>Item</th>'+
    '<th>Tipe</th>'+
    '<th>Warna</th>'+
    '<th>Panjang</th>'+
    '<th>Lebar</th>'+
    '<th>Quantity</th>'+
    '<th>Keterangan</th>'+
    '</tr>';

    var id_quotation = $('#id_quotation_'+id).val();

    $.ajax({
      url: "<?=site_url('klg/quotation/getDetailQuotation')?>",
      type: 'POST',
      dataType: 'JSON',
      data: {
        id_quotation : id_quotation,
      },
    })
    .done(function(data) {      
      // console.log(data.detail);
      var total_semua = 0;
      var total_cbm = 0;
      for (var i = 0; i < data.detail.length; i++) {
          var no = i+1;
          var color = "white";
          var fontcolor = "black";
          var total = data.detail[i].harga * data.detail[i].qty;
          var total_semua = total_semua + total;
          var dp = data['dp'];
          var cur = data['mata_uang'];
          infoTable += '<tr bgcolor="'+color+'">'+
          '<td><font color="'+fontcolor+'">'+no+'</font></td>'+
          '<td><font color="'+fontcolor+'">'+data.detail[i].kode_gambar+'</font></td>'+
          '<td><font color="'+fontcolor+'">'+data.detail[i].lokasi+'</font></td>'+
          '<td><font color="'+fontcolor+'">'+data.detail[i].item+'</font></td>'+
          '<td><font color="'+fontcolor+'">'+data.detail[i].tipe+'</font></td>'+
          '<td align="center"><font color="'+fontcolor+'">'+data.detail[i].warna+'</font></td>'+
          '<td align="center"><font color="'+fontcolor+'">'+data.detail[i].panjang+'</font></td>'+
          '<td align="center"><font color="'+fontcolor+'">'+data.detail[i].lebar+'</font></td>'+
          '<td align="right"><font color="'+fontcolor+'">'+data.detail[i].qty+'</font></td>'+
          '<td><font color="'+fontcolor+'">'+data.detail[i].keterangan+'</font></td>'+
          '</tr>';
               
      };
      
      // infoTable += '<tr bgcolor="#f7f7f7">'+
      //             '<td colspan="10">Total</td>'+
      //             '<td align="right">'+cur+' '+commaSeparateNumber(total_semua)+'</td>'+
      //             '</tr>'+
      //             '<tr bgcolor="#f7f7f7">'+
      //             '<td colspan="10">DownPayment</td>'+
      //             '<td align="right">'+cur+' '+commaSeparateNumber(dp)+'</td>'+
      //             '</tr>'+
      //             '<tr bgcolor="#c7c4ff">'+
      //             '<td colspan="10">Grand Total</td>'+
      //             '<td align="right">'+cur+' '+commaSeparateNumber(total_semua - dp)+'</td>'+
      //             '</tr>'+
      //             '</table>';
      // console.log(infoTable);
      // return infoTable;
      row.child(infoTable).show();
      tr.addClass('shown');
    })
.fail(function() {
  console.log("error");
})
.always(function() {
      // console.log("complete");
    });  

return infoTable;
}

function commaSeparateNumber (val) {
  val = val.toString();
  while (/(\d+)(\d{3})/.test(val)){
    val = val.replace(/(\d+)(\d{3})/, '$1'+'.'+'$2');
  }
  return val;
}
</script>