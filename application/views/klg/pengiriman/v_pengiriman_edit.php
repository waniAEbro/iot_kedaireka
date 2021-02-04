<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Form Pengiriman</h3>

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
            <label>No Surat Jalan</label>
            <input type="text" class="form-control" id="no_pengiriman" name="no_pengiriman" value="<?= $rowPengiriman->no_pengiriman ?>" placeholder="No pengiriman" readonly required>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>No Permintaan</label>
            <input type="text" class="form-control" id="no_invoice" name="no_invoice" value="<?= $rowPermintaan->no_invoice ?>" readonly required>
            <input type="hidden" class="form-control" id="id_invoice" name="id_invoice" value="<?= $rowPermintaan->id ?>" readonly required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>No PO/SO</label>
            <input type="text" class="form-control" id="no_po" name="no_po" value="<?= $rowPermintaan->no_po ?>" readonly required>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Store</label>
            <input type="text" class="form-control" id="store" name="store" value="<?= $rowPermintaan->store ?>" readonly required>
            <input type="hidden" class="form-control" id="id_store" name="id_store" value="<?= $rowPermintaan->id_store ?>" readonly required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>No. Telp</label>
            <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= $rowPermintaan->no_telp ?>" readonly required>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Alamat Pengiriman</label>
            <input type="text" class="form-control" id="alamat" value="<?= $rowPermintaan->alamat_proyek ?>" placeholder="Alamat Pengiriman">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Sopir</label>
            <input type="text" class="form-control" id="sopir" placeholder="Sopir" value="<?= $rowPengiriman->sopir ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>No Polisi</label>
            <input type="text" class="form-control" id="no_polisi" placeholder="No Polisi" value="<?= $rowPengiriman->no_polisi ?>">
            <input type="hidden" class="form-control" size="2" id="id_pengiriman" value="<?= $rowPengiriman->id ?>">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Special Intruction</label><br>
            <textarea id="keterangan" name="keterangan" rows="10" cols="150">
            <?= $rowPengiriman->keterangan ?>
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
  <div class="box-footer spn">
    <button type="submit" onclick="save()" id="proses" class="btn btn-success kirimsemua">Simpan</button>
  </div>
  <div class="box-footer detkirim">
    <h3>Detail Pengiriman</h3>
    <table width="100%" id="tableku" class="table table-bordered" style="font-size: smaller;">
      <thead>
        <tr>
          <th>No</th>
          <th>Item</th>
          <th>Warna</th>
          <th>Bukaan</th>
          <th>Jml Permintaan</th>
          <th>Blm Terkirim</th>
          <th>Stock</th>
          <th>Terkirim</th>
          <th>Tipe</th>
          <th>Keterangan</th>
          <th>Status Detail</th>
          <th>Jumlah Kirim</th>
          <th>Act</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1;
        $row = 1;
        $totrow = 0;
        $totstat = 0; ?>
        <?php foreach ($detail as $val) :
          $qtyIn = $this->m_prioritas_pengiriman->getQtyIn($val->id_item, $val->id_tipe, $val->id_warna, $val->bukaan, $val->lebar, $val->tinggi);
          $qtyOutAll = $this->m_prioritas_pengiriman->getQtyOutAll($val->id_item, $val->id_tipe, $val->id_warna, $val->bukaan, $val->lebar, $val->tinggi);
          $qtyOut = $this->m_prioritas_pengiriman->getQtyOut($val->id_item, $val->id_tipe, $val->id_warna, $val->bukaan, $val->lebar, $val->tinggi, $val->id_invoice);
          $qtysended = $this->m_prioritas_pengiriman->getqtysended($id_kirim, $val->id_item, $val->id_tipe, $val->id_warna, $val->bukaan, $val->lebar, $val->tinggi);
          if ($qtyIn != '') {
            $in = $qtyIn;
          } else {
            $in = 0;
          }
          if ($qtyOut != '') {
            $send = $qtyOut;
          } else {
            $send = 0;
          }
          if ($qtyOutAll != '') {
            $out = $qtyOutAll;
          } else {
            $out = 0;
          }
          $stok = $in - $out;
          $permintaan = $val->qty - $send;
          if ($permintaan > $stok) {
            $stat = 0;
            $notif = "#ff8063";
          } else {
            $stat = 1;
            $notif = "";
          }

          $totrow = $totrow + $row;
          $totstat = $totstat + $stat;
        ?>
          <tr bgcolor="<?= $notif ?>">
            <td align="center"><?= $i ?></td>
            <td><?= $val->item . ' (' . $val->lebar . 'x' . $val->tinggi . ')' ?></td>
            <td align="center"><?= $val->warna ?></td>
            <td align="center"><?= $val->bukaan ?></td>
            <td align="center"><?= $val->qty ?></td>
            <td align="center"><?= $permintaan ?></td>
            <td align="center"><?= $stok ?></td>
            <td align="center"><?= $send ?></td>
            <td align="center"><?= $val->tipe ?></td>
            <td align="center"><?= $val->keterangan ?></td>
            <td align="center"><?= $val->status_detail ?></td>
            <td align="center">
              <input type="hidden" id="sto_<?= $val->id ?>" value="<?= $stok ?>"><input type="hidden" id="per_<?= $val->id ?>" value="<?= $val->qty ?>"><input type="text" class="form-control" value="<?= $qtysended ?>" size="2" id="qty_<?= $val->id ?>">
            </td>
            <td align="center">
              <?php if ($qtysended != 0) { ?>
                <a onclick="update(<?= $val->id ?>)" class="btn btn-primary sdh">Update</a>
              <?php } else { ?>
                <a onclick="simpan(<?= $val->id ?>)" id="simpan<?= $val->id ?>" class="btn btn-primary sdh">Simpan</a>
              <?php } ?>
            </td>
          </tr>
          <?php $i++; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="box-footer detkirim">
    <a onclick="finish(<?= $rowPermintaan->id ?>)" class="btn btn-success sdh">Finish</a>
  </div>

  </form>
</div>



<script language="javascript">
  function finish(id) {
    if (confirm('Anda yakin ingin menyelesaikan?')) {
      $.growl.notice({
        title: 'Berhasil',
        message: "Surat Jalan Berhasil!"
      });
      load_silent("klg/pengiriman/finish/" + id, "#content");
    }
  }
  $(document).ready(function() {
    var table = $('#tableku').DataTable({
      "scrollX": true,
      "ordering": true,
      "paging": false,
    });
    $('.datepicker').datepicker({
      autoclose: true
    });

    $("#lampiran").fileinput({
      'showUpload': true
    });
    $('.fileinput-upload-button').hide();
    $("select").select2();
    CKEDITOR.replace('keterangan');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();

    // $(".harga").hide();
    // $(".sdh").hide();

    // $('#form_pembelian').hide();
  });

  function save() {
    $(this).find("button[type='submit']").prop('disabled', true);
    var path = $("#lampiran").val().replace('C:\\fakepath\\', '');
    if (path == '') {
      $.ajax({
        type: "POST",
        url: site + 'klg/prioritas_pengiriman/updatepengiriman',
        dataType: 'json',
        data: {
          id_pengiriman: $("#id_pengiriman").val(),
          id_store: $("#id_store").val(),
          no_pengiriman: $("#no_pengiriman").val(),
          id_invoice: $("#id_invoice").val(),
          sopir: $("#sopir").val(),
          no_polisi: $("#no_polisi").val(),
          keterangan: CKEDITOR.instances.keterangan.getData(),

        },
        success: function(data) {
          $.growl.notice({
            title: 'Sukses',
            message: data['msg']
          });
        }
      });
    } else {
      $.ajaxFileUpload({
        url: site + 'klg/prioritas_pengiriman/updatepengirimanImage',
        secureuri: false,
        fileElementId: 'lampiran',
        dataType: 'json',
        data: {
          id_pengiriman: $("#id_pengiriman").val(),
          id_store: $("#id_store").val(),
          no_pengiriman: $("#no_pengiriman").val(),
          id_invoice: $("#id_invoice").val(),
          sopir: $("#sopir").val(),
          no_polisi: $("#no_polisi").val(),
          keterangan: CKEDITOR.instances.keterangan.getData(),
        },
        success: function(data) {
          $.growl.notice({
            title: 'Berhasil',
            message: data['msg']
          });
        },
        error: function(data, e) {
          $("#info").html(e);
        }
      })
      return false;
    };

  }
















  function simpan(id) {
    var permintaan = $("#per_" + id).val();
    var qty = $("#qty_" + id).val();
    var stk = $("#sto_" + id).val();

    if (parseInt(qty) > parseInt(permintaan)) {
      $.growl.error({
        title: 'Peringatan',
        message: 'Qty melebihi permintaan!'
      });
    } else {
      if (parseInt(qty) > parseInt(stk)) {
        $.growl.error({
          title: 'Peringatan',
          message: 'Qty melebihi stock!'
        });
      } else {
        $.ajax({
            type: "POST",
            url: "<?= site_url('klg/prioritas_pengiriman/savepengirimanDetail') ?>",
            dataType: 'json',
            data: {
              'id_did': id,
              'id_store': $("#id_store").val(),
              'id_pengiriman': $("#id_pengiriman").val(),
              'qty': qty,
            },
          })
          .success(function(datasaved) {

            $.growl.notice({
              title: 'Sukses',
              message: "Berhasil menyimpan pengiriman"
            });
            $("#simpan" + id).hide();
          })
          .fail(function(XHR) {
            if (XHR.readyState == 0) {
              $.growl.error({
                title: 'Peringatan',
                message: 'Terjadi Kesalahan! KONEKSI TERPUTUS'
              });
            } else {
              $.growl.error({
                title: 'Peringatan',
                message: 'Terjadi Kesalahan! UNKNOWN ERROR'
              });
            }
          });
      }
    }
  }

  function update(id) {
    var permintaan = $("#per_" + id).val();
    var qty = $("#qty_" + id).val();
    var stk = $("#sto_" + id).val();

    if (parseInt(qty) > parseInt(permintaan)) {
      $.growl.error({
        title: 'Peringatan',
        message: 'Qty melebihi permintaan!'
      });
    } else {
      if (parseInt(qty) > parseInt(stk)) {
        $.growl.error({
          title: 'Peringatan',
          message: 'Qty melebihi stock!'
        });
      } else {
        $.ajax({
            type: "POST",
            url: "<?= site_url('klg/prioritas_pengiriman/updatepengirimanDetail') ?>",
            dataType: 'json',
            data: {
              'id_did': id,
              'id_store': $("#id_store").val(),
              'id_pengiriman': $("#id_pengiriman").val(),
              'qty': qty,
            },
          })
          .success(function(datasaved) {

            $.growl.notice({
              title: 'Sukses',
              message: "Berhasil mengupdate pengiriman"
            });
          })
          .fail(function(XHR) {
            if (XHR.readyState == 0) {
              $.growl.error({
                title: 'Peringatan',
                message: 'Terjadi Kesalahan! KONEKSI TERPUTUS'
              });
            } else {
              $.growl.error({
                title: 'Peringatan',
                message: 'Terjadi Kesalahan! UNKNOWN ERROR'
              });
            }
          });
      }
    }
  }
</script>