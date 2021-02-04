<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_summary extends CI_Model
{

	public function getData($value = '')
	{
		$this->db->join('master_item mi', 'mi.id = dsd.id_item', 'left');
		$this->db->join('master_jenis_barang mjb', 'mjb.id = mi.id_jenis_barang', 'left');
		$this->db->join('master_warna mw', 'mw.id = dsd.id_warna', 'left');
		$this->db->where('dsd.inout', 1);
		$this->db->where('dsd.id_tipe', 1);
		$this->db->where('dsd.status_so', 1);
		$this->db->group_by('dsd.id_item,dsd.id_warna,dsd.bukaan,dsd.lebar,dsd.tinggi');
		$this->db->select('dsd.*,mi.item,mw.warna,mi.safety_stok,mjb.jenis_barang,sum(dsd.qty) as total');
		$this->db->order_by('mi.item', 'asc');
		return $this->db->get('data_stok_detail dsd');
	}
	public function getDatabelumso($value = '')
	{
		$this->db->join('master_item mi', 'mi.id = dsd.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = dsd.id_warna', 'left');
		$this->db->where('dsd.inout', 1);
		$this->db->where('dsd.so', 0);
		$this->db->where('dsd.id_tipe', 1);
		$this->db->where('dsd.status_so', 1);
		$this->db->group_by('dsd.id_item,dsd.id_warna,dsd.bukaan,dsd.lebar,dsd.tinggi');
		$this->db->select('dsd.*,mi.item,mw.warna,mi.safety_stok,sum(dsd.qty) as total');
		$this->db->order_by('mi.item', 'asc');
		return $this->db->get('data_stok_detail dsd');
	}
	function summary_all_permintaan()
	{
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->where('di.id_status', 1);
		$res = $this->db->get('data_invoice_detail did');
		$data = array();
		$nilai = 0;
		foreach ($res->result() as $key) {
			if (isset($data[$key->id_item][$key->id_tipe][$key->id_warna][$key->bukaan])) {
				$nilai = $data[$key->id_item][$key->id_tipe][$key->id_warna][$key->bukaan];
			} else {
				$nilai = 0;
			}
			$data[$key->id_item][$key->id_tipe][$key->id_warna][$key->bukaan] = $key->qty + $nilai;
		}
		return $data;
	}

	public function getPermintaan($item = '', $warna = '', $bukaan = '')
	{
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', $bukaan);
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->where('di.id_status', 1);
		$this->db->select('sum(did.qty) as qty');
		$this->db->where('did.id_tipe', 1);
		$hasil = $this->db->get('data_invoice_detail did')->row()->qty;
		if ($hasil != '') {
			return $hasil;
		} else {
			return '0';
		}
	}

	public function real_stok($item = '', $warna = '', $bukaan = '')
	{
		$this->db->where('id_tipe', 1);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty) as masuk');
		$hasil = $this->db->get('data_stok_detail');
		$masuk = $hasil->row()->masuk;

		$this->db->where('id_tipe', 1);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty_out) as keluar');
		$hasilq = $this->db->get('data_stok_detail');
		$keluar = $hasilq->row()->keluar;

		$sisa = $masuk - $keluar;
		return $sisa;
	}
	public function real_stok_row()
	{

		$this->db->where('status_so', 1);
		$this->db->select('*');
		$res = $this->db->get('data_stok_detail');

		$nilai = 0;
		foreach ($res->result() as $key) {
			if (isset($data[$key->id_item][$key->id_tipe][$key->id_warna][$key->bukaan])) {
				$nilai = $data[$key->id_item][$key->id_tipe][$key->id_warna][$key->bukaan];
			} else {
				$nilai = 0;
			}
			$data[$key->id_item][$key->id_tipe][$key->id_warna][$key->bukaan] = $nilai + $key->qty;
			$data[$key->id_item][$key->id_tipe][$key->id_warna][$key->bukaan] = $data[$key->id_item][$key->id_tipe][$key->id_warna][$key->bukaan] - $key->qty_out;
		}
		return $data;
	}

	public function getDataFilter($jenis_barang = '', $item = '', $warna = '', $bukaan = '')
	{
		if ($jenis_barang != 'x') {
			$this->db->where('mi.id_jenis_barang', $jenis_barang);
		}
		if ($item != 'x') {
			$this->db->where('dsd.id_item', $item);
		}
		if ($warna != 'x') {
			$this->db->where('dsd.id_warna', $warna);
		}
		if ($bukaan != 'x') {
			$this->db->where('dsd.bukaan', $bukaan);
		}
		$this->db->join('master_item mi', 'mi.id = dsd.id_item', 'left');
		$this->db->join('master_jenis_barang mjb', 'mjb.id = mi.id_jenis_barang', 'left');
		$this->db->join('master_warna mw', 'mw.id = dsd.id_warna', 'left');
		$this->db->where('dsd.inout', 1);
		$this->db->where('dsd.id_tipe', 1);
		$this->db->where('dsd.status_so', 1);
		$this->db->group_by('dsd.id_item,dsd.id_warna,dsd.bukaan,dsd.lebar,dsd.tinggi');
		$this->db->select('dsd.*,mi.item,mw.warna,mi.safety_stok,mjb.jenis_barang,sum(dsd.qty) as total');
		$this->db->order_by('mi.item', 'asc');
		return $this->db->get('data_stok_detail dsd');
	}

	public function getQtyKirim($item = '', $warna = '', $bukaan = '')
	{
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('id_tipe', 1);
		$this->db->where('inout', 2);
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty_out) as qty');
		$hasil = $this->db->get('data_stok_detail');
		return $hasil->row()->qty;
	}

	public function getTabelDetail($item = '', $warna = '', $bukaan = '')
	{
		$this->db->join('master_item mp', 'mp.id = dsd.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = dsd.id_warna', 'left');
		$this->db->where('dsd.id_item', $item);
		$this->db->where('dsd.id_warna', $warna);
		$this->db->where('dsd.bukaan', $bukaan);
		$this->db->where('dsd.id_tipe', 1);
		$this->db->where('dsd.status_so', 1);
		$this->db->order_by('dsd.id', 'desc');
		$this->db->select('dsd.*,mp.item,mw.warna');
		return $this->db->get('data_stok_detail dsd');
	}

	public function getSisaStok($id = '', $item = '', $warna = '', $bukaan = '')
	{
		$this->db->where('id <=', $id);
		$this->db->where('id_tipe', 1);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty) as masuk');
		$hasil = $this->db->get('data_stok_detail');
		$masuk = $hasil->row()->masuk;

		$this->db->where('id <=', $id);
		$this->db->where('id_tipe', 1);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty_out) as keluar');
		$hasilq = $this->db->get('data_stok_detail');
		$keluar = $hasilq->row()->keluar;


		$sisa = $masuk - $keluar;
		return $sisa;
	}

	public function getDataPivot($value = '')
	{
		$this->db->join('master_jenis_barang mjb', 'mjb.id = mi.id_jenis_barang', 'left');
		$this->db->order_by('mi.item', 'asc');
		$this->db->select('mi.*,mjb.jenis_barang');
		return $this->db->get('master_item mi');
	}

	public function getWarnaPivot($id = '')
	{
		if ($id == 1) {
			$this->db->where('id <', 8);
		} else {
			$this->db->where('id >', 7);
		}

		$this->db->order_by('warna', 'asc');
		return $this->db->get('master_warna');
	}

	public function getrowJum($item = '', $warna = '', $bukaan = '')
	{
		$this->db->where('id_tipe', 1);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty) as masuk');
		$hasil = $this->db->get('data_stok_detail');
		$masuk = $hasil->row()->masuk;

		$this->db->where('id_tipe', 1);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty_out) as keluar');
		$hasilq = $this->db->get('data_stok_detail');
		$keluar = $hasilq->row()->keluar;

		$sisa = $masuk - $keluar;
		return $sisa;
	}

	public function getrowJumR($item = '', $warna)
	{
		$this->db->where('id_tipe', 1);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', 'R');
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty) as masuk');
		$hasil = $this->db->get('data_stok_detail');
		$masuk = $hasil->row()->masuk;

		$this->db->where('id_tipe', 1);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', 'R');
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty_out) as keluar');
		$hasilq = $this->db->get('data_stok_detail');
		$keluar = $hasilq->row()->keluar;

		$sisa = $masuk - $keluar;
		return $sisa;
	}
	public function getrowJumL($item = '', $warna)
	{
		$this->db->where('id_tipe', 1);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', 'L');
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty) as masuk');
		$hasil = $this->db->get('data_stok_detail');
		$masuk = $hasil->row()->masuk;

		$this->db->where('id_tipe', 1);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', 'L');
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty_out) as keluar');
		$hasilq = $this->db->get('data_stok_detail');
		$keluar = $hasilq->row()->keluar;

		$sisa = $masuk - $keluar;
		return $sisa;
	}
	public function getrowJumN($item = '', $warna)
	{
		$this->db->where('id_tipe', 1);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', '-');
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty) as masuk');
		$hasil = $this->db->get('data_stok_detail');
		$masuk = $hasil->row()->masuk;

		$this->db->where('id_tipe', 1);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', '-');
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty_out) as keluar');
		$hasilq = $this->db->get('data_stok_detail');
		$keluar = $hasilq->row()->keluar;

		$sisa = $masuk - $keluar;
		return $sisa;
	}

	public function getrowJumOTS($item = '', $warna = '', $bukaan = '')
	{
		$this->db->join('data_invoice_detail did', 'did.id_invoice = di.id', 'left');
		$this->db->where('di.id_status', 1);
		$this->db->where('did.id_tipe', 1);
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', $bukaan);
		$this->db->select('sum(did.qty) as permintaan');
		$permintaan = $this->db->get('data_invoice di')->row()->permintaan;

		$this->db->join('data_stok_detail dsd', 'dsd.id_invoice = di.id', 'left');
		$this->db->where('di.id_status', 1);
		$this->db->where('dsd.id_tipe', 1);
		$this->db->where('dsd.id_item', $item);
		$this->db->where('dsd.id_warna', $warna);
		$this->db->where('dsd.bukaan', $bukaan);
		$this->db->select('sum(dsd.qty_out) as keluar');
		$keluar = $this->db->get('data_invoice di')->row()->keluar;

		$sisa = $permintaan - $keluar;
		return $sisa;
	}

	public function getrowJumROTS($item = '', $warna)
	{
		$this->db->join('data_invoice_detail did', 'did.id_invoice = di.id', 'left');
		$this->db->where('di.id_status', 1);
		$this->db->where('did.id_tipe', 1);
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', 'R');
		$this->db->select('sum(did.qty) as permintaan');
		$permintaan = $this->db->get('data_invoice di')->row()->permintaan;

		$this->db->join('data_stok_detail dsd', 'dsd.id_invoice = di.id', 'left');
		$this->db->where('di.id_status', 1);
		$this->db->where('dsd.id_tipe', 1);
		$this->db->where('dsd.id_item', $item);
		$this->db->where('dsd.id_warna', $warna);
		$this->db->where('dsd.bukaan', 'R');
		$this->db->select('sum(dsd.qty_out) as keluar');
		$keluar = $this->db->get('data_invoice di')->row()->keluar;

		$sisa = $permintaan - $keluar;
		return $sisa;
	}
	public function getrowJumLOTS($item = '', $warna)
	{
		$this->db->join('data_invoice_detail did', 'did.id_invoice = di.id', 'left');
		$this->db->where('di.id_status', 1);
		$this->db->where('did.id_tipe', 1);
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', 'L');
		$this->db->select('sum(did.qty) as permintaan');
		$permintaan = $this->db->get('data_invoice di')->row()->permintaan;

		$this->db->join('data_stok_detail dsd', 'dsd.id_invoice = di.id', 'left');
		$this->db->where('di.id_status', 1);
		$this->db->where('dsd.id_tipe', 1);
		$this->db->where('dsd.id_item', $item);
		$this->db->where('dsd.id_warna', $warna);
		$this->db->where('dsd.bukaan', 'L');
		$this->db->select('sum(dsd.qty_out) as keluar');
		$keluar = $this->db->get('data_invoice di')->row()->keluar;

		// $this->db->where('id_tipe', 1);
		// $this->db->where('id_item', $item);
		// $this->db->where('id_warna', $warna);
		// $this->db->where('bukaan', 'L');
		// $this->db->where('status_so', 1);
		// $this->db->select('sum(qty_out) as keluar');
		// $hasil = $this->db->get('data_stok_detail');
		// $keluar = $hasil->row()->keluar;

		$sisa = $permintaan - $keluar;
		return $sisa;
	}
	public function getrowJumNOTS($item = '', $warna)
	{
		$this->db->join('data_invoice_detail did', 'did.id_invoice = di.id', 'left');
		$this->db->where('di.id_status', 1);
		$this->db->where('did.id_tipe', 1);
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', '-');
		$this->db->select('sum(did.qty) as permintaan');
		$permintaan = $this->db->get('data_invoice di')->row()->permintaan;

		$this->db->join('data_stok_detail dsd', 'dsd.id_invoice = di.id', 'left');
		$this->db->where('di.id_status', 1);
		$this->db->where('dsd.id_tipe', 1);
		$this->db->where('dsd.id_item', $item);
		$this->db->where('dsd.id_warna', $warna);
		$this->db->where('dsd.bukaan', '-');
		$this->db->select('sum(dsd.qty_out) as keluar');
		$keluar = $this->db->get('data_invoice di')->row()->keluar;

		$sisa = $permintaan - $keluar;
		return $sisa;
	}

	public function getNomorSO()
	{
		$this->db->select('*');
		$this->db->from('data_stockopname');
		$this->db->limit(1);
		$this->db->order_by('no_so', 'desc');
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$string = $hasil->row()->no_so;
			$arr = explode("/", $string, 2);
			$first = $arr[0];
			$no = $first + 1;
			return $no;
		} else {
			return '1';
		}
	}
	public function get_aktifso()
	{
		$this->db->where('finish', 0);
		$hasil = $this->db->get('data_stockopname');
		return $hasil;
	}
	public function savecekpointso($datapost)
	{
		$this->db->insert('data_stockopname', $datapost);
	}
	public function get_nama_item($id)
	{
		$this->db->select('*');
		$this->db->from('master_item');
		$this->db->where('id', $id);
		return $this->db->get()->row()->item;
	}
	public function get_nama_warna($id)
	{
		$this->db->select('*');
		$this->db->from('master_warna');
		$this->db->where('id', $id);
		return $this->db->get()->row()->warna;
	}
	public function insertDataSO($datapost)
	{
		$upd['so'] = $datapost['id_stockopname'];
		$stokasli = $datapost['realstock'];
		// if ($stokasli!=0) {

		# code...
		$upd['status_so'] = 2;
		$this->db->where('id_item', $datapost['item']);
		$this->db->where('id_warna', $datapost['warna']);
		$this->db->where('bukaan', $datapost['bukaan']);
		$this->db->where('lebar', $datapost['lebar']);
		$this->db->where('tinggi', $datapost['tinggi']);
		$this->db->where('id_tipe', 1);
		$this->db->update('data_stok_detail', $upd);
		sleep(1);
		$this->db->insert('data_stokopname_detail', $datapost);

		$dtx = array(
			'id_tipe'  => 1,
			'id_item'  => $datapost['item'],
			'id_warna' => $datapost['warna'],
			'bukaan'   => $datapost['bukaan'],
			'lebar'    => $datapost['lebar'],
			'tinggi'   => $datapost['tinggi'],
			'qty'      => $datapost['realstock'],
			'inout'    => 1,
		);
		$this->db->insert('data_stok_detail', $dtx);


		// }
	}
	public function akhiriSO($id_so)
	{
		$object['finish'] = 1;
		$this->db->where('id', $id_so);
		$this->db->update('data_stockopname', $object);
	}
}

/* End of file m_summary.php */
/* Location: ./application/models/klg/m_summary.php */