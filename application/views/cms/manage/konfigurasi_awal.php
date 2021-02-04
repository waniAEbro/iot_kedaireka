<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    
    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Konfigurasi Notifikasi</h3>

            
          </div>
          <div class="box-body">
            <?php echo form_open('',array('name'=>'faddmenugrup','class'=>'form-horizontal','role'=>'form'));?>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email Manager</label>
                <div class="col-sm-8">
                <?php echo form_input(array('name'=>'email_manager','id'=>'email_manager','value'=>$grupedit->email_manager,'class'=>'form-control'));?>
                <?php echo form_error('email_manager');?>
                </div>
            </div>
            

            <div class="form-group">
                <label class="col-sm-2 control-label">Save</label>
                <div class="col-sm-8 tutup">
                <?php
                //echo button('send_form(document.faddmenugrup,"master/produk/show_addForm/","#divsubcontent")','Save','btn btn-success')." ";
                ?>
                <input onclick="save()" type="submit" value="Save" id="tombol" class="btn btn-success">
                </div>
            </div>
        </form>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript">

var path='';
function save()
{
    if (path == '') {
        $.ajax({
        type: "POST",
        url: "<?= site_url('cms/manage/configure_def/')?>",
        dataType:'json',
        data: {
           
            email_manager             : $("#email_manager").val(),
            
        },
        success   : function(data)
        {
          $.growl.notice({ title: 'Sukses', message: data['msg']});      
          load_silent("cms/manage/configure_def/","#content");
        }
      });

    }
  
  return false;
}
</script>