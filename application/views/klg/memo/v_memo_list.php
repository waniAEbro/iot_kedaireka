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
            <h3 class="box-title">List Memo</h3>

            <div class="box-tools pull-right">
            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                echo button('load_silent("klg/memo/formAdd","#content")','Tambah Memo','btn btn-success');
              } else {
                # code...
              }
              ?>
              <button type="button" class="btn bg-purple" onclick="cetak()" data-toggle="tooltip" title="Print">Print</button>
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
                <th>Store</th>
                <th>No Memo</th>
                <th>Nama Project</th>
                <th>Alamat Project</th>
                <th>Tgl Memo</th>
                <th>Deadline Pengambilan</th>
                <th>No FPPP</th>
                <th>Charge</th>
                <th>Alasan</th>
                <th>Act</th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($memo->result() as $row): 
            $ada = $this->m_memo->getJumDetail($row->id);
          ?>
          <tr>
            <?php if ($ada > 0) { ?>
            <td class="details-control" id="<?=$i?>"></td>
             <?php } else { ?>
            <td></td>
            <?php }  ?>
            <td align="center"><?=$i?></td>
            <td><?=$row->store?><input type="hidden" id="id_sku_<?=$i?>" value="<?=$row->id?>"></td>
            <td><?=$row->no_memo?></td>
            <td><?=$row->nama_project?></td>
            <td><?=$row->alamat_project?></td>
            <td><?=$row->tgl_memo?></td>
            <td><?=$row->deadline_pengambilan?></td>
            <td><?=$row->no_fppp?></td>
            <td><?=$row->charge?></td>
            <td><?=$row->alasan?></td>
            <td align="center">
            <a target="_blank" href="<?=base_url('klg/memo/cetak');?>/<?=$row->id?>" class="btn btn-xs btn-warning">Cetak</a>
            
            <?php if ($row->lampiran!='') { ?>
            <a target="_blank" href="<?=base_url($row->lampiran);?>" class="btn btn-xs btn-danger">Lampiran</a>
            <?php } ?>

            <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '2') {
                echo button('load_silent("klg/memo/formEdit/'.$row->id.'","#content")','Edit','btn btn-xs btn-info','data-toggle="tooltip" title="Edit"');
                if ($row->id_status == 1) {
                echo '<br>'.button('load_silent("klg/memo/permintaan/'.$row->id.'","#content")','Buat Ke Prioritas Pengiriman','btn btn-xs btn-default','data-toggle="tooltip" title="Jadi Permintaan"');
                } else{
                  echo '<br>'.'<b>Sudah ada di Permintaan</b>';
                }
              }
              ?>
            </td>
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
function cetak()
  {
    var left = (screen.width/2)-(640/2);
    var top = (screen.height/2)-(480/2);
    var url = "<?=site_url('klg/memo/cetakTabel')?>";
    window.open(url, "", "width=640, height=480, scrollbars=yes, left="+left+", top="+top);
  }

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
    '<th>Gambar</th>'+
    '<th>Ada di WO</th>'+
    '<th>Alasan</th>'+
    '<th>Charge</th>'+
    '<th>Brg Dikembalikan</th>'+
    '<th>Keterangan</th>'+
    '</tr>';

    var id_sku = $('#id_sku_'+id).val();

    $.ajax({
      url: "<?=site_url('klg/memo/getDetailTabel')?>",
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
          '<td><font color="'+fontcolor+'">'+data.detail[i].tipe+'-'+data.detail[i].item+' ('+data.detail[i].lebar+'x'+data.detail[i].tinggi+') '+data.detail[i].warna+'-'+data.detail[i].bukaan+'</font></td>'+
          '<td align="center"><font color="'+fontcolor+'"><img src="<?=base_url("'+data.detail[i].gambar+'")?>" height="30px"></font></td>'+
          '<td align="center"><font color="'+fontcolor+'">'+data.detail[i].ada_di_wo+'</font></td>'+
          '<td align="center"><font color="'+fontcolor+'">'+data.detail[i].alasan+'</font></td>'+
          '<td align="center"><font color="'+fontcolor+'">'+data.detail[i].charge+'</font></td>'+
          '<td align="center"><font color="'+fontcolor+'">'+data.detail[i].brg_dikembalikan+'</font></td>'+
          '<td align="center"><font color="'+fontcolor+'">'+data.detail[i].keterangan+'</font></td>'+
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
</script>