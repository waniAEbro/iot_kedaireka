<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$row = fetch_single_row($edit);
?>
<div class="row" id="form_pembelian">
  <div class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">From Edit User</h3>
        <?php if (from_session('level') <= 2) { ?>
          <div class="box-tools pull-right">
            <?php echo button('load_silent("cms/user/","#content")', 'Back to List user', 'btn btn-danger', 'data-toggle="tooltip" title="Back List user"'); ?>
          </div>
        <?php } ?>
      </div>
      <div class="box-body">
        <?php echo form_open('', array('name' => 'faddmenugrup', 'class' => 'form-horizontal', 'role' => 'form')); ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">Nama</label>
          <div class="col-sm-8">
            <?php echo form_input(array('name' => 'id', 'value' => $row->id, 'id' => 'id', 'class' => 'form-control', 'style' => 'display:none')); ?>

            <?php echo form_input(array('name' => 'nama', 'id' => 'nama', 'value' => $row->nama, 'class' => 'form-control')); ?>
            <?php echo form_error('nama'); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Username</label>
          <div class="col-sm-8">
            <?php echo form_input(array('name' => 'username', 'id' => 'username', 'value' => $row->username, 'class' => 'form-control')); ?>
            <?php echo form_error('username'); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Password</label>
          <div class="col-sm-8">
            <?php echo form_password(array('name' => 'password', 'id' => 'password', 'class' => 'form-control')); ?>
            <?php echo form_error('password'); ?>
          </div>
        </div>
        <?php if (from_session('level') <= 2) { ?>

          <div class="form-group">
            <label class="col-sm-2 control-label">Level</label>
            <div class="col-sm-8">
              <select id="selector_level" name="selector_level" class="form-control" style="width:100%" required>
                <?php foreach ($level->result() as $val) :
                  if ($val->id == $row->level) {
                    $sel = "selected";
                  } else {
                    $sel = "";
                  } ?>
                  <option value="<?= $val->id ?>" <?= $sel ?>><?= $val->level ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Store</label>
            <div class="col-sm-8">
              <select id="id_store" name="id_store" class="form-control" style="width:100%" required>
                <?php foreach ($store->result() as $val) :
                  if ($val->id == $row->id_store) {
                    $sel = "selected";
                  } else {
                    $sel = "";
                  } ?>
                  <option value="<?= $val->id ?>" <?= $sel ?>><?= $val->store ?></option>
                <?php endforeach; ?>
              </select>
              <span>*)jika level yg dibuat admin atau manajer abaikan pilihan store</span>
            </div>
          </div>
        <?php } ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">No Hp</label>
          <div class="col-sm-8">
            <?php echo form_input(array('name' => 'no_hp', 'id' => 'no_hp', 'value' => $row->no_hp, 'class' => 'form-control')); ?>
            <?php echo form_error('no_hp'); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Alamat</label>
          <div class="col-sm-8">
            <?php echo form_input(array('name' => 'alamat', 'id' => 'alamat', 'value' => $row->alamat, 'class' => 'form-control')); ?>
            <?php echo form_error('alamat'); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Save</label>
          <div class="col-sm-8 tutup">
            <?php
            //echo button('send_form(document.faddmenugrup,"cms/user/show_addForm/","#divsubcontent")','Save','btn btn-success')." ";
            ?>
            <input onclick="save()" type="submit" value="Save" class="btn btn-success">
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {

    $("select").select2();
    $('.tutup').click(function(e) {
      $('#myModal').modal('hide');
    });
  });

  function save() {
    var ida = $('#id').val();

    $.ajax({
      type: "POST",
      url: "<?= site_url('cms/user/edit/"+ida+"') ?>",
      dataType: 'json',
      data: {
        id: $("#id").val(),
        nama: $("#nama").val(),
        username: $("#username").val(),
        password: $("#password").val(),
        level: $("#selector_level").val(),
        id_store: $("#id_store").val(),
        no_hp: $("#no_hp").val(),
        alamat: $("#alamat").val(),

      },
      success: function(data) {
        if (data['sts'] == 'no') {
          $.growl.error({
            title: 'Silahkan Ulangi!',
            message: data['msg']
          });
        } else {
          $.growl.notice({
            title: 'Sukses',
            message: data['msg']
          });
          load_silent("cms/user/", "#content");
        };
      }
    });



    return false;
  }
</script>