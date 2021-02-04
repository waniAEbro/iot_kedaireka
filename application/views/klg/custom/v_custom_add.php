    <div class="row" id="form_pembelian">
      <div class="col-lg-3">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Input Custom</h3>
          </div>
          <div class="div-pembelian">
            <form method="post" class="form-vertical form" role="form" id="formid">
              <div class="box-body">
                <div class="form-group">
                  <label>Jenis Custom</label>
                  <select id="jenis_fppp" name="jenis_fppp" class="form-control" style="width:100%" required>
                    <option value="">-- Select Jenis Custom --</option>
                    <option value="1">dari Form Permintaan</option>
                    <option value="2">tdk dari Form Permintaan</option>
                  </select>
                </div>

                <!-- start dr form order -->
                <div class="form-group">
                  <label class="control-label" for="merk">Tgl Produksi:</label>
                  <input type="text" data-date-format="yyyy-mm-dd" class="form-control datepicker" id="tgl" name="tgl" autocomplete="off">
                </div>
                <div class="divcustom">
                  <div class="form-group">
                    <label>No Permintaan</label>
                    <select id="id_invoice" name="id_invoice" class="form-control" style="width:100%" required>
                      <option value="">-- Select No Permintaan --</option>
                      <?php foreach ($no_permintaan as $val) : ?>
                        <option value="<?= $val->id ?>"><?= $val->no_invoice ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Item</label>
                    <select id="item" name="item" class="form-control" style="width:100%" required>
                      <option value="">-- Select Item --</option>
                    </select>
                    <span id='gbritem'></span>
                    <span id='jenis_barang'></span>
                  </div>
                  <div class="form-group">
                    <label>Warna</label>
                    <select id="warna" name="warna" class="form-control" style="width:100%" required>
                      <option value="">-- Select Warna --</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Bukaan:</label>
                    <select id="bukaan" name="bukaan" class="form-control" style="width:100%" required>
                      <option value="">-- Select Bukaan --</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Lebar (mm):</label>
                    <select id="lebar" name="lebar" class="form-control" style="width:100%" required>
                      <option value="">-- Select Lebar --</option>
                    </select>
                    <span id="infolebar"></span>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Tinggi (mm):</label>
                    <select id="tinggi" name="tinggi" class="form-control" style="width:100%" required>
                      <option value="">-- Select Lebar --</option>
                    </select>
                    <span id="infotinggi"></span>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Quantity:</label>
                    <input type="hidden" class="form-control" id="id_jenis_barang" name="id_jenis_barang" readonly>
                    <input type="hidden" class="form-control" id="id_produksi" name="id_produksi" readonly>
                    <input type="text" style="text-align: right;" class="form-control" id="qty" name="qty" placeholder="Quantity" autocomplete="off">
                    <input type="hidden" style="text-align: right;" class="form-control" id="qtyorderku" name="qtyorderku" placeholder="Quantity" autocomplete="off">
                    <span id="qtyorder"></span>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Cek 1:</label>
                    <input type="text" class="form-control" id="cek1" name="cek1" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Cek 2:</label>
                    <input type="text" class="form-control" id="cek2" name="cek2" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Cek 3:</label>
                    <input type="text" class="form-control" id="cek3" name="cek3" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <a onclick="quotation()" class="btn btn-info">Add Produksi Custom</a>
                  </div>
                </div>
                <!-- end dr form order -->
                <!-- start dr form direct -->
                <div class="divdirect">
                  <div class="form-group">
                    <label>Item</label>
                    <select id="item_d" name="item_d" class="form-control" style="width:100%" required>
                      <option value="">-- Select Item --</option>
                      <?php foreach ($item as $val) : ?>
                        <option value="<?= $val->id ?>"><?= $val->item ?></option>
                      <?php endforeach; ?>
                    </select>
                    <span id='gbritem'></span>
                    <span id='jenis_barang'></span>
                  </div>
                  <div class="form-group">
                    <label>Warna</label>
                    <select id="warna_d" name="warna_d" class="form-control" style="width:100%" required>
                      <option value="">-- Select Warna --</option>
                      <?php foreach ($warna as $val) : ?>
                        <option value="<?= $val->id ?>"><?= $val->warna ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Bukaan:</label>
                    <select id="bukaan_d" name="bukaan_d" class="form-control" style="width:100%" required>
                      <option value="">-- Select Bukaan --</option>
                      <option value="R">R</option>
                      <option value="L">L</option>
                      <option value="-">tdk ada</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Lebar (mm):</label>
                    <input type="text" style="text-align: right;" class="form-control" id="lebar_d" value="0" name="lebar_d" placeholder="Lebar" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Tinggi (mm):</label>
                    <input type="text" style="text-align: right;" class="form-control" id="tinggi_d" value="0" name="tinggi_d" placeholder="Tinggi" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Quantity:</label>
                    <input type="text" style="text-align: right;" class="form-control" id="qty_d" name="qty_d" placeholder="Quantity" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Cek Kesesuaian Ukuran:</label>
                    <input type="text" class="form-control" id="cek1_d" name="cek1_d" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Cek Kerapihan:</label>
                    <input type="text" class="form-control" id="cek2_d" name="cek2_d" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="merk">Cek Kelengkapan Unit:</label>
                    <input type="text" class="form-control" id="cek3_d" name="cek3_d" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <a onclick="quotation_d()" class="btn btn-primary">Add Produksi Custom</a>
                  </div>
                </div>
                <!-- end dr form direct -->
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Saved Item</h3>
          </div>
          <div class="box-body">
            <table width="100%" id="tableku" class="table table-bordered table-striped" style="font-size: smaller;">
              <thead>
                <tr>
                  <th width="5%">Act</th>
                  <th width="25%">Item</th>
                  <th width="10%">Ukuran</th>
                  <th width="10%">Warna</th>
                  <th width="5%">Bukaan</th>
                  <th width="5%">Quantity</th>
                </tr>
              </thead>
              <tbody id="dataTbl">
              </tbody>
            </table>
          </div>
          <div class="box-footer">
            <a onclick="finish()" class="btn btn-success pull-right"> Finish</a>
          </div>
        </div>
      </div>
    </div>

    <script language="javascript">
      function finish() {
        if (confirm('Anda yakin ingin menyelesaikan?')) {
          $.growl.notice({
            title: 'Berhasil',
            message: "Produksi selesai!"
          });
          load_silent("klg/custom/", "#content");
        }
      }
      $(document).ready(function() {
        $('.datepicker').datepicker({
          autoclose: true
        });

        $("select").select2();
        $(".harga").hide();
        $('.divcustom').hide();
        $('.divdirect').hide();

      });

      function save() {
        $(this).find("button[type='submit']").prop('disabled', true);
        $.ajax({
          type: "POST",
          url: site + 'klg/produksi/saveProduksi',
          dataType: 'json',
          data: {
            tgl: $("#tgl").val(),

          },
          success: function(data) {
            $('#id_produksi').val(data['id']);
            $.growl.notice({
              title: 'Sukses',
              message: data['msg']
            });
            $('#tutup').click();
            $('#form_pembelian').show(1000);
          }
        });
        return false;

      }

      var xi = 0;


      $('#formid').on('keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (e.keyCode == 13 || e.keyCode == 9) {
          e.preventDefault();
          quotation();
        }
      });

      function quotation() {
        if ($('#qty').val() > $('#qtyorderku').val()) {
          $.growl.error({
            title: 'Peringatan',
            message: 'Qty melebihi permintaan!'
          });
        } else {
          if ($('#item').val() != '' && $('#bukaan').val() != '' && $('#warna').val() != '' && $('#lebar').val() != '' && $('#tinggi').val() != '' && $('#qty').val() != '') {

            $.ajax({
                type: "POST",
                url: "<?= site_url('klg/custom/saveCustomDetail') ?>",
                dataType: 'json',
                data: {
                  'tgl': $("#tgl").val(),
                  'id_invoice': $("#id_invoice").val(),
                  'item': $("#item").val(),
                  'warna': $("#warna").val(),
                  'bukaan': $("#bukaan").val(),
                  'lebar': $("#lebar").val(),
                  'tinggi': $("#tinggi").val(),
                  'cek1': $("#cek1").val(),
                  'cek2': $("#cek2").val(),
                  'cek3': $("#cek3").val(),
                  'qty': $("#qty").val(),
                },
              })
              .success(function(datasaved) {
                //code here
                xi++;
                var i = datasaved['id'];


                var x = '<tr id="output_data_' + i + '" class="output_data">\
                  <td width="5%" align="center">\
                    <a href="javascript:void(0)" onClick="hapus(' + i + ')">\
                      <i class="fa fa-trash"></i>\
                    </a>\
                  </td>\
                  <td width="25%">\
                    ' + $('#item :selected').text() + '\
                  </td>\
                  <td width="10%">\
                    ' + $('#lebar').val() + 'x' + $('#tinggi').val() + '\
                  </td>\
                  <td width="10%">\
                    ' + $('#warna :selected').text() + '\
                  </td>\
                  <td width="5%">\
                    ' + $('#bukaan').val() + '\
                  </td>\
                  <td width="5%">\
                    ' + $('#qty').val() + '\
                  </td>\
                </tr>';
                $('tr.odd').remove();
                $('#dataTbl').append(x);
                $('#item').val('').trigger('change');
                $('#warna').val('').trigger('change');
                $('#bukaan').val('').trigger('change');
                $('#lebar').val('');
                $('#harga').val('');
                $('#tinggi').val('');
                $('#cek1').val('');
                $('#cek2').val('');
                $('#cek3').val('');
                $('#qty').val('');
                $.growl.notice({
                  title: 'Sukses',
                  message: "Berhasil menyimpan Produksi"
                });

              })
              .fail(function(XHR) {
                if (XHR.readyState == 0) {
                  $.growl.error({
                    title: 'Peringatan',
                    message: 'Terjadi Kesalahan! KONEKSI TERPUTUS'
                  });
                  $('#jumlah').val('');
                } else {
                  $.growl.error({
                    title: 'Peringatan',
                    message: 'Terjadi Kesalahan! UNKNOWN ERROR'
                  });
                  $('#jumlah').val('');
                }
              });



          } else {
            $.growl.error({
              title: 'Peringatan',
              message: 'Lengkapi Form dulu!'
            });
          };
        }
      }

      function quotation_d() {
        if ($('#item_d').val() != '' && $('#bukaan_d').val() != '' && $('#warna_d').val() != '' && $('#lebar_d').val() != '' && $('#tinggi_d').val() != '' && $('#qty_d').val() != '') {

          $.ajax({
              type: "POST",
              url: "<?= site_url('klg/custom/saveCustomDetail') ?>",
              dataType: 'json',
              data: {
                'id_invoice': 0,
                'tgl': $("#tgl").val(),
                'item': $("#item_d").val(),
                'warna': $("#warna_d").val(),
                'bukaan': $("#bukaan_d").val(),
                'lebar': $("#lebar_d").val(),
                'tinggi': $("#tinggi_d").val(),
                'cek1': $("#cek1_d").val(),
                'cek2': $("#cek2_d").val(),
                'cek3': $("#cek3_d").val(),
                'qty': $("#qty_d").val(),
              },
            })
            .success(function(datasaved) {
              //code here
              xi++;
              var i = datasaved['id'];


              var x = '<tr id="output_data_' + i + '" class="output_data">\
                  <td width="5%" align="center">\
                    <a href="javascript:void(0)" onClick="hapus(' + i + ')">\
                      <i class="fa fa-trash"></i>\
                    </a>\
                  </td>\
                  <td width="25%">\
                    ' + $('#item_d :selected').text() + '\
                  </td>\
                  <td width="10%">\
                    ' + $('#lebar_d').val() + 'x' + $('#tinggi_d').val() + '\
                  </td>\
                  <td width="10%">\
                    ' + $('#warna_d :selected').text() + '\
                  </td>\
                  <td width="5%">\
                    ' + $('#bukaan_d').val() + '\
                  </td>\
                  <td width="5%">\
                    ' + $('#qty_d').val() + '\
                  </td>\
                </tr>';
              $('tr.odd').remove();
              $('#dataTbl').append(x);
              $('#item_d').val('').trigger('change');
              $('#warna_d').val('').trigger('change');
              $('#bukaan_d').val('').trigger('change');
              $('#lebar_d').val('');
              $('#harga_d').val('');
              $('#tinggi_d').val('');
              $('#cek1_d').val('');
              $('#cek2_d').val('');
              $('#cek3_d').val('');
              $('#qty_d').val('');
              $.growl.notice({
                title: 'Sukses',
                message: "Berhasil menyimpan Produksi"
              });

            })
            .fail(function(XHR) {
              if (XHR.readyState == 0) {
                $.growl.error({
                  title: 'Peringatan',
                  message: 'Terjadi Kesalahan! KONEKSI TERPUTUS'
                });
                $('#jumlah').val('');
              } else {
                $.growl.error({
                  title: 'Peringatan',
                  message: 'Terjadi Kesalahan! UNKNOWN ERROR'
                });
                $('#jumlah').val('');
              }
            });



        } else {
          $.growl.error({
            title: 'Peringatan',
            message: 'Lengkapi Form dulu!'
          });
        };
      }


      function hapus(i) {
        if (confirm('Lanjutkan Proses Hapus?')) {
          $.ajax({
              type: "POST",
              url: "<?= site_url('klg/produksi/deleteItem') ?>",
              dataType: 'json',
              data: {
                'id': i
              }
            })
            .success(function(datasaved) {
              $.growl.notice({
                title: 'Sukses',
                message: datasaved.msg
              });
              $('#output_data_' + i).remove();
              hitungJml(xi);
            });
        }
      }

      $("select[name=id_invoice]").change(function() {
        var x = $("select[name=item]");
        if ($(this).val() == "") {
          x.html("<option>-- Select Item --</option>");
        } else {
          z = "<option>-- Select Item --</option>";
          $.ajax({
            url: "<?= site_url('klg/custom/getItemInvoice') ?>",
            dataType: "json",
            type: "POST",
            data: {
              "id": $(this).val()
            },
            success: function(data) {

              var z = "<option value=''>-- Select Item --</option>";
              for (var i = 0; i < data.length; i++) {
                z += '<option value=' + data[i].id + '>' + data[i].item + '-' + data[i].tipe + '</option>';
              }

              x.html(z);
              $('#item').val('').trigger('change');
              $('#warna').val('').trigger('change');
              $('#bukaan').val('').trigger('change');
              $('#lebar').val('').trigger('change');
              $('#tinggi').val('').trigger('change');
            }
          });

        }
      });

      $("select[name=item]").change(function() {
        var x = $("select[name=warna]");
        if ($(this).val() == "") {
          x.html("<option>-- Select Warna --</option>");
        } else {
          z = "<option>-- Select Warna --</option>";
          $.ajax({
            url: "<?= site_url('klg/custom/getWarnaItem') ?>",
            dataType: "json",
            type: "POST",
            data: {
              "id_invoice": $('#id_invoice').val(),
              "id_item": $(this).val(),
            },
            success: function(data) {

              var z = "<option value=''>-- Select Warna --</option>";
              for (var i = 0; i < data.length; i++) {
                z += '<option value=' + data[i].id + '>' + data[i].warna + '</option>';
              }

              x.html(z);
              $('#warna').val('').trigger('change');
              $('#bukaan').val('').trigger('change');
              $('#lebar').val('').trigger('change');
              $('#tinggi').val('').trigger('change');
            }
          });

        }
      });

      $("select[name=warna]").change(function() {
        var x = $("select[name=bukaan]");
        if ($(this).val() == "") {
          x.html("<option>-- Select Bukaan --</option>");
        } else {
          z = "<option>-- Select Bukaan --</option>";
          $.ajax({
            url: "<?= site_url('klg/custom/getBukaanItem') ?>",
            dataType: "json",
            type: "POST",
            data: {
              "id_invoice": $('#id_invoice').val(),
              "id_item": $('#item').val(),
              "id_warna": $(this).val()
            },
            success: function(data) {

              var z = "<option value=''>-- Select Bukaan --</option>";
              for (var i = 0; i < data.length; i++) {
                z += '<option value=' + data[i].bukaan + '>' + data[i].bukaan + '</option>';
              }

              x.html(z);
              $('#bukaan').val('').trigger('change');
              $('#lebar').val('').trigger('change');
              $('#tinggi').val('').trigger('change');
            }
          });

        }
      });

      $("select[name=bukaan]").change(function() {
        var x = $("select[name=lebar]");
        if ($(this).val() == "") {
          x.html("<option>-- Select Lebar --</option>");
        } else {
          z = "<option>-- Select Lebar --</option>";
          $.ajax({
            url: "<?= site_url('klg/custom/getLebarItem') ?>",
            dataType: "json",
            type: "POST",
            data: {
              "id_invoice": $('#id_invoice').val(),
              "id_item": $('#item').val(),
              "id_warna": $('#warna').val(),
              "bukaan": $(this).val()
            },
            success: function(data) {

              var z = "<option value=''>-- Select Lebar --</option>";
              for (var i = 0; i < data.length; i++) {
                z += '<option value=' + data[i].lebar + '>' + data[i].lebar + '</option>';
              }

              x.html(z);
              $('#lebar').val('').trigger('change');
              $('#tinggi').val('').trigger('change');
            }
          });

        }
      });

      $("select[name=lebar]").change(function() {
        var x = $("select[name=tinggi]");
        if ($(this).val() == "") {
          x.html("<option>-- Select Tinggi --</option>");
        } else {
          z = "<option>-- Select Tinggi --</option>";
          $.ajax({
            url: "<?= site_url('klg/custom/getTinggiItem') ?>",
            dataType: "json",
            type: "POST",
            data: {
              "id_invoice": $('#id_invoice').val(),
              "id_item": $('#item').val(),
              "id_warna": $('#warna').val(),
              "bukaan": $('#bukaan').val(),
              "lebar": $(this).val()
            },
            success: function(data) {

              var z = "<option value=''>-- Select Tinggi --</option>";
              for (var i = 0; i < data.length; i++) {
                z += '<option value=' + data[i].tinggi + '>' + data[i].tinggi + '</option>';
              }

              x.html(z);
              $('#tinggi').val('').trigger('change');
            }
          });

        }
      });

      $("#tinggi").change(function() {
        $.ajax({
          url: "<?= site_url('klg/custom/getQtyTinggi/') ?>",
          dataType: "json",
          type: "POST",
          data: {
            "id_invoice": $('#id_invoice').val(),
            "id_item": $('#item').val(),
            "bukaan": $('#bukaan').val(),
            "id_warna": $('#warna').val(),
            "lebar": $('#lebar').val(),
            "tinggi": $(this).val(),
          },
          success: function(img) {
            $('#qtyorderku').val(img['qty']);
            $('#qtyorder').html('<font color="blue">Qty dibutuhkan = ' + img['qty'] + '</font>');
          }
        });


      });
      // $("#bukaan").change(function(){
      //       $.ajax({
      //         url      : "<?= site_url('klg/custom/getLebarTinggi/') ?>",
      //         dataType : "json",
      //         type     : "POST",
      //         data     : {
      //           "id_invoice" : $('#id_invoice').val(),
      //           "id_item" : $('#item').val(),
      //           "id_warna" : $('#warna').val(),
      //           "bukaan" : $(this).val(),
      //         },
      //         success  : function(img){
      //            $('#lebar').val(img['lebar']);
      //             $('#tinggi').val(img['tinggi']);
      //             $('#qtyorderku').val(img['qty']);
      //             $('#qtyorder').html('<font color="blue">Qty dibutuhkan = '+img['qty']+'</font>');
      //           }
      //       });


      // });

      $("#jenis_fppp").change(function() {
        if ($(this).val() == 1) {
          $('.divcustom').show(50);
          $('.divdirect').hide(50);
        } else {
          $('.divcustom').hide(50);
          $('.divdirect').show(50);
        };


      });

      // $("#warna").change(function(){
      //       var bukan = $('#id_jenis_barang').val();
      //   if (bukan!='1') {
      //     $.ajax({
      //         url      : "<?= site_url('klg/custom/getLebarTinggi/') ?>",
      //         dataType : "json",
      //         type     : "POST",
      //         data     : {
      //           "id_invoice" : $('#id_invoice').val(),
      //           "id_item" : $('#item').val(),
      //           "id_warna" : $(this).val(),
      //           "bukaan" : '-',
      //         },
      //         success  : function(img){
      //            $('#lebar').val(img['lebar']);
      //             $('#tinggi').val(img['tinggi']);
      //             $('#qtyorderku').val(img['qty']);
      //             $('#qtyorder').html('<font color="blue">Qty dibutuhkan = '+img['qty']+'</font>');
      //           }
      //       });
      //   }

      //   });

      $("#item").change(function() {
        $('#bukaan').val('').trigger('change');
        $.ajax({
          url: "<?= site_url('klg/produksi/getDetailItem/') ?>",
          dataType: "json",
          type: "POST",
          data: {
            "item": $(this).val(),
          },
          success: function(img) {
            $("#gbritem").html('<div class="form-group"> <label class="control-label">Picture : </label> <img style="padding:10px;" src="<?php echo base_url() . "'+img['gambar']+'"; ?>" class="file-preview-image"></div>');

            // $('#lebar').val(img['lebar']);
            // $('#tinggi').val(img['tinggi']);
            $('#id_jenis_barang').val(img['id_jenis_barang']);
            $('#jenis_barang').html('Jenis Barang : ' + img['jenis_barang']);

          }
        });


      });
    </script>