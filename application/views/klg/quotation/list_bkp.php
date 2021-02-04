<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3>
              Master Harga Item
            </h3>
            <div class="box-tools pull-right">

              <?php
              $sesi = from_session('level');
              if ($sesi == '1' || $sesi == '3') {
                echo button('load_silent("master/harga_item/show_addForm/","#content")','Add New quotation','btn btn-success');
              } else {
                # code...
              }
              ?>
              
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>No Quotation</label>
                  <input type="text" class="form-control" id="no_quotation" name="no_quotation" placeholder="No Quotation" readonly required>
                </div>              
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Currency</label>
                  <select id="currency" name="currency" class="form-control" style="width:100%" required>
                    <option value="">-- Select Currency --</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Nama Proyek</label>
                  <input type="text" class="form-control" id="nama_proyek" placeholder="Nama Proyek" >
                </div>              
              </div>
            </div>
          </div>
          <div class="box-body">
            <table id="memListTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>No</th>
            <th>Kode</th>
            <th>Lebar</th>
            <th>Panjang</th>
            <th>Kode Tipe</th>
            <th>Kode Warna</th>
            <th>Currency</th>
            <th>Harga</th>
            <th>Act</th>
        </tr>
    </thead>
</table>
          </div>

        </div>
      </div>
    </div>

<script type="text/javascript">
// $(document).ready(function(){
//     var table = $('#memListTable').DataTable({
//         // Processing indicator
//         "processing": true,
//         // DataTables server-side processing mode
//         "serverSide": true,
//         "ordering": false,
//         "searching": false,
//         // Initial no order.
//         "order": [],
//         // Load data from an Ajax source
//         "ajax": {
//             "url": "<?php echo base_url('master/harga_item/getMapping/'); ?>",
//             "type": "POST"
//         },
//         Set column definition initialisation properties
//         'columnDefs': [
//           {
//               "targets": [1], // your case first column
//               "visible": false,
//               "searchable": false
//          },
//          {
//               "targets": [0], // your case first column
//               "orderable": false,
//               "width": "4%"
//          },
//          {
//               "targets": [0,8],
//               "className": "text-center",
//          },
//          {
//             "targets": -1,
//             "data": null,
//             "defaultContent": "<button class='edit btn btn-info'>Edit</button>"
//         }
//         ]

//     });
      
//       $('#memListTable tbody').on( 'click', 'button.edit', function () {
//           var data = table.row( $(this).parents('tr') ).data();
//                   load_silent("master/harga_item/show_editForm/"+data[ 1 ]+"","#content");
//       } );
// });

var table;
    $(document).ready(function() {
 
        //datatables
        table = $('#memListTable').DataTable({ 
 
            "processing": true, 
            "serverSide": true, 
            "ordering": false,
            "order": [], 
             
            "ajax": {
                "url": "<?php echo site_url('master/harga_item/getLists')?>",
                "type": "POST"
            },
 
             
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            {
                  "targets": [1], 
                  "visible": false,
                  "searchable": false
             },
             {
                  "targets": [0,8],
                  "className": "text-center",
             },
            {
                "targets": -1,
                "data": null,
                "defaultContent": "<button class='edit btn btn-info'>Edit</button>"
            },
            ],
 
        });
              $('#memListTable tbody').on( 'click', 'button.edit', function () {
                  var data = table.row( $(this).parents('tr') ).data();
                          load_silent("master/harga_item/show_editForm/"+data[ 1 ]+"","#content");
              } );
 
    });
</script>