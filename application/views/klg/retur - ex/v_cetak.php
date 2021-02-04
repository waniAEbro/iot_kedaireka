<?php
   

class MYPDF extends TCPDF {
   public function Header() {
    
   $image = base_url('assets/img/logo.png');
    $this->Image($image, 13, 5, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    $this->Cell(0, 2, 'Surat Retur', 0, true, 'L', 0, '', 0, false, 'T', 'M');
    $this->Line(15, 20, 190, 20);

}


public function Footer() {

    $this->SetY(-27);

    $this->SetFont('helvetica', 'B', 8);

    $this->Cell(175, 3, 'FR-AA-MKT-03-R00 ', 0, true, 'R', 0, '', 0, false, 'T', 'M');
    $this->Line(15, 274, 190, 274);
    $this->Cell(180, 3, '', 0, true, 'R', 0, '', 0, false, 'T', 'M');
    $this->Cell(0, 2, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, true, 'C', 0, '', 0, false, 'T', 'M');
    $this->Cell(0, 2, 'PT. ALLURE ALLUMINIO ', 0, true, 'L', 0, '', 0, false, 'T', 'M');
    $this->Cell(0, 2, 'Rukan Artha Gading Niaga Blok B No.17, Kelapa Gading Jakarta Utara-14240, Jakarta, Indonesia ', 0, true, 'L', 0, '', 0, false, 'T', 'M');
    $this->Cell(0, 2, 'P. +62 21 45850530 mail@allureindustries.com ', 0, true, 'L', 0, '', 0, false, 'T', 'M');
    $imageiso = base_url('assets/img/iso9001.png');
    $this->Image($imageiso, 170, 276, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetFont('times', '', 10);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));


$pdf->SetMargins(PDF_MARGIN_LEFT, 22, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);



$pdf->SetAutoPageBreak(TRUE, 36);

$pdf->AddPage("P","A4");

$tgl_skrg = date('d').' '.$this->fungsi->bulan(date('m')).' '.date('Y');

$html = '
<style>

table.first {
        font-size: 9pt;
        font-weight:bold;
		width:100%;
    }
</style>
<table border="0" class="first" cellpadding="1">
    <tbody>
        <tr>
            <td width="15%">Date</td>
            <td width="2%">:</td>
            <td width="40%">'.$tgl_skrg.'</td>
            <td width="15%">No Retur</td>
            <td width="2%">:</td>
            <td width="20%">'.$header->no_pengiriman.'</td>
        </tr>
        <tr>
            <td>No Permintaan</td>
            <td>:</td>
            <td>'.$header->no_invoice.'</td>
            <td>No PO/SO</td>
            <td>:</td>
            <td>'.$header->no_po.'</td>            
        </tr>
        <tr>
            <td>Tgl Retur</td>
            <td>:</td>
            <td colspan="4">'.$header->date.'</td>           
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td colspan="4">'.$header->keterangan.'</td>           
        </tr>
        
    </tbody>
</table><br><br><br>
';

$pdf->SetFont('Helvetica', '', 8, '', 'false');
$html .= '
<strong>Produk Retur :</strong>
<table border="0.2" cellpadding="1">
        <tr>
            <td width="40%" align="center">Item</td>
            <td width="10%" align="center">Ukuran</td>
            <td width="10%" align="center">Warna</td>
            <td width="10%" align="center">Bukaan</td>
            <td width="10%" align="center">Qty</td>
            <td width="20%" align="center">Tipe</td>
        </tr>';
$html .= '<tr>
            <td> '.$header->item.'</td>
            <td align="center">'.$header->lebar.'x'.$header->tinggi.'</td>
            <td align="center">'.$header->warna.'</td>
            <td align="center">'.$header->bukaan.'</td>
            <td align="center">'.$header->qty.'</td>
            <td align="center">'.$header->tipe.'</td>
        </tr>';
$html .= '</table><br><br>';
$html .= '
<strong>Produk Ganti :</strong>
<table border="0.2" cellpadding="1">
        <tr>
            <td width="40%" align="center">Item</td>
            <td width="10%" align="center">Ukuran</td>
            <td width="10%" align="center">Warna</td>
            <td width="10%" align="center">Bukaan</td>
            <td width="10%" align="center">Qty</td>
            <td width="20%" align="center">Tipe</td>
        </tr>';
$html .= '<tr>
            <td> '.$header->item_baru.'</td>
            <td align="center">'.$header->lebar_baru.'x'.$header->tinggi_baru.'</td>
            <td align="center">'.$header->warna_baru.'</td>
            <td align="center">'.$header->bukaan_baru.'</td>
            <td align="center">'.$header->qty_baru.'</td>
            <td align="center">'.$header->tipe_baru.'</td>
        </tr>';
$html .= '</table><br><br>';
// $pdf->SetFont('Helvetica', '', 8, '', 'false');
$html .= '
<style>
table.ttd {
        font-size: 7pt;
        width:100%;
    }
</style>
<table border="0.2" class="ttd"cellpadding="1">
        <tr>
            <td width="15%" align="center">F&A APPROVAL</td>
            <td width="15%" align="center">PROPOSED BY</td>
            <td width="25%" align="center">CHECKED BY</td>
            <td width="15%" align="center">ACKNOWLEDGED BY</td>
            <td width="15%" align="center">ACKNOWLEDGED BY</td>
            <td width="15%" align="center">APPROVED BY</td>
        </tr>
        <tr>
            <td style="height:30px;" width="15%" align="center"></td>
            <td width="15%" align="center"></td>
            <td width="25%" align="center"></td>
            <td width="15%" align="center"></td>
            <td width="15%" align="center"></td>
            <td width="15%" align="center"></td>
        </tr>
        <tr>
            <td width="15%" align="center">F&A</td>
            <td width="15%" align="center">Admin ALPHAMAX</td>
            <td width="25%" align="center">Manager ALPHAMAX</td>
            <td width="15%" align="center">Production</td>
            <td width="15%" align="center">Logistic</td>
            <td width="15%" align="center">Directur</td>
        </tr>
        ';
$html .= '</table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
// ob_end_clean();
//Close and output PDF document

$pdf->Output($header->id.'retur.pdf', 'I');
// ob_end_clean();

//============================================================+
// END OF FILE
//============================================================+