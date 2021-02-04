<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Summary extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_summary');
	}

	public function index()
	{
		$this->fungsi->check_previleges('summary');

		$data['summary']    = $this->m_summary->getData();
		$data['jenis_barang'] = $this->db->get('master_jenis_barang');
		$data['item']       = $this->db->get('master_item');
		$data['warna']      = $this->db->get('master_warna');
		$data['bukaan']     = $this->db->get('master_bukaan');
		$data['permintaan'] = $this->m_summary->summary_all_permintaan();
		$data['realstock']  = $this->m_summary->real_stok_row();
		$data['id_item']    = '';
		$data['id_jenis_barang']    = '';
		$data['id_warna']   = '';
		$data['id_bukaan']  = '';
		$this->load->view('klg/summary/v_summary_list', $data);
	}
	public function summary_so()
	{
		$this->fungsi->check_previleges('summary');
		$data['summary']    = $this->m_summary->getData();

		$data['item']       = $this->db->get('master_item');
		$data['warna']      = $this->db->get('master_warna');
		$data['bukaan']     = $this->db->get('master_bukaan');
		$data['permintaan'] = $this->m_summary->summary_all_permintaan();
		$data['realstock']  = $this->m_summary->real_stok_row();
		$data['cek_aktif']  = $this->m_summary->get_aktifso();
		$data['id_item']    = '';
		$data['id_warna']   = '';
		$data['id_bukaan']  = '';
		$this->load->view('klg/summary/v_summary_belumso', $data);
	}
	public function filter($jenis_barang = '', $item = '', $warna = '', $bukaan = '')
	{
		$this->fungsi->check_previleges('summary');
		$data['summary']   = $this->m_summary->getDataFilter($jenis_barang, $item, $warna, $bukaan);
		$data['jenis_barang'] = $this->db->get('master_jenis_barang');
		$data['item']      = $this->db->get('master_item');
		$data['warna']     = $this->db->get('master_warna');
		$data['bukaan']    = $this->db->get('master_bukaan');
		$data['permintaan'] = $this->m_summary->summary_all_permintaan();
		$data['realstock'] = $this->m_summary->real_stok_row();
		$data['id_jenis_barang']    = $jenis_barang;
		$data['id_item']   = $item;
		$data['id_warna']  = $warna;
		$data['id_bukaan'] = $bukaan;
		$this->load->view('klg/summary/v_summary_list', $data);
	}

	public function detail($item = '', $warna = '', $bukaan = '')
	{
		$this->fungsi->check_previleges('summary');
		$data['data'] = $this->m_summary->getTabelDetail($item, $warna, $bukaan);
		$this->load->view('klg/summary/v_summary_detail', $data);
	}

	public function cetak($id)
	{
		$data['item'] = $this->m_summary->getDataPivot();
		$data['warna'] = $this->m_summary->getWarnaPivot($id);
		$this->load->view('klg/summary/v_cetak', $data);
	}
	public function stock_opname()
	{
		$this->fungsi->check_previleges('stockopname');
		$data = array(
			'no_so' => str_pad($this->m_summary->getNomorSO(), 3, '0', STR_PAD_LEFT) . '/stockopname' . '/' . date('m') . '/' . date('Y'),
			'cek_aktif' => $this->m_summary->get_aktifso(),
		);

		$this->load->view('klg/summary/v_stockopname_add.php', $data);
	}
	public function stockopname_detail()
	{
		$this->fungsi->check_previleges('summary');

		$this->load->view('klg/summary/v_stock_opname', $data);
	}
	public function saveso($value = 0)
	{
		$this->fungsi->check_previleges('stockopname');
		$tgl = $this->input->post('tgl');
		$no_so = $this->input->post('no_so');
		$datapost = array(
			'no_so'  => $no_so,
			'tgl'    => $tgl,
		);
		$this->m_summary->savecekpointso($datapost);
		$this->fungsi->catat($datapost, "Menyimpan Stock Opname sbb:", true);
		$data['msg'] = "Stock Opname Disimpan";
		echo json_encode($data);
	}
	public function form($param = '')
	{
		$content   = "<div id='divsubcontent'></div>";
		$header    = "Form Validasi Stok";
		$subheader = "Stock Validasi";
		$buttons[] = button('jQuery.facebox.close()', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
		echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
		if ($param == 'base') {
			$this->fungsi->run_js('load_silent("klg/summary/show_addForm/","#divsubcontent")');
		} else {
			$item = $this->uri->segment(5);
			$warna = $this->uri->segment(6);
			$bukaan = $this->uri->segment(7);
			$lebar = $this->uri->segment(8);
			$tinggi = $this->uri->segment(9);
			$realstok = $this->uri->segment(10);
			$id_so = $this->uri->segment(11);
			// $row->id_item.'/'.$row->id_warna.'/'.$row->bukaan.'/'.$row->lebar.'/'.$row->tinggi.'/'.$realstok
			$this->fungsi->run_js('load_silent("klg/summary/show_addForm/' . $item . '/' . $warna . '/' . $bukaan . '/' . $lebar . '/' . $tinggi . '/' . $realstok . '/' . $id_so . '","#divsubcontent")');
		}
	}
	public function show_addForm()
	{
		$this->fungsi->check_previleges('stockopname');
		$this->load->library('form_validation');
		$config = array(
			array(
				'field'	=> 'realstock',
				'label' => 'Real Stock',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE) {
			$data['item'] = $this->uri->segment(4);
			$data['warna'] = $this->uri->segment(5);
			$data['bukaan'] = $this->uri->segment(6);
			$data['lebar'] = $this->uri->segment(7);
			$data['tinggi'] = $this->uri->segment(8);
			$data['realstok'] = $this->uri->segment(9);
			$data['id_so'] = $this->uri->segment(10);
			$data['nama_item'] = $this->m_summary->get_nama_item($data['item']);
			$data['nama_warna'] = $this->m_summary->get_nama_warna($data['warna']);

			$this->load->view('klg/summary/v_so_add', $data);
		} else {
			$datapost = get_post_data(array('realstock', 'item', 'warna', 'bukaan', 'lebar', 'tinggi', 'id_stockopname'));
			$this->m_summary->insertDataSO($datapost);
			$this->fungsi->run_js('load_silent("klg/summary/summary_so","#form_pembelian")');
			$this->fungsi->message_box("Data SO sukses disimpan...", "success");
			$this->fungsi->catat($datapost, "Menambah SO dengan data sbb:", true);
		}
	}
	function akiriSO($id_so)
	{
		$this->fungsi->check_previleges('stockopname');
		$this->m_summary->akhiriSO($id_so);
		$this->fungsi->run_js('load_silent("klg/summary/stock_opname","#content")');
		$this->fungsi->message_box("Stock Opname Sukses diakhiri...", "success");
		$this->fungsi->catat($datapost, "mengakhiri pencatatan Stock Opname pada " . $id_so, false);
	}

	public function excel($id = '')
	{
		$this->fungsi->check_previleges('summary');
		$this->load->library('excel');
		$this->load->library('drawing');
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('PIVOT SUMMARY');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', 'TABEL PIVOT');
		//merge cell A1 until C1
		$this->excel->getActiveSheet()->mergeCells('A1:BB1');
		//set aligment to center for that merged cell (A1 to C1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

		// $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		for ($col = ord('C'); $col <= ord('BB'); $col++) { //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
			// $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		$this->excel->getActiveSheet()->getStyle('A2:BB2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A3:BB3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('A3', 'No');
		$this->excel->getActiveSheet()->setCellValue('B3', 'Item');

		$this->excel->getActiveSheet()->setCellValue('C2', '-');
		$this->excel->getActiveSheet()->mergeCells('C2:F2');
		$this->excel->getActiveSheet()->setCellValue('C3', 'L');
		$this->excel->getActiveSheet()->setCellValue('D3', 'R');
		$this->excel->getActiveSheet()->setCellValue('E3', '-');
		$this->excel->getActiveSheet()->setCellValue('F3', 'SS');

		$this->excel->getActiveSheet()->setCellValue('G2', 'BIRU');
		$this->excel->getActiveSheet()->mergeCells('G2:J2');
		$this->excel->getActiveSheet()->setCellValue('G3', 'L');
		$this->excel->getActiveSheet()->setCellValue('H3', 'R');
		$this->excel->getActiveSheet()->setCellValue('I3', '-');
		$this->excel->getActiveSheet()->setCellValue('J3', 'SS');

		$this->excel->getActiveSheet()->setCellValue('K2', 'COKELAT (RALL 8017 SG)');
		$this->excel->getActiveSheet()->mergeCells('K2:N2');
		$this->excel->getActiveSheet()->setCellValue('K3', 'L');
		$this->excel->getActiveSheet()->setCellValue('L3', 'R');
		$this->excel->getActiveSheet()->setCellValue('M3', '-');
		$this->excel->getActiveSheet()->setCellValue('N3', 'SS');

		$this->excel->getActiveSheet()->setCellValue('O2', 'HIJAU');
		$this->excel->getActiveSheet()->mergeCells('O2:R2');
		$this->excel->getActiveSheet()->setCellValue('O3', 'L');
		$this->excel->getActiveSheet()->setCellValue('P3', 'R');
		$this->excel->getActiveSheet()->setCellValue('Q3', '-');
		$this->excel->getActiveSheet()->setCellValue('R3', 'SS');


		$this->excel->getActiveSheet()->setCellValue('S2', 'HITAM (SBM)');
		$this->excel->getActiveSheet()->mergeCells('S2:V2');
		$this->excel->getActiveSheet()->setCellValue('S3', 'L');
		$this->excel->getActiveSheet()->setCellValue('T3', 'R');
		$this->excel->getActiveSheet()->setCellValue('U3', '-');
		$this->excel->getActiveSheet()->setCellValue('V3', 'SS');

		$this->excel->getActiveSheet()->setCellValue('W2', 'KAYU (P5)');
		$this->excel->getActiveSheet()->mergeCells('W2:Z2');
		$this->excel->getActiveSheet()->setCellValue('W3', 'L');
		$this->excel->getActiveSheet()->setCellValue('X3', 'R');
		$this->excel->getActiveSheet()->setCellValue('Y3', '-');
		$this->excel->getActiveSheet()->setCellValue('Z3', 'SS');

		$this->excel->getActiveSheet()->setCellValue('AA2', 'KAYU (WE 02)');
		$this->excel->getActiveSheet()->mergeCells('AA2:AD2');
		$this->excel->getActiveSheet()->setCellValue('AA3', 'L');
		$this->excel->getActiveSheet()->setCellValue('AB3', 'R');
		$this->excel->getActiveSheet()->setCellValue('AC3', '-');
		$this->excel->getActiveSheet()->setCellValue('AD3', 'SS');

		$this->excel->getActiveSheet()->setCellValue('AE2', 'MERAH');
		$this->excel->getActiveSheet()->mergeCells('AE2:AH2');
		$this->excel->getActiveSheet()->setCellValue('AE3', 'L');
		$this->excel->getActiveSheet()->setCellValue('AF3', 'R');
		$this->excel->getActiveSheet()->setCellValue('AG3', '-');
		$this->excel->getActiveSheet()->setCellValue('AH3', 'SS');

		$this->excel->getActiveSheet()->setCellValue('AI2', 'PUTIH');
		$this->excel->getActiveSheet()->mergeCells('AI2:AL2');
		$this->excel->getActiveSheet()->setCellValue('AI3', 'L');
		$this->excel->getActiveSheet()->setCellValue('AJ3', 'R');
		$this->excel->getActiveSheet()->setCellValue('AK3', '-');
		$this->excel->getActiveSheet()->setCellValue('AL3', 'SS');

		$this->excel->getActiveSheet()->setCellValue('AM2', 'PUTIH (RALL 9003)');
		$this->excel->getActiveSheet()->mergeCells('AM2:AP2');
		$this->excel->getActiveSheet()->setCellValue('AM3', 'L');
		$this->excel->getActiveSheet()->setCellValue('AN3', 'R');
		$this->excel->getActiveSheet()->setCellValue('AO3', '-');
		$this->excel->getActiveSheet()->setCellValue('AP3', 'SS');

		$this->excel->getActiveSheet()->setCellValue('AQ2', 'SILVER');
		$this->excel->getActiveSheet()->mergeCells('AQ2:AT2');
		$this->excel->getActiveSheet()->setCellValue('AQ3', 'L');
		$this->excel->getActiveSheet()->setCellValue('AR3', 'R');
		$this->excel->getActiveSheet()->setCellValue('AS3', '-');
		$this->excel->getActiveSheet()->setCellValue('AT3', 'SS');

		$this->excel->getActiveSheet()->setCellValue('AU2', 'KOMBINASI');
		$this->excel->getActiveSheet()->mergeCells('AU2:AX2');
		$this->excel->getActiveSheet()->setCellValue('AU3', 'L');
		$this->excel->getActiveSheet()->setCellValue('AV3', 'R');
		$this->excel->getActiveSheet()->setCellValue('AW3', '-');
		$this->excel->getActiveSheet()->setCellValue('AX3', 'SS');

		$this->excel->getActiveSheet()->setCellValue('AY2', 'ANTIQUE BRASS');
		$this->excel->getActiveSheet()->mergeCells('AY2:BB2');
		$this->excel->getActiveSheet()->setCellValue('AY3', 'L');
		$this->excel->getActiveSheet()->setCellValue('AZ3', 'R');
		$this->excel->getActiveSheet()->setCellValue('BA3', '-');
		$this->excel->getActiveSheet()->setCellValue('BB3', 'SS');



		// for($col = ord('A'); $col <= ord('H'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		//          //change the font size
		//         $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

		//         $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		// }
		$item = $this->m_summary->getDataPivot();
		$totrow = $item->num_rows();
		$row = 4;
		$maxrow = $totrow + 3;
		$i = 1;
		foreach ($item->result() as $key) {
			$this->excel->getActiveSheet()->setCellValue('A' . $row, $i)->getColumnDimension('A')->setAutoSize(true);
			$this->excel->getActiveSheet()->setCellValue('A' . $row, $i);
			$this->excel->getActiveSheet()->setCellValue('B' . $row, $i)->getColumnDimension('B')->setAutoSize(true);
			$this->excel->getActiveSheet()->setCellValue('B' . $row, $key->item);

			$this->excel->getActiveSheet()->setCellValue('C' . $row, $this->m_summary->getrowJumL($key->id, '1'));
			$this->excel->getActiveSheet()->setCellValue('D' . $row, $this->m_summary->getrowJumR($key->id, '1'));
			$this->excel->getActiveSheet()->setCellValue('E' . $row, $this->m_summary->getrowJumN($key->id, '1'));
			$this->excel->getActiveSheet()->setCellValue('F' . $row, $key->safety_stok);

			$this->excel->getActiveSheet()->setCellValue('G' . $row, $this->m_summary->getrowJumL($key->id, '2'));
			$this->excel->getActiveSheet()->setCellValue('H' . $row, $this->m_summary->getrowJumR($key->id, '2'));
			$this->excel->getActiveSheet()->setCellValue('I' . $row, $this->m_summary->getrowJumN($key->id, '2'));
			$this->excel->getActiveSheet()->setCellValue('J' . $row, $key->safety_stok);

			$this->excel->getActiveSheet()->setCellValue('K' . $row, $this->m_summary->getrowJumL($key->id, '3'));
			$this->excel->getActiveSheet()->setCellValue('L' . $row, $this->m_summary->getrowJumR($key->id, '3'));
			$this->excel->getActiveSheet()->setCellValue('M' . $row, $this->m_summary->getrowJumN($key->id, '3'));
			$this->excel->getActiveSheet()->setCellValue('N' . $row, $key->safety_stok);

			$this->excel->getActiveSheet()->setCellValue('O' . $row, $this->m_summary->getrowJumL($key->id, '4'));
			$this->excel->getActiveSheet()->setCellValue('P' . $row, $this->m_summary->getrowJumR($key->id, '4'));
			$this->excel->getActiveSheet()->setCellValue('Q' . $row, $this->m_summary->getrowJumN($key->id, '4'));
			$this->excel->getActiveSheet()->setCellValue('R' . $row, $key->safety_stok);

			$this->excel->getActiveSheet()->setCellValue('S' . $row, $this->m_summary->getrowJumL($key->id, '5'));
			$this->excel->getActiveSheet()->setCellValue('T' . $row, $this->m_summary->getrowJumR($key->id, '5'));
			$this->excel->getActiveSheet()->setCellValue('U' . $row, $this->m_summary->getrowJumN($key->id, '5'));
			$this->excel->getActiveSheet()->setCellValue('V' . $row, $key->safety_stok);

			$this->excel->getActiveSheet()->setCellValue('W' . $row, $this->m_summary->getrowJumL($key->id, '6'));
			$this->excel->getActiveSheet()->setCellValue('X' . $row, $this->m_summary->getrowJumR($key->id, '6'));
			$this->excel->getActiveSheet()->setCellValue('Y' . $row, $this->m_summary->getrowJumN($key->id, '6'));
			$this->excel->getActiveSheet()->setCellValue('Z' . $row, $key->safety_stok);

			$this->excel->getActiveSheet()->setCellValue('AA' . $row, $this->m_summary->getrowJumL($key->id, '7'));
			$this->excel->getActiveSheet()->setCellValue('AB' . $row, $this->m_summary->getrowJumR($key->id, '7'));
			$this->excel->getActiveSheet()->setCellValue('AC' . $row, $this->m_summary->getrowJumN($key->id, '7'));
			$this->excel->getActiveSheet()->setCellValue('AD' . $row, $key->safety_stok);

			$this->excel->getActiveSheet()->setCellValue('AE' . $row, $this->m_summary->getrowJumL($key->id, '8'));
			$this->excel->getActiveSheet()->setCellValue('AF' . $row, $this->m_summary->getrowJumR($key->id, '8'));
			$this->excel->getActiveSheet()->setCellValue('AG' . $row, $this->m_summary->getrowJumN($key->id, '8'));
			$this->excel->getActiveSheet()->setCellValue('AH' . $row, $key->safety_stok);

			$this->excel->getActiveSheet()->setCellValue('AI' . $row, $this->m_summary->getrowJumL($key->id, '9'));
			$this->excel->getActiveSheet()->setCellValue('AJ' . $row, $this->m_summary->getrowJumR($key->id, '9'));
			$this->excel->getActiveSheet()->setCellValue('AK' . $row, $this->m_summary->getrowJumN($key->id, '9'));
			$this->excel->getActiveSheet()->setCellValue('AL' . $row, $key->safety_stok);

			$this->excel->getActiveSheet()->setCellValue('AM' . $row, $this->m_summary->getrowJumL($key->id, '10'));
			$this->excel->getActiveSheet()->setCellValue('AN' . $row, $this->m_summary->getrowJumR($key->id, '10'));
			$this->excel->getActiveSheet()->setCellValue('AO' . $row, $this->m_summary->getrowJumN($key->id, '10'));
			$this->excel->getActiveSheet()->setCellValue('AP' . $row, $key->safety_stok);

			$this->excel->getActiveSheet()->setCellValue('AQ' . $row, $this->m_summary->getrowJumL($key->id, '11'));
			$this->excel->getActiveSheet()->setCellValue('AR' . $row, $this->m_summary->getrowJumR($key->id, '11'));
			$this->excel->getActiveSheet()->setCellValue('AS' . $row, $this->m_summary->getrowJumN($key->id, '11'));
			$this->excel->getActiveSheet()->setCellValue('AT' . $row, $key->safety_stok);

			$this->excel->getActiveSheet()->setCellValue('AU' . $row, $this->m_summary->getrowJumL($key->id, '12'));
			$this->excel->getActiveSheet()->setCellValue('AV' . $row, $this->m_summary->getrowJumR($key->id, '12'));
			$this->excel->getActiveSheet()->setCellValue('AW' . $row, $this->m_summary->getrowJumN($key->id, '12'));
			$this->excel->getActiveSheet()->setCellValue('AX' . $row, $key->safety_stok);

			$this->excel->getActiveSheet()->setCellValue('AY' . $row, $this->m_summary->getrowJumL($key->id, '13'));
			$this->excel->getActiveSheet()->setCellValue('AZ' . $row, $this->m_summary->getrowJumR($key->id, '13'));
			$this->excel->getActiveSheet()->setCellValue('BA' . $row, $this->m_summary->getrowJumN($key->id, '13'));
			$this->excel->getActiveSheet()->setCellValue('BB' . $row, $key->safety_stok);

			$row++;
			$i++;
		}

		//Freeze pane
		// $this->excel->getActiveSheet()->freezePane('A4');
		//Cell Style
		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$this->excel->getActiveSheet()->getStyle('A3:BB' . $maxrow)->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getStyle('C2:BB' . $maxrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//Save as an Excel BIFF (xls) file
		$filename = 'PIVOT TABLE.xlsx'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}
}

/* End of file summary.php */
/* Location: ./application/controllers/klg/summary.php */