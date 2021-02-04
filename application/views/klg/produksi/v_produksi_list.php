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
            <h3 class="box-title">List Produksi</h3>

            <div class="box-tools pull-right">
            <?php
                echo button('load_silent("klg/produksi/formAdd","#content")','Tambah Produksi','btn btn-success');
              
              ?>
            </div>
          </div>
          <div class="box-body">
          <style type="text/css" media="screen">
          .large-table-container-3 {
            /*max-width: 800px;*/
            overflow-x: scroll;
            overflow-y: auto;
          }
          .large-table-container-3 table {
            
          }
          .large-table-fake-top-scroll-container-3 {
            /*max-width: 800px;*/
            overflow-x: scroll;
            overflow-y: auto;
          }
          .large-table-fake-top-scroll-container-3 div {
            background-color: red;
            font-size:1px;
            line-height:1px;
          }

          /*misc*/
          td {
            border: 1px solid gray;
          }
            
          </style>
          <div class="large-table-fake-top-scroll-container-3">
            <div>&nbsp;</div>
          </div>
          <div class="large-table-container-3">
            <table width="100%" id="tableku" class="table table-striped">
              <thead>
                <th width="5%"></th>
                <th width="5%">No</th>
                <th>No Produksi</th>
                <th>Tanggal</th>
                <th>Total Produksi</th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($produksi->result() as $row): 
            $ada = $this->m_produksi->getJumDetail($row->id);
          ?>
          <tr>
            <?php if ($ada=='1') { ?>
            <td class="details-control" id="<?=$i?>"></td>
             <?php } else { ?>
            <td></td>
            <?php }  ?>
            <td align="center"><?=$i?></td>
            <td align="center"><?=$row->no_produksi?></td>
            <td align="center"><?=$row->tgl?><input type="hidden" id="id_sku_<?=$i?>" value="<?=$row->id?>"></td>
            <td align="right"><?=$row->total?></td>
          </tr>

        <?php $i++; endforeach;?>
        </tbody>
            </table>
          </div>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tableku').DataTable( {
      "ordering": true,
      // "scrollX": true,
    } );
  

  $('#tableku tbody').on('click', 'td.details-control', function (e) {
    var tr = $(this).closest('tr');
    var td = $(this).closest('td');
    var row = table.row( tr );
          if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
          }
          else {
            dataRow = format(td[0].id, row, tr);            
          }
        });
    function format (id, row, tr) {

    infoTable = '<table id="infoTable" class="table table-bordered" border="0" style="font-size: smaller;">'+
    '<tr bgcolor="#c7c4ff">'+
    '<th>No</th>'+
    '<th>Item</th>'+
    '<th>Ukuran</th>'+
    '<th>Gambar</th>'+
    '<th>Warna</th>'+
    '<th>Bukaan</th>'+
    '<th>Qty</th>'+
    '<th>Act</th>'+
    '</tr>';

    var id_sku = $('#id_sku_'+id).val();

    $.ajax({
      url: "<?=site_url('klg/produksi/getDetailTabel')?>",
      type: 'POST',
      dataType: 'JSON',
      data: {
        id_sku : id_sku,
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
          
          infoTable += '<tr bgcolor="'+color+'">'+
          '<td><font color="'+fontcolor+'">'+no+'</font></td>'+
          '<td><font color="'+fontcolor+'">'+data.detail[i].item+'</font></td>'+
          '<td align="center"><font color="'+fontcolor+'">'+data.detail[i].lebar+'x'+data.detail[i].tinggi+'</font></td>'+
          '<td align="center"><font color="'+fontcolor+'"><img src="<?=base_url("'+data.detail[i].gambar+'")?>" height="30px"></font></td>'+
          '<td align="center"><font color="'+fontcolor+'">'+data.detail[i].warna+'</font></td>'+
          '<td align="center"><font color="'+fontcolor+'">'+data.detail[i].bukaan+'</font></td>'+
          '<td align="center"><font color="'+fontcolor+'">'+data.detail[i].jml+'</font></td>'+
          '<td align="center"><a href="javascript:void(0)" class="btn btn-xs btn-primary" onClick="detail('+data.detail[i].id+')">Detail</a></td>'+
          '</tr>';
               
      };
      
      infoTable += '</table>';
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
});

function detail(id) {
  load_silent("klg/produksi/detail/"+id,"#content");
}


  $(function() {
  var tableContainer = $(".large-table-container-3");
  var table = $(".large-table-container-3 table");
  var fakeContainer = $(".large-table-fake-top-scroll-container-3");
  var fakeDiv = $(".large-table-fake-top-scroll-container-3 div");

  var tableWidth = table.width();
  fakeDiv.width(tableWidth);
  
  fakeContainer.scroll(function() {
    tableContainer.scrollLeft(fakeContainer.scrollLeft());
  });
  tableContainer.scroll(function() {
    fakeContainer.scrollLeft(tableContainer.scrollLeft());
  });
})
</script>