<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Form Edit Invoice Pelanggan</h3>

    <div class="box-tools pull-right">
      <button type="button" id="tutup" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <form method="post" class="form-vertical form_faktur" role="form">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>No Invoice</label>
            <input type="text" class="form-control" id="no_invoice" name="no_invoice" value="<?= $header->no_invoice ?>" placeholder="No Invoice" readonly required>
          </div>
        </div>
      </div>
      <?php if (from_session('level') < 4) {
        $ds = "";
      } else {
        $ds = "disabled";
      } ?>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Store</label>
            <select id="store" name="store" class="form-control" <?= $ds ?>>
              <option value="">-- Select Store --</option>
              <?php foreach ($store->result() as $valap) : ?>
                <?php if ($header->id_store == $valap->id) {
                  $selected = 'selected';
                } else {
                  $selected = '';
                } ?>
                <option value="<?= $valap->id ?>" <?= $selected ?>><?= $valap->store ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Jenis Market</label>
            <select id="jenis_market" name="jenis_market" class="form-control">
              <option value="">-- Select Jenis Market --</option>
              <?php foreach ($jenis_market->result() as $valap) : ?>
                <?php if ($header->id_jenis_market == $valap->id) {
                  $selected = 'selected';
                } else {
                  $selected = '';
                } ?>
                <option value="<?= $valap->id ?>" <?= $selected ?>><?= $valap->jenis_market ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Kategori Lokasi</label>
            <select id="kategori_lokasi" name="kategori_lokasi" class="form-control">
              <option value="">-- Select Kategori Lokasi --</option>
              <?php foreach ($kategori_lokasi->result() as $valap) : ?>
                <?php if ($header->id_kategori_lokasi == $valap->id) {
                  $selected = 'selected';
                } else {
                  $selected = '';
                } ?>
                <option value="<?= $valap->id ?>" <?= $selected ?>><?= $valap->kategori_lokasi ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Jenis Case</label>
            <select id="case" name="case" class="form-control">
              <option value="">-- Select Case --</option>
              <?php foreach ($case as $valap) : ?>
                <?php if ($header->id_case == $valap->id) {
                  $selected = 'selected';
                } else {
                  $selected = '';
                } ?>
                <option value="<?= $valap->id ?>" <?= $selected ?>><?= $valap->case ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Pembeli</label>
            <input type="text" class="form-control" id="pembeli" value="<?= $header->pembeli ?>" name="pembeli" placeholder="Pembeli" required>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Alamat</label>
            <input type="text" class="form-control" id="alamat" value="<?= $header->alamat ?>" placeholder="Alamat">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>No Telp.</label>
            <input type="text" class="form-control" id="no_telp" value="<?= $header->no_telp ?>" placeholder="No Telp.">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Tgl Pengiriman</label>
            <input type="text" data-date-format="yyyy-mm-dd" value="<?= $header->tgl_pengiriman ?>" class="form-control datepicker" id="tgl_pengiriman" placeholder="Tanggal Pengiriman" required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Keterangan</label>
            <input type="text" class="form-control" value="<?= $header->keterangan ?>" id="keterangan" placeholder="Keterangan">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Diskon (Margin)</label>
            <div class="input-group">
              <input type="text" class="form-control" value="<?= $header->diskon ?>" id="diskon" placeholder="Diskon (Margin)">
              <span class="input-group-addon"><b>%</b></span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>PPN</label>
            <div class="input-group">
              <input type="text" class="form-control" value="<?= $header->ppn ?>" id="ppn" value="10" placeholder="PPN">
              <span class="input-group-addon"><b>%</b></span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Biaya Pengiriman</label>
            <input type="text" class="form-control" id="biaya_kirim" value="<?= $header->biaya_kirim ?>" placeholder="Biaya Pengirirman">
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
              <select id="tipe_invoice" name="tipe_invoice" class="form-control" style="width:100%" required>
                <option value="">-- Tipe Permintaan --</option>
                <?php foreach ($tipe_invoice as $valap) : ?>
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
                <option value="-">tidak ada</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label" for="merk">Lebar (mm):</label>
              <input type="hidden" class="form-control" id="id_invoice" value="<?= $header->id ?>" name="id_invoice" readonly>
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
              <label>Promo Bulanan</label>
              <input type="text" class="form-control" id="promo" placeholder="Promo Bulanan">
            </div>
            <div class="form-group">
              <label class="control-label" for="merk">Quantity:</label>
              <input type="text" style="text-align: right;" class="form-control" id="qty" name="qty" placeholder="Quantity" autocomplete="off">
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
              <th width="5%">Act</th>
              <th width="10%">Tipe</th>
              <th width="25%">Item</th>
              <th width="10%">Warna</th>
              <th width="5%">Bukaan</th>
              <th width="5%">Quantity</th>
              <th width="10%">Harga</th>
              <th width="5%">Promo</th>
              <th width="10%">Keterangan</th>
            </tr>
          </thead>
          <tbody id="dataTbl">
            <?php $i = 1; ?>
            <?php foreach ($produk as $val) :
            ?>
              <tr id="output_data_<?= $val->id ?>" class="output_data">
                <td align="center">
                  <a href="javascript:void(0)" onClick="hapus(<?= $val->id ?>)">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
                <td><?= $val->tipe ?></td>
                <td><?= $val->item . '(' . $val->lebar . 'x' . $val->tinggi . ')' ?></td>
                <td align="center"><?= $val->warna ?></td>
                <td align="center"><?= $val->bukaan ?></td>
                <td align="center"><?= $val->qty ?></td>
                <td align="center"><?= $val->harga ?></td>
                <td align="center"><?= $val->promo ?></td>
                <td><?= $val->keterangan ?></td>
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
      load_silent("warehouse/invoice/", "#content");
    }
  }
  $(document).ready(function() {
    $('.datepicker').datepicker({
      autoclose: true
    });


    $("select").select2();
    // $(".harga").hide();


    // $('#form_pembelian').hide();
  });

  function save() {
    $(this).find("button[type='submit']").prop('disabled', true);

    $.ajax({
      type: "POST",
      url: site + 'warehouse/invoice/updateInvoice',
      dataType: 'json',
      data: {
        id_invoice: $('#id_invoice').val(),
        store: $("#store").val(),
        jenis_market: $("#jenis_market").val(),
        kategori_lokasi: $("#kategori_lokasi").val(),
        id_case: $("#case").val(),
        pembeli: $("#pembeli").val(),
        alamat: $("#alamat").val(),
        no_telp: $("#no_telp").val(),
        tgl_pengiriman: $("#tgl_pengiriman").val(),
        keterangan: $("#keterangan").val(),
        diskon: $("#diskon").val(),
        ppn: $("#ppn").val(),
        biaya_kirim: $("#biaya_kirim").val(),

      },
      success: function(data) {
        // $('#id_invoice').val(data['id']);
        $.growl.notice({
          title: 'Sukses',
          message: data['msg']
        });
        $('#tutup').click();
        $('#form_pembelian').show(1000);
      }
    });


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
    if ($('#id_invoice').val() != '' && $('#item').val() != '' && $('#warna').val() != '' && $('#bukaan').val() != '' && $('#lebar').val() != '' && $('#tinggi').val() != '' && $('#qty').val() != '' && $("#tipe_custom").val() != '') {

      $.ajax({
          type: "POST",
          url: "<?= site_url('warehouse/invoice/saveInvoiceDetail') ?>",
          dataType: 'json',
          data: {
            'id_invoice': $('#id_invoice').val(),
            'tipe_invoice': $("#tipe_invoice").val(),
            'item': $("#item").val(),
            'warna': $("#warna").val(),
            'bukaan': $("#bukaan").val(),
            'lebar': $("#lebar").val(),
            'tinggi': $("#tinggi").val(),
            'harga': $("#harga").val(),
            'promo': $("#promo").val(),
            'keterangan': $("#ket_detail").val(),
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
                  <td width="10%">\
                    ' + $('#tipe_invoice :selected').text() + '\
                  </td>\
                  <td width="25%">\
                    ' + $('#item :selected').text() + ' (' + $('#lebar').val() + 'x' + $('#tinggi').val() + ')' + '\
                  </td>\
                  <td align="center" width="10%">\
                    ' + $('#warna :selected').text() + '\
                  </td>\
                  <td align="center" width="5%">\
                    ' + $('#bukaan').val() + '\
                  </td>\
                  <td align="center" width="5%">\
                    ' + $('#qty').val() + '\
                  </td>\
                  <td align="center" width="10%">\
                    ' + $('#harga').val() + '\
                  </td>\
                  <td align="center" width="5%">\
                    ' + $('#promo').val() + '\
                  </td>\
                  <td width="5%">\
                    ' + $('#ket_detail').val() + '\
                  </td></tr>';
          $('tr.odd').remove();
          $('#dataTbl').append(x);
          $('#item').val('').trigger('change');
          $('#warna').val('').trigger('change');
          $('#bukaan').val('').trigger('change');
          $('#lebar').val('');
          $('#harga').val('');
          $('#tinggi').val('');
          $('#qty').val('');
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
          url: "<?= site_url('warehouse/invoice/deleteItem') ?>",
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
      url: "<?= site_url('klg/invoice/getDetailStore/') ?>",
      dataType: "json",
      type: "POST",
      data: {
        "store": $(this).val(),
      },
      success: function(img) {
        $('#no_telp').val(img['no_telp']);
        $('#alamat').val(img['alamat']);
        $('#jenis_market').val(img['id_jenis_market']).trigger('change');
      }
    });


  });

  $("#tipe_invoice").change(function() {
    if ($(this).val() == 2) {
      $('#lebar').attr('readonly', false);
      $('#tinggi').attr('readonly', false);
      $('.harga').show(50);
      $('#lebar').val(0);
      $('#tinggi').val(0);
      $('#harga').val(0);
    } else {
      $('#lebar').attr('readonly', true);
      $('#tinggi').attr('readonly', true);
      $('#harga').val('0');
      $('.harga').hide(50);
    }
  });



  $("#item").change(function() {
    $.ajax({
      url: "<?= site_url('klg/invoice/getDetailItem/') ?>",
      dataType: "json",
      type: "POST",
      data: {
        "item": $(this).val(),
      },
      success: function(img) {
        $("#gbritem").html('<div class="form-group"> <label class="control-label">Picture : </label> <img style="padding:10px;" src="<?php echo base_url() . "'+img['gambar']+'"; ?>" class="file-preview-image"></div>');
        if ($("#tipe_invoice").val() == 1) {
          $('#lebar').val(img['lebar']);
          $('#tinggi').val(img['tinggi']);
        }
      }
    });


  });

  $("#warna").change(function() {
    var kl = $('#kategori_lokasi').val();
    $.ajax({
      url: "<?= site_url('warehouse/invoice/getHargaItem/') ?>",
      dataType: "json",
      type: "POST",
      data: {
        "item": $('#item').val(),
        "warna": $(this).val(),
      },
      success: function(img) {
        if (kl == 1) {
          $('#harga').val(img['harga_jabotabek']);
        } else if (kl == 2) {
          $('#harga').val(img['harga_dalam_pulau']);
        } else {
          $('#harga').val(img['harga_luar_pulau']);
        };
      }
    });


  });
</script>