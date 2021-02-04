<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
    $row = fetch_single_row($edit);
?>
    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">From Add User</h3>
                <?php if (from_session('level')<=2) {?>
                <div class="box-tools pull-right">
                  <?php echo button('load_silent("cms/user/","#content")','Back to List user','btn btn-danger','data-toggle="tooltip" title="Back List user"');?> 
                </div>
                <?php }?>
            </div>
          <div class="box-body">
            <?php echo form_open('',array('name'=>'faddmenugrup','class'=>'form-horizontal','role'=>'form'));?>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">Nama</label>
                <div class="col-sm-8">
                <?php echo form_input(array('name'=>'id','value'=>$row->id,'id'=>'id','class'=>'form-control','style'=>'display:none'));?>
                
                <?php echo form_input(array('name'=>'nama','id'=>'nama','value'=>$row->nama,'class'=>'form-control','readonly'=>'readonly'));?>
                <?php echo form_error('nama');?>
                </div>
            </div>
            <?php if (from_session('level')<=2) {?>

            <div class="form-group">
                <label class="col-sm-2 control-label">Level</label>
                <div class="col-sm-8">
                  <?php echo form_dropdown('level',$level,$row->level,'id="level" class="form-control select2" readonly');?>
                  <?php echo form_error('level', '<span class="error-span">', '</span>'); ?>
                </div>
            </div>
            <?php }?>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-8">
                <?php echo form_input(array('name'=>'email','id'=>'email','value'=>$row->email,'class'=>'form-control'));?>
                <?php echo form_error('email');?>
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
    
    $(".select2").select2();
    $('.fileinput-upload-button').hide();
    $('.tutup').click(function(e) {  
        $('#myModal').modal('hide');
    });
});

function save()
{
    var ida = $('#id').val();
    
        $.ajax({
        type: "POST",
        url: "<?= site_url('master/manajer/show_editForm/"+ida+"')?>",
        dataType:'json',
        data: {
            id        : $("#id").val(),
            level        : $("#level").val(),
            email        : $("#email").val(),
          
        },
        success   : function(data)
        {
          $.growl.notice({ title: 'Sukses', message: data['msg']});      
          load_silent("master/manajer/","#content");
        }
      });

    
  
  return false;
}
</script>