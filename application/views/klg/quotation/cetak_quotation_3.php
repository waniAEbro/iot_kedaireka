<?php
   
//    print_r($quo);
//    die();

class MYPDF3 extends TCPDF {
    public $quo;
     
    public function setData($quo){
        $this->quo = $quo;
    }
   public function Header() {
    
    $quo= $this->quo;

    $image = base_url('assets/img/astral_aplikator.png');
    $image2 = base_url($quo->logo);
    $this->Image($image2, 20, 10, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    $this->Image($image, 155, 10, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

}


public function Footer() {

    $this->SetY(-27);

    $this->SetFont('helvetica', 'B', 8);

    $this->Cell(175, 3, 'FR-AA-MKT-03-R00 ', 0, true, 'R', 0, '', 0, false, 'T', 'M');
    $this->Line(15, 274, 190, 274);
    $this->Cell(180, 3, '', 0, true, 'R', 0, '', 0, false, 'T', 'M');
    $this->Cell(0, 2, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, true, 'C', 0, '', 0, false, 'T', 'M');
    $this->Cell(0, 2, 'PT. ALLURE ALUMINIO ', 0, true, 'L', 0, '', 0, false, 'T', 'M');
    $this->Cell(0, 2, 'Rukan Artha Gading Niaga Blok B No.17, Kelapa Gading Jakarta Utara-14240,Jakarta,Indonesia ', 0, true, 'L', 0, '', 0, false, 'T', 'M');
    $this->Cell(0, 2, 'P. +62 21 45850530 mail@allureindustries.com ', 0, true, 'L', 0, '', 0, false, 'T', 'M');
    $imageiso = base_url('assets/img/iso9001.png');
    $this->Image($imageiso, 170, 276, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
}
}

$pdf = new MYPDF3(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setData($quo);
$pdf->SetFont('times', '', 10);
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));


$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);



$pdf->SetAutoPageBreak(TRUE, 30);

$pdf->AddPage("P","A4");

$tgl_skrg = date('d').' '.date('M').' '.date('Y');

$html = '
<style>

table.first {
        font-size: 10pt;
        font-weight:bold;
		width:100%;
    }
</style>
<table border="0" class="first" cellpadding="3">
    <tbody>
        <tr>
            <td width="300">
            </td>
            <td width="20">
            </td>
            <td width="200" align="right">
               Jakarta, '.$tgl_skrg.'
            </td>
        </tr>
        <tr>
            <td width="300">
               Kepada Yth.
            </td>
            <td width="20">
            </td>
            <td width="200">
            </td>
        </tr>
        <tr>
            <td width="300">
               '.$quo->nama_owner.'
            </td>
            <td width="20">
            </td>
            <td width="200">
            </td>
        </tr>
        <tr>
            <td width="520" colspan="3">
               di '.$quo->alamat_proyek.'
            </td>
        </tr>
        <tr>
            <td width="300">
            </td>
            <td width="20">
            </td>
            <td width="200">
            </td>
        </tr>
        <tr>
            <td colspan="3" width="520">
               Penawaran Harga Kusen Astral proyek '.$quo->nama_proyek.' di '.$quo->alamat_proyek.'
            </td>

        </tr>
        <tr>
            <td colspan="3" width="520">
               Quotation No. '.$quo->no_quotation.'
            </td>
            
        </tr>
        <tr>
            <td width="300"></td>
            <td width="20"></td>
            <td width="200"></td>
        </tr>
        <tr>
            <td width="300">
               Dengan hormat,
            </td>
            <td width="20"></td>
            <td width="200"></td>
        </tr>
        <tr>
            <td colspan="3" width="520">
               Dengan ini, kami sertakan penawaran produk kami sesuai dengan gambar yang dikirimkan kepada kami.
            </td>
        </tr>
        <tr>
            <td colspan="3" width="520">
            </td>
        </tr>
    </tbody>
</table>
';

$pdf->SetFont('Helvetica', '', 10, '', 'false');
$html .= '
<style>
font-size: 9pt;
table.second {
        color: #003300;
		width:100%;
    }
h4 {
        color: black;
        font-family: Helvetica;
        font-size: 10pt;
        text-decoration: none;
		text-align:center;
    }
table.second th {
	font-weight:bold;
	font-size: 9pt;
}
table.second td {
	 font-size: 8pt;
}
table.second .r1 {
    font-size: 8pt;
}
</style>';
$total_all=0;
$i = 1;

foreach($showKG as $key){
$html .= '<table border="0.2" class="second" cellspacing="0" cellpadding="1">
    <tbody>
        <tr>
            <th width="5%" align="center">No.</th>
            <th width="15%" align="center">Kode Gambar</th>
            <th width="20%" align="center">Gambar Item</th>
            <th width="45%" align="center">Description</th>
            <th width="15%" align="center">Item Price</th>
        </tr>';
$total_item = 0; $harga_row_tipe = 0; $total_item_tambahan = 0;

$jumlahItem = count($det[$key->id_kode_gambar]);
    $luas_item=0;
    $nama_item=array();
    $item_tambahan=array();
    $harga_item=array();
    $harga_item_tambahan=array();
    $gambar_item=array();
    $nama_item['add']=array();
    $harga_item['add']=array();
    foreach($det[$key->id_kode_gambar] as $item){
        if($item->kode_tipe=='ADD'){
            $nama_item['add'][]=$item->item;
            $harga_item['add'][] = $item->harga * $item->qty;
        }else{
            $nama_item['utama'][]=$item->item;
            $gambar_item[]=$item->gambar;
            $luas_item  = ($item->panjang * $item->lebar) / 1000000;        
            $harga_item['utama'][]          = $item->harga * $item->qty;
            if(isset($tam[$item->id_quotation][$item->id])){
                $tambahan=$tam[$item->id_quotation][$item->id];
                $item_tambahan[]=$tambahan->item;
                $harga_item_tambahan[]=$tambahan->harga_tambahan*$tambahan->qty_tambahan*$luas_item;
                
            }        
        }
    }

    $ketcustom='';
    if(sizeof($nama_item['utama'])>1){
        $ketcustom="CUSTOM";
        $gambarItem='assets/img/combiitem.png';
    }
    else{
        $gambarItem=$gambar_item[0];
    }
if(sizeof($item_tambahan)>0){
    $ketItemTamb=implode($item_tambahan,', ');
}else{
    $ketItemTamb='EXCLUDE';
}
if(sizeof($nama_item['add'])>0){
    $ketADD=implode($nama_item['add'],', ');
}else{
    $ketADD='EXCLUDE';
}

$harga_utama_hit=array_sum($harga_item['utama']);
$harga_second_hit=array_sum($harga_item['add'])+array_sum($harga_item_tambahan);

$harga_utama=$harga_utama_hit+(($key->adjustment/100)*$harga_utama_hit)-(($key->diskon/100)*$harga_utama_hit);
$harga_second=$harga_second_hit+(($key->adjustment/100)*$harga_second_hit)-(($key->diskon/100)*$harga_second_hit);
$html.='<tr nobr="true">
            <td rowspan="6" align="center">'.$i++.'</td>
            <td rowspan="6">'.$key->kode_gambar.'<br>'.$item->lokasi.'<br>'.$key->ket_qty.' Unit</td>
            <td rowspan="6"><img align="center" src="'.$gambarItem.'" width="70" height="70"></td>
            <td>'.implode($nama_item['utama'],', ').'</td>
            <td rowspan="4" align="right">'.number_format($harga_utama,2,',','.').'</td>
        </tr>
        <tr nobr="true">
            <td>Color: '.$item->warna.'</td>
        </tr nobr="true">
        <tr nobr="true">
            <td>Daun: '.$item->daun.'</td>
        </tr nobr="true">
        <tr nobr="true">
            <td>Dimension: '.$key->ket_dimensi.'</td>
        </tr nobr="true">
        <tr nobr="true">
            <td>ADD: '.$ketADD.'</td>
            <td rowspan="2" align="right">'.number_format($harga_second,2,',','.').'</td>
        </tr>
        <tr nobr="true">
            <td>Kaca : '.$ketItemTamb.'</td>
        </tr>
        '; 
        $total  = $harga_utama+$harga_second;
        
        $totSe = $total;
        $html.='<tr>
        <td colspan="4" align="left">SUBTOTAL</td>
        <td align="right">'.number_format($totSe,2,',','.').'</td>
        </tr>
    </tbody>
</table><br><br>
'; 
$total_all=$total_all+$totSe;
}


$html.='<table border="0.2" class="second" cellspacing="0" cellpadding="1">
<tbody>
    <tr>
        <td colspan="5">GRAND TOTAL</td>
        <td  align="right">Rp. '.number_format($total_all,2,',','.').'</td>
    </tr>
    </table><br><br>
    
    '.$quo->keterangan;


    $html.='<table class="second" cellspacing="0" cellpadding="1">
    <tbody>
    <tr>
        <td>Hormat Kami</td>
        <td colspan="3"></td>
        <td colspan="2">Menyetujui</td>
    </tr>
    <tr><td colspan="5"></td></tr>
    <tr><td colspan="5"></td></tr>
    <tr><td colspan="5"></td></tr>
    <tr>
        <td>'.$quo->aplikator.'</td>
        <td colspan="3"></td>
        <td colspan="2">'.$quo->nama_owner.'</td>
    </tr>
    </table><br>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
// ob_end_clean();
//Close and output PDF document

$pdf->Output($quo->aplikator.'_quotation1.pdf', 'I');
// ob_end_clean();

//============================================================+
// END OF FILE
//============================================================+