<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_monitoring extends CI_Model {

	public function getDataCommon($value='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_jenis_barang mjb', 'mjb.id = mp.id_jenis_barang', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->join('master_status_detail msd', 'msd.id = did.id_status_detail', 'left');
		$this->db->select('did.*,msd.status_detail,mst.store,mst.zona,di.date as tgl_permintaan,di.tgl_pengiriman,di.no_invoice,di.no_po,mp.item,mw.warna,mp.safety_stok,mjb.jenis_barang');
		$this->db->where('did.id_tipe', 1);
		$this->db->where('di.id_status', 1);
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_invoice_detail did');
	}

	function get_sudah_kirim()
	{
		$this->db->where('inout', 2);
		$res=$this->db->get('data_stok_detail');
		$data=array();
		$nilai=0;
		foreach ($res->result() as $key) {
			if(isset($data[$key->id_invoice][$key->id_tipe][$key->id_item][$key->id_warna][$key->bukaan][$key->lebar][$key->tinggi])){
				$nilai=$data[$key->id_invoice][$key->id_tipe][$key->id_item][$key->id_warna][$key->bukaan][$key->lebar][$key->tinggi];
			}else{
				$nilai=0;
			}
			$data[$key->id_invoice][$key->id_tipe][$key->id_item][$key->id_warna][$key->bukaan][$key->lebar][$key->tinggi]=$key->qty_out+$nilai;
		}
		return $data;
	}

	function get_stock_ready()
	{
		$this->db->where('status_so', 1);
		$res=$this->db->get('data_stok_detail');
		$data=array();
		$nilai=0;
		foreach ($res->result() as $key) {
			if(isset($data[$key->id_tipe][$key->id_item][$key->id_warna][$key->bukaan][$key->lebar][$key->tinggi])){
				$nilai=$data[$key->id_tipe][$key->id_item][$key->id_warna][$key->bukaan][$key->lebar][$key->tinggi];
			}else{
				$nilai=0;
			}
			$data[$key->id_tipe][$key->id_item][$key->id_warna][$key->bukaan][$key->lebar][$key->tinggi]=$key->qty+$nilai;
			$data[$key->id_tipe][$key->id_item][$key->id_warna][$key->bukaan][$key->lebar][$key->tinggi]=$data[$key->id_tipe][$key->id_item][$key->id_warna][$key->bukaan][$key->lebar][$key->tinggi]-$key->qty_out;
		}
		return $data;
	}

	public function getDataCommonFilter($tgl='',$store='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_jenis_barang mjb', 'mjb.id = mp.id_jenis_barang', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->join('master_status_detail msd', 'msd.id = did.id_status_detail', 'left');
		$this->db->select('did.*,msd.status_detail,mst.store,mst.zona,di.date as tgl_permintaan,di.tgl_pengiriman,di.no_invoice,di.no_po,mp.item,mw.warna,mp.safety_stok,mjb.jenis_barang');
		$this->db->where('did.id_tipe', 1);
		$this->db->where('di.id_status', 1);
		if ($tgl !='x') {
			$this->db->where('DATE(di.tgl_pengiriman)', $tgl);
		}
		if ($store !='x') {
			$this->db->where('di.id_store', $store);
		}
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_invoice_detail did');
	}

	public function sudahkirim($id_invoice='',$tipe='',$item='',$warna='',$bukaan='',$lebar='',$tinggi='')
	{
		$this->db->where('id_invoice', $id_invoice);
		$this->db->where('id_item', $item);
		$this->db->where('id_tipe', $tipe);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('lebar', $lebar);
		$this->db->where('tinggi', $tinggi);
		$this->db->where('inout', 2);

		$this->db->select('sum(qty_out) as qty');
		$hasil = $this->db->get('data_stok_detail')->row()->qty;
		if ($hasil !='') {
			return $hasil;
		} else {
			return '0';
		}

	}

	public function stokready($tipe='',$item='',$warna='',$bukaan='',$lebar='',$tinggi='')
	{
		$this->db->where('id_tipe', $tipe);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('lebar', $lebar);
		$this->db->where('tinggi', $tinggi);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty) as masuk');
		$hasil = $this->db->get('data_stok_detail');
		$masuk = $hasil->row()->masuk;

		$this->db->where('id_tipe', $tipe);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('lebar', $lebar);
		$this->db->where('tinggi', $tinggi);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty_out) as keluar');
		$hasilq = $this->db->get('data_stok_detail');
		$keluar = $hasilq->row()->keluar;
		
		$sisa = $masuk - $keluar;
		return $sisa;

	}

	public function getDataCustomFilter($tgl='',$store='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_jenis_barang mjb', 'mjb.id = mp.id_jenis_barang', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->join('master_status_detail msd', 'msd.id = did.id_status_detail', 'left');
		$this->db->select('did.*,msd.status_detail,mst.store,mst.zona,di.date as tgl_permintaan,di.tgl_pengiriman,di.no_invoice,di.no_po,mp.item,mw.warna,mp.safety_stok,mjb.jenis_barang');
		$this->db->where('did.id_tipe', 2);
		$this->db->where('di.id_status', 1);
		if ($tgl !='x') {
			$this->db->where('DATE(di.tgl_pengiriman)', $tgl);
		}
		if ($store !='x') {
			$this->db->where('di.id_store', $store);
		}
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_invoice_detail did');
	}

	public function getDataCustom($value='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_jenis_barang mjb', 'mjb.id = mp.id_jenis_barang', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->join('master_status_detail msd', 'msd.id = did.id_status_detail', 'left');
		$this->db->select('did.*,msd.status_detail,mst.store,mst.zona,di.date as tgl_permintaan,di.tgl_pengiriman,di.no_invoice,di.no_po,mp.item,mw.warna,mp.safety_stok,mjb.jenis_barang');
		$this->db->where('did.id_tipe', 2);
		$this->db->where('di.id_status', 1);
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_invoice_detail did');
	}

	public function getstokin($tipe='',$item='',$warna='',$bukaan='',$lebar='',$tinggi='')
	{
		$this->db->where('id_item', $item);
		$this->db->where('id_tipe', $tipe);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('lebar', $lebar);
		$this->db->where('tinggi', $tinggi);
		$this->db->where('inout', 1);
		$this->db->where('status_so', 1);

		$this->db->select('sum(qty) as qty');
		$hasil = $this->db->get('data_stok_detail')->row()->qty;
		if ($hasil !='') {
			return $hasil;
		} else {
			return '0';
		}

	}

	public function getstokout($id_invoice='',$tipe='',$item='',$warna='',$bukaan='',$lebar='',$tinggi='')
	{
		$this->db->where('id_item', $item);
		$this->db->where('id_tipe', $tipe);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('lebar', $lebar);
		$this->db->where('tinggi', $tinggi);
		$this->db->where('inout', 2);
		$this->db->where('status_so', 1);

		$this->db->select('sum(qty_out) as qty');
		$hasil = $this->db->get('data_stok_detail')->row()->qty;
		if ($hasil !='') {
			return $hasil;
		} else {
			return '0';
		}

	}

	public function getTanggalCommon($value='')
	{
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->where('did.id_tipe', 1);
		$this->db->where('di.id_status', 1);
		$this->db->select('di.tgl_pengiriman');
		$this->db->group_by('di.tgl_pengiriman');
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_invoice_detail did');
	}

	public function getStoreCommon($value='')
	{
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->where('did.id_tipe', 1);
		$this->db->where('di.id_status', 1);
		$this->db->select('mst.store,di.id_store');
		$this->db->group_by('di.id_store');
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_invoice_detail did');
	}

	public function getTanggalCustom($value='')
	{
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->where('did.id_tipe', 2);
		$this->db->where('di.id_status', 1);
		$this->db->select('di.tgl_pengiriman');
		$this->db->group_by('di.tgl_pengiriman');
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_invoice_detail did');
	}

	public function getStoreCustom($value='')
	{
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->where('did.id_tipe', 2);
		$this->db->where('di.id_status', 1);
		$this->db->select('mst.store,di.id_store');
		$this->db->group_by('di.id_store');
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_invoice_detail did');
	}

	public function getDataPivot($id_tipe='')
	{
		// $this->db->join('master_jenis_barang mjb', 'mjb.id = mi.id_jenis_barang', 'left');
		// $this->db->order_by('mi.item', 'asc');
		// $this->db->select('mi.*,mjb.jenis_barang');
		// return $this->db->get('master_item mi');
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_jenis_barang mjb', 'mjb.id = mp.id_jenis_barang', 'left');
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->select('mp.*,mjb.jenis_barang');
		$this->db->where('did.id_tipe', $id_tipe);
		$this->db->where('di.id_status', 1);
		$this->db->group_by('mp.id');
		$this->db->order_by('did.id_item', 'asc');
		return $this->db->get('data_invoice_detail did');
	}

	public function getWarnaPivot($id='')
	{
		if ($id == 1) {
			$this->db->where('id <', 8);
		} else {
			$this->db->where('id >', 7);
		}
		
		$this->db->order_by('warna', 'asc');
		return $this->db->get('master_warna');
	}

	public function getrowJumR($item='',$warna)
	{
		
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_tipe', '1');
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', 'R');
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->where('di.id_status', 1);
		$this->db->select('sum(qty) as qty');
		$per = $this->db->get('data_invoice_detail did')->row()->qty;
		if ($per !='') {
			$permintaan = $per;
		} else {
			$permintaan = 0;
		}

		$this->db->where('dsd.id_item', $item);
		$this->db->where('dsd.id_tipe', '1');
		$this->db->where('dsd.id_warna', $warna);
		$this->db->where('dsd.bukaan', 'R');
		$this->db->where('dsd.inout', '2');

		$this->db->select('sum(qty_out) as qty');
		$this->db->join('data_invoice diq', 'diq.id = dsd.id_invoice', 'left');
		$this->db->where('diq.id_status', 1);
		// $this->db->where('dsd.status_so', 1);

		$kel = $this->db->get('data_stok_detail dsd')->row()->qty;
		if ($kel !='') {
			$keluar = $kel;
		} else {
			$keluar = 0;
		}
		
		return $permintaan-$keluar;
		
	}
	public function getrowJumL($item='',$warna)
	{
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_tipe', '1');
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', 'L');
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->where('di.id_status', 1);
		$this->db->select('sum(qty) as qty');
		$per = $this->db->get('data_invoice_detail did')->row()->qty;
		if ($per !='') {
			$permintaan = $per;
		} else {
			$permintaan = 0;
		}

		$this->db->where('dsd.id_item', $item);
		$this->db->where('dsd.id_tipe', '1');
		$this->db->where('dsd.id_warna', $warna);
		$this->db->where('dsd.bukaan', 'L');
		$this->db->where('dsd.inout', '2');

		$this->db->select('sum(qty_out) as qty');
		$this->db->join('data_invoice diq', 'diq.id = dsd.id_invoice', 'left');
		$this->db->where('diq.id_status', 1);
		// $this->db->where('dsd.status_so', 1);
		$kel = $this->db->get('data_stok_detail dsd')->row()->qty;
		if ($kel !='') {
			$keluar = $kel;
		} else {
			$keluar = 0;
		}
		
		return $permintaan-$keluar;
	}
	public function getrowJumN($item='',$warna)
	{
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_tipe', '1');
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', '-');
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->where('di.id_status', 1);
		$this->db->select('sum(qty) as qty');
		$per = $this->db->get('data_invoice_detail did')->row()->qty;
		if ($per !='') {
			$permintaan = $per;
		} else {
			$permintaan = 0;
		}

		$this->db->where('dsd.id_item', $item);
		$this->db->where('dsd.id_tipe', '1');
		$this->db->where('dsd.id_warna', $warna);
		$this->db->where('dsd.bukaan', '-');
		$this->db->where('dsd.inout', '2');

		$this->db->select('sum(qty_out) as qty');
		$this->db->join('data_invoice diq', 'diq.id = dsd.id_invoice', 'left');
		$this->db->where('diq.id_status', 1);
		// $this->db->where('dsd.status_so', 1);
		$kel = $this->db->get('data_stok_detail dsd')->row()->qty;
		if ($kel !='') {
			$keluar = $kel;
		} else {
			$keluar = 0;
		}
		
		return $permintaan-$keluar;
	}

}

/* End of file m_monitoring.php */
/* Location: ./application/models/klg/m_monitoring.php */