<?php


class MYPDF extends TCPDF
{
    //    public function Header() {

    //    // $image = base_url('assets/img/logo.png');
    //    //  $this->Image($image, 13, 5, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    //    //  $this->Cell(0, 2, 'SURAT JALAN', 0, true, 'C', 0, '', 0, false, 'T', 'M');


    // }


    public function Footer()
    {

        $this->SetY(-27);

        $this->SetFont('helvetica', 'B', 8);

        $this->Cell(175, 3, 'FR-AA-MKT-03-R00 ', 0, true, 'R', 0, '', 0, false, 'T', 'M');
        $this->Line(15, 274, 190, 274);
        $this->Cell(180, 3, '', 0, true, 'R', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 2, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, true, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 2, 'PT. ALLURE ALLUMINIO ', 0, true, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 2, 'Rukan Artha Gading Niaga Blok B No.17, Kelapa Gading Jakarta Utara-14240, Jakarta, Indonesia ', 0, true, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 2, 'P. +62 21 45850530 mail@allureindustries.com ', 0, true, 'L', 0, '', 0, false, 'T', 'M');
        $imageiso = base_url('assets/img/iso9001.png');
        $this->Image($imageiso, 170, 276, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetFont('times', '', 10);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));


$pdf->SetMargins(PDF_MARGIN_LEFT, 2, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);



$pdf->SetAutoPageBreak(TRUE, 36);
$pdf->SetPrintHeader(false);
$pdf->AddPage("P", "A4");

$tgl_skrg = date('d') . ' ' . $this->fungsi->bulan(date('m')) . ' ' . date('Y');
$hed = '
<table>
        <tr>
            <td width="35%"><img src="' . base_url('assets/img/logo.png') . '" width="70"></td>
            <td  width="50%"><h1>SURAT JALAN</h1></td>
        </tr>
        ';
$hed .= '</table><hr>';
// output the HTML content
$pdf->writeHTML($hed, true, false, true, false, '');
// $this->Line(15, 20, 190, 20);
$pdf->SetFont('Helvetica', '', 9, '', 'false');
$html = '
<style>

table.first {
        font-weight:bold;
		width:100%;
    }
</style>
<table border="0" class="first" cellpadding="1">
        <tr>
            <td width="15%"><b>Kepada</b></td>
            <td width="5%">:</td>
            <td width="40%"></td>
            <td width="15%">No Surat Jalan</td>
            <td width="5%">:</td>
            <td width="20%">' . $header->no_surat_jalan . '</td>
        </tr>
        <tr>
            <td colspan="3">' . $header->nama_proyek . '</td>
            <td>Tanggal</td>
            <td>:</td>
            <td>' . date('Y-m-d', strtotime($header->created)) . '</td>
        </tr>
        <tr>
            <td colspan="3">' . $header->penerima . '</td>
            <td>Sopir</td>
            <td>:</td>
            <td>' . $header->sopir . '</td>
        </tr>
        <tr>
            <td colspan="3">' . $header->alamat_pengiriman . '</td>
            <td>No Polisi</td>
            <td>:</td>
            <td>' . $header->no_kendaraan . '</td>
        </tr>
</table><br>
';
$html .= '
<table border="0.2" cellpadding="1">
        <tr>
            <td width="5%" align="center"><b>No</b></td>
            <td width="30%" align="center"><b>Nama Barang</b></td>
            <td width="10%" align="center"><b>Jumlah</b></td>
            <td width="15%" align="center"><b>Jumlah Packing</b></td>
            <td width="10%" align="center"><b>Satuan</b></td>
            <td width="30%" align="center"><b>Warna</b></td>
        </tr>';
$i = 1;
$total = 0;
foreach ($detail as $key) {
    $total = $total + $key->qty_out;
    $html .= '<tr>
                    <td align="center">' . $i++ . '</td>
                    <td> ' . $key->section_allure . '</td>
                    <td align="center">' . $key->qty_out . '</td>
                    <td align="center">1</td>
                    <td align="center">' . $key->satuan . '</td>
                    <td align="center">' . $key->warna_aluminium . '</td>
                </tr>';
}
$html .= '</table><br><br>';
$html .= '
<style>
table.ttd {
        font-size: 7pt;
        width:100%;
    }
</style>
<table border="0.2" class="ttd"cellpadding="1">
        <tr>
            <td width="15%" align="center">Tanda Terima</td>
            <td width="15%" align="center">Sopir</td>
            <td width="25%" align="center">Bag. Logistik</td>
            <td width="30%" align="center">SPV Admin Logistik</td>
            <td width="15%" align="center">Security</td>
        </tr>
        <tr>
            <td style="height:30px;" width="15%" align="center"></td>
            <td width="15%" align="center"></td>
            <td width="25%" align="center"></td>
            <td width="30%" align="center"></td>
            <td width="15%" align="center"></td>
        </tr>
        <tr>
            <td width="15%">Nama :<br>Tanggal :</td>
            <td width="15%">Nama :<br>Tanggal :</td>
            <td width="25%">Nama :<br>Tanggal :</td>
            <td width="30%">Nama :<br>Tanggal :</td>
            <td width="15%">Nama :<br>Tanggal :</td>
        </tr>
        ';
$html .= '</table><br><br>';

$html .= '
<table class="ttd"cellpadding="1">
        <tr>
            <td>*Putih:Finance   Merah:Eksternal   Kuning:Logistik   Hijau:SCM</td>
        </tr>
        <tr>
            <td>*Barang diatas merupakan barang titipan PT. Allure Alluminio</td>
        </tr>
        ';
$html .= '</table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
// ob_end_clean();
//Close and output PDF document

$pdf->Output($header->nama_proyek . '_SJ_BOM.pdf', 'I');
// ob_end_clean();

//============================================================+
// END OF FILE
//============================================================+