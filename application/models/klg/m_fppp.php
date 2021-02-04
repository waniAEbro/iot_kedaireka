<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_fppp extends CI_Model
{

	public function getData($param)
	{
		$this->db->join('master_divisi md', 'md.id = df.id_divisi', 'left');
		$this->db->join('master_kaca mk', 'mk.id = df.id_kaca', 'left');
		$this->db->join('master_pengiriman mp', 'mp.id = df.id_pengiriman', 'left');
		$this->db->join('master_metode_pengiriman mpp', 'mpp.id = df.id_metode_pengiriman', 'left');
		$this->db->join('master_warna_aluminium mwa', 'mwa.id = df.id_warna_aluminium', 'left');
		$this->db->where('df.id_divisi', $param);

		$this->db->select('df.*,md.divisi,mk.kaca,mp.pengiriman,metode_pengiriman,mwa.warna_aluminium');

		return $this->db->get('data_fppp df');
	}

	public function insertfppp($value = '')
	{
		$this->db->insert('data_fppp', $value);
	}

	public function insertfpppDetail($value = '')
	{
		$this->db->insert('data_fppp_detail', $value);
	}

	public function getDataDetailTabel($value = '')
	{
		$this->db->join('master_brand mb', 'mb.id = did.id_brand', 'left');
		$this->db->join('master_item mi', 'mi.id = did.id_item', 'left');
		$this->db->select('did.*,mb.brand,mi.item');

		$this->db->where('did.id_fppp', $value);
		return $this->db->get('data_fppp_detail did')->result();
	}
	public function getNoFppp($value = '')
	{
		$year = date('Y');
		$month = date('m');
		$this->db->where('DATE_FORMAT(created,"%Y")', $year);
		$this->db->where('DATE_FORMAT(created,"%m")', $month);
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$hasil = $this->db->get('data_fppp');
		if ($hasil->num_rows() > 0) {

			$string = $hasil->row()->no_fppp;
			$arr = explode("/", $string, 2);
			$first = $arr[0];
			$no = $first + 1;
			return $no;
		} else {
			return '1';
		}
	}

	public function updateDetail($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('data_fppp_detail', $data);
	}

	// public function getdata($store = '', $bulan = '', $tahun = '')
	// {
	// 	$this->db->join('master_brand mb', 'mb.id = di.id_brand', 'left');
	// 	$this->db->join('master_status ms', 'ms.id = di.id_status', 'left');
	// 	$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
	// 	if ($store != 'x') {
	// 		$this->db->where('di.id_store', $store);
	// 	}

	// 	if ($bulan != 'x') {
	// 		$this->db->where('MONTH(di.date)', $bulan);
	// 	}

	// 	$this->db->where('YEAR(di.date)', $tahun);
	// 	$this->db->select('di.*,mb.brand,ms.status,mst.store,mst.zona');
	// 	$this->db->order_by('di.id', 'desc');
	// 	return $this->db->get('data_fppp di');
	// }

	// public function getTotalOrder($store = '', $bulan = '', $tahun = '')
	// {
	// 	$this->db->join('data_fppp_detail did', 'did.id_fppp = di.id', 'left');
	// 	if ($store != 'x') {
	// 		$this->db->where('di.id_store', $store);
	// 	}

	// 	if ($bulan != 'x') {
	// 		$this->db->where('MONTH(di.date)', $bulan);
	// 	}

	// 	$this->db->where('MONTH(di.date)', $bulan);
	// 	$this->db->where('YEAR(di.date)', $tahun);
	// 	$this->db->select('sum(did.qty) as total');
	// 	$this->db->order_by('di.id', 'desc');
	// 	return $this->db->get('data_fppp di')->row()->total;
	// }

	// public function cekNofppp($value = '')
	// {
	// 	$this->db->where('no_fppp', $value);
	// 	$hasil = $this->db->get('data_fppp');
	// 	if ($hasil->num_rows() > 0) {
	// 		return 'n';
	// 	} else {
	// 		return 'y';
	// 	}
	// }



	// public function getEdit($value = '')
	// {
	// 	$this->db->join('master_brand mb', 'mb.id = di.id_brand', 'left');
	// 	$this->db->join('master_status ms', 'ms.id = di.id_status', 'left');
	// 	$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
	// 	$this->db->select('di.*,mb.brand,ms.status,mst.store,mst.zona');
	// 	$this->db->where('di.id', $value);
	// 	return $this->db->get('data_fppp di');
	// }

	// public function getfppp($value = '')
	// {
	// 	$year = date('Y');
	// 	$month = date('m');
	// 	$this->db->where('DATE_FORMAT(date,"%Y")', $year);
	// 	$this->db->where('DATE_FORMAT(date,"%m")', $month);
	// 	$this->db->order_by('no_fppp', 'desc');
	// 	$this->db->limit(1);
	// 	$hasil = $this->db->get('data_fppp');
	// 	if ($hasil->num_rows() > 0) {

	// 		$string = $hasil->row()->no_fppp;
	// 		$arr = explode("/", $string, 2);
	// 		$first = $arr[0];
	// 		$no = $first + 1;
	// 		return $no;
	// 	} else {
	// 		return '1';
	// 	}
	// }



	// public function updatefppp($id = '', $value = '')
	// {
	// 	$this->db->where('id', $id);
	// 	$this->db->update('data_fppp', $value);
	// }

	// public function insertfpppDetail($value = '')
	// {
	// 	if ($value['harga'] < 1) {
	// 		$value['harga'] = 0;
	// 	}
	// 	$this->db->insert('data_fppp_detail', $value);
	// }

	// public function deleteDetailItem($value = '')
	// {
	// 	$this->db->where('id', $value);
	// 	$this->db->delete('data_fppp_detail');
	// }

	// public function getRowDetailStore($value = '')
	// {
	// 	$this->db->where('id', $value);
	// 	return $this->db->get('master_store')->row();
	// }

	// public function getRowDetailItem($value = '')
	// {
	// 	$this->db->where('mi.id', $value);
	// 	$this->db->join('master_jenis_barang mjb', 'mjb.id = mi.id_jenis_barang', 'left');
	// 	$this->db->select('mi.*,mjb.jenis_barang');
	// 	return $this->db->get('master_item mi')->row();
	// }

	// public function getWarnaItem($id = '')
	// {
	// 	$this->db->join('master_warna mw', 'mw.id = mi.id_warna', 'left');
	// 	$this->db->select('mw.*');
	// 	$this->db->where('mi.id', $id);
	// 	return $this->db->get('master_item mi')->result();
	// }



	// public function getDataDetailTabelProduksi($value = '')
	// {
	// 	$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
	// 	$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
	// 	$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
	// 	$this->db->join('data_produksi dp', 'dp.id_fppp_detail = did.id', 'left');
	// 	$this->db->where('did.id_fppp', $value);
	// 	$this->db->group_by('did.id');
	// 	$this->db->select('mp.item,did.lebar,did.tinggi,mp.gambar,mw.warna,mt.tipe,did.id,did.qty,sum(dp.qty) as qtyProduksi');
	// 	return $this->db->get('data_fppp_detail did')->result();
	// }

	// public function getDataDetailItemProduksi($value = '')
	// {
	// 	$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
	// 	$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
	// 	$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
	// 	$this->db->join('data_produksi dp', 'dp.id_fppp_detail = did.id', 'left');
	// 	$this->db->join('data_fppp di', 'di.id = did.id_fppp', 'left');
	// 	$this->db->where('did.id', $value);
	// 	$this->db->group_by('did.id');
	// 	$this->db->select('di.no_fppp,did.id_fppp,mp.item,did.lebar,did.tinggi,mw.warna,mt.tipe,did.id,did.qty,sum(dp.qty) as qtyProduksi');
	// 	return $this->db->get('data_fppp_detail did')->row();
	// }

	// public function saveDetailProduksi($object = '')
	// {
	// 	$this->db->insert('data_produksi', $object);
	// }

	// public function getJumDetail($value = '')
	// {
	// 	$this->db->where('id_fppp', $value);
	// 	$hasil = $this->db->get('data_fppp_detail');
	// 	if ($hasil->num_rows() > 0) {
	// 		return '1';
	// 	} else {
	// 		return '0';
	// 	}
	// }

	// public function getItemTotalfppp($value = '')
	// {
	// 	// $this->db->where('id_fppp', $value);
	// 	// $this->db->select('sum(qty) as tot');
	// 	// return $this->db->get('data_fppp_detail')->row()->tot;
	// 	$res = $this->db->get('data_fppp_detail did');
	// 	$data = array();
	// 	$nilai = 0;
	// 	foreach ($res->result() as $key) {
	// 		if (isset($data[$key->id_fppp])) {
	// 			$nilai = $data[$key->id_fppp];
	// 		} else {
	// 			$nilai = 0;
	// 		}
	// 		$data[$key->id_fppp] = $key->qty + $nilai;
	// 	}
	// 	return $data;
	// }

	// public function cekSO($po = "")
	// {
	// 	$this->db->where('no_po', $po);
	// 	return $this->db->get('data_fppp')->num_rows();
	// }

	// public function getItemTotalTerkirim($value = '')
	// {
	// 	// $this->db->where('id_fppp', $value);
	// 	// $this->db->select('sum(qty_out) as tot');
	// 	// return $this->db->get('data_stok_detail')->row()->tot;
	// 	$res = $this->db->get('data_stok_detail did');
	// 	$data = array();
	// 	$nilai = 0;
	// 	foreach ($res->result() as $key) {
	// 		if (isset($data[$key->id_fppp])) {
	// 			$nilai = $data[$key->id_fppp];
	// 		} else {
	// 			$nilai = 0;
	// 		}
	// 		$data[$key->id_fppp] = $key->qty_out + $nilai;
	// 	}
	// 	return $data;
	// }

	// public function getTotOrder($value = '')
	// {
	// 	$this->db->where('id_fppp', $value);
	// 	$this->db->select('sum(qty) as jml');
	// 	return $this->db->get('data_fppp_detail')->row()->jml;
	// }

	// public function getTotProduksi($value = '')
	// {
	// 	$this->db->where('id_fppp', $value);
	// 	$this->db->select('sum(qty) as jml');
	// 	$hasil = $this->db->get('data_produksi');
	// 	// if ($hasil->num_rows()>0) {
	// 	return $hasil->row()->jml;
	// 	// } else {
	// 	//     return '0';
	// 	// }
	// }

	// public function getRowKategoriLokasi($store)
	// {
	// 	$this->db->where('id', $store);
	// 	return $this->db->get('master_store')->row()->id_kategori_lokasi;
	// }

	// public function getMappingHarga($item, $warna, $lokasi)
	// {
	// 	$this->db->where('id_item', $item);
	// 	$this->db->where('id_warna', $warna);

	// 	$hasil = $this->db->get('data_mapping');
	// 	if ($hasil->num_rows() > 0) {
	// 		if ($lokasi == 1) {
	// 			return $hasil->row()->harga_jabotabek;
	// 		} elseif ($lokasi == 2) {
	// 			return $hasil->row()->harga_dalam_pulau;
	// 		} else {
	// 			return $hasil->row()->harga_luar_pulau;
	// 		}
	// 	} else {
	// 		return '0';
	// 	}
	// }

	// public function getHeaderCetak($value = '')
	// {
	// 	$this->db->join('master_brand mb', 'mb.id = di.id_brand', 'left');
	// 	$this->db->join('master_status ms', 'ms.id = di.id_status', 'left');
	// 	$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
	// 	$this->db->select('di.*,mb.brand,ms.status,mst.store,mst.zona,di.alamat_proyek as alamat,mst.no_telp');
	// 	$this->db->where('di.id', $value);
	// 	return $this->db->get('data_fppp di')->row();
	// }
	// public function template_email($id_fppp, $store)
	// {
	// 	$html = '<!DOCTYPE html>
	// 	<html style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
	// 	<head>
	// 	<meta name="viewport" content="width=device-width" />
	// 	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	// 	<title>Actionable emails e.g. reset password</title>


	// 	<style type="text/css">
	// 	img {
	// 	max-width: 100%;
	// 	}
	// 	body {
	// 	-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
	// 	}
	// 	body {
	// 	background-color: #f6f6f6;
	// 	}
	// 	@media only screen and (max-width: 640px) {
	// 	  body {
	// 		padding: 0 !important;
	// 	  }
	// 	  h1 {
	// 		font-weight: 800 !important; margin: 20px 0 5px !important;
	// 	  }
	// 	  h2 {
	// 		font-weight: 800 !important; margin: 20px 0 5px !important;
	// 	  }
	// 	  h3 {
	// 		font-weight: 800 !important; margin: 20px 0 5px !important;
	// 	  }
	// 	  h4 {
	// 		font-weight: 800 !important; margin: 20px 0 5px !important;
	// 	  }
	// 	  h1 {
	// 		font-size: 22px !important;
	// 	  }
	// 	  h2 {
	// 		font-size: 18px !important;
	// 	  }
	// 	  h3 {
	// 		font-size: 16px !important;
	// 	  }
	// 	  .container {
	// 		padding: 0 !important; width: 100% !important;
	// 	  }
	// 	  .content {
	// 		padding: 0 !important;
	// 	  }
	// 	  .content-wrap {
	// 		padding: 10px !important;
	// 	  }
	// 	  .fppp {
	// 		width: 100% !important;
	// 	  }
	// 	}
	// 	</style>
	// 	</head>

	// 	<body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

	// 	<table class="body-wrap" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
	// 		<td class="container" width="600" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
	// 		  <div class="content" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
	// 			<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
	// 				  <meta itemprop="name" content="Confirm Email" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" /><table width="100%" cellpadding="0" cellspacing="0" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
	// 				  <td class="content-block" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
	// 				  		Dear Bapak/Ibu
	// 					  </td>
	// 					</tr><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
	// 					Berikut ini terlampir Permintaan Pengiriman ' . $id_fppp . ' ' . $store . '
	// 					  </td>
	// 					</tr><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
	// 						--Jeni
	// 					  </td>
	// 					</tr></table></td>
	// 			  </tr></table><div class="footer" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">

	// 				</tr></table></div></div>
	// 		</td>
	// 		<td style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
	// 	  </tr></table></body>
	// 	</html>';
	// 	// $html='diberitahukan untuk manajer bahwa ada form permintaan baru  dari '.$pembeli.'silahkan cek lampiran untuk melihat detail isian';
	// 	return $html;
	// }

	// public function cancelOrder($value = '')
	// {
	// 	$object = array('id_status' => 3,);
	// 	$this->db->where('id', $value);
	// 	$this->db->update('data_fppp', $object);
	// }

	// public function getDetailfppp($value = '')
	// {
	// 	$this->db->where('id', $value);
	// 	return $this->db->get('data_fppp_detail')->row();
	// }

	// public function updatefpppDetail($data = '', $id = '')
	// {
	// 	$this->db->where('id', $id);
	// 	$this->db->update('data_fppp_detail', $data);
	// }
}

/* End of file m_fppp.php */
/* Location: ./application/models/klg/m_fppp.php */