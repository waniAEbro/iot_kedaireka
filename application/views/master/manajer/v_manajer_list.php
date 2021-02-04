<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div class="row" id="form_pembelian">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Admin HO dan WO</h3>
          </div>

          <div class="box-body">
            <table width="100%" id="tableku" class="table table-striped">
              <thead>
                <th>No</th>
                <th>Owner</th>
                <th>Picture</th>
                <th>Level</th>
                <th>Email</th>
                <th>Act</th>
              </thead>
              <tbody>
          <?php 
          $i = 1;
          foreach($manajer->result() as $row):
          $avatar = parse_avatar($row->gambar,$row->nama,75,'');             
          ?>
          <tr>
            <td><?=$i++?></td>
            <td><?=$row->nama?></td>
            <td><?=$avatar?></td>
            <td><?=$row->nama_level?></td>
            <td><?=$row->email?></td>
            <td>
            <?php echo button('load_silent("master/manajer/show_editForm/'.$row->id.'","#content")','Edit','btn btn-info','data-toggle="tooltip" title="Edit User"');?> 
						</td>
					</tr>

				<?php endforeach;?>
				</tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tableku').DataTable( {
      "ordering": false,
      "scrollX": true,
    } );
  });
</script>