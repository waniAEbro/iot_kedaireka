<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$row = fetch_single_row($edit);
?>
<div class="row" id="form_pembelian">
  <div class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">From Edit Item</h3>
      </div>
      <div class="box-body">
        <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">Item</label>
          <div class="col-sm-8">
            <?php echo form_input(array('name' => 'id', 'value' => $row->id, 'id' => 'id', 'class' => 'form-control', 'style' => 'display:none;')); ?>
            <?php echo form_input(array('name' => 'item', 'value' => $row->item, 'id' => 'item', 'class' => 'form-control')); ?>
            <?php echo form_error('item'); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Jenis Barang</label>
          <div class="col-sm-8">
            <select id="jenis_barang" name="jenis_barang" class="form-control" style="width:100%" required>
              <option value="">-- Select Jenis Barang --</option>
              <?php foreach ($jenis_barang->result() as $val) : ?>
                <?php if ($val->id == $row->id_jenis_barang) {
                  $selb = "selected";
                } else {
                  $selb = "";
                } ?>
                <option value="<?= $val->id ?>" <?= $selb ?>><?= $val->jenis_barang ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="userfile">Gambar</label>
          <div class="col-sm-8">
            <?php echo form_upload(array('name' => 'ufile', 'id' => 'ufile')); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Lebar</label>
          <div class="col-sm-8">
            <?php echo form_input(array('name' => 'lebar', 'value' => $row->lebar, 'id' => 'lebar', 'class' => 'form-control')); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Tinggi</label>
          <div class="col-sm-8">
            <?php echo form_input(array('name' => 'tinggi', 'value' => $row->tinggi, 'id' => 'tinggi', 'class' => 'form-control')); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Spesification</label>
          <div class="col-sm-8">
            <?php echo form_input(array('name' => 'spesifikasi', 'value' => $row->spesifikasi, 'id' => 'spesifikasi', 'class' => 'form-control')); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Lokasi</label>
          <div class="col-sm-8">
            <select id="lokasi" name="lokasi" class="form-control" style="width:100%" required>
              <option value="">-- Select Lokasi --</option>
              <?php foreach ($lokasi->result() as $val) : ?>
                <?php if ($val->id == $row->id_lokasi) {
                  $selb = "selected";
                } else {
                  $selb = "";
                } ?>
                <option value="<?= $val->id ?>" <?= $selb ?>><?= $val->lokasi ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Jumlah Safety Stok</label>
          <div class="col-sm-8">
            <?php echo form_input(array('name' => 'safety_stok', 'value' => $row->safety_stok, 'id' => 'safety_stok', 'class' => 'form-control')); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Save</label>
          <div class="col-sm-8 tutup">
            <input onclick="save()" type="submit" id="tombol" value="Save" class="btn btn-success" disabled>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $("#ufile").fileinput({
      'showUpload': true,
      initialPreview: '<img src="<?php echo base_url() . $row->gambar; ?>" class="file-preview-image">'
    });
    $("select").select2();
    $('#tombol').removeAttr('disabled', false);
    $('.tutup').click(function(e) {
      $('#myModal').modal('hide');
    });
  });

  function save() {
    $('#tombol').attr('disabled', 'disabled');
    var path = $("#ufile").val().replace('C:\\fakepath\\', '');
    var ida = $('#id').val();
    if (path == '') {
      $.ajax({
        type: "POST",
        url: "<?= site_url('master/item/show_editForm/"+ida+"') ?>",
        dataType: 'json',
        data: {
          id: $("#id").val(),
          item: $("#item").val(),
          id_jenis_barang: $("#jenis_barang").val(),
          lebar: $("#lebar").val(),
          tinggi: $("#tinggi").val(),
          spesifikasi: $("#spesifikasi").val(),
          id_warna: $("#warna").val(),
          id_lokasi: $("#lokasi").val(),
          safety_stok: $("#safety_stok").val(),

        },
        success: function(data) {
          $.growl.notice({
            title: 'Sukses',
            message: data['msg']
          });
          load_silent("master/item/", "#content");
        }
      });

    } else {
      $.ajaxFileUpload({
        url: "<?= site_url('master/item/show_editForm_file/"+ida+"') ?>",
        secureuri: false,
        fileElementId: 'ufile',
        dataType: 'json',
        data: {
          id: $("#id").val(),
          item: $("#item").val(),
          id_jenis_barang: $("#jenis_barang").val(),
          lebar: $("#lebar").val(),
          tinggi: $("#tinggi").val(),
          spesifikasi: $("#spesifikasi").val(),
          id_warna: $("#warna").val(),
          id_lokasi: $("#lokasi").val(),
          safety_stok: $("#safety_stok").val(),
        },
        success: function(data) {
          $.growl.notice({
            title: 'Berhasil',
            message: data['msg']
          });
          load_silent("master/item/", "#content");
        },
        error: function(data, e) {
          $("#info").html(e);
        }
      })

    };

    return false;
  }
</script>