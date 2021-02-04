<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Edit Permintaan</h3>

    <div class="box-tools pull-right">
      <button type="button" id="tutup" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <form method="post" class="form-vertical form_faktur" role="form">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>No Permintaan</label>
            <input type="text" class="form-control" id="no_fppp" name="no_fppp" value="<?= $row->no_fppp ?>" placeholder="No fppp" readonly required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>No PO/SO</label>
            <input type="text" class="form-control" id="no_po" name="no_po" value="<?= $row->no_po ?>" placeholder="No PO/SO" required autocomplete="off">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Brand</label>
            <select id="brand" name="brand" class="form-control" style="width:100%" required>
              <option value="">-- Brand --</option>
              <?php foreach ($brand as $valap) : ?>
                <?php if ($valap->id == $row->id_brand) {
                  $selb = "selected";
                } else {
                  $selb = "";
                } ?>
                <option value="<?= $valap->id ?>" <?= $selb ?>>[<?= $valap->id ?>] - <?= $valap->brand ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Projek Owner</label>
            <input type="text" class="form-control" id="projek_owner" value="<?= $row->project_owner ?>" placeholder="Projek Owner">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Store/Mitra</label>
            <select id="store" name="store" class="form-control" style="width:100%" required>
              <option value="">-- Store/Mitra --</option>
              <?php foreach ($store as $valap) : ?>
                <?php if ($valap->id == $row->id_store) {
                  $selm = "selected";
                } else {
                  $selm = "";
                } ?>
                <option value="<?= $valap->id ?>" <?= $selm ?>><?= $valap->store ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>No Telp.</label>
            <input type="text" class="form-control" id="no_telp" value="<?= $row->no_telp ?>" placeholder="No Telp.">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Alamat Proyek</label>
            <input type="text" class="form-control" id="alamat" value="<?= $row->alamat_proyek ?>" placeholder="Alamat Proyek">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Tanggal Pengiriman</label>
            <input type="text" data-date-format="yyyy-mm-dd" value="<?= $row->tgl_pengiriman ?>" class="form-control datepicker" id="tgl_pengiriman" placeholder="Tanggal Pengiriman" required>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Waktu Input</label>
            <input type="text" value="<?= date('Y/m/d H:i:s') ?>" class="form-control" id="date">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Special Intruction</label><br>
            <textarea id="keterangan" name="keterangan" rows="10" cols="150">
                <?= $row->intruction ?>
                </textarea>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Upload Lampiran</label>
            <?php echo form_upload(array('name' => 'lampiran', 'id' => 'lampiran')); ?>
            <span style="color:red">*) Lampiran File berformat .pdf maks 2MB</span>
          </div>
        </div>
      </div>


  </div>
  <!-- /.box-body -->
  <div class="box-footer">
    <button type="submit" onclick="save()" id="proses" class="btn btn-success">Process</button>
  </div>
  </form>
</div>

<div class="row" id="form_pembelian">
  <div class="col-lg-3">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Input Item</h3>
      </div>
      <div class="div-pembelian">
        <form method="post" class="form-vertical form" role="form" id="formid">
          <div class="box-body">
            <div class="form-group">
              <label>Tipe Permintaan</label>
              <select id="tipe_fppp" name="tipe_fppp" class="form-control" style="width:100%" required>
                <option value="">-- Tipe Permintaan --</option>
                <?php foreach ($tipe_fppp as $valap) : ?>
                  <?php if ($valap->id == '1') {
                    $sel = "selected";
                  } else {
                    $sel = "";
                  } ?>
                  <option value="<?= $valap->id ?>" <?= $sel ?>><?= $valap->tipe ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Item</label>
              <select id="item" name="item" class="form-control" style="width:100%" required>
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
              <select id="warna" name="warna" class="form-control" style="width:100%" required>
                <option value="">-- Select Warna --</option>
                <?php foreach ($warna as $val) : ?>
                  <option value="<?= $val->id ?>"><?= $val->warna ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label" for="merk">Bukaan:</label>
              <select id="bukaan" name="bukaan" class="form-control" style="width:100%" required>
                <option value="">-- Select Bukaan --</option>
                <option value="R">R</option>
                <option value="L">L</option>
                <option value="-">tdk ada</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label" for="merk">Lebar (mm):</label>
              <input type="text" style="text-align: right;" class="form-control" id="lebar" value="0" name="lebar" placeholder="Lebar" autocomplete="off" readonly>
              <span id="infolebar"></span>
            </div>
            <div class="form-group">
              <label class="control-label" for="merk">Tinggi (mm):</label>
              <input type="text" style="text-align: right;" class="form-control" id="tinggi" value="0" name="tinggi" placeholder="Tinggi" autocomplete="off" readonly>
              <span id="infotinggi"></span>
            </div>
            <div class="form-group harga">
              <label class="control-label" for="merk">Harga:</label>
              <input type="text" style="text-align: right;" class="form-control" id="harga" name="harga" placeholder="Harga" autocomplete="off">
            </div>
            <div class="form-group">
              <label class="control-label" for="merk">Quantity:</label>
              <input type="hidden" class="form-control" id="id_fppp" name="id_fppp" value="<?= $row->id ?>" readonly>
              <input type="text" style="text-align: right;" class="form-control" id="qty" name="qty" placeholder="Quantity" autocomplete="off">
            </div>
            <div class="form-group">
              <label class="control-label" for="merk">Status Detail:</label>
              <select id="status_detail" name="status_detail" class="form-control" style="width:100%" required>
                <option value="">-- Select Status Detail --</option>
                <?php foreach ($status_detail as $val) : ?>
                  <option value="<?= $val->id ?>"><?= $val->status_detail ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label" for="merk">Keterangan:</label>
              <input type="text" class="form-control" id="ket_detail" name="ket_detail" autocomplete="off">
            </div>

            <div class="form-group">
              <a onclick="quotation()" class="btn btn-info">Add Permintaan</a>
            </div>
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
              <th width="10%">Act</th>
              <th width="25%">Item</th>
              <th width="10%">Ukuran</th>
              <th width="10%">Warna</th>
              <th width="5%">Bukaan</th>
              <th width="5%">Quantity</th>
              <th width="7%">Tipe</th>
              <th width="7%">Status</th>
            </tr>
          </thead>
          <tbody id="dataTbl">
            <?php $i = 1; ?>
            <?php foreach ($detail as $val) :
            ?>
              <tr id="output_data_<?= $val->id ?>" class="output_data">
                <td align="center">
                  <a class="btn btn-xs btn-danger" href="javascript:void(0)" onClick="hapus(<?= $val->id ?>)">
                    <i class="fa fa-trash"></i>
                  </a>
                  <a class="btn btn-xs btn-warning" onClick="editItem(<?= $val->id ?>)"><i class="fa fa-edit"></i></a>
                </td>
                <td id="td_item_<?= $val->id ?>"><?= $val->item ?></td>
                <td id="td_ukuran_<?= $val->id ?>"><?= $val->lebar . 'x' . $val->tinggi ?></td>
                <td id="td_warna_<?= $val->id ?>"><?= $val->warna ?></td>
                <td id="td_bukaan_<?= $val->id ?>"><?= $val->bukaan ?></td>
                <td id="td_qty_<?= $val->id ?>"><?= $val->qty ?></td>
                <td><?= $val->tipe ?></td>
                <td><?= $val->status_detail ?></td>
              </tr>
              <?php $i++; ?>
            <?php endforeach; ?>
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
        message: "Tambah Permintaan selesai!"
      });
      load_silent("klg/fppp/finish/<?= $row->id ?>", "#content");
    }
  }
  $(document).ready(function() {
    $('.datepicker').datepicker({
      autoclose: true
    });

    $("#lampiran").fileinput({
      'showUpload': true
    });
    $('.fileinput-upload-button').hide();
    $("select").select2();
    // $(".harga").hide();
    $('#harga').attr('readonly', true);

    // Replace the <textarea id="editor1"> with a CKEditor files/2019/12/03cd07ae4cb5f5f8ab4f5c4cd80d81e5.png
    // instance, using default configuration.
    CKEDITOR.replace('keterangan');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();

    $('.form_pembelian').hide();
  });

  function save() {
    $(this).find("button[type='submit']").prop('disabled', true);
    var path = $("#lampiran").val().replace('C:\\fakepath\\', '');
    if (path == '') {
      $.ajax({
        type: "POST",
        url: site + 'klg/fppp/updatefppp',
        dataType: 'json',
        data: {
          id_fppp: $("#id_fppp").val(),
          brand: $("#brand").val(),
          date: $("#date").val(),
          no_po: $("#no_po").val(),
          no_fppp: $("#no_fppp").val(),
          projek_owner: $("#projek_owner").val(),
          id_store: $("#store").val(),
          no_telp: $("#no_telp").val(),
          tgl_pengiriman: $("#tgl_pengiriman").val(),
          alamat_proyek: $("#alamat").val(),
          keterangan: CKEDITOR.instances.keterangan.getData(),

        },
        success: function(data) {
          // $('#id_fppp').val(data['id']);
          $.growl.notice({
            title: 'Sukses',
            message: data['msg']
          });
          $('#tutup').click();
          $('#form_pembelian').show(1000);
        }
      });
    } else {
      $.ajaxFileUpload({
        url: site + 'klg/fppp/updatefpppImage',
        secureuri: false,
        fileElementId: 'lampiran',
        dataType: 'json',
        data: {
          id_fppp: $("#id_fppp").val(),
          brand: $("#brand").val(),
          no_po: $("#no_po").val(),
          no_fppp: $("#no_fppp").val(),
          tipe_fppp: $("#tipe_fppp").val(),
          projek_owner: $("#projek_owner").val(),
          id_store: $("#store").val(),
          no_telp: $("#no_telp").val(),
          tgl_pengiriman: $("#tgl_pengiriman").val(),
          alamat_proyek: $("#alamat").val(),
          keterangan: CKEDITOR.instances.keterangan.getData(),
        },
        success: function(data) {
          // $('#id_fppp').val(data['id']);
          $.growl.notice({
            title: 'Berhasil',
            message: data['msg']
          });
          $('#tutup').click();
          $('#form_pembelian').show(1000);
        },
        error: function(data, e) {
          $("#info").html(e);
        }
      })
      return false;
    };

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

    if ($('#id_fppp').val() != '' && $('#item').val() != '' && $('#bukaan').val() != '' && $('#warna').val() != '' && $('#lebar').val() != '' && $('#tinggi').val() != '' && $('#qty').val() != '' && $("#tipe_custom").val() != '') {

      $.ajax({
          type: "POST",
          url: "<?= site_url('klg/fppp/savefpppDetail') ?>",
          dataType: 'json',
          data: {
            'id_fppp': $('#id_fppp').val(),
            'tipe_fppp': $("#tipe_fppp").val(),
            'item': $("#item").val(),
            'warna': $("#warna").val(),
            'bukaan': $("#bukaan").val(),
            'lebar': $("#lebar").val(),
            'tinggi': $("#tinggi").val(),
            'harga': $("#harga").val(),
            'keterangan': $("#ket_detail").val(),
            'status_detail': $("#status_detail").val(),
            'qty': $("#qty").val(),
          },
        })
        .success(function(datasaved) {
          //code here
          xi++;
          var i = datasaved['id'];


          var x = '<tr id="output_data_' + i + '" class="output_data">\
                  <td width="10%" align="center">\
                    <a class="btn btn-xs btn-danger" href="javascript:void(0)" onClick="hapus(' + i + ')">\
                      <i class="fa fa-trash"></i>\
                    </a>\
                    <a class="btn btn-xs btn-warning" onClick="editItem(' + i + ')"><i class="fa fa-edit"></i></a>\
                  </td>\
                  <td id="td_item_' + i + '" width="25%">\
                    ' + $('#item :selected').text() + '\
                  </td>\
                  <td id="td_ukuran_' + i + '" width="10%">\
                    ' + $('#lebar').val() + 'x' + $('#tinggi').val() + '\
                  </td>\
                  <td id="td_warna_' + i + '" width="10%">\
                    ' + $('#warna :selected').text() + '\
                  </td>\
                  <td id="td_bukaan_' + i + '" width="5%">\
                    ' + $('#bukaan').val() + '\
                  </td>\
                  <td id="td_qty_' + i + '" width="5%">\
                    ' + $('#qty').val() + '\
                  </td>\
                  <td width="7%">\
                    ' + $('#tipe_fppp :selected').text() + '\
                  </td>\
                  <td width="7%">\
                    ' + $('#status_detail :selected').text() + '\
                  </td>\
                </tr>';
          $('tr.odd').remove();
          $('#dataTbl').append(x);
          $('#item').val('').trigger('change');
          $("#gbritem").html('');
          $('#jenis_barang').html('');
          $('#warna').val('').trigger('change');
          $('#bukaan').val('').trigger('change');
          $('#status_detail').val('').trigger('change');
          $('#lebar').val('');
          $('#harga').val('');
          $('#tinggi').val('');
          $('#qty').val('');
          $("#ket_detail").val(''),
            $.growl.notice({
              title: 'Sukses',
              message: "Berhasil menyimpan Permintaan"
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
          url: "<?= site_url('klg/fppp/deleteItem') ?>",
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

  $("#store").change(function() {
    $.ajax({
      url: "<?= site_url('klg/fppp/getDetailStore/') ?>",
      dataType: "json",
      type: "POST",
      data: {
        "store": $(this).val(),
      },
      success: function(img) {
        $('#no_telp').val(img['no_telp']);
        $('#alamat').val(img['alamat']);
      }
    });


  });

  $("#tipe_fppp").change(function() {
    $('#item').val('').trigger('change');
    $("#gbritem").html('');
    $('#jenis_barang').html('');
    if ($(this).val() == 2) {
      $('#lebar').attr('readonly', false);
      $('#tinggi').attr('readonly', false);
      $('#harga').attr('readonly', false);
      $('.harga').show(50);
      $('#lebar').val(0);
      $('#tinggi').val(0);
      $('#harga').val(0);
    } else {
      $('#lebar').attr('readonly', true);
      $('#tinggi').attr('readonly', true);
      $('#harga').val('0');
      $('#harga').attr('readonly', true);
    }
  });



  $("#item").change(function() {
    $('#bukaan').val('').trigger('change');
    $.ajax({
      url: "<?= site_url('klg/fppp/getDetailItem/') ?>",
      dataType: "json",
      type: "POST",
      data: {
        "item": $(this).val(),
      },
      success: function(img) {
        $("#gbritem").html('<div class="form-group"> <label class="control-label">Picture : </label> <img style="padding:10px;" src="<?php echo base_url() . "'+img['gambar']+'"; ?>" class="file-preview-image"></div>');
        if ($("#tipe_fppp").val() == 1) {
          $('#lebar').val(img['lebar']);
          $('#tinggi').val(img['tinggi']);
          $('#harga').val(img['harga']);
        }
        $('#jenis_barang').html('Jenis Barang : ' + img['jenis_barang']);

      }
    });


  });

  $("#warna").change(function() {
    if ($("#tipe_fppp").val() == 1) {
      $.ajax({
        url: "<?= site_url('klg/fppp/getHarga/') ?>",
        dataType: "json",
        type: "POST",
        data: {
          "store": $("#store").val(),
          "item": $("#item").val(),
          "warna": $(this).val(),
        },
        success: function(img) {
          $('#harga').val(img['harga']);
        }
      });
    }
  });

  function editItem(id) {

    $.ajax({
        type: "POST",
        url: "<?= site_url('klg/fppp/editItem') ?>",
        dataType: 'json',
        data: {
          'id': id
        }
      })
      .success(function(datasaved) {
        $('#myModalEdit').modal('show');

        $("#id_edit").val(id);
        $("#item_edit").val(datasaved['item']).change();
        $("#warna_edit").val(datasaved['warna']).change();
        $("#bukaan_edit").val(datasaved['bukaan']).change();
        $("#lebar_edit").val(datasaved['lebar']);
        $("#tinggi_edit").val(datasaved['tinggi']);
        $("#qty_edit").val(datasaved['qty']);
        $("#keterangan_edit").val(datasaved['keterangan']);
      });
  }

  function saveEditItem() {
    if ($('#item_edit').val() != '' && $('#warna_edit').val() != '' && $('#bukaan_edit').val() != '' && $('#lebar_edit').val() != '' && $('#tinggi_edit').val() != '' && $('#qty_edit').val() != '') {
      $.ajax({
          type: "POST",
          url: "<?= site_url('klg/fppp/updateItemDetail') ?>",
          dataType: 'json',
          data: {
            'id': $('#id_edit').val(),
            'item': $('#item_edit').val(),
            'warna': $('#warna_edit').val(),
            'bukaan': $('#bukaan_edit').val(),
            'lebar': $('#lebar_edit').val(),
            'tinggi': $('#tinggi_edit').val(),
            'qty': $("#qty_edit").val(),
            'keterangan': $("#keterangan_edit").val(),
          }
        })
        .success(function(datasaved) {
          $('#td_item_' + datasaved['id']).html($('#item_edit :selected').text());
          $('#td_warna_' + datasaved['id']).html($('#warna_edit :selected').text());
          $('#td_bukaan_' + datasaved['id']).html($('#bukaan_edit :selected').text());
          $('#td_ukuran_' + datasaved['id']).html($('#lebar_edit').val() + 'x' + $('#tinggi_edit').val());
          $('#td_qty_' + datasaved['id']).html($('#qty_edit').val());

          $('#id_edit').val('');
          $('#item_edit').val('').trigger('change');
          $('#warna_edit').val('').trigger('change');
          $('#bukaan_edit').val('').trigger('change');
          $('#lebar_edit').val('');
          $('#tinggi_edit').val('');
          $('#qty_edit').val('');
          $('#keterangan_edit').val('');
          $.growl.notice({
            title: 'Sukses',
            message: "Order Detail Updated!"
          });
          $('#btnEditQuo').click();

        })
        .fail(function(XHR) {
          if (XHR.readyState == 0) {
            $.growl.error({
              title: 'Peringatan',
              message: 'Terjadi Kesalahan, Quotation Gagal! KONEKSI TERPUTUS'
            });
            $('#qty_edit').val('');
          } else {
            $.growl.error({
              title: 'Peringatan',
              message: 'Terjadi Kesalahan, Quotation Gagal! UNKNOWN ERROR'
            });
            $('#qty_edit').val('');
          }
        });

    } else {
      $.growl.error({
        title: 'Peringatan',
        message: 'Lengkapi Form dulu!'
      });
    };
  }
</script>

<div class="modal fade" id="myModalEdit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Item</label>
          <select id="item_edit" name="item_edit" class="form-control" style="width:100%" required>
            <option value="">-- Select Item --</option>
            <?php foreach ($item as $val) : ?>
              <option value="<?= $val->id ?>"><?= $val->item ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Warna</label>
          <select id="warna_edit" name="warna_edit" class="form-control" style="width:100%" required>
            <option value="">-- Select Warna --</option>
            <?php foreach ($warna as $val) : ?>
              <option value="<?= $val->id ?>"><?= $val->warna ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Bukaan</label>
          <select id="bukaan_edit" name="bukaan_edit" class="form-control" style="width:100%" required>
            <option value="">-- Select Bukaan --</option>
            <?php foreach ($bukaan as $val) : ?>
              <option value="<?= $val->bukaan ?>"><?= $val->nama_bukaan ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group fortipe">
          <label class="control-label" for="merk">Lebar:</label>
          <input type="text" style="text-align: right;" class="form-control" id="lebar_edit" name="lebar_edit" placeholder="Lebar" autocomplete="off">
        </div>
        <div class="form-group fortipe">
          <label class="control-label" for="merk">Tinggi:</label>
          <input type="text" style="text-align: right;" class="form-control" id="tinggi_edit" name="tinggi_edit" placeholder="Tinggi" autocomplete="off">
        </div>

        <div class="form-group">
          <label class="control-label" for="merk">Quantity:</label>
          <input type="hidden" class="form-control" id="id_edit" name="id_edit" autocomplete="off">
          <input type="text" style="text-align: right;" class="form-control" id="qty_edit" name="qty_edit" placeholder="Quantity" autocomplete="off">
        </div>
        <div class="form-group">
          <label class="control-label" for="merk">Keterangan:</label>
          <input type="text" style="text-align: right;" class="form-control" id="keterangan_edit" name="keterangan_edit" placeholder="Keterangan" autocomplete="off">
        </div>
        <div class="form-group">
          <a onclick="saveEditItem()" class="btn btn-info">Save</a>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" id="btnEditQuo" class="btn btn-default tmyModalTambahan" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>