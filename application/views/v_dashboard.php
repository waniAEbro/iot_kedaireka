<div class="col-md-12">
  <!-- Widget: user widget style 1 -->
  <div class="box box-widget widget-user">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header bg-black" style="background: url('<?php echo base_url(); ?>assets/img/photo2.jpg') center center;height:320px;">
      <h3 class="widget-user-username"><?= from_session('nama') ?></h3>
      <h5 class="widget-user-desc"><?= from_session('nama_level') ?></h5>
    </div>
    <div class="widget-user-image">

      <?php
      $avatar = parse_avatar(from_session('gambar'), from_session('nama'), 40, 'img-circle');
      ?>
      <?php echo $avatar; ?>
    </div>
    <div class="box-footer">
      <div class="row">
        <div class="col-sm-12 border-right">
          <div class="description-block">
            <h5 class="description-header">WELCOME IN ALLURE RETAIL SYSTEM</h5>
            <?php
            if (from_session('id')==2) {
              echo button('load_silent("klg/fppp/uploadbom/1","#content")', 'Upload', 'btn btn-xs btn-success', 'data-toggle="tooltip" title="Upload"');
            }
            ?>
            <span class="description-text"><?php echo button('load_silent("cms/user/formedituser/' . from_session('id') . '","#content")', 'Update Profil', 'btn bg-purple', 'data-toggle="tooltip" title="Update Profil"'); ?>
            </span>
            <?php
            if (from_session('level')==1) {
              echo button('load_silent("klg/fppp/uploadmasterstock","#content")', 'Upload Master dan Stock', 'btn btn-danger', 'data-toggle="tooltip" title="Upload Master dan Stock"');
            }
            ?>
          </div>
          <!-- /.description-block -->
        </div>

        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
  </div>
  <!-- /.widget-user -->
</div>