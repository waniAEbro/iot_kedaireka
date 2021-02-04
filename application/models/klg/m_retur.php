<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_retur extends CI_Model
{

	public function getData($value = '')
	{
		$this->db->join('master_store ms', 'ms.id = dr.id_store', 'left');
		$this->db->join('master_jenis_retur mjr', 'mjr.id = dr.id_jenis_retur', 'left');
		$this->db->join('master_alasan_retur mar', 'mar.id = dr.id_alasan_retur', 'left');
		$this->db->select('dr.*,ms.store,mjr.jenis_retur,mar.alasan_retur');
		$this->db->order_by('dr.id', 'desc');
		return $this->db->get('data_retur dr');
	}

	public function getNomor($value = '')
	{
		$year = date('Y');
		$month = date('m');
		$this->db->where('DATE_FORMAT(date,"%Y")', $year);
		$this->db->where('DATE_FORMAT(date,"%m")', $month);
		$this->db->order_by('no_retur', 'desc');
		$this->db->limit(1);
		$hasil = $this->db->get('data_retur');
		if ($hasil->num_rows() > 0) {

			$string = $hasil->row()->no_retur;
			$arr = explode("/", $string, 2);
			$first = $arr[0];
			$no = $first + 1;
			return $no;
		} else {
			return '1';
		}
	}

	public function getEdit($id = '')
	{
		$this->db->where('id', $id);
		return $this->db->get('data_retur');
	}
	public function editRetur($value = '', $id)
	{
		$this->db->where('id', $id);
		$this->db->update('data_retur', $value);
	}

	public function getItemStore($id = '')
	{
		$this->db->where('did.id_store', $id);
		$this->db->join('master_item mi', 'mi.id = did.id_item', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->group_by('did.id_item,did.id_tipe,did.id_warna,did.bukaan,did.lebar,did.tinggi');
		$this->db->order_by('did.id', 'desc');
		$this->db->select('did.*,mi.item,mt.tipe,mw.warna');
		return $this->db->get('warehouse_data_detail did')->result();
	}

	public function getDetailInvoice($value = '')
	{
		$this->db->where('id', $value);
		return $this->db->get('warehouse_data_detail')->row();
	}

	public function insertRetur($value = '')
	{
		$this->db->insert('data_retur', $value);
	}
	public function insertReturDetail($value = '')
	{
		$this->db->insert('data_retur_detail', $value);
	}

	public function getJumDetail($value = '')
	{
		$this->db->where('id_retur', $value);
		$hasil = $this->db->get('data_retur_detail');
		if ($hasil->num_rows() > 0) {
			return '1';
		} else {
			return '0';
		}
	}

	public function getDataDetailTabel($value = '')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');

		$this->db->join('master_item mpn', 'mpn.id = did.id_item_baru', 'left');
		$this->db->join('master_warna mwn', 'mwn.id = did.id_warna_baru', 'left');
		$this->db->join('master_tipe mtn', 'mtn.id = did.id_tipe_baru', 'left');

		$this->db->select('did.*,mt.tipe,mp.item,mw.warna,mpn.item as item_baru,mwn.warna as warna_baru,mtn.tipe as tipe_baru');
		// $this->db->order_by('did.id', 'desc');
		$this->db->where('did.id_retur', $value);
		return $this->db->get('data_retur_detail did')->result();
	}

	public function deleteRetur($value = '')
	{
		$this->db->where('id', $value);
		$this->db->delete('data_retur');
	}

	public function deleteDetailRetur($value = '')
	{
		$this->db->where('id_retur', $value);
		$this->db->delete('data_retur_detail');
	}
	public function getRowretur($id = '')
	{
		$this->db->where('id', $id);
		return $this->db->get('data_retur')->row();
	}

	public function getDetailretur($id = '')
	{
		$this->db->where('id_retur', $id);
		return $this->db->get('data_retur_detail');
	}

	public function getMaxProduksi($value = '')
	{
		$this->db->select_max('id');
		return $this->db->get('data_produksi')->row()->id;
	}

	public function insertStok($value = '')
	{
		$this->db->insert('data_stok_detail', $value);
	}

	public function insertStokWarehouse($value = '')
	{
		$this->db->insert('warehouse_data_detail', $value);
	}

	public function updateStatus($value = '')
	{
		$object = array('status' => 2,);
		$this->db->where('id', $value);
		$this->db->update('data_retur', $object);
	}

	public function getHeaderCetak($value = '')
	{
		$this->db->join('master_store ms', 'ms.id = dr.id_store', 'left');
		$this->db->join('master_jenis_retur mjr', 'mjr.id = dr.id_jenis_retur', 'left');
		$this->db->select('dr.*,ms.store,mjr.jenis_retur');
		$this->db->where('dr.id', $value);
		return $this->db->get('data_retur dr');
	}

	public function getIsiCetak($value = '')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');

		$this->db->join('master_item mpn', 'mpn.id = did.id_item_baru', 'left');
		$this->db->join('master_warna mwn', 'mwn.id = did.id_warna_baru', 'left');
		$this->db->join('master_tipe mtn', 'mtn.id = did.id_tipe_baru', 'left');

		$this->db->select('did.*,mt.tipe,mp.item,mw.warna,mpn.item as item_baru,mwn.warna as warna_baru,mtn.tipe as tipe_baru');
		// $this->db->order_by('did.id', 'desc');
		$this->db->where('did.id_retur', $value);
		return $this->db->get('data_retur_detail did');
	}

	public function template_email_retur($id_invoice, $store)
	{
		$html = '<!DOCTYPE html>
		<html style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
		<head>
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Actionable emails e.g. reset password</title>


		<style type="text/css">
		img {
		max-width: 100%;
		}
		body {
		-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
		}
		body {
		background-color: #f6f6f6;
		}
		@media only screen and (max-width: 640px) {
		  body {
			padding: 0 !important;
		  }
		  h1 {
			font-weight: 800 !important; margin: 20px 0 5px !important;
		  }
		  h2 {
			font-weight: 800 !important; margin: 20px 0 5px !important;
		  }
		  h3 {
			font-weight: 800 !important; margin: 20px 0 5px !important;
		  }
		  h4 {
			font-weight: 800 !important; margin: 20px 0 5px !important;
		  }
		  h1 {
			font-size: 22px !important;
		  }
		  h2 {
			font-size: 18px !important;
		  }
		  h3 {
			font-size: 16px !important;
		  }
		  .container {
			padding: 0 !important; width: 100% !important;
		  }
		  .content {
			padding: 0 !important;
		  }
		  .content-wrap {
			padding: 10px !important;
		  }
		  .invoice {
			width: 100% !important;
		  }
		}
		</style>
		</head>

		<body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

		<table class="body-wrap" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
			<td class="container" width="600" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
			  <div class="content" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
				<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
					  <meta itemprop="name" content="Confirm Email" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" /><table width="100%" cellpadding="0" cellspacing="0" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
							Silahkan Konfirm melalui Link Di Bawah ini
						  </td>
						</tr><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
							diberitahukan untuk manajer bahwa ada permintaan retur dari ' . $store . ' silahkan cek lampiran untuk melihat detail isian
						  </td>
						</tr><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
							<a href="' . base_url('out/verif_tolak/verifikasi/' . $id_invoice) . '" class="btn-primary" itemprop="url" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">Setujui Permintaan</a>
						  </td>
						</tr><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
							&mdash; Alphamax System
						  </td>
						</tr></table></td>
				  </tr></table><div class="footer" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">

					</tr></table></div></div>
			</td>
			<td style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
		  </tr></table></body>
		</html>';
		// $html='diberitahukan untuk manajer bahwa ada form permintaan baru  dari '.$pembeli.'silahkan cek lampiran untuk melihat detail isian';
		return $html;
	}
	public function editVerifikasi($id = '', $status = '')
	{
		$object = array('status' => $status,);
		$this->db->where('id', $id);
		$this->db->update('data_retur', $object);
	}
}

/* End of file m_retur.php */
/* Location: ./application/models/klg/m_retur.php */