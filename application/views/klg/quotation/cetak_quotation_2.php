<?php
   

class MYPDF2 extends TCPDF {
   public function Header() {

    $image = base_url('assets/img/logo1.png');
    $image2 = base_url('assets/img/logo2.png');
    $this->Image($image, 10, 5, 80, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    $this->Image($image2, 140, 20, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

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

$pdf = new MYPDF2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetFont('times', '', 10);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));


$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);



$pdf->SetAutoPageBreak(TRUE, 45);

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
               '.$quo->aplikator.'
            </td>
            <td width="20">
            </td>
            <td width="200">
            </td>
        </tr>
        <tr>
            <td width="520" colspan="3">
               di '.$quo->alamat.'
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


foreach($showKG as $key){
    $i = 1;
$html .= '<br><table border="0.2" class="second" cellspacing="0" cellpadding="1">
    <tbody>
        <tr>
            <td colspan="9">'.$key->kode_gambar.'</td>
        </tr>  
        <tr>
            <th width="5%" align="center">No.</th>
            <th width="27%" align="center">Item</th>
            <th width="7%" align="center">Lebar</th>
            <th width="7%" align="center">Tinggi</th>
            <th width="10%" align="center">Tipe</th>
            <th width="5%" align="center">Daun</th>
            <th width="17%" align="center">Warna</th>
            <th width="7%" align="center">Jumlah</th>
            <th width="15%" align="center">Harga</th>
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
    
            
    foreach ($det[$key->id_kode_gambar] as $item) {
        if($item->kode_tipe=='ADD'){
            $nama_item['add'][]=$item->item;
            $harga_item_main=$item->harga * $item->qty;
            $harga_item['add'][] = $harga_item_main;
        }else{
            $nama_item['utama'][]=$item->item;
            $gambar_item[]=$item->gambar;
            $luas_item  = ($item->panjang * $item->lebar) / 1000000;        
            $harga_item_main=$item->harga * $item->qty;
            $harga_item['utama'][]          = $harga_item_main;
            if(isset($tam[$item->id_quotation][$item->id])){
                
                $tambahan=$tam[$item->id_quotation][$item->id];
                // die(print_r($tambahan));
                $item_tambahan[]=$tambahan->item;
                $tambahan_harga=$tambahan->harga_tambahan*$tambahan->qty_tambahan*$luas_item;
                $harga_item_tambahan[]=$tambahan_harga;
            }        
        }    
$html.='<tr nobr="true">
            <td align="center">'.$i++.'.</td>
            <td>'.$item->item.'</td>
            <td align="center">'.$item->lebar.'</td>
            <td align="center">'.$item->panjang.'</td>
            <td align="center">'.$item->tipe.'</td>
            <td align="center">'.$item->daun.'</td>
            <td align="center">'.$item->warna.'</td>
            <td align="center">'.$item->qty.'</td>
            <td align="right">'.number_format($harga_item_main,2,',','.').'</td>
        </tr>'; 
        if(isset($tam[$item->id_quotation][$item->id])){
            $html.='<tr nobr="true">
            <td align="center">'.$i++.'</td>
            <td>'.$tambahan->item.'</td>
            <td align="center">'.$item->lebar.'</td>
            <td align="center">'.$item->panjang.'</td>
            <td></td>
            <td></td>
            <td align="center">'.$tambahan->warna.'</td>
            <td align="center">'.$tambahan->qty_tambahan.'</td>
            <td align="right">'.number_format($tambahan_harga,2,',','.').'</td>
            </tr>'; 
        }
    }
        $total  = array_sum($harga_item['utama'])+array_sum($harga_item['add'])+array_sum($harga_item_tambahan);
        $adj = ($key->adjustment/100)*$total;
        $dis = ($key->diskon/100)*$total;
        $totSe = $total + $adj - $dis;
        $html.='<tr>
            <td colspan="8" align="left">Price </td>
            <td align="right">'.number_format($total,2,',','.').'</td>
        </tr>
        <tr>
            <td colspan="8" align="left">Adjustment '.$key->adjustment.' %</td>
            <td align="right">'.number_format($adj,2,',','.').'</td>
        </tr>
        <tr>
            <td colspan="8" align="left">Discount '.$key->diskon.' %</td>
            <td align="right">'.number_format($dis,2,',','.').'</td>
        </tr>
        <tr>
            <td colspan="8" align="left">SUBTOTAL</td>
            <td align="right">'.number_format($totSe,2,',','.').'</td>
        </tr>
    </tbody>
</table><br>
'; 
$total_all=$total_all+$totSe;
}


$html.='<br><table border="0.2" class="second" cellspacing="0" cellpadding="1">
<tbody>
    <tr>
        <td colspan="5">GRANDTOTAL</td>
        <td  align="right">'.number_format($total_all,2,',','.').'</td>
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
        <td colspan="4"></td>
        <td colspan="2">'.$quo->aplikator.'</td>
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