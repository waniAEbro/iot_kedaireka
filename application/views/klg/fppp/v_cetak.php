<?php
   

class MYPDF extends TCPDF {
   public function Header() {
    
   $image = base_url('assets/img/logo.png');
    $this->Image($image, 13, 5, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    $this->Cell(0, 2, 'FORM PERMINTAAN PENGIRIMAN ( PINTU & DISPLAY )', 0, true, 'L', 0, '', 0, false, 'T', 'M');
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

$pdf->SetFont('Helvetica', '', 9, '', 'false');
$html = '
<style>

table.first {
        font-weight:bold;
        width:100%;
    }
</style>
<table border="0" class="first" cellpadding="1">
    <tbody>
        <tr>
            <td width="15%">Date</td>
            <td width="3%">:</td>
            <td width="40%">'.$header->date.'</td>
            <td width="15%">No Permintaan</td>
            <td width="3%">:</td>
            <td width="20%">'.$header->no_invoice.'</td>
        </tr>
        <tr>
            <td>To</td>
            <td>:</td>
            <td>PPIC & logistic</td>
            <td>No PO/SO</td>
            <td>:</td>
            <td>'.$header->no_po.'</td>            
        </tr>
        <tr>
            <td>Contact Person</td>
            <td>:</td>
            <td>Bp. Calvin</td>
            <td>Tgl Kirim</td>
            <td>:</td>
            <td>'.$header->tgl_pengiriman.'</td>            
        </tr>

        
        <tr>
            <td>Mitra/Store</td>
            <td>:</td>
            <td colspan="4">'.$header->store.'</td>
        </tr>
        <tr>
            <td>Telp</td>
            <td>:</td>
            <td colspan="4">'.$header->no_telp.'</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td colspan="4">'.$header->alamat.'</td>
        </tr>
        
    </tbody>
</table><br>
';
$html .= '<table border="1" cellpadding="2">
    <tr>
        <td style="height:30px;">Special Instruction : '.$header->intruction.'</td>
    </tr>

</table><br><br>
';
$html .= '
<table border="0.2" cellpadding="1">
        <tr>
            <td width="5%" align="center">No</td>
            <td width="20%" align="center">Item</td>
            <td width="10%" align="center">Ukuran</td>
            <td width="25%" align="center">Warna</td>
            <td width="8%" align="center">Bukaan</td>
            <td width="5%" align="center">Qty</td>
            <td width="8%" align="center">Tipe</td>
            <td width="9%" align="center">Status</td>
            <td width="10%" align="center">Keterangan</td>
        </tr>';
$i=1;$total=0;
foreach($detail as $key){
    $total = $total + $key->qty;
$html .= '<tr>
            <td align="center">'.$i++.'</td>
            <td> '.$key->item.'</td>
            <td align="center">'.$key->lebar.'x'.$key->tinggi.'</td>
            <td align="center">'.$key->warna.'</td>
            <td align="center">'.$key->bukaan.'</td>
            <td align="center">'.$key->qty.'</td>
            <td align="center">'.$key->tipe.'</td>
            <td align="center">'.$key->status_detail.'</td>
            <td align="center">'.$key->keterangan.'</td>
        </tr>';
}
$html .= '<tr>
            <td align="center" colspan="5"><b> Total Item</b></td>
            <td align="center"><b> '.$total.'</b></td>
            <td></td>
            <td></td>
        </tr>
        </table><br><br>';

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
            <td width="15%" align="center">Director</td>
        </tr>
        ';
$html .= '</table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
// ob_end_clean();
//Close and output PDF document

$pdf->Output($header->store.'_permintaan.pdf', 'I');
// ob_end_clean();

//============================================================+
// END OF FILE
//============================================================+