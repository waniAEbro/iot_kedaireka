<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Form NCR</h3>

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
            <label>Store/Mitra</label>
            <select id="store" name="store" class="form-control" style="width:100%" required>
              <option value="">-- Store/Mitra --</option>
              <?php foreach ($store as $valap) : ?>
                <option value="<?= $valap->id ?>"><?= $valap->store ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Nama Project</label>
            <input type="text" class="form-control" id="nama_project" placeholder="Nama Project">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>No NCR</label>
            <input type="text" class="form-control" id="no_ncr" name="no_ncr" value="<?= $nomor_ncr ?>" placeholder="No NCR" readonly required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>No WO/SPK</label>
            <input type="text" class="form-control" id="no_wo" name="no_wo" placeholder="No WO/SPK" required autocomplete="off">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Tanggal</label>
            <input type="text" data-date-format="yyyy-mm-dd" value="<?= date('Y-m-d') ?>" class="form-control datepicker" id="tanggal" placeholder="Tanggal" required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>No FPPP</label>
            <input type="text" class="form-control" id="no_fppp" placeholder="No FPPP">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Kepada</label>
            <input type="text" class="form-control" id="kepada" placeholder="Kepada" required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Item</label><br>
            <textarea id="item" name="item" rows="10" cols="150">
                </textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Dilaporkan Oleh</label>
            <input type="text" class="form-control" id="dilaporkan_oleh" placeholder="Dilaporkan Oleh">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Jenis Ketidaksesuaian</label>
            <select id="jenis_ketidaksesuaian" name="jenis_ketidaksesuaian" class="form-control" style="width:100%" required>
              <option value="">-- Jenis Ketidaksesuaian --</option>
              <?php foreach ($jenis_ketidaksesuaian as $valap) : ?>
                <option value="<?= $valap->id ?>">[<?= $valap->id ?>] - <?= $valap->jenis_ketidaksesuaian ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Deskripsi Masalah</label><br>
            <textarea id="deskripsi_masalah" name="deskripsi_masalah" rows="10" cols="150">
                </textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Analisa Penyebab Masalah</label><br>
            <textarea id="analisa_penyebab_masalah" name="analisa_penyebab_masalah" rows="10" cols="150">
                </textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Tindakan Perbaikan</label><br>
            <textarea id="tindakan_perbaikan" name="tindakan_perbaikan" rows="10" cols="150">
                </textarea>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Lampiran</label>
            <div class="">
              <?php echo form_upload(array('name' => 'lampiran', 'id' => 'lampiran')); ?>
              <span style="color:red">*) Lampiran File berformat .pdf maks 2MB</span>
            </div>
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
</div>


<script language="javascript">
  function finish() {
    if (confirm('Anda yakin ingin menyelesaikan?')) {
      $.growl.notice({
        title: 'Berhasil',
        message: "Tambah NCR selesai!"
      });
      load_silent("klg/ncr/finish/" + $("#id_ncr").val() + "", "#content");
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
    $(".harga").hide();

    // Replace the <textarea id="editor1"> with a CKEditor files/2019/12/03cd07ae4cb5f5f8ab4f5c4cd80d81e5.png
    // instance, using default configuration.
    CKEDITOR.replace('item');
    CKEDITOR.replace('deskripsi_masalah');
    CKEDITOR.replace('analisa_penyebab_masalah');
    CKEDITOR.replace('tindakan_perbaikan');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();

    $('.form_pembelian').hide();
  });

  function save() {
    $(this).find("button[type='submit']").prop('disabled', true);
    var path = $("#lampiran").val().replace('C:\\fakepath\\', '');
    if (path == '') {
      $.growl.warning({
        title: 'Peringatan',
        message: 'Lampiran harus diisi!'
      });
    } else {
      $.ajaxFileUpload({
        url: site + 'klg/ncr/savencrImage',
        secureuri: false,
        fileElementId: 'lampiran',
        dataType: 'json',
        data: {
          store: $("#store").val(),
          nama_project: $("#nama_project").val(),
          no_ncr: $("#no_ncr").val(),
          no_wo: $("#no_wo").val(),
          tanggal: $("#tanggal").val(),
          no_fppp: $("#no_fppp").val(),
          kepada: $("#kepada").val(),
          item: CKEDITOR.instances.item.getData(),
          dilaporkan_oleh: $("#dilaporkan_oleh").val(),
          id_jenis_ketidaksesuaian: $("#jenis_ketidaksesuaian").val(),
          deskripsi_masalah: CKEDITOR.instances.deskripsi_masalah.getData(),
          analisa_penyebab_masalah: CKEDITOR.instances.analisa_penyebab_masalah.getData(),
          tindakan_perbaikan: CKEDITOR.instances.tindakan_perbaikan.getData(),
        },
        success: function(data) {
          $.growl.notice({
            title: 'Berhasil',
            message: data['msg']
          });
          load_silent("klg/ncr/", "#content");
        },
        error: function(data, e) {
          $("#info").html(e);
        }
      })
      return false;
    };

  }
</script>