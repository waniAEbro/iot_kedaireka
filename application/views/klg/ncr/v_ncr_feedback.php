<div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Feedback NCR <?=$row->no_ncr?></h3>

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
                <label>Lampiran</label>
                <div class="">
                <?php echo form_upload(array('name'=>'lampiran','id'=>'lampiran'));?>
                <span style="color:red">*) Lampiran File berformat .jpg|jpeg|png maks 2MB</span>
                <input type="hidden" id="id_ncr" name="id_ncr" value="<?=$id?>" readonly required>
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
  if(confirm('Anda yakin ingin menyelesaikan?'))
  {
    $.growl.notice({ title: 'Berhasil', message: "Tambah NCR selesai!"});
    load_silent("klg/ncr/finish/"+$("#id_ncr").val()+"","#content");
  }
}
$(document).ready(function() {
  $('.datepicker').datepicker({
    autoclose: true
  });

  $("#lampiran").fileinput({
    'showUpload'            :true
    });
  $('.fileinput-upload-button').hide();
  
});

function save()
{
  $(this).find("button[type='submit']").prop('disabled',true);
     var path = $("#lampiran").val().replace('C:\\fakepath\\', '');
    if(path == ''){
        $.growl.warning({ title: 'Peringatan', message: 'Lampiran harus diisi!' });
    }
     else{
        $.ajaxFileUpload
          ({
            url:site+'klg/ncr/saveFeedback',
            secureuri:false,
            fileElementId:'lampiran',
            dataType: 'json',
            data: {
                id_ncr                    : $("#id_ncr").val(),
              },
            success: function (data)
            {
              $.growl.notice({ title: 'Berhasil', message: data['msg'] });
              load_silent("klg/ncr/","#content");
            },
            error: function (data, e)
            {
              $("#info").html(e);
            }
          })
          return false;
    };
  
}


</script>