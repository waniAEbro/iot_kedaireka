<?php


class MYPDF extends TCPDF
{
    public function Header()
    {

        $image = base_url('assets/img/logo.png');
        $this->Image($image, 13, 5, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Cell(0, 2, 'LAPORAN KETIDAKSESUAIAN', 0, true, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 2, '               NCR (Non Conformity Record)', 0, true, 'L', 0, '', 0, false, 'T', 'M');
        $this->Line(15, 20, 190, 20);
    }


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


$pdf->SetMargins(PDF_MARGIN_LEFT, 22, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);



$pdf->SetAutoPageBreak(TRUE, 36);

$pdf->AddPage("P", "A4");

$tgl_skrg = date('d') . ' ' . $this->fungsi->bulan(date('m')) . ' ' . date('Y');

$html = '
<style>

table.first {
        font-size: 10pt;
        font-weight:bold;
		width:100%;
    }
</style>
<table border="0" class="first" cellpadding="1">
    <tbody>
        <tr>
            <td width="15%">Nama Project</td>
            <td width="2%">:</td>
            <td width="43%">' . $header->nama_project . '</td>
            <td width="15%">No NCR</td>
            <td width="2%">:</td>
            <td width="23%">' . $header->no_ncr . '</td>
        </tr>
        <tr>
            <td>No WO/SPK</td>
            <td>:</td>
            <td>' . $header->no_wo . '</td>
            <td>Tanggal</td>
            <td>:</td>
            <td>' . $header->tanggal . '</td>
        </tr>
        <tr>
            <td>No FPPP</td>
            <td>:</td>
            <td>' . $header->no_fppp . '</td>
            <td>Kepada</td>
            <td>:</td>
            <td>' . $header->kepada . '</td>
        </tr>
        <tr>
            <td>Jenis Ketidaksesuaian</td>
            <td>:</td>
            <td>' . $header->jenis_ketidaksesuaian . '</td>
            <td>Dilaporkan oleh</td>
            <td>:</td>
            <td>' . $header->dilaporkan_oleh . '</td>
        </tr>

    </tbody>
</table><br><br><br>
';
$html .= '<table border="1" cellpadding="1">
    <tr>
        <td>Item : ' . $header->item . '</td>
    </tr>

</table>
';
$html .= '<table border="1" cellpadding="1">
    <tr>
        <td>Deskripsi Masalah : ' . $header->deskripsi_masalah . '</td>
    </tr>

</table>
';
$html .= '<table border="1" cellpadding="1">
    <tr>
        <td>Analisa Penyebab Masalah : ' . $header->analisa_penyebab_masalah . '</td>
    </tr>

</table>
';
$html .= '<table border="1" cellpadding="1">
    <tr>
        <td>Tindakan Perbaikan : ' . $header->tindakan_perbaikan . '</td>
    </tr>

</table>
';




// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
// ob_end_clean();
//Close and output PDF document

$pdf->Output($header->store . '_permintaan.pdf', 'I');
// ob_end_clean();

//============================================================+
// END OF FILE
//============================================================+