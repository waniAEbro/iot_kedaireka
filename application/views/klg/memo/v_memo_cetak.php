<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" media="all"  href="<?=base_url();?>assets/css/bootstrap.min.cetak.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" media="all"  href="<?=base_url();?>assets/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" media="all"  href="<?=base_url();?>assets/css/ionicons.min.css">
	<!-- tdeme style -->
	<link rel="stylesheet" media="all"  href="<?=base_url();?>assets/css/AdminLTE.min.css">

	<!-- jQuery 2.1.4 -->
	<script src="<?=base_url();?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="<?=base_url();?>assets/js/jquery-ui.min.js"></script>	
	<script>
		$(document).ready(function(e) {
			window.print();

		});		
	</script>
	<script type="text/javascript">
		function cetak()
		{
			window.print();
		}
	</script>
	<style type="text/css" media="print">

		@page {
		    size: auto;   /* auto is the initial value */
		    margin-top: 0;  /* this affects the margin in the printer settings */
		    margin-bottom: 0;  /* this affects the margin in the printer settings */
		}
		.btn-cetak
		{
			display: none;
		}

		.table td {
			padding:1px;
		}

	</style>
	<style type="text/css" media="print">
  		.table>tbody>tr>th,.table>tfoot>tr>th,.table>thead>tr>th {
    		text-align: center;
  		}
  	</style>

</head>
<body style="margin: 0px;">
	<div class="wrapper" style="font-size: smaller;">
		<!-- Content Header (Page header) -->		
		<section class="content-header">
			<a onclick="cetak()" id="cetak" name="cetak" class="btn btn-success btn-cetak"> Cetak</a>			
		</section>

		<section class="content" style="padding:0px;">
			<div class="row">
				<div class="col-lg-12">
					<div class="box box-primary">
					<h3 class="box-title">List Memo</h3>
						<table width="100%" class="table table-bordered">
				              <thead>
				                <th width="5%">No</th>
				                <th>Store</th>
				                <th>No Memo</th>
				                <th>Nama Project</th>
				                <th>Alamat Project</th>
				                <th>Tgl Memo</th>
				                <th>Deadline Pengambilan</th>
				                <th>No FPPP</th>
				                <th>Charge</th>
				                <th>Alasan</th>
				              </thead>
				              <tbody>
				          <?php 
				          $i = 1;
				          foreach($memo->result() as $row): 
				            $ada = $this->m_memo->getJumDetail($row->id);
				          ?>
				          <tr>
				            <td align="center"><?=$i?></td>
				            <td><?=$row->store?></td>
				            <td><?=$row->no_memo?></td>
				            <td><?=$row->nama_project?></td>
				            <td><?=$row->alamat_project?></td>
				            <td><?=$row->tgl_memo?></td>
				            <td><?=$row->deadline_pengambilan?></td>
				            <td><?=$row->no_fppp?></td>
				            <td><?=$row->charge?></td>
				            <td><?=$row->alasan?></td>
				          </tr>

				        <?php $i++; endforeach;?>
				        </tbody>
				            </table>
					</div>
				</div>
			</div>
		</section>		
	</div>

</body>
</html>