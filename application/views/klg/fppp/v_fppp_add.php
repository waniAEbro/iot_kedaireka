<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Form FPPP</h3>

    <div class="box-tools pull-right">
      <button type="button" id="tutup" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <form method="post" class="form-vertical form_faktur" role="form">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Divisi</label>
            <?= form_dropdown('id_divisi_tampil', $divisi, $param, 'id="id_divisi_tampil" class="form-control" disabled') ?>
            <input type="hidden" id="id_divisi" value="<?= $param ?>" class="form-control" autocomplete="off">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>No FPPP</label>
            <input type="text" id="no_fppp" class="form-control" value="<?= $no_fppp ?>" autocomplete="off" readonly>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Tanggal Pembuatan</label>
            <input type="text" id="tgl_pembuatan" value="<?= date('Y-m-d') ?>" class="form-control" autocomplete="off" readonly>
          </div>
        </div>
      </div>
      <?php
      if ($param == 2) {
      ?>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Type FPPP</label>
              <input type="text" id="type_fppp" class="form-control" autocomplete="off">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Tahap Produksi</label>
              <input type="text" id="tahap_produksi" class="form-control" autocomplete="off">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Nama Aplikator</label>
              <input type="text" id="nama_aplikator" class="form-control" autocomplete="off">
            </div>
          </div>
        </div>
      <?php
      }
      ?>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Applicant</label>
            <input type="text" id="applicant" class="form-control" autocomplete="off">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Applicant Sector</label>
            <input type="text" id="applicant_sector" class="form-control" autocomplete="off">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Authorized Disributor</label>
            <input type="text" id="authorized_distributor" class="form-control" autocomplete="off">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Nama Proyek</label>
            <input type="text" id="nama_proyek" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Tahap</label>
            <input type="text" id="tahap" class="form-control">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Alamat Proyek</label>
            <input type="text" id="alamat_proyek" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Status Order</label>
            <input type="text" id="status_order" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Note NCR/FPPP</label>
            <input type="text" id="note_ncr" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Pengiriman</label>
            <?= form_dropdown('id_pengiriman', $pengiriman, '', 'id="id_pengiriman" class="form-control"') ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Deadline Pengiriman</label>
            <input type="text" id="deadline_pengiriman" data-date-format="yyyy-mm-dd" value="<?= date('Y-m-d') ?>" class="form-control datepicker" autocomplete="off">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Metode Pengiriman</label>
            <?= form_dropdown('id_metode_pengiriman', $metode_pengiriman, '', 'id="id_metode_pengiriman" class="form-control"') ?>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Penggunaan Peti</label>
            <?= form_dropdown('id_penggunaan_peti', $penggunaan_peti, '', 'id="id_penggunaan_peti" class="form-control"') ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Penggunaan Sealant</label>
            <?= form_dropdown('id_penggunaan_sealant', $penggunaan_sealant, '', 'id="id_penggunaan_sealant" class="form-control"') ?>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Warna aluminium</label>
            <?= form_dropdown('id_warna_aluminium', $warna_aluminium, '', 'id="id_warna_aluminium" class="form-control"') ?>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Warna Lainya</label>
            <?= form_dropdown('id_warna_lainya', $warna_lainya, '', 'id="id_warna_lainya" class="form-control"') ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Warna Sealant</label>
            <input type="text" id="warna_sealant" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Ditujukan Kepada</label>
            <input type="text" id="ditujukan_kepada" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>No Telp Tujuan</label>
            <input type="text" id="no_telp_tujuan" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Nama Ekspedisi</label>
            <input type="text" id="pengiriman_ekspedisi" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Alamat Ekspedisi</label>
            <input type="text" id="alamat_ekspedisi" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Nama Sales Marketing</label>
            <input type="text" id="sales" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Nama PIC Project</label>
            <input type="text" id="pic_project" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Admin Koordinator</label>
            <input type="text" id="admin_koordinator" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Kaca</label>
            <?= form_dropdown('id_kaca', $kaca, '', 'id="id_kaca" class="form-control"') ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>Jenis Kaca</label>
            <input type="text" id="jenis_kaca" class="form-control">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Logo Kaca</label>
            <?= form_dropdown('id_logo_kaca', $logo_kaca, '', 'id="id_logo_kaca" class="form-control"') ?>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Jumlah Opening</label>
            <input type="text" id="jumlah_gambar" class="form-control">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Jumlah Unit</label>
            <input type="text" id="jumlah_unit" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Lampiran</label>
            <?php echo form_upload(array('name' => 'lampiran', 'id' => 'lampiran')); ?>
            <span style="color:red">*) Lampiran File berformat .pdf maks 2MB</span>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Note</label><br>
            <textarea id="keterangan" name="keterangan" rows="10" cols="150">
                </textarea>
          </div>
        </div>
      </div>


  </div>
  <!-- /.box-body -->
  <div class="box-footer">
    <button type="submit" onclick="save()" id="proses" class="btn btn-success">Process</button>
    <!-- <a id="silahkantunggu" class="btn btn-danger">Process</a> -->
    <span id="info"></span>
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
              <label class="control-label">Brand</label>
              <?= form_dropdown('id_brand', $brand, '', 'id="id_brand" class="form-control"') ?>
            </div>
            <div class="form-group">
              <label class="control-label">Kode Opening</label>
              <input type="text" id="kode_opening" class="form-control">
            </div>
            <div class="form-group">
              <label class="control-label">Kode Unit</label>
              <input type="text" id="kode_unit" class="form-control">
            </div>
            <div class="form-group">
              <label class="control-label">Item</label>
              <?= form_dropdown('id_item', $item, '', 'id="id_item" class="form-control"') ?>
            </div>
            <div class="form-group">
              <label class="control-label">Glass Thick</label>
              <input type="text" id="glass_thick" class="form-control">
            </div>
            <div class="form-group">
              <label class="control-label">Finish Coating</label>
              <?= form_dropdown('finish_coating', $warna_aluminium, '', 'id="finish_coating" class="form-control"') ?>
            </div>
            <div class="form-group">
              <label class="control-label">Qty</label>
              <input type="hidden" id="id_fppp" readonly>
              <input type="text" id="qty" class="form-control" autocomplete="off">
            </div>
            <div class="form-group">
              <a onclick="quotation()" class="btn btn-info">Add Item</a>
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
              <th width="15%">Brand</th>
              <th width="10%">Kode Opening</th>
              <th width="10%">Kode Unit</th>
              <th width="25%">Item</th>
              <th width="10%">Glass Thick</th>
              <th width="10%">Finish Coating</th>
              <th width="7%">Qty</th>
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
        message: "Tambah Permintaan selesai!"
      });
      load_silent("klg/fppp/hasil_finish/" + $("#id_divisi").val() + "", "#content");
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
    $("#silahkantunggu").hide();
    // Replace the <textarea id="editor1"> with a CKEditor files/2019/12/03cd07ae4cb5f5f8ab4f5c4cd80d81e5.png
    // instance, using default configuration.
    CKEDITOR.replace('keterangan');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();

    $('#form_pembelian').hide();
  });

  function save() {
    var path = $("#lampiran").val().replace('C:\\fakepath\\', '');
    var wa = $('#id_warna_aluminium').val();
    $('#finish_coating').val(wa).trigger('change');
    if (path == '') {
      $.ajax({
        type: "POST",
        url: site + 'klg/fppp/savefppp',
        dataType: 'json',
        data: {
          id_divisi: $("#id_divisi").val(),
          tgl_pembuatan: $("#tgl_pembuatan").val(),
          no_fppp: $("#no_fppp").val(),
          applicant: $("#applicant").val(),
          applicant_sector: $("#applicant_sector").val(),
          authorized_distributor: $("#authorized_distributor").val(),
          type_fppp: $("#type_fppp").val(),
          tahap_produksi: $("#tahap_produksi").val(),
          nama_aplikator: $("#nama_aplikator").val(),
          nama_proyek: $("#nama_proyek").val(),
          tahap: $("#tahap").val(),
          alamat_proyek: $("#alamat_proyek").val(),
          status_order: $("#status_order").val(),
          note_ncr: $("#note_ncr").val(),
          id_pengiriman: $("#id_pengiriman").val(),
          deadline_pengiriman: $("#deadline_pengiriman").val(),
          id_metode_pengiriman: $("#id_metode_pengiriman").val(),
          id_penggunaan_peti: $("#id_penggunaan_peti").val(),
          id_penggunaan_sealant: $("#id_penggunaan_sealant").val(),
          id_warna_aluminium: $("#id_warna_aluminium").val(),
          id_warna_lainya: $("#id_warna_lainya").val(),
          warna_sealant: $("#warna_sealant").val(),
          ditujukan_kepada: $("#ditujukan_kepada").val(),
          no_telp_tujuan: $("#no_telp_tujuan").val(),
          pengiriman_ekspedisi: $("#pengiriman_ekspedisi").val(),
          alamat_ekspedisi: $("#alamat_ekspedisi").val(),
          sales: $("#sales").val(),
          pic_project: $("#pic_project").val(),
          admin_koordinator: $("#admin_koordinator").val(),
          id_kaca: $("#id_kaca").val(),
          jenis_kaca: $("#jenis_kaca").val(),
          id_logo_kaca: $("#id_logo_kaca").val(),
          jumlah_gambar: $("#jumlah_gambar").val(),
          jumlah_unit: $("#jumlah_unit").val(),
          note: CKEDITOR.instances.keterangan.getData(),

        },
        success: function(data) {

          $('#id_fppp').val(data['id']);
          $.growl.notice({
            title: 'Sukses',
            message: data['msg']
          });
          $('#tutup').click();
          $('#form_pembelian').show(1000);

        },
        error: function(data, e) {
          $("#info").html(e);
        }
      });
    } else {
      $.ajaxFileUpload({
        url: site + 'klg/fppp/savefpppImage',
        secureuri: false,
        fileElementId: 'lampiran',
        dataType: 'json',
        data: {
          id_divisi: $("#id_divisi").val(),
          tgl_pembuatan: $("#tgl_pembuatan").val(),
          no_fppp: $("#no_fppp").val(),
          applicant: $("#applicant").val(),
          applicant_sector: $("#applicant_sector").val(),
          authorized_distributor: $("#authorized_distributor").val(),
          type_fppp: $("#type_fppp").val(),
          tahap_produksi: $("#tahap_produksi").val(),
          nama_aplikator: $("#nama_aplikator").val(),
          nama_proyek: $("#nama_proyek").val(),
          tahap: $("#tahap").val(),
          alamat_proyek: $("#alamat_proyek").val(),
          status_order: $("#status_order").val(),
          note_ncr: $("#note_ncr").val(),
          id_pengiriman: $("#id_pengiriman").val(),
          deadline_pengiriman: $("#deadline_pengiriman").val(),
          id_metode_pengiriman: $("#id_metode_pengiriman").val(),
          id_penggunaan_peti: $("#id_penggunaan_peti").val(),
          id_penggunaan_sealant: $("#id_penggunaan_sealant").val(),
          id_warna_aluminium: $("#id_warna_aluminium").val(),
          id_warna_lainya: $("#id_warna_lainya").val(),
          warna_sealant: $("#warna_sealant").val(),
          ditujukan_kepada: $("#ditujukan_kepada").val(),
          no_telp_tujuan: $("#no_telp_tujuan").val(),
          pengiriman_ekspedisi: $("#pengiriman_ekspedisi").val(),
          alamat_ekspedisi: $("#alamat_ekspedisi").val(),
          sales: $("#sales").val(),
          pic_project: $("#pic_project").val(),
          admin_koordinator: $("#admin_koordinator").val(),
          id_kaca: $("#id_kaca").val(),
          jenis_kaca: $("#jenis_kaca").val(),
          id_logo_kaca: $("#id_logo_kaca").val(),
          jumlah_gambar: $("#jumlah_gambar").val(),
          jumlah_unit: $("#jumlah_unit").val(),
          note: CKEDITOR.instances.keterangan.getData(),
        },
        success: function(data) {
          $('#id_fppp').val(data['id']);
          $.growl.notice({
            title: 'Sukses',
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
            'id_brand': $("#id_brand").val(),
            'kode_opening': $("#kode_opening").val(),
            'kode_unit': $("#kode_unit").val(),
            'id_item': $("#id_item").val(),
            'glass_thick': $("#glass_thick").val(),
            'finish_coating': $("#finish_coating").val(),
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
                  <td id="td_id_brand_' + i + '" width="15%">\
                    ' + $('#id_brand :selected').text() + '\
                  </td>\
                  <td id="td_kode_opening_' + i + '" width="10%">\
                    ' + $('#kode_opening').val() + '\
                  </td>\
                  <td id="td_kode_unit_' + i + '" width="10%">\
                    ' + $('#kode_unit').val() + '\
                  </td>\
                  <td id="td_id_item_' + i + '" width="25%">\
                  ' + $('#id_item :selected').text() + '\
                  </td>\
                  <td id="td_glass_thick_' + i + '" width="10%">\
                    ' + $('#glass_thick').val() + '\
                  </td>\
                  <td id="td_finish_coating_' + i + '" width="10%">\
                    ' + $('#finish_coating :selected').text() + '\
                  </td>\
                  <td id="td_qty_' + i + '" width="7%">\
                    ' + $('#qty').val() + '\
                  </td>\
                </tr>';
          $('tr.odd').remove();
          $('#dataTbl').append(x);
          $('#id_brand').val('').trigger('change');
          $('#id_item').val('').trigger('change');
          $("#gbritem").html('');
          $('#kode_opening').val('');
          $('#kode_unit').val('');
          $('#glass_thick').val('');
          $('#qty').val('');
          $.growl.notice({
            title: 'Sukses',
            message: "Berhasil menyimpan FPPP"
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

  // $("#store").change(function() {
  //   $.ajax({
  //     url: "<?= site_url('klg/fppp/getDetailStore/') ?>",
  //     dataType: "json",
  //     type: "POST",
  //     data: {
  //       "store": $(this).val(),
  //     },
  //     success: function(img) {
  //       $('#no_telp').val(img['no_telp']);
  //       $('#alamat').val(img['alamat']);
  //     }
  //   });


  // });

  // $("#tipe_fppp").change(function() {
  //   $('#item').val('').trigger('change');
  //   $("#gbritem").html('');
  //   $('#jenis_barang').html('');
  //   if ($(this).val() == 2) {
  //     $('#lebar').attr('readonly', false);
  //     $('#tinggi').attr('readonly', false);
  //     $('#harga').attr('readonly', false);
  //     $('.harga').show(50);
  //     $('#lebar').val(0);
  //     $('#tinggi').val(0);
  //     $('#harga').val(0);
  //   } else {
  //     $('#lebar').attr('readonly', true);
  //     $('#tinggi').attr('readonly', true);
  //     $('#harga').val('0');
  //     $('#harga').attr('readonly', true);
  //   }
  // });



  // $("#item").change(function() {
  //   $('#bukaan').val('').trigger('change');
  //   $.ajax({
  //     url: "<?= site_url('klg/fppp/getDetailItem/') ?>",
  //     dataType: "json",
  //     type: "POST",
  //     data: {
  //       "item": $(this).val(),
  //     },
  //     success: function(img) {
  //       $("#gbritem").html('<div class="form-group"> <label class="control-label">Picture : </label> <img style="padding:10px;" src="<?php echo base_url() . "'+img['gambar']+'"; ?>" class="file-preview-image"></div>');
  //       if ($("#tipe_fppp").val() == 1) {
  //         $('#lebar').val(img['lebar']);
  //         $('#tinggi').val(img['tinggi']);
  //         $('#harga').val(img['harga']);
  //       }
  //       $('#jenis_barang').html('Jenis Barang : ' + img['jenis_barang']);

  //     }
  //   });


  // });

  // $("#warna").change(function() {
  //   if ($("#tipe_fppp").val() == 1) {
  //     $.ajax({
  //       url: "<?= site_url('klg/fppp/getHarga/') ?>",
  //       dataType: "json",
  //       type: "POST",
  //       data: {
  //         "store": $("#store").val(),
  //         "item": $("#item").val(),
  //         "warna": $(this).val(),
  //       },
  //       success: function(img) {
  //         $('#harga').val(img['harga']);
  //       }
  //     });
  //   }
  // });

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