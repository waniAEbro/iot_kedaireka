<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3>
              Quotation
            </h3>
            <div class="box-tools pull-right">

              <?php
              $sesi = from_session('level');
                echo button('load_silent("klg/quotation/formAdd","#content")','Add New quotation','btn btn-success');
              
              ?>
              
            </div>
          </div>

          <div class="box-body">
            <table id="memListTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>No</th>
            <th>No Quotation</th>
            <th>Aplikator</th>
            <th>Nama Proyek</th>
            <th>Owner</th>
            <th>Kontak</th>
            <th>Status</th>
            <th>act</th>
        </tr>
    </thead>
</table>
          </div>




        </div>
      </div>
    </div>

<script type="text/javascript">
$(document).ready(function(){
    var table = $('#memListTable').DataTable({
        // Processing indicator
        "processing": true,
        // DataTables server-side processing mode
        "serverSide": true,
        // Initial no order.
        "ordering": false,
        "order": [],
        // Load data from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('klg/quotation/getLists/'); ?>",
            "type": "POST"
        },
        //Set column definition initialisation properties
        'columnDefs': [
          {
              "targets": [1], // your case first column
              "visible": false,
              "searchable": false
         },
         {
              "targets": [6],
              "searchable": false
         },
         {
              "targets": [0], // your case first column
              "orderable": false,
              "width": "4%"
         },
         {
              "targets": [0,6],
              "className": "text-center",
         },
         {
            "targets": -1,
            "data": null,
            "className": "text-center",
            "defaultContent": "<div class='dropdown'><button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown'>Status<span class='caret'></span></button><ul class='dropdown-menu'><li><button class='b1'>Pending</button><button class='b2'>Deal</button><button class='b3'>Lost</button><button class='b4'>Cancel</button></li></ul></div><button class='edit btn btn-info btn-xs'>Edit</button><button class='cetak btn btn-success btn-xs'>Cetak</button>"
        }
        ]

    });
      $('#memListTable tbody').on( 'click', 'button.b1', function () {
          var data = table.row( $(this).parents('tr') ).data();
          var r = confirm("Apakah anda yakin?");
                if (r == true) {
                  load_silent("klg/quotation/validasi/1/"+data[ 1 ]+"","#content");
                }
      } );
      $('#memListTable tbody').on( 'click', 'button.b2', function () {
          var data = table.row( $(this).parents('tr') ).data();
          var r = confirm("Apakah anda yakin?");
                if (r == true) {
                  load_silent("klg/quotation/validasi/2/"+data[ 1 ]+"","#content");
                }
      } );
      $('#memListTable tbody').on( 'click', 'button.b3', function () {
          var data = table.row( $(this).parents('tr') ).data();
          var r = confirm("Apakah anda yakin?");
                if (r == true) {
                  load_silent("klg/quotation/validasi/3/"+data[ 1 ]+"","#content");
                }
      } );
      $('#memListTable tbody').on( 'click', 'button.b4', function () {
          var data = table.row( $(this).parents('tr') ).data();
          var r = confirm("Apakah anda yakin?");
                if (r == true) {
                  load_silent("klg/quotation/validasi/4/"+data[ 1 ]+"","#content");
                }
      } );
      $('#memListTable tbody').on( 'click', 'button.edit', function () {
          var data = table.row( $(this).parents('tr') ).data();
                  load_silent("klg/quotation/formEdit/"+data[ 1 ]+"","#content");
      } );
      // $('#memListTable tbody').on( 'click', 'button.dp', function () {
      //     var data = table.row( $(this).parents('tr') ).data();
      //             load_silent("klg/quotation/editDP/"+data[ 1 ]+"","#modal");
      // } );
      $('#memListTable tbody').on( 'click', 'button.cetak', function () {
        var data = table.row( $(this).parents('tr') ).data();
        var aidi = data[ 1 ];
        cetak1(aidi);
        cetak2(aidi);
        cetak3(aidi);
        
      } );

      
});

function cetak1 (aidi) {
  var win = window.open("<?php echo base_url('klg/quotation/cetak_quotation/');?>/"+aidi, "_blank");
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
}
function cetak2 (aidi) {
  var win = window.open("<?php echo base_url('klg/quotation/cetak_quotation2/');?>/"+aidi, "_blank");
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
}
function cetak3 (aidi) {
  var win = window.open("<?php echo base_url('klg/quotation/cetak_quotation3/');?>/"+aidi, "_blank");
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
}

</script>